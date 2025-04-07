<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Room Details') }}: {{ $room->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Room Information') }}</h3>
                            <dl class="mt-4 space-y-4">
                                <div class="border-t border-gray-200 pt-4">
                                    <dt class="text-sm font-medium text-gray-500">
                                        {{ __('Code') }}
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $room->code }}
                                    </dd>
                                </div>
                                <div class="border-t border-gray-200 pt-4">
                                    <dt class="text-sm font-medium text-gray-500">
                                        {{ __('Career') }}
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $room->career->name }}
                                    </dd>
                                </div>
                                <div class="border-t border-gray-200 pt-4">
                                    <dt class="text-sm font-medium text-gray-500">
                                        {{ __('Description') }}
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $room->desc }}
                                    </dd>
                                </div>
                                <div class="border-t border-gray-200 pt-4">
                                    <dt class="text-sm font-medium text-gray-500">
                                        {{ __('Created') }}
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $room->created_at->format('M d, Y') }}
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Enrolled Students') }}</h3>
                            @if($room->enrollments->count() > 0)
                                <div class="mt-4 space-y-4">
                                    @foreach($room->enrollments as $enrollment)
                                        <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ $enrollment->user->name }}
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    Enrolled {{ $enrollment->enrolled_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="mt-4 text-sm text-gray-500">
                                    {{ __('No students enrolled in this room yet.') }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('rooms.edit', $room) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Edit Room') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
