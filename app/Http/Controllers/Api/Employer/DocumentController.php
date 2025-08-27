<?php

namespace App\Http\Controllers\Api\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employer\StoreDocumentRequest;
use App\Http\Requests\Employer\UpdateDocumentRequest;
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

        return $this->ok('Documents récupérés avec succès', $documents);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentRequest $request): JsonResponse
    {
        $enterprise = $this->getActiveEnterprise();

        $member = Member::where('enterprise_id', $enterprise->id)
            ->findOrFail($request->member_id);

        $data = $request->validated();
        $file = $request->file('file');

        $document = $this->documentService->save($data, $member, $enterprise, $file);

        return $this->created('Document créé avec succès', $document->load('documentable.user'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocumentRequest $request, Document $document): JsonResponse
    {
        $enterprise = $this->getActiveEnterprise();

        $data = $request->validated();
        $file = $request->file('file');

        $updatedDocument = $this->documentService->update($data, $document->id, $enterprise, $file);

        return $this->ok('Document mis à jour avec succès', $updatedDocument->load('documentable.user'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Document $document): JsonResponse
    {
        $enterprise = $this->getActiveEnterprise();

        $this->documentService->delete($document->id, $enterprise);

        return $this->ok('Document supprimé avec succès');
    }
}