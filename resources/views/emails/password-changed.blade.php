<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe modifié - {{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .success-icon {
            background-color: #27ae60;
            color: white;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin: 20px auto;
        }

        .content {
            text-align: center;
            margin-bottom: 30px;
        }

        .info-box {
            background-color: #e8f5e8;
            border: 1px solid #27ae60;
            color: #155724;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: left;
        }

        .security-tips {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: left;
        }

        .contact-support {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #7f8c8d;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ecf0f1;
        }

        .btn {
            display: inline-block;
            background-color: #3498db;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo">{{ config('app.name') }}</div>
            <h1>Mot de passe modifié avec succès</h1>
            <div class="success-icon">✓</div>
        </div>

        <div class="content">
            @if($firstName)
            <p>Bonjour {{ $firstName }},</p>
            @else
            <p>Bonjour,</p>
            @endif

            <p>Votre mot de passe a été modifié avec succès le <strong>{{ date('d/m/Y à H:i') }}</strong>.</p>
        </div>

        <div class="info-box">
            <h3>✅ Confirmation de sécurité</h3>
            <p>Cette modification a été effectuée suite à votre demande de réinitialisation de mot de passe avec un code
                de vérification envoyé à votre adresse email.</p>
        </div>

        <div class="security-tips">
            <h3>🔒 Conseils de sécurité</h3>
            <ul>
                <li>Utilisez un mot de passe unique et complexe</li>
                <li>Ne partagez jamais vos identifiants</li>
                <li>Déconnectez-vous toujours après utilisation</li>
                <li>Vérifiez régulièrement vos activités de compte</li>
            </ul>
        </div>

        <div class="contact-support">
            <strong>Vous n'avez pas effectué cette modification ?</strong><br>
            Si vous n'êtes pas à l'origine de ce changement, contactez immédiatement notre support technique.
            <br><br>
            <a href="mailto:{{ config('app.support_email') }}" class="btn">Contacter le support</a>
        </div>

        <div class="footer">
            <p>Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.</p>
        </div>
    </div>
</body>

</html>
