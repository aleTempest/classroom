<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-validation-errors class="mb-4" />

                    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Hidden teacher_id field -->
                        <input type="hidden" name="teacher_id" value="{{ $teacherId }}">

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Room Selection -->
                            <div>
                                <x-label for="room_id" value="{{ __('Room') }}" />
                                <select id="room_id" name="room_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" required>
                                    <option value="">{{ __('Select Room') }}</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                            {{ $room->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Title -->
                            <div>
                                <x-label for="title" value="{{ __('Title') }}" />
                                <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required />
                            </div>

                            <!-- Topic -->
                            <div>
                                <x-label for="topic" value="{{ __('Topic') }}" />
                                <x-input id="topic" class="block mt-1 w-full" type="text" name="topic" :value="old('topic')" required />
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ __('Example: Linear Algebra, American History') }}
                                </p>
                            </div>

                            <!-- Content -->
                            <div>
                                <x-label for="content" value="{{ __('Content') }}" />
                                <textarea id="content" name="content" rows="6" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" required>{{ old('content') }}</textarea>
                            </div>

                            <!-- Publish Options -->
                            <div class="space-y-2">
                                <x-label value="{{ __('Publish Options') }}" />
                                <div class="flex items-center">
                                    <input id="publish_now" name="publish_now" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <x-label for="publish_now" value="{{ __('Publish Immediately') }}" class="ms-2" />
                                </div>
                                <div id="publish_date_container" class="mt-2 hidden">
                                    <x-label for="published_at" value="{{ __('Or schedule for later:') }}" />
                                    <x-input id="published_at" class="block mt-1 w-full" type="datetime-local" name="published_at" />
                                </div>
                            </div>

                            <!-- Attachments -->
                            <div>
                                <x-label for="attachments" value="{{ __('Attachments') }}" />
                                <input id="attachments" name="attachments[]" type="file" multiple class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.png">
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ __('Allowed file types: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG') }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('posts.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900 me-4">
                                {{ __('Cancel') }}
                            </a>
                            <x-button>
                                {{ __('Create Post') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Toggle publish date field
        document.getElementById('publish_now').addEventListener('change', function() {
            const publishDateContainer = document.getElementById('publish_date_container');
            if (this.checked) {
                publishDateContainer.classList.add('hidden');
                document.getElementById('published_at').value = '';
            } else {
                publishDateContainer.classList.remove('hidden');
            }
        });
    </script>
    @endpush
</x-app-layout>
