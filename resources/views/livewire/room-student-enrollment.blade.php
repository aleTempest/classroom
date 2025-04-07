<div>
    <!-- Search Bar -->
    <div class="mb-4">
        <x-label value="{{ __('Search Students') }}" />
        <div class="relative">
            <x-input
                wire:model.live="search"
                type="text"
                placeholder="{{ __('Search by name or email') }}"
                class="w-full"
            />
            @if($search)
                <button wire:click="$set('search', '')" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </button>
            @endif
        </div>
    </div>

    <!-- Search Results -->

@if($search && count($searchResults) > 0)
        <div class="mb-6 bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-4 py-2 bg-gray-50 border-b border-gray-200">
                <p class="text-sm font-medium text-gray-700">{{ __('Search Results') }}</p>
            </div>
            <ul class="divide-y divide-gray-200">
                @foreach($searchResults as $student)
                    <li class="px-4 py-3 hover:bg-gray-50 cursor-pointer flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $student->name }}</p>
                            <p class="text-xs text-gray-500">{{ $student->email }}</p>
                        </div>
                        <button
                            wire:click.prevent="toggleStudent({{ $student->id }})"
                            class="text-sm {{ in_array($student->id, $selectedStudents) ? 'text-green-600' : 'text-gray-400 hover:text-gray-600' }}"
                        >
                            @if(in_array($student->id, $selectedStudents))
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                            @endif
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    @elseif($search)
        <div class="mb-6 p-4 text-center text-sm text-gray-500">
            {{ __('No students found') }}
        </div>
    @endif

    <!-- Selected Students -->
    <div>
        <div class="flex justify-between items-center mb-2">
            <x-label value="{{ __('Enrolled Students') }}" />

<button wire:click.prevent="saveEnrollments">
    {{ __('Save Changes') }}
</button>
        </div>

        @if(count($selectedStudents) > 0)
            <ul class="space-y-2">
@foreach($enrolledStudents as $student)
    @if(in_array($student['id'], $selectedStudents))
                        <li class="flex items-center justify-between bg-white p-3 rounded-lg shadow-sm border border-gray-200">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $student['name'] }}</p>
                                <p class="text-xs text-gray-500">{{ $student['email'] }}</p>
                            </div>
                            <button
                                wire:click.prevent="removeStudent({{ $student['id'] }})"
                                class="text-red-600 hover:text-red-900 text-sm"
                            >
                                {{ __('Remove') }}
                            </button>
                        </li>
                    @endif
                @endforeach
            </ul>
        @else
            <div class="bg-white p-4 rounded-lg border border-gray-200 text-center text-sm text-gray-500">
                {{ __('No students enrolled') }}
            </div>
        @endif
    </div>

    @if (session()->has('message'))
        <div class="mt-4 px-4 py-2 bg-green-100 border border-green-200 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif
</div>
