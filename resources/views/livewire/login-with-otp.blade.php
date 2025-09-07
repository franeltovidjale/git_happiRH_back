<div class="min-h-screen flex items-center justify-center bg-blue-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Card Container -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-10">
            <!-- Logo -->
            <div class="flex justify-center mb-8">
                <img src="{{ asset('logo.svg') }}" alt="{{ config('app.name') }}" class="w-14 h-14">
            </div>

            <!-- Welcome Text -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-primary-500 mb-3">{{ config('app.name') }}</h1>
                <p class="text-gray-600">
                    @if($currentStep === 1)
                    Enter your credentials to continue to {{ config('app.name') }}
                    @else
                    Enter the 6-digit code sent to {{ $user->email }}
                    @endif
                </p>
            </div>

            <!-- Error Message -->
            @if($errorMessage)
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-red-600 text-sm">{{ $errorMessage }}</p>
            </div>
            @endif

            <!-- Step 1: Email/Password Form -->
            @if($currentStep === 1)
            <form wire:submit.prevent="login" class="space-y-6">
                <div>
                    <input type="email" wire:model="email" placeholder="Email address*"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-400 text-gray-900"
                        required>
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <input type="password" wire:model="password" placeholder="Password*"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-400 text-gray-900"
                        required>
                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <button type="submit" wire:loading.attr="disabled"
                    class="w-full bg-primary-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-primary-700 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span wire:loading.remove>Continue</span>
                    <span wire:loading>Processing...</span>
                </button>
            </form>
            @endif

            <!-- Step 2: OTP Form -->
            @if($currentStep === 2)
            <form wire:submit.prevent="verifyOtp" class="space-y-6">
                <!-- OTP Input -->
                <div>
                    <input type="text" wire:model="otp" wire:keydown.enter="verifyOtp" placeholder="Enter 6-digit code"
                        maxlength="6"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-400 text-gray-900 text-center text-xl font-bold tracking-widest">
                </div>
                @error('otp') <span class="text-red-500 text-sm block text-center">{{ $message }}</span> @enderror

                <button type="submit" wire:loading.attr="disabled"
                    class="w-full bg-primary-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-primary-700 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span wire:loading.remove>Verify OTP</span>
                    <span wire:loading>Verifying...</span>
                </button>

                <!-- Back and Resend buttons -->
                <div class="flex justify-between items-center">
                    <button type="button" wire:click="goBack"
                        class="text-gray-600 hover:text-gray-800 text-sm font-medium">
                        ← Back to login
                    </button>

                    <button type="button" wire:click="resendOtp" wire:loading.attr="disabled"
                        class="text-primary-600 hover:text-primary-700 text-sm font-medium disabled:opacity-50">
                        <span wire:loading.remove>Resend OTP</span>
                        <span wire:loading>Sending...</span>
                    </button>
                </div>
            </form>
            @endif

            <!-- Help Link -->
            <div class="text-center mt-6">
                <span class="text-gray-600 text-sm">Connection trouble? </span>
                <a href="#" class="text-blue-600 text-sm hover:text-blue-700 font-medium">Visit our Help Center</a>
            </div>
        </div>
    </div>
</div>
