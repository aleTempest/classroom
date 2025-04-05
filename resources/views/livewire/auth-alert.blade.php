@props([
    'role' => 'admin',
    'title' => 'Access Denied',
    'message' => 'You are not authorized to view this page.',
    'showHomeButton' => true,
    'showBackButton' => true,
    'icon' => 'shield-exclamation' // Options: shield-exclamation, lock-closed, ban
])

@if(auth()->user()->role === $role)
    {{ $slot }}
@else
    <div class="min-h-screen flex items-center justify-center bg-gray-50 p-4 sm:p-6">
        <div class="w-full max-w-md bg-white rounded-xl shadow-md overflow-hidden p-6 space-y-6">
            <!-- Icon Section -->
            <div class="flex justify-center">
                @if($icon === 'shield-exclamation')
                <svg class="h-16 w-16 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                @elseif($icon === 'lock-closed')
                <svg class="h-16 w-16 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                @else
                <svg class="h-16 w-16 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>
                @endif
            </div>

            <!-- Text Content -->
            <div class="text-center space-y-2">
                <h1 class="text-2xl font-bold text-gray-800">{{ $title }}</h1>
                <p class="text-gray-600">{{ $message }}</p>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row justify-center gap-3 pt-4">
                @if($showBackButton)
                <a href="{{ url()->previous() }}"
                   class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    ← Go Back
                </a>
                @endif

                @if($showHomeButton)
                <a href="/"
                   class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Return Home
                </a>
                @endif
            </div>
        </div>
    </div>
@endif
