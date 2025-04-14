<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostAttachment;
use App\Models\Teacher;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['teacher', 'room', 'attachments'])
            ->latest()
            ->paginate(10);

        $teacher = auth()->user()->teacher; // Assuming authenticated teacher

        return view('posts.teacher.index', [
            'teacher' => $teacher,
            'publishedCount' => $teacher->posts()->whereNotNull('published_at')->count(),
            'draftCount' => $teacher->posts()->whereNull('published_at')->count(),
            'posts' => $teacher->posts()->with(['room', 'attachments'])->latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teacherId = auth()->user()->teacher->id;
        $rooms = Room::all();
        return view('posts.create', compact('teacherId', 'rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'room_id' => 'required|exists:rooms,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'topic' => 'required|string|max:255',
            'published_at' => 'nullable|date',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,png|max:2048',
        ]);

        // Handle "Publish Now" checkbox
        if ($request->has('publish_now')) {
            $validated['published_at'] = now();
        }

        $post = Post::create($validated);

        if ($request->hasFile('attachments')) {
            $this->handleAttachments($request->file('attachments'), $post);
        }


        return redirect()->route('teacher.posts.index')
                         ->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load(['teacher', 'room', 'attachments']);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $teachers = Teacher::all();
        $rooms = Room::all();

        return view('posts.edit', compact('post', 'teachers', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'room_id' => 'required|exists:rooms,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'topic' => 'required|string|max:255',
            'published_at' => 'nullable|date',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,png|max:2048',
            'delete_attachments' => 'nullable|array',
            'delete_attachments.*' => 'exists:post_attachments,id',
        ]);

        $post->update($validated);

        // Handle attachment deletions
        if ($request->has('delete_attachments')) {
            $this->deleteAttachments($request->input('delete_attachments'));
        }

        // Handle new attachments
        if ($request->hasFile('attachments')) {
            $this->handleAttachments($request->file('attachments'), $post);
        }

        return redirect()->route('posts.show', $post)
                         ->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Delete all attachments first
        foreach ($post->attachments as $attachment) {
            Storage::disk($attachment->disk)->delete($attachment->path);
        }

        $post->delete();

        return redirect()->route('posts.index')
                         ->with('success', 'Post deleted successfully.');
    }

    /**
     * Handle file attachments upload
     */
    protected function handleAttachments($files, Post $post)
    {
        foreach ($files as $file) {
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $mimeType = $file->getMimeType();
            $size = $file->getSize();

            // Generate unique filename
            $filename = Str::uuid() . '.' . $extension;
            $path = $file->storeAs('posts/' . $post->id, $filename, 'public');

            $post->attachments()->create([
                'original_name' => $originalName,
                'path' => $path,
                'mime_type' => $mimeType,
                'size' => $size,
                'extension' => $extension,
                'disk' => 'public',
            ]);
        }
    }

    /**
     * Delete attachments
     */
    protected function deleteAttachments(array $attachmentIds)
    {
        $attachments = PostAttachment::whereIn('id', $attachmentIds)->get();

        foreach ($attachments as $attachment) {
            Storage::disk($attachment->disk)->delete($attachment->path);
            $attachment->delete();
        }
    }

    /**
     * Download an attachment
     */
    public function downloadAttachment(PostAttachment $attachment)
    {
        if (!Storage::disk($attachment->disk)->exists($attachment->path)) {
            abort(404);
        }

        return Storage::disk($attachment->disk)->download(
            $attachment->path,
            $attachment->original_name
        );
    }
}
