<?php

namespace App\Models;

use App\Commons\Enums\EntityStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @method static where(string $string, int $int)
 * @method static create(array $validated)
 * @method static find(int $id)
 * @property mixed $id
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'provider_id', 'family_id', 'status',
    ];

    protected $casts = [
        'status' => EntityStatus::class
    ];

    public function children(): HasMany
    {
        return $this->hasMany(ProductChild::class);
    }

    public function colors(): HasManyThrough
    {
        return $this->hasManyThrough(
            Color::class,
            ProductChild::class,
            'product_id',
            'id',
            'id',
            'color_id'
        );
    }

    public function images(): HasManyThrough
    {
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }
}
