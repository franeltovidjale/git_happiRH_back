@extends('layouts.web')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-50">
    <div class="p-8 w-full max-w-md">
        <!-- Success Icon -->
        <div class="flex justify-center mb-6">
            <div class="flex justify-center items-center w-16 h-16 bg-green-100 rounded-full">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>

        <!-- Success Message -->
        <div class="mb-8 text-center">
            <h1 class="mb-2 text-2xl font-bold text-gray-900">Compte créé avec succès !</h1>
            <p class="text-gray-600">Votre entreprise <strong>{{ $enterprise->name }}</strong> a été créée.</p>
        </div>

        <!-- Status Information -->
        <div class="p-6 mb-6 bg-gray-50 rounded-lg">
            <h3 class="mb-3 font-semibold text-gray-900">Statut de votre entreprise</h3>

            @switch($enterprise->status)
            @case('requested')
            <div class="flex items-center space-x-2">
                <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                <span class="font-medium text-yellow-800">En attente de validation</span>
            </div>
            <p class="mt-2 text-sm text-gray-600">
                Votre demande est en cours d'examen par notre équipe. Vous recevrez une notification une fois validée.
            </p>
            @break
            @case('active')
            <div class="flex items-center space-x-2">
                <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                <span class="font-medium text-green-800">Actif</span>
            </div>
            <p class="mt-2 text-sm text-gray-600">
                Votre compte est actif et vous pouvez commencer à utiliser toutes les fonctionnalités.
            </p>
            @break
            @case('pending')
            <div class="flex items-center space-x-2">
                <div class="w-3 h-3 bg-blue-400 rounded-full"></div>
                <span class="font-medium text-blue-800">En cours de traitement</span>
            </div>
            <p class="mt-2 text-sm text-gray-600">
                Votre demande est en cours de traitement. Vous serez notifié dès que possible.
            </p>
            @break
            @default
            <div class="flex items-center space-x-2">
                <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
                <span class="font-medium text-gray-800">{{ ucfirst($enterprise->status) }}</span>
            </div>
            @endswitch
        </div>

        <!-- Email Notification -->
        <div class="p-6 mb-6 bg-blue-50 rounded-lg border border-blue-200">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h4 class="mb-1 font-semibold text-blue-900">Email envoyé</h4>
                    <p class="text-sm text-blue-800">
                        Un email contenant vos identifiants de connexion a été envoyé à <strong>{{ $enterprise->email
                            }}</strong>.
                    </p>
                </div>
            </div>
        </div>

        <!-- Next Steps -->
        <div class="p-6 mb-6 bg-gray-50 rounded-lg">
            <h3 class="mb-3 font-semibold text-gray-900">Prochaines étapes</h3>
            <ul class="space-y-2 text-sm text-gray-600">
                <li class="flex items-start space-x-2">
                    <span class="mt-0.5 text-green-500">✓</span>
                    <span>Vérifiez votre boîte email</span>
                </li>
                <li class="flex items-start space-x-2">
                    <span class="mt-0.5 text-gray-400">2</span>
                    <span>Connectez-vous avec vos identifiants</span>
                </li>
                <li class="flex items-start space-x-2">
                    <span class="mt-0.5 text-gray-400">3</span>
                    <span>Changez votre mot de passe temporaire</span>
                </li>
                <li class="flex items-start space-x-2">
                    <span class="mt-0.5 text-gray-400">4</span>
                    <span>Complétez les informations de votre entreprise</span>
                </li>
            </ul>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-3">
            <a href="{{ route('welcome') }}"
                class="block px-6 py-3 w-full font-medium text-center text-white rounded-lg transition-colors bg-primary hover:bg-primary-700">
                Retour à l'accueil
            </a>

            <div class="text-center">
                <span class="text-sm text-gray-500">Besoin d'aide ?</span>
                <a href="mailto:support@example.com" class="ml-1 font-medium text-primary hover:text-primary-700">
                    Contactez-nous
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
