<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code de vérification - HappyHR</title>
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

        .otp-code {
            background-color: #3498db;
            color: white;
            font-size: 32px;
            font-weight: bold;
            text-align: center;
            padding: 20px;
            border-radius: 8px;
            letter-spacing: 5px;
            margin: 20px 0;
        }

        .content {
            text-align: center;
            margin-bottom: 30px;
        }

        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #7f8c8d;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ecf0f1;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo">HappyHR</div>
            <h1>Code de vérification</h1>
        </div>

        <div class="content">
            @if($firstName)
            <p>Bonjour {{ $firstName }},</p>
            @else
            <p>Bonjour,</p>
            @endif

            <p>Vous avez demandé la réinitialisation de votre mot de passe. Voici votre code de vérification :</p>

            <div class="otp-code">
                {{ $otpCode }}
            </div>

            <p>Saisissez ce code pour continuer la réinitialisation de votre mot de passe.</p>
        </div>

        <div class="warning">
            <strong>Important :</strong>
            <ul style="text-align: left; margin: 10px 0;">
                <li>Ce code expire dans 10 minutes</li>
                <li>Ne partagez jamais ce code avec qui que ce soit</li>
                <li>Si vous n'avez pas demandé cette réinitialisation, ignorez cet email</li>
            </ul>
        </div>

        <div class="footer">
            <p>Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
            <p>&copy; {{ date('Y') }} HappyHR. Tous droits réservés.</p>
        </div>
    </div>
</body>

</html>
