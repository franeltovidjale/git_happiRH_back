<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe modifié</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            text-align: center;
        }

        .logo {
            font-size: 20px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .success-icon {
            background-color: #27ae60;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin: 20px auto;
        }

        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            font-size: 14px;
        }

        .note {
            font-size: 14px;
            color: #666;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">{{ config('app.name') }}</div>

        <div class="success-icon">✓</div>

        <h2>Mot de passe modifié</h2>

        @if($firstName)
        <p>Bonjour {{ $firstName }},</p>
        @endif

        <p>Votre mot de passe a été modifié avec succès le {{ date('d/m/Y à H:i') }}.</p>

        <div class="warning">
            <strong>Vous n'avez pas effectué cette modification ?</strong><br>
            Contactez immédiatement notre support :
            <a href="mailto:{{ config('app.support_email', 'support@example.com') }}">{{ config('app.support_email',
                'support@example.com') }}</a>
        </div>

        <p class="note">
            {{ config('app.name') }} - Cet email a été envoyé automatiquement.
        </p>
    </div>
</body>

</html>
