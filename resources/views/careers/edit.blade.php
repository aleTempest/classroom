<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Career') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-validation-errors class="mb-4" />

                    @session('status')
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ $value }}
                        </div>
                    @endsession

                    <form method="POST" action="{{ route('careers.update', $career) }}">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-label for="name" value="{{ __('Career Name') }}" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name', $career->name)" required autofocus />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('careers.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900 me-4">
                                {{ __('Cancel') }}
                            </a>
                            <x-button>
                                {{ __('Update') }}
                            </x-button>
                        </div>
                    </form>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <form method="POST" action="{{ route('careers.destroy', $career) }}">
                            @csrf
                            @method('DELETE')
                            <x-danger-button onclick="return confirm('Are you sure you want to delete this career?')">
                                {{ __('Delete Career') }}
                            </x-danger-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
