<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Solution complète de gestion des ressources humaines</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#1045BD">
    <meta name="msapplication-TileColor" content="#1045BD">
    <meta name="msapplication-config" content="{{ asset('browserconfig.xml') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        .radial-gradient-blue {
            background-image: radial-gradient(circle at 100% 100%, #e0f2fe, #bfdbfe);
        }

        .text-gradient-blue {
            background-image: linear-gradient(to right, #1045BD, #9566F2);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
    </style>
    @stack('styles')

    @yield('links')

    @livewireStyles
</head>

<body class="bg-gray-100/80 text-foreground">

    <!-- Main Container -->
    <div class="max-w-7xl mx-auto p-4">

        <!-- Navigation Bar -->
        <header
            class="sticky top-0 z-50 bg-white backdrop-blur-sm flex justify-between items-center p-5 rounded-3xl mb-4 transition-all duration-300">
            <a href="/" class="flex items-center space-x-2">
                <img src="{{ asset('logo.svg') }}" alt="{{ config('app.name') }}" class="w-10 h-10">
                <span class="font-bold text-2xl text-primary-700">{{ config('app.name') }}</span>
            </a>
            <nav class="hidden md:flex space-x-6 lg:space-x-12 text-gray-600 font-medium">
                <a href="{{ route('features') }}" class="hover:text-primary-600">Features</a>
                <a href="{{ route('tarifs') }}" class="hover:text-primary-600">Tarifs</a>
                <a href="{{ route('demo') }}" class="hover:text-primary-600">Vidéos de démo</a>
                <a href="{{ route('resources') }}" class="hover:text-primary-600">Resources</a>
                <a href="{{ route('company') }}" class="hover:text-primary-600">Company</a>
            </nav>
            <div class="flex items-center space-x-4">
                <x-ui.button variant="secondary" size="md">Login</x-ui.button>
                <x-ui.button variant="primary" size="md" href="{{ route('public.register') }}">
                    <span>Démarrer gratuitement</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </x-ui.button>
            </div>
        </header>

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>
    </div>

    @livewireScripts()
    @stack('scripts')

    <script>
        // Détecter le scroll pour ajouter shadow à la navbar sticky
    window.addEventListener('scroll', function() {
        const header = document.querySelector('header');
        if (window.scrollY > 0) {
            header.classList.add('shadow');
        } else {
            header.classList.remove('shadow');
        }
    });
    </script>
</body>

</html>
