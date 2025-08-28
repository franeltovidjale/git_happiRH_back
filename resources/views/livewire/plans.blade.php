<div>
    <!-- Configuration Section -->
    <div class="mx-auto mb-16 max-w-4xl">
        <!-- Header -->
        <div class="mb-12 text-center">
            <h1 class="mb-4 text-4xl font-bold text-gray-900 sm:text-5xl">
                Sans engagement. Sans frais cachés.
            </h1>
            <p class="text-lg text-gray-600">
                18 000 entreprises ont déjà adopté notre solution de paie automatisée.
            </p>
        </div>

        <!-- Configuration Controls -->
        <div
            class="flex flex-col gap-8 justify-center items-center p-4 rounded-lg border border-primary-100 lg:flex-row lg:gap-16">
            <!-- Employee Count Selector -->
            <div class="flex items-center space-x-4">
                <div class="flex items-center bg-white rounded-lg border border-gray-200 shadow-sm">
                    <button wire:click="decrementEmployeeCount"
                        class="flex justify-center items-center w-12 h-12 text-gray-500 rounded-l-lg transition-colors hover:text-gray-700 hover:bg-gray-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                        </svg>
                    </button>
                    <div
                        class="flex justify-center items-center w-16 h-12 text-xl font-semibold text-gray-900 border-gray-200 border-x">
                        {{ $employeeCount }}
                    </div>
                    <button wire:click="incrementEmployeeCount"
                        class="flex justify-center items-center w-12 h-12 text-gray-500 rounded-r-lg transition-colors hover:text-gray-700 hover:bg-gray-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                    </button>
                </div>
                <span class="text-gray-700 border-b border-gray-400 border-dotted cursor-help">
                    collaborateurs
                </span>
            </div>

            <!-- Business Type Selection -->
            <div class="flex space-x-4">
                <!-- TPE / PME Card -->
                <div class="relative">
                    <div wire:click="setBusinessType('tpe_pme')"
                        class="p-4 w-48 h-32 bg-white rounded-lg transition-all cursor-pointer hover:shadow-md {{ $businessType === 'tpe_pme' ? 'border-2 border-blue-500' : 'border border-gray-200 hover:border-gray-300' }}">
                        <div class="flex flex-col h-full">
                            <div class="flex items-center mb-3">
                                <div
                                    class="flex justify-center items-center mr-3 w-8 h-8 {{ $businessType === 'tpe_pme' ? 'bg-blue-100' : 'bg-gray-100' }} rounded-lg">
                                    <svg class="w-5 h-5 {{ $businessType === 'tpe_pme' ? 'text-blue-600' : 'text-gray-600' }}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-semibold text-gray-900">TPE / PME</h3>
                                <p class="mt-1 text-xs text-gray-500">Entreprise établie</p>
                            </div>
                        </div>
                    </div>
                    <!-- Selected indicator -->
                    @if($businessType === 'tpe_pme')
                    <div class="absolute -top-1 -right-1 w-3 h-3 bg-blue-500 rounded-full"></div>
                    @endif
                </div>

                <!-- Tarif personnalisé Card -->
                <div class="relative">
                    <div wire:click="setBusinessType('custom')"
                        class="p-4 w-48 h-32 bg-white rounded-lg transition-all cursor-pointer hover:shadow-md {{ $businessType === 'custom' ? 'border-2 border-blue-500' : 'border border-gray-200 hover:border-gray-300' }}">
                        <div class="flex flex-col h-full">
                            <div class="flex items-center mb-3">
                                <div
                                    class="flex justify-center items-center mr-3 w-8 h-8 {{ $businessType === 'custom' ? 'bg-blue-100' : 'bg-gray-100' }} rounded-lg">
                                    <svg class="w-5 h-5 {{ $businessType === 'custom' ? 'text-blue-600' : 'text-gray-600' }}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-semibold text-gray-900">Tarif personnalisé</h3>
                                <p class="mt-1 text-xs text-gray-500">Premier versement de salaire</p>
                            </div>
                        </div>
                    </div>
                    <!-- Selected indicator -->
                    @if($businessType === 'custom')
                    <div class="absolute -top-1 -right-1 w-3 h-3 bg-blue-500 rounded-full"></div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <!-- Toggle button -->
    @if($businessType === 'tpe_pme')
    <div class="flex justify-center items-center mb-12 rounded-full backdrop-blur-sm">
        <button wire:click="toggleBillingCycle"
            class="bg-white text-primary-700 font-medium py-3 px-8 rounded-full soft-shadow-blue transition-all duration-500 ease-out hover:scale-105 hover:shadow-lg flex items-center space-x-3 group {{ $billingCycle === 'monthly' ? 'bg-white text-primary-700' : 'text-gray-500' }}">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-4 h-4 transition-transform duration-300 group-hover:scale-110" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path
                    d="M8 2v4M16 2v4M3 10h18M3 6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h18a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2H3z" />
                <path d="M9 14h6M9 18h6" />
            </svg>
            <span class="transition-all duration-300">MENSUEL</span>
        </button>
        <button wire:click="toggleBillingCycle"
            class="text-gray-500 font-medium py-3 px-8 rounded-full transition-all duration-500 ease-out hover:scale-105 hover:bg-white/50 hover:text-gray-700 flex items-center space-x-3 group {{ $billingCycle === 'yearly' ? 'bg-white text-primary-700' : 'text-gray-500' }}">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-4 h-4 transition-transform duration-300 group-hover:scale-110" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path
                    d="M8 2v4M16 2v4M3 10h18M3 6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h18a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2H3z" />
                <path d="M9 14h6M9 18h6" />
                <path d="M9 22h6" />
            </svg>
            <span class="transition-all duration-300">ANNUEL</span>
        </button>
    </div>
    @endif

    <!-- Promotional message for yearly -->
    @if($businessType === 'tpe_pme' && $billingCycle === 'yearly')
    <div class="mb-8 text-center">
        <div class="inline-flex items-center px-4 py-2 text-sm font-medium text-green-800 bg-green-100 rounded-full">
            <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd"></path>
            </svg>
            Économisez {{ number_format($yearlyPlanRate * 100) }}% avec le paiement annuel !
        </div>
    </div>
    @endif

    <!-- Pricing cards container -->
    <div
        class="{{ $businessType === 'custom' ? 'mx-auto max-w-4xl' : 'grid grid-cols-1 gap-8 mx-auto w-full md:grid-cols-3' }}">
        @foreach($this->plans as $plan)
        <div
            class="bg-white rounded-[32px] p-8 {{ $plan->is_recommended ? 'soft-shadow-blue' : 'soft-shadow-white' }} flex flex-col items-center text-center transition-all duration-500 ease-out hover:scale-105 hover:shadow-xl hover:-translate-y-2 hover:border-4 hover:border-primary-500 group relative {{ $businessType === 'custom' ? 'w-full' : '' }}">
            @if($plan->is_recommended)
            <div class="absolute -top-4 -right-4 w-24 h-24 rounded-full bg-primary/10"></div>
            <div class="absolute -bottom-6 -left-6 w-20 h-20 rounded-full bg-secondary/10"></div>
            <div class="absolute -right-2 top-8 w-12 h-12 rounded-full bg-primary/5"></div>
            <span
                class="absolute -top-3 left-1/2 z-20 px-4 py-1 text-xs font-semibold text-white rounded-full transform -translate-x-1/2 bg-primary">LE
                PLUS POPULAIRE</span>
            @endif

            @if($plan->is_custom_quote)
            <!-- Custom Quote Layout -->
            <div
                class="flex flex-col lg:flex-row items-center justify-between w-full gap-8 {{ $plan->is_recommended ? 'relative z-10' : '' }}">
                <!-- Left side - Pricing -->
                <div class="flex flex-col items-center text-center lg:items-start lg:text-left">
                    <div class="flex items-center mb-4">
                        <svg class="mr-3 w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <h3 class="text-2xl font-bold text-primary-700">{{ $plan->name }}</h3>
                    </div>
                    <div class="mb-6">
                        <span class="text-3xl font-extrabold text-orange-400">Sur devis</span>
                        <div class="mt-2 text-sm text-gray-600">Contactez-nous pour un devis personnalisé</div>
                    </div>
                    <a href="{{ route('public.register', ['plan' => $plan->slug]) }}"
                        class="inline-block px-8 py-3 w-full font-medium text-center text-white rounded-lg transition-colors lg:w-auto bg-secondary-600 hover:bg-secondary-700">
                        Choisir cette offre
                    </a>
                </div>

                <!-- Right side - Features -->
                <div class="flex flex-col items-center lg:items-start">

                    <p class="mb-6 text-sm text-gray-600">Démarrez du bon pied... et à prix doux !</p>

                    <div class="space-y-3 text-left">
                        @foreach($plan->features->take(4) as $feature)
                        @if($feature->pivot->is_enabled)
                        <div class="flex items-center space-x-3">
                            <svg class="flex-shrink-0 w-5 h-5 text-teal-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z" />
                            </svg>
                            <span class="text-gray-700">{{ $feature->name }}</span>
                        </div>
                        @endif
                        @endforeach
                    </div>

                    <a href="#" class="flex items-center mt-4 text-sm text-secondary-500 hover:text-secondary-600">
                        Voir toutes les fonctionnalités
                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
            @else
            <!-- Regular Pricing Layout -->
            <div class="mb-8 {{ $plan->is_recommended ? 'relative z-10' : '' }}">
                @if($billingCycle === 'monthly')
                @if($plan->price_per_employee > 0)
                <div class="text-center">
                    <span class="text-lg font-extrabold text-orange-400 sm:text-xl">{{ $this->formatTotalPrice($plan)
                        }}</span>
                    <span class="text-sm text-gray-500">/mois</span>
                    @if($employeeCount > 0)
                    <div class="mt-2 text-sm font-medium text-teal-600">
                        pour + {{ $employeeCount }} collaborateur{{ $employeeCount > 1 ? 's' : '' }}
                    </div>
                    @endif
                </div>
                @else
                <span class="text-lg font-extrabold text-orange-400 sm:text-xl">{{ $this->formatPrice($plan) }}</span>
                <span class="text-sm text-gray-500">/mois</span>
                @endif
                @if($this->getTrialInfo($plan))
                <div class="mt-1 text-sm font-medium text-green-600">
                    {{ $this->getTrialInfo($plan) }}
                </div>
                @endif
                @else
                @if($plan->price_per_employee > 0)
                <div class="text-center">
                    <span class="text-lg font-extrabold text-orange-400 sm:text-xl">{{
                        number_format($this->getYearlyPrice($this->calculateTotalPrice($plan)), 0, ',', ' ') }} {{
                        $plan->currency }}</span>
                    <span class="text-sm text-gray-500">/an</span>
                    <div class="mt-1 text-xs font-medium text-green-600">
                        {{
                        number_format($this->getMonthlyPriceFromYearly($this->getYearlyPrice($this->calculateTotalPrice($plan))),
                        0, ',', ' ')
                        }}
                        {{ $plan->currency }}/mois
                    </div>
                    @if($employeeCount > 0)
                    <div class="mt-2 text-sm font-medium text-teal-600">
                        + {{ $employeeCount }} collaborateur{{ $employeeCount > 1 ? 's' : '' }}
                    </div>
                    @endif
                </div>
                @else
                <span class="text-lg font-extrabold text-orange-400 sm:text-xl">{{
                    number_format($this->getYearlyPrice($plan->price), 0, ',', ' ') }} {{ $plan->currency }}</span>
                <span class="text-sm text-gray-500">/an</span>
                <div class="mt-1 text-xs font-medium text-green-600">
                    {{ number_format($this->getMonthlyPriceFromYearly($this->getYearlyPrice($plan->price)), 0, ',', ' ')
                    }}
                    {{ $plan->currency }}/mois
                </div>
                @endif
                @endif
            </div>
            @endif

            @if(!$plan->is_custom_quote)
            <h3 class="text-2xl font-bold text-primary-700 mb-4 {{ $plan->is_recommended ? 'relative z-10' : '' }}">{{
                $plan->name }}</h3>
            <p class="text-gray-500 text-sm mb-2 max-w-[200px] {{ $plan->is_recommended ? 'relative z-10' : '' }}">{{
                $plan->description }}</p>
            <p class="text-gray-400 text-xs mb-8 max-w-[200px] {{ $plan->is_recommended ? 'relative z-10' : '' }}">{{
                $plan->target_audience }}</p>

            <div class="space-y-4 mb-8 text-left w-full {{ $plan->is_recommended ? 'relative z-10' : '' }}">
                @foreach($plan->features as $feature)
                <div
                    class="flex items-center space-x-2 {{ $feature->pivot->is_enabled ? 'text-gray-600' : 'text-gray-400' }}">
                    @if($feature->pivot->is_enabled)
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-teal-500" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z" />
                    </svg>
                    @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                    @endif
                    <span>{{ $feature->name }}</span>
                </div>
                @endforeach
            </div>

            <a href="{{ route('public.register', ['plan' => $plan->slug, 'employeesCount' => $employeeCount, 'billingCycle' => $billingCycle]) }}"
                class="w-full {{ $plan->is_recommended ? 'bg-secondary-600 hover:bg-secondary-700 text-white' : 'bg-white hover:bg-gray-50 text-primary-600 border-2 border-primary-600' }} py-3 px-6 rounded-lg font-medium transition-colors {{ $plan->is_recommended ? 'relative z-10' : '' }} inline-block text-center">
                Commencer
            </a>

            <div class="mt-4 text-center {{ $plan->is_recommended ? 'relative z-10' : '' }}">
                <a href="#" class="text-sm transition-colors duration-200 text-secondary-500 hover:text-secondary-600">
                    Cela ne vous convient pas ? <span class="font-medium text-orange-500">Personnaliser</span>
                </a>
            </div>
            @endif
        </div>
        @endforeach
    </div>

</div>
