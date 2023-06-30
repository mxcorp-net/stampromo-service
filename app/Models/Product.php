<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, int $int)
 * @method static create(array $validated)
 * @method static find(int $id)
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'provider_id', 'family_id', 'status',
    ];
}
