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
                <h2 class="text-2xl font-bold text-center">Choisissez votre plan</h2>

                <div class="space-y-4">
                    @foreach($availablePlans as $plan)
                    <div class="border-2 rounded-lg p-4 cursor-pointer transition-all {{ $selectedPlanId == $plan->id ? 'border-primary bg-primary-50' : 'border-gray-200 hover:border-gray-300' }}"
                        wire:click="selectPlan({{ $plan->id }})">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-semibold text-lg">{{ $plan->name }}</h3>
                                <p class="text-gray-600 text-sm">{{ $plan->description }}</p>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-primary">{{ number_format($plan->price) }} {{
                                    $plan->currency }}</div>
                                <div class="text-sm text-gray-500">/mois</div>
                            </div>
                        </div>

                        @if($selectedPlanId == $plan->id)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <h4 class="font-medium mb-2">Fonctionnalités incluses:</h4>
                            <ul class="space-y-1 text-sm">
                                @foreach($plan->features->where('pivot.is_enabled', true)->take(5) as $feature)
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $feature->name }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                    @endforeach
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

                <form wire:submit.prevent="register" class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email
                            professionnel</label>
                        <input type="email" id="email" wire:model="email"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="contact@votreentreprise.com">
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Numéro de
                            téléphone</label>
                        <input type="tel" id="phone" wire:model="phone"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="+33 1 23 45 67 89">
                        @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="countryCode" class="block text-sm font-medium text-gray-700 mb-1">Pays</label>
                        <select id="countryCode" wire:model="countryCode"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="">Sélectionnez un pays</option>
                            @foreach($this->countries as $country)
                            <option value="{{ $country->code }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                        @error('countryCode') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="employeeCount" class="block text-sm font-medium text-gray-700 mb-1">Nombre
                            d'employés</label>
                        <input type="number" id="employeeCount" wire:model="employeeCount" min="1" max="1000"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="10">
                        @error('employeeCount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                        <div class="relative">
                            <input type="{{ $showPassword ? 'text' : 'password' }}" id="password" wire:model="password"
                                class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="••••••••">
                            <button type="button" wire:click="togglePassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                @if($showPassword)
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21">
                                    </path>
                                </svg>
                                @else
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                                @endif
                            </button>
                        </div>
                        @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex space-x-4">
                        <button type="button" wire:click="previousStep"
                            class="flex-1 bg-gray-200 text-gray-700 py-3 px-6 rounded-lg font-medium hover:bg-gray-300 transition-colors">
                            Retour
                        </button>
                        <button type="submit"
                            class="flex-1 bg-primary text-white py-3 px-6 rounded-lg font-medium hover:bg-primary-700 transition-colors">
                            Créer mon compte
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
