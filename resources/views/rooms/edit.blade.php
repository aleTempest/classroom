<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Room') }}: {{ $room->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-validation-errors class="mb-4" />

                    <form method="POST" action="{{ route('rooms.update', $room) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Room Fields -->
                            <div>
                                <x-label for="career_id" value="{{ __('Career') }}" />
                                <select id="career_id" name="career_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" required>
                                    <option value="">{{ __('Select Career') }}</option>
                                    @foreach($careers as $career)
                                        <option value="{{ $career->id }}" {{ old('career_id', $room->career_id) == $career->id ? 'selected' : '' }}>
                                            {{ $career->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <x-label for="code" value="{{ __('Room Code') }}" />
                                <x-input id="code" class="block mt-1 w-full" type="text" name="code" :value="old('code', $room->code)" required />
                            </div>

                            <div>
                                <x-label for="name" value="{{ __('Room Name') }}" />
                                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $room->name)" required />
                            </div>

                            <div>
                                <x-label for="desc" value="{{ __('Description') }}" />
                                <textarea id="desc" name="desc" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('desc', $room->desc) }}</textarea>
                            </div>

                            <!-- Student Enrollment Section -->
<div class="mt-6 pt-6 border-t border-gray-200">
    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Student Enrollments') }}</h3>
    @livewire('room-student-enrollment', ['room' => $room])
</div>
                        </div>

                        <div class="flex items-center justify-end mt-6 space-x-4">
                            <a href="{{ route('rooms.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Cancel') }}
                            </a>
                            <x-button>
                                {{ __('Update Room') }}
                            </x-button>
                        </div>
                    </form>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <form method="POST" action="{{ route('rooms.destroy', $room) }}">
                            @csrf
                            @method('DELETE')
                            <x-danger-button onclick="return confirm('Are you sure you want to delete this room?')">
                                {{ __('Delete Room') }}
                            </x-danger-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
