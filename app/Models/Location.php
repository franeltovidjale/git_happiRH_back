<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * Location Model
 *
 * @property int $id
 * @property int $enterprise_id
 * @property string $name
 * @property bool $active
 * @property string $slug
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Enterprise $enterprise
 * @property-read \Illuminate\Database\Eloquent\Collection|Employee[] $employees
 */
class Location extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'enterprise_id',
        'name',
        'active',
        'slug',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Boot the model and add event listeners.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($location) {
            if (empty($location->slug)) {
                $location->slug = static::generateUniqueSlug($location->name, $location->enterprise_id);
            }
        });
    }

    /**
     * Generate a unique slug for the location.
     */
    protected static function generateUniqueSlug(string $name, int $enterpriseId): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        while (static::where('enterprise_id', $enterpriseId)->where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Get the enterprise that owns the location.
     */
    public function enterprise(): BelongsTo
    {
        return $this->belongsTo(Enterprise::class, 'enterprise_id');
    }

    /**
     * Get the employees that belong to the location.
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'location_id');
    }
}
