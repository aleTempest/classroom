<div>
    @if($showPassword)
        <span class="text-sm text-gray-500">{{ $teacher->user->password }}</span>
    @else
        <span class="text-sm text-gray-500">{{ $maskedPassword }}</span>
    @endif
    <button
        wire:click="togglePassword"
        class="ml-2 text-xs text-indigo-600 hover:text-indigo-900"
    >
        {{ $showPassword ? 'Hide' : 'Show' }}
    </button>
</div>
