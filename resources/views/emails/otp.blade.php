<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code de vérification</title>
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

        .otp-code {
            background-color: #3498db;
            color: white;
            font-size: 36px;
            font-weight: bold;
            padding: 15px;
            border-radius: 6px;
            letter-spacing: 8px;
            margin: 25px 0;
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

        @if($firstName)
        <p>Bonjour {{ $firstName }},</p>
        @endif

        <p>Votre code de vérification :</p>

        <div class="otp-code">{{ $otpCode }}</div>

        <p class="note">
            Ce code expire dans 10 minutes.<br>
            Ne le partagez avec personne.
        </p>
    </div>
</body>

</html>
