<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Atom extends Model
{
    protected $fillable = [
        'word',
    ];

    public $timestamps = false;

    public function article(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'indexes');
    }
}
