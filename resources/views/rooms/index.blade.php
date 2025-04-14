<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rooms') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-medium text-gray-900">
                    {{ __('All Rooms') }}
                </h3>
                <x-link-button href="{{ route('rooms.create') }}">
                    {{ __('Add New Room') }}
                </x-link-button>
            </div>

            @if (session('success'))
                <div class="mb-4 px-4 py-2 bg-green-100 border border-green-200 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($rooms as $room)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        {{ $room->name }}
                                        <span class="text-sm font-normal text-gray-500">({{ $room->code }})</span>
                                    </h3>
                                    <p class="text-sm text-indigo-600 mt-1">
                                        {{ $room->career->name }}
                                    </p>

                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    {{ $room->getEnrollmentCount() ?? 0 }} students
                                </span>
                            </div>

                            <p class="mt-3 text-sm text-gray-600">
                                {{ $room->desc }}
                            </p>

                            <div class="mt-4 flex justify-between items-center">
                                <span class="text-xs text-gray-500">
                                    Created {{ $room->created_at->diffForHumans() }}
                                </span>
                                <div class="flex space-x-2">
                                    <a href="{{ route('rooms.edit', $room) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">
                                        {{ __('Edit') }}
                                    </a>
                                    <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm" onclick="return confirm('Are you sure you want to delete this room?')">
                                            {{ __('Delete') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 bg-white p-6 shadow-sm sm:rounded-lg text-center">
                        <p class="text-gray-500">{{ __('No rooms found.') }}</p>
                        <a href="{{ route('rooms.create') }}" class="mt-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Create your first room') }}
                        </a>
                    </div>
                @endforelse
            </div>

            @if ($rooms->hasPages())
                <div class="mt-6">
                    {{ $rooms->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
