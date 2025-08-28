<div class="min-h-screen flex items-center justify-center">
    <div class="flex flex-col md:flex-row bg-white w-full rounded-3xl overflow-hidden">

        <!-- Left Section (Registration Form) -->
        <div class="w-full md:w-1/2 p-8 md:p-16 flex flex-col items-center justify-center">
            <!-- Logo -->
            <div class="flex items-center space-x-2 mb-8">
                <img src="{{ asset('logo.svg') }}" alt="{{ config('app.name') }}" class="w-12 h-12">
                <span class="font-bold text-2xl text-primary-700">{{ config('app.name') }}</span>
            </div>

            <p class="text-gray-500 mb-8">Commencez votre gestion RH en quelques étapes</p>

            <!-- Step Indicator -->
            <div class="flex items-center space-x-4 mb-8">
                <div class="flex items-center">
                    <div
                        class="w-8 h-8 rounded-full flex items-center justify-center {{ $currentStep >= 1 ? 'bg-primary text-white' : 'bg-gray-200 text-gray-500' }}">
                        1
                    </div>
                    <span class="ml-2 text-sm {{ $currentStep >= 1 ? 'text-primary' : 'text-gray-500' }}">Plan</span>
                </div>
                <div class="w-8 h-0.5 bg-gray-200"></div>
                <div class="flex items-center">
                    <div
                        class="w-8 h-8 rounded-full flex items-center justify-center {{ $currentStep >= 2 ? 'bg-primary text-white' : 'bg-gray-200 text-gray-500' }}">
                        2
                    </div>
                    <span class="ml-2 text-sm {{ $currentStep >= 2 ? 'text-primary' : 'text-gray-500' }}">Compte</span>
                </div>
            </div>

            <!-- Step 1: Plan Selection -->
            @if($currentStep === 1)
            <div class="w-full max-w-md space-y-6">
                <h2 class="text-2xl font-bold text-center">Votre plan sélectionné</h2>

                <div class="border-2 border-primary bg-primary-50 rounded-lg p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-semibold text-lg">{{ $selectedPlan->name }}</h3>
                            <p class="text-gray-600 text-sm">{{ $selectedPlan->description }}</p>
                            <div class="mt-2">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $billingCycle === 'yearly' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $billingCycle === 'yearly' ? 'Facturation annuelle' : 'Facturation mensuelle' }}
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-primary">{{ $this->formatTotalPrice() }}</div>
                            @if($billingCycle === 'yearly' && $this->getMonthlyPriceFromYearly())
                            <div class="text-sm text-gray-500">{{ $this->getMonthlyPriceFromYearly() }}</div>
                            @endif
                        </div>
                    </div>

                    @if($employeesCount > 0 && $selectedPlan->price_per_employee > 0)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Prix de base:</span>
                            <span class="font-medium">{{ $this->formatBasePrice() }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">{{ $employeesCount }} employé{{ $employeesCount > 1 ? 's' : ''
                                }} × {{ $this->formatPricePerEmployee() }}:</span>
                            <span class="font-medium">{{ $this->formatTotalPrice() }}</span>
                        </div>
                    </div>
                    @endif
                </div>

                <button wire:click="nextStep"
                    class="w-full bg-primary text-white py-3 px-6 rounded-lg font-medium hover:bg-primary-700 transition-colors">
                    Continuer
                </button>
            </div>
            @endif

            <!-- Step 2: Account Information -->
            @if($currentStep === 2)
            <div class="w-full max-w-md space-y-6">
                <h2 class="text-2xl font-bold text-center">Créer votre compte</h2>

                @if(session()->has('error'))
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
                @endif

                @if(session()->has('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <form wire:submit.prevent="register" class="space-y-4 {{ $isProcessing ? 'cursor-wait' : '' }}">
                    <div>
                        <label for="enterpriseName" class="block text-sm font-medium text-gray-700 mb-1">Nom de
                            l'entreprise</label>
                        <input type="text" id="enterpriseName" wire:model="enterpriseName"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent {{ $isProcessing ? 'cursor-wait' : '' }}"
                            placeholder="Nom de votre entreprise" {{ $isProcessing ? 'disabled' : '' }}>
                        @error('enterpriseName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email
                            professionnel</label>
                        <input type="email" id="email" wire:model="email"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent {{ $isProcessing ? 'cursor-wait' : '' }}"
                            placeholder="contact@votreentreprise.com" {{ $isProcessing ? 'disabled' : '' }}>
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Numéro de
                            téléphone</label>
                        <input type="tel" id="phone" wire:model="phone"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent {{ $isProcessing ? 'cursor-wait' : '' }}"
                            placeholder="+33 1 23 45 67 89" {{ $isProcessing ? 'disabled' : '' }}>
                        @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="countryCode" class="block text-sm font-medium text-gray-700 mb-1">Pays</label>
                        <select id="countryCode" wire:model="countryCode"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent {{ $isProcessing ? 'cursor-wait' : '' }}"
                            {{ $isProcessing ? 'disabled' : '' }}>
                            <option value="">Sélectionnez un pays</option>
                            @foreach($this->countries as $country)
                            <option value="{{ $country->code }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                        @error('countryCode') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>





                    <div class="flex space-x-4">
                        <button type="button" wire:click="previousStep"
                            class="flex-1 bg-gray-200 text-gray-700 py-3 px-6 rounded-lg font-medium hover:bg-gray-300 transition-colors {{ $isProcessing ? 'cursor-wait' : '' }}"
                            {{ $isProcessing ? 'disabled' : '' }}>
                            Retour
                        </button>
                        <button type="submit"
                            class="flex-1 bg-primary text-white py-3 px-6 rounded-lg font-medium hover:bg-primary-700 transition-colors flex items-center justify-center {{ $isProcessing ? 'cursor-wait' : '' }}"
                            {{ $isProcessing ? 'disabled' : '' }}>
                            @if($isProcessing)
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Création en cours...
                            @else
                            Créer mon compte
                            @endif
                        </button>
                    </div>
                </form>

                <div class="text-center">
                    <span class="text-gray-500">Déjà un compte ?</span>
                    <a href="#" class="text-primary hover:text-primary-700 font-medium ml-1">Se connecter</a>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Section (Marketing) -->
        <div
            class="hidden md:flex w-full md:w-1/2 bg-primary text-white p-12 lg:p-16 flex-col items-center justify-center text-center relative overflow-hidden">
            <!-- Creative, minimalist graphic elements -->
            <div class="absolute w-64 h-64 bg-primary-400 rounded-full opacity-20 -top-16 -left-16 transform rotate-45">
            </div>
            <div
                class="absolute w-40 h-40 bg-primary-300 rounded-full opacity-10 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
            </div>
            <div class="absolute w-80 h-80 bg-primary-600 rounded-full opacity-10 -bottom-20 -right-20"></div>

            <div class="relative z-10">
                <h2 class="text-4xl font-extrabold mb-4 leading-relaxed">
                    Une <span class="text-primary-200">solution</span> de gestion
                    <br class="hidden lg:block"> moderne pour vos
                    <br class="hidden lg:block">ressources humaines.
                </h2>
                <p class="text-primary-200 mb-8 max-w-sm">
                    Rationalisez vos tâches RH. {{ config('app.name') }} gère sans effort la présence, les déplacements
                    et la paie.
                </p>
            </div>
        </div>

    </div>
</div>
