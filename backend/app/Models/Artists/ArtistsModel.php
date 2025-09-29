<?php

namespace App\Models\Artists;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtistsModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Artists\ArtistsModelFactory> */
    use HasFactory;

    protected $table = 'artists';

    protected $fillable = [
        'name',
        'stage_name',
        'genre',
        'bio',
    ];
}
