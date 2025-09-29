<?php

namespace App\Models\SocialMedias;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMediasModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\SocialMedia\SocialMediasModelFactory> */
    use HasFactory;

    protected $table = 'social_medias';

    protected $fillable = [
        'social_media'
    ];
}
