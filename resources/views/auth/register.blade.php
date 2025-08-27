@extends('layouts.web')

@section('content')
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

            <!-- Registration Form -->
            <form class="space-y-4 w-full max-w-sm">
                <x-ui.input type="email" name="email" label="Email professionnel"
                    placeholder="contact@votreentreprise.com" required />

                <x-ui.input type="tel" name="phone" label="Numéro de téléphone" placeholder="+33 1 23 45 67 89"
                    required />

                <x-ui.input type="password" name="password" label="Mot de passe" placeholder="••••••••" required />

                <x-ui.button type="submit" variant="primary" size="lg" :fullWidth="true">
                    Créer mon compte
                </x-ui.button>

                <div class="text-center">
                    <span class="text-gray-500">Déjà un compte ?</span>
                    <a href="#" class="text-primary hover:text-primary-700 font-medium ml-1">Se connecter</a>
                </div>
            </form>
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
@endsection
