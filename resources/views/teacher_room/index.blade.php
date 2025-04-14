<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rooms') }}
        </h2>
    </x-slot>
<div class="py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    My Classes
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    {{ $teacher->first_name }} {{ $teacher->last_name }} • {{ $teacher->email }}
                </p>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                    {{ $rooms->count() }} {{ Str::plural('class', $rooms->count()) }}
                </span>
            </div>
        </div>

        <!-- Class Cards Grid -->
        @if($rooms->isEmpty())
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">No classes assigned</h3>
                    <p class="mt-1 text-sm text-gray-500">You haven't been assigned to any classes yet.</p>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($rooms as $room)
                    <div class="bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200">
                        <!-- Class Header -->
                        <div class="px-4 py-5 sm:px-6 bg-white">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900 truncate">
                                    {{ $room->name }}
                                </h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    {{ $room->code }}
                                </span>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                {{ $room->career->name }}
                            </p>
                        </div>
                        
                        <!-- Class Details -->
                        <div class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-900">
                                        {{ $room->enrollments->count() }} {{ Str::plural('student', $room->enrollments->count()) }}
                                    </span>
                                </div>
                                <div class="text-sm text-gray-500">
                                    Created {{ $room->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="px-4 py-4 sm:px-6 bg-gray-50">
                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('rooms.show', $room) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    View Class
                                </a>
                                <a href="{{ route('rooms.edit', $room) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Manage
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

</x-app-layout>