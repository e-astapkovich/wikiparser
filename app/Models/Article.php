<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    protected $fillable = [
        'title',
        'content',
    ];

    public $timestamps = false;

    public function atoms(): BelongsToMany
    {
        return $this->belongsToMany(Atom::class, 'indexes')->withPivot('quantity');
    }
}
