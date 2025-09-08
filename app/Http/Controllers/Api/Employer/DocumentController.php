<?php

namespace App\Http\Controllers\Api\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Employer\Documents\StoreDocumentRequest;
use App\Http\Requests\Api\Employer\Documents\UpdateDocumentRequest;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use App\Models\Member;
use App\Services\DocumentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function __construct(
        private DocumentService $documentService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $enterprise = $this->getActiveEnterprise();

        $filters = $request->only(['search', 'member_id', 'scope', 'active', 'per_page']);
        $documents = $this->documentService->getDocumentsForEnterprise($enterprise, $filters);

        return $this->ok('Documents récupérés avec succès', DocumentResource::collection($documents));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentRequest $request): JsonResponse
    {
        try {
            $enterprise = $this->getActiveEnterprise();

            $member = Member::where('enterprise_id', $enterprise->id)
                ->findOrFail($request->member_id);

            $data = $request->validated();
            $file = $request->file('file');

            $document = $this->documentService->save($data, $member, $enterprise, $file);

            return $this->created('Document créé avec succès', $document->load('documentable.user'));
        } catch (\Throwable $e) {
            logger()->error('Erreur lors de la création du document: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->except(['file']),
            ]);

            return $this->error('Erreur lors de la création du document', 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocumentRequest $request, Document $document): JsonResponse
    {
        try {
            $enterprise = $this->getActiveEnterprise();

            $data = $request->validated();
            $file = $request->file('file');

            $updatedDocument = $this->documentService->update($data, $document->id, $enterprise, $file);

            return $this->ok('Document mis à jour avec succès', DocumentResource::make($updatedDocument));
        } catch (\Throwable $e) {
            logger()->error($e);

            return $this->error('Erreur lors de la mise à jour du document', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Document $document): JsonResponse
    {
        try {
            $enterprise = $this->getActiveEnterprise();

            $this->documentService->delete($document->id, $enterprise);

            return $this->ok('Document supprimé avec succès');
        } catch (\Throwable $e) {
            logger()->error('Erreur lors de la suppression du document: ' . $e->getMessage(), [
                'exception' => $e,
                'document_id' => $document->id,
            ]);

            return $this->error('Erreur lors de la suppression du document', 500);
        }
    }
}
