<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'stores';

    protected $fillable = [
        'name',
        'address',
        'active',
    ];

    protected $casts = [
        'name' => 'string',
        'address' => 'string',
        'active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relationship many to many with books
     */
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }
}
