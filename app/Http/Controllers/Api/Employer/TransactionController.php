<?php

namespace App\Http\Controllers\Api\Employer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Employer\EnterpriseTransactionResource;
use App\Models\EnterpriseTransaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of transactions
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $transactions = EnterpriseTransaction::forEnterprise(auth()->user()->currentEnterprise->id)
                ->with(['employer:id,name,email'])
                ->when($request->get('status'), function ($query, $status) {
                    return $query->byStatus($status);
                })
                ->orderBy('created_at', 'desc')
                ->paginate($request->get('per_page', 15));

            return $this->ok('Transactions récupérées avec succès', [
                'transactions' => EnterpriseTransactionResource::collection($transactions->items()),
                'meta' => [
                    'current_page' => $transactions->currentPage(),
                    'last_page' => $transactions->lastPage(),
                    'per_page' => $transactions->perPage(),
                    'total' => $transactions->total(),
                ],
            ]);
        } catch (\Exception $e) {
            logger()->error($e);

            return $this->serverError('Erreur lors de la récupération des transactions', null, $e->getMessage());
        }
    }
}
