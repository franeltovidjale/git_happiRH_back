<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\JsonResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function badRequest($message = 'Requête invalide', $data = null, $error = null, $responseCode = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
            'error' => $error
        ], $responseCode ?? 400);
    }

    protected function conflict($message = 'Conflit détecté', $data = null, $error = null, $responseCode = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
            'error' => $error
        ], $responseCode ?? 409);
    }

    protected function unprocessable($message = 'Données non traitées', $data = null, $error = null, $responseCode = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
            'error' => $error
        ], $responseCode ?? 422);
    }

    protected function created($message = 'Créé avec succès', $data = null, $error = null, $responseCode = null): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'error' => $error
        ], $responseCode ?? 201);
    }

    protected function ok($message = 'Opération réussie', $data = null, $error = null, $responseCode = null): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'error' => $error
        ], $responseCode ?? 200);
    }

    protected function serverError($message = 'Une erreur inattendue s\'est produite', $data = null, $error = null, $responseCode = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
            'error' => $error
        ], $responseCode ?? 500);
    }

    protected function notFound($message = 'Ressource introuvable', $data = null, $error = null, $responseCode = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
            'error' => $error
        ], $responseCode ?? 404);
    }

    protected function unauthorized($message = 'Vous n\'êtes pas autorisé(e) à accéder à cette page', $data = null, $error = null, $responseCode = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
            'error' => $error
        ], $responseCode ?? 401);
    }

    protected function forbidden($message = 'Accès interdit', $data = null, $error = null, $responseCode = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
            'error' => $error
        ], $responseCode ?? 403);
    }

    protected function noContent($message = 'Aucun contenu', $data = null, $error = null, $responseCode = null): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'error' => $error
        ], $responseCode ?? 204);
    }
}