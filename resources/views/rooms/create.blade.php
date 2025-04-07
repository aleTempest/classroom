<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Room') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-validation-errors class="mb-4" />

                    <form method="POST" action="{{ route('rooms.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <x-label for="career_id" value="{{ __('Career') }}" />
                                <select id="career_id" name="career_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" required>
                                    <option value="">{{ __('Select Career') }}</option>
                                    @foreach($careers as $career)
                                        <option value="{{ $career->id }}" {{ old('career_id') == $career->id ? 'selected' : '' }}>
                                            {{ $career->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <x-label for="code" value="{{ __('Room Code') }}" />
                                <x-input id="code" class="block mt-1 w-full" type="text" name="code" :value="old('code')" required />
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ __('Example: CS101 for Computer Science') }}
                                </p>
                            </div>

                            <div>
                                <x-label for="name" value="{{ __('Room Name') }}" />
                                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                            </div>

                            <div>
                                <x-label for="desc" value="{{ __('Description') }}" />
                                <textarea id="desc" name="desc" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('desc') }}</textarea>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('rooms.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900 me-4">
                                {{ __('Cancel') }}
                            </a>
                            <x-button>
                                {{ __('Create Room') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
