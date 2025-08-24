<?php

namespace Tests\Unit;

use App\Contracts\Documentable;
use App\Models\Document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class TestDocumentable extends Model implements Documentable
{
    protected $table = 'members';

    protected $fillable = ['enterprise_id', 'user_id', 'location_id', 'status_by', 'type', 'status', 'username', 'code', 'birth_date', 'marital_status', 'nationality', 'role', 'joining_date'];

    /**
     * Get the documents for this model.
     */
    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    /**
     * Get the enterprise ID for this documentable model.
     */
    public function getEnterpriseId(): int
    {
        return $this->enterprise_id;
    }

    /**
     * Get the model's ID.
     */
    public function getId(): int
    {
        return $this->id;
    }
}