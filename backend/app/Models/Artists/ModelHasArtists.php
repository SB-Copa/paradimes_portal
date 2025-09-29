<?php

namespace App\Models\Artists;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHasArtists extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Artists\ModelHasArtistsFactory> */
    use HasFactory;

    protected $table = 'model_has_artists';

    protected $fillable = [
        'artist_id',
        'model_id',
        'model_type',
    ];
}
