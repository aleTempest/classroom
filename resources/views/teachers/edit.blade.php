<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Teacher') }}: {{ $teacher->full_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-validation-errors class="mb-4" />

                    <form method="POST" action="{{ route('teachers.update', $teacher) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Teacher Fields -->
                            <div>
                                <x-label for="first_name" value="{{ __('First Name') }}" />
                                <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
                                    :value="old('first_name', $teacher->first_name)" required autofocus />
                            </div>

                            <div>
                                <x-label for="last_name" value="{{ __('Last Name') }}" />
                                <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                                    :value="old('last_name', $teacher->last_name)" required />
                            </div>

                            <div>
                                <x-label for="date_of_birth" value="{{ __('Date of Birth') }}" />
                                <x-input id="date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth"
                                    :value="old('date_of_birth', optional($teacher->date_of_birth)->format('Y-m-d'))" />
                            </div>

                            <div>
                                <x-label for="gender" value="{{ __('Gender') }}" />
                                <select id="gender" name="gender" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                    <option value="">{{ __('Select gender') }}</option>
                                    <option value="male" {{ old('gender', $teacher->gender) == 'male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                                    <option value="female" {{ old('gender', $teacher->gender) == 'female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                                    <option value="other" {{ old('gender', $teacher->gender) == 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                </select>
                            </div>

                            <div>
                                <x-label for="salary" value="{{ __('Salary') }}" />
                                <x-input id="salary" class="block mt-1 w-full" type="number" step="0.01" name="salary"
                                    :value="old('salary', $teacher->salary)" />
                            </div>

                            <div>
                                <x-label for="phone_number" value="{{ __('Phone Number') }}" />
                                <x-input id="phone_number" class="block mt-1 w-full" type="tel" name="phone_number"
                                    :value="old('phone_number', $teacher->phone_number)" />
                            </div>

                            <!-- User Fields -->
                            <div>
                                <x-label for="email" value="{{ __('Email') }}" />
                                <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                                    :value="old('email', $teacher->user->email)" required />
                            </div>

                            <div>
                                <x-label for="password" value="{{ __('Password') }}" />
                                <x-input id="password" class="block mt-1 w-full" type="password" name="password"
                                    placeholder="{{ __('Leave blank to keep current password') }}" />
                            </div>

                            <div>
                                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                                <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                                    name="password_confirmation" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('teachers.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900 me-4">
                                {{ __('Cancel') }}
                            </a>
                            <x-button>
                                {{ __('Update Teacher') }}
                            </x-button>
                        </div>
                    </form>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <form method="POST" action="{{ route('teachers.destroy', $teacher) }}">
                            @csrf
                            @method('DELETE')
                            <x-danger-button onclick="return confirm('Are you sure you want to delete this teacher?')">
                                {{ __('Delete Teacher') }}
                            </x-danger-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
