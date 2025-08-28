<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Changement de statut</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .status-message {
            background-color: #e7f3ff;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin: 20px 0;
            font-size: 16px;
            font-weight: bold;
        }

        .note {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 10px;
            border-radius: 3px;
            margin: 15px 0;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            font-size: 12px;
            color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Notification de statut</h2>
    </div>

    <div class="status-message">
        @switch($newStatus)
        @case('active')
        Votre compte a été activé avec succès.
        @break
        @case('suspended')
        Votre compte a été mis en pause temporairement.
        @break
        @case('terminated')
        Votre compte a été désactivé.
        @break
        @case('rejected')
        Votre demande d'accès a été refusée.
        @break
        @case('requested')
        Votre demande d'accès est en cours de traitement.
        @break
        @default
        Le statut de votre compte a été modifié.
        @endswitch
    </div>

    @if($statusNote)
    <div class="note">
        <strong>Information complémentaire :</strong><br>
        {{ $statusNote }}
    </div>
    @endif

    <p>
        Si vous avez des questions concernant ce changement, veuillez contacter votre responsable ou le service des
        ressources humaines.
    </p>

    <div class="footer">
        <p>Cet email a été envoyé automatiquement par le système HappyRH.</p>
        <p>Merci de ne pas répondre à cet email.</p>
    </div>
</body>

</html>
