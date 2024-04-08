<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'books';

    protected $fillable = [
        'name',
        'isbn',
        'value',
    ];

    protected $casts = [
        'name' => 'string',
        'isbn' => 'integer',
        'value' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relationship many to many with store
     */
    public function stores(): BelongsToMany
    {
        return $this->belongsToMany(Store::class);
    }
}
