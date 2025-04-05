<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Student') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-validation-errors class="mb-4" />

                    <form method="POST" action="{{ route('students.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- User Fields -->
                            <div>
                                <x-label for="name" value="{{ __('Full Name') }}" />
                                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            </div>

                            <div>
                                <x-label for="email" value="{{ __('Email') }}" />
                                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                            </div>

                            <div>
                                <x-label for="password" value="{{ __('Password') }}" />
                                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                            </div>

                            <div>
                                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                            </div>

                            <!-- Student Fields -->
                            <div>
                                <x-label for="enrollment" value="{{ __('Enrollment Number') }}" />
                                <x-input id="enrollment" class="block mt-1 w-full" type="text" name="enrollment" :value="old('enrollment')" required />
                            </div>

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
                                <x-label for="date_of_birth" value="{{ __('Date of Birth') }}" />
                                <x-input id="date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth" :value="old('date_of_birth')" required />
                            </div>

                            <div>
                                <x-label for="phone_number" value="{{ __('Phone Number') }}" />
                                <x-input id="phone_number" class="block mt-1 w-full" type="tel" name="phone_number" :value="old('phone_number')" required />
                            </div>

                            <div>
                                <x-label for="emergency_contact" value="{{ __('Emergency Contact') }}" />
                                <x-input id="emergency_contact" class="block mt-1 w-full" type="text" name="emergency_contact" :value="old('emergency_contact')" required />
                            </div>

                            <div>
                                <x-label for="address" value="{{ __('Address') }}" />
                                <x-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required />
                            </div>

                            <div>
                                <x-label for="enrollment_date" value="{{ __('Enrollment Date') }}" />
                                <x-input id="enrollment_date" class="block mt-1 w-full" type="date" name="enrollment_date" :value="old('enrollment_date', now()->format('Y-m-d'))" required />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('students.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900 me-4">
                                {{ __('Cancel') }}
                            </a>
                            <x-button>
                                {{ __('Create Student') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
