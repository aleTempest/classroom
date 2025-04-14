<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Classroom Posts') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Create Post Button -->
            <div class="flex justify-end mb-6">
                <x-link-button href="{{ route('posts.create') }}" class="bg-indigo-600 hover:bg-indigo-700">
                    <i class="fas fa-plus mr-2"></i> {{ __('New Post') }}
                </x-link-button>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Empty State -->
            @if($posts->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-center p-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">No posts yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating your first classroom post.</p>
                    <div class="mt-6">
                        <x-link-button href="{{ route('posts.create') }}" class="bg-indigo-600 hover:bg-indigo-700">
                            <i class="fas fa-plus mr-2"></i> {{ __('New Post') }}
                        </x-link-button>
                    </div>
                </div>
            @else
                <!-- Posts Timeline -->
                <div class="space-y-6">
                    @foreach($posts as $post)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 hover:border-indigo-300 transition duration-150 ease-in-out">
                            <div class="p-6">
                                <!-- Post Header -->
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">{{ $post->title }}</h3>
                                        <p class="text-sm text-gray-500 mt-1">
                                            Posted in {{ $post->room->name }} •
                                            {{ $post->published_at ? $post->published_at->format('M d, Y H:i') : 'Draft' }}
                                        </p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        @if($post->published_at)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Published
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Draft
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Post Content -->
                                <div class="mt-4">
                                    <p class="text-gray-700">{{ $post->topic }}</p>
                                </div>

                                <!-- Post Footer -->
                                <div class="mt-6 flex justify-between items-center">
                                    <div class="flex items-center space-x-4">
                                        @if($post->attachments->count() > 0)
                                            <span class="inline-flex items-center text-sm text-gray-500">
                                                <i class="fas fa-paperclip mr-1"></i>
                                                {{ $post->attachments->count() }} files
                                            </span>
                                        @endif
                                        <span class="inline-flex items-center text-sm text-gray-500">
                                            <i class="fas fa-eye mr-1"></i>
                                            {{ $post->students->count() }}/{{ $post->room->students->count() }} viewed
                                        </span>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex space-x-3">
                                        <a href="{{ route('posts.show', $post) }}" class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                                            <i class="fas fa-eye mr-1"></i> View
                                        </a>
                                        <a href="{{ route('posts.edit', $post) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
                                        <form action="{{ route('posts.destroy', $post) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure you want to delete this post?')" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none">
                                                <i class="fas fa-trash mr-1"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if ($posts->hasPages())
                    <div class="mt-8">
                        {{ $posts->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
