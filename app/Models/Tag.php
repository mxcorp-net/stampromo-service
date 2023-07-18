<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, int $int)
 */
class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'word'
    ];
}
