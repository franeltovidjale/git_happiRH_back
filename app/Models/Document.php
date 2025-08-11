<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $documentable_id
 * @property string $documentable_type
 * @property string $key
 * @property string|null $path
 * @property bool $active
 * @property string $scope
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $documentable
 */
class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'documentable_id',
        'documentable_type',
        'key',
        'path',
        'active',
        'scope',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Get the parent documentable model.
     */
    public function documentable()
    {
        return $this->morphTo();
    }
}