<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue dans l'équipe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 600px;
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

        .welcome-icon {
            background-color: #3498db;
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

        .credentials-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 20px;
            margin: 20px 0;
            text-align: left;
        }

        .credential-item {
            margin: 10px 0;
            padding: 10px;
            background: white;
            border-radius: 3px;
            border-left: 4px solid #3498db;
        }

        .credential-label {
            font-weight: bold;
            color: #2c3e50;
            display: block;
            margin-bottom: 5px;
        }

        .credential-value {
            font-family: 'Courier New', monospace;
            background-color: #f1f2f6;
            padding: 5px 8px;
            border-radius: 3px;
            word-break: break-all;
        }

        .security-warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            font-size: 14px;
        }

        .next-steps {
            background-color: #e8f5e8;
            border: 1px solid #c3e6c3;
            color: #2d5a2d;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: left;
        }

        .next-steps h4 {
            margin-top: 0;
            color: #2d5a2d;
        }

        .next-steps ul {
            margin: 10px 0;
            padding-left: 20px;
        }

        .note {
            font-size: 14px;
            color: #666;
            margin-top: 20px;
        }

        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">{{ config('app.name') }}</div>

        <div class="welcome-icon">👋</div>

        <h2>Bienvenue dans l'équipe !</h2>

        <p>Bonjour {{ $firstName }} {{ $lastName }},</p>

        <p>{{ $employerName }} vous a ajouté(e) en tant qu'employé(e) sur {{ config('app.name') }}. Voici vos
            informations de connexion :</p>

        <div class="credentials-box">
            <h3 style="margin-top: 0; color: #2c3e50;">🔑 Vos identifiants de connexion</h3>

            <div class="credential-item">
                <span class="credential-label">Email :</span>
                <span class="credential-value">{{ $email }}</span>
            </div>

            <div class="credential-item">
                <span class="credential-label">Mot de passe temporaire :</span>
                <span class="credential-value">{{ $password }}</span>
            </div>
        </div>

        <div class="security-warning">
            <strong>⚠️ Important :</strong><br>
            Pour votre sécurité, nous vous recommandons fortement de changer ce mot de passe temporaire lors de votre
            première connexion.
        </div>

        <div class="next-steps">
            <h4>📋 Prochaines étapes :</h4>
            <ul>
                <li>Connectez-vous à votre compte avec les identifiants ci-dessus</li>
                <li>Changez votre mot de passe temporaire</li>
                <li>Complétez votre profil si nécessaire</li>
                <li>Explorez les fonctionnalités disponibles</li>
            </ul>
        </div>

        <a href="{{ config('app.url') }}" class="button">Se connecter</a>

        <p class="note">
            Si vous avez des questions, n'hésitez pas à contacter {{ $employerName }} ou notre support technique.<br>
            {{ config('app.name') }} - Cet email a été envoyé automatiquement.
        </p>
    </div>
</body>

</html>