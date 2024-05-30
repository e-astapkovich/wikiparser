<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndexModel extends Model
{
    use HasFactory;

    protected $table = 'indexes';

    protected $fillable = [
        'atom_id',
        'article_id',
        'quantity',
    ];

    public $timestamps = false;
}
