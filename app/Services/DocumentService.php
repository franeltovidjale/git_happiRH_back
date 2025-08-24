<?php

namespace App\Services;

use App\Contracts\Documentable;
use App\Models\Document;
use App\Models\Enterprise;
use App\Models\Member;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DocumentService
{
    /**
     * Save a new document for a documentable model.
     */
    public function save(array $data, Documentable $documentable, Enterprise $enterprise, ?UploadedFile $file = null): Document
    {
        // Verify the documentable belongs to the enterprise
        if ($documentable->getEnterpriseId() !== $enterprise->id) {
            throw new ModelNotFoundException('Documentable not found in this enterprise.');
        }

        $scope = $data['scope'] ?? 'private';

        if ($scope === 'private') {
            $disk = 'local';
        } else {
            $disk = 'public';
        }

        // Handle file upload if provided
        $path = null;
        if ($file) {
            $path = $this->uploadFile($file, $enterprise, $documentable, $disk);
        }

        // Use the documents() relationship to create the document
        return $documentable->documents()->create([
            'key' => $data['key'],
            'name' => $data['name'],
            'path' => $path ?? $data['path'] ?? null,
            'active' => $data['active'] ?? true,
            'scope' => $data['scope'] ?? 'private',
        ]);
    }

    /**
     * Update an existing document.
     */
    public function update(array $data, int $documentId, Enterprise $enterprise, ?UploadedFile $file = null): Document
    {
        $document = Document::findOrFail($documentId);

        // Verify the document belongs to the enterprise
        $documentable = $document->documentable;
        if (! $documentable || $documentable->getEnterpriseId() !== $enterprise->id) {
            throw new ModelNotFoundException('Document not found in this enterprise.');
        }

        $scope = ($data['scope'] ?? $document->scope) ?? 'private';

        if ($scope === 'private') {
            $disk = 'local';
        } else {
            $disk = 'public';
        }

        // Handle file upload if provided
        if ($file) {
            // Delete old file if exists
            if ($document->path) {
                Storage::delete($document->path);
            }

            $path = $this->uploadFile($file, $enterprise, $documentable, $disk);
            $data['path'] = $path;
        }

        $document->update($data);

        return $document->fresh();
    }

    /**
     * Delete a document.
     */
    public function delete(int $documentId, Enterprise $enterprise): bool
    {
        $document = Document::findOrFail($documentId);

        // Verify the document belongs to the enterprise
        $documentable = $document->documentable;
        if (! $documentable || $documentable->getEnterpriseId() !== $enterprise->id) {
            throw new ModelNotFoundException('Document not found in this enterprise.');
        }

        // Delete the file if exists
        if ($document->path) {
            Storage::delete($document->path);
        }

        return $document->delete();
    }



    /**
     * Get documents for an enterprise with filters.
     */
    public function getDocumentsForEnterprise(Enterprise $enterprise, array $filters = []): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = Document::with(['documentable.user'])
            ->whereHas('documentable', function ($query) use ($enterprise) {
                $query->where('enterprise_id', $enterprise->id);
            });

        // Apply search filter
        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('key', 'like', "%{$search}%");
            });
        }

        // Apply member filter
        if (! empty($filters['member_id'])) {
            $query->where('documentable_id', $filters['member_id'])
                ->where('documentable_type', Member::class);
        }

        return $query->orderBy('created_at', 'desc')
            ->paginate($filters['per_page'] ?? 15);
    }



    /**
     * Upload a file and return the storage path.
     */
    protected function uploadFile(UploadedFile $file, Enterprise $enterprise, Documentable $documentable, $disk = 'public'): string
    {
        $fileName = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs(
            "documents/{$enterprise->id}/" . class_basename($documentable) . "/{$documentable->getId()}",
            $fileName,
            $disk
        );

        return $path;
    }
}
