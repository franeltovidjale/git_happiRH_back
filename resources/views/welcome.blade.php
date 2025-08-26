@extends('layouts.web')

@section('content')
<!-- Main Content Grid -->
<div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-16">
    <!-- Left Section -->
    <section class="flex flex-col justify-center">
        <span class="uppercase tracking-wide font-bold text-sm text-primary-500 mb-2">Solution RH Complète</span>
        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6">
            Simplifiez votre <span class="text-gradient-blue">gestion RH</span> avec notre <span
                class="text-gradient-blue">plateforme intelligente</span>.
        </h1>
        <p class="text-gray-500 text-base sm:text-lg mb-8 max-w-lg">
            Gérez vos employés, suivez les performances et optimisez vos processus RH en temps réel. Une solution
            complète pour les entreprises modernes.
        </p>
        <x-button variant="primary" size="lg" :fullWidth="$fullWidth ?? false" class="sm:w-fit">
            <span>Commencer Gratuitement</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
            </svg>
        </x-button>

        <!-- Stats -->
        <div
            class="flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-10 mt-8 sm:mt-12 lg:mt-16">
            <div class="text-left">
                <span class="text-3xl sm:text-4xl font-bold text-primary-700">500+</span>
                <p class="text-sm text-gray-500">Entreprises<br>satisfaites</p>
            </div>
            <div class="text-left">
                <span class="text-3xl sm:text-4xl font-bold text-primary-700">40%</span>
                <p class="text-sm text-gray-500">Gain de temps<br>en gestion RH</p>
            </div>
        </div>
    </section>

    <!-- Right Section with Cards -->
    <section class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
        <!-- Total Earning Card -->
        <div class="bg-gray-50 p-6 sm:p-8 rounded-3xl flex flex-col space-y-4">
            <div class="flex justify-between items-center">
                <span class="text-gray-500 font-medium text-sm">Employés Actifs</span>
                <div class="flex items-center text-green-500 text-xs font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>+15%</span>
                </div>
            </div>
            <span class="text-xl sm:text-2xl font-bold text-primary-700">1,247</span>
            <p class="text-gray-400 text-xs">Ce mois-ci</p>
            <div class="w-full h-24 sm:h-32 flex items-center justify-center">
                <!-- Placeholder for the radial chart -->
                <div
                    class="w-24 h-24 sm:w-32 sm:h-32 rounded-full radial-gradient-blue flex items-center justify-center">
                    <div class="w-18 h-18 sm:w-24 sm:h-24 bg-white rounded-full"></div>
                </div>
            </div>
        </div>
        <!-- Funnel Summary Card -->
        <div class="bg-gray-50 p-6 sm:p-8 rounded-3xl flex flex-col space-y-4">
            <span class="font-medium text-primary-700">Processus RH</span>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-gray-500 font-medium text-sm">Recrutement</span>
                    <div class="w-16 sm:w-20 h-2 rounded-full bg-teal-400"></div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-500 font-medium text-sm">Formation</span>
                    <div class="w-12 sm:w-16 h-2 rounded-full bg-primary-500"></div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-500 font-medium text-sm">Évaluation</span>
                    <div class="w-8 sm:w-12 h-2 rounded-full bg-secondary-500"></div>
                </div>
            </div>
        </div>
        <!-- Projections Card -->
        <div class="bg-gray-50 p-6 sm:p-8 rounded-3xl flex flex-col space-y-4 col-span-1 sm:col-span-2">
            <div class="flex justify-between items-center">
                <span class="font-medium text-primary-700">Performance RH</span>
                <div class="flex items-center space-x-2 text-gray-500 text-sm">
                    <span>Ce trimestre</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
            <!-- Placeholder for bar chart -->
            <div class="h-32 sm:h-40 flex items-end justify-between space-x-1 sm:space-x-2">
                <div class="flex flex-col items-center">
                    <div class="bg-primary-500 rounded-full w-3 h-6 sm:w-4 sm:h-8 relative">
                        <span
                            class="absolute -top-5 sm:-top-6 left-1/2 -translate-x-1/2 text-xs font-semibold text-primary-700">+85%</span>
                    </div>
                </div>
                <div class="bg-primary-300 rounded-full w-3 h-12 sm:w-4 sm:h-16"></div>
                <div class="bg-primary-300 rounded-full w-3 h-8 sm:w-4 sm:h-12"></div>
                <div class="bg-primary-300 rounded-full w-3 h-20 sm:w-4 sm:h-24"></div>
                <div class="bg-primary-300 rounded-full w-3 h-12 sm:w-4 sm:h-16"></div>
                <div class="bg-primary-300 rounded-full w-3 h-6 sm:w-4 sm:h-10"></div>
                <div class="bg-primary-300 rounded-full w-3 h-16 sm:w-4 sm:h-20"></div>
            </div>
        </div>
        <!-- Recognizable Card -->
        <div class="bg-gray-50 p-6 rounded-3xl flex items-center justify-between col-span-1 sm:col-span-2">
            <div class="flex -space-x-2 overflow-hidden">
                <img class="inline-block h-8 w-8 sm:h-10 sm:w-10 rounded-full ring-2 ring-white"
                    src="https://placehold.co/40x40/6ee7b7/000000?text=JP" alt="User 1">
                <img class="inline-block h-8 w-8 sm:h-10 sm:w-10 rounded-full ring-2 ring-white"
                    src="https://placehold.co/40x40/d8b4fe/000000?text=AT" alt="User 2">
                <img class="inline-block h-8 w-8 sm:h-10 sm:w-10 rounded-full ring-2 ring-white"
                    src="https://placehold.co/40x40/a5b4fc/000000?text=SM" alt="User 3">
                <div
                    class="inline-flex items-center justify-center h-8 w-8 sm:h-10 sm:w-10 rounded-full ring-2 ring-white bg-primary-500 text-white font-medium text-xs sm:text-sm">
                    +45
                </div>
            </div>
            <span class="font-medium text-primary-700">Équipes Actives</span>
        </div>
    </section>
</div>
@endsection
