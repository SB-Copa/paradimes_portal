<?php

namespace App\Models\SocialMedias;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHasSocialMediasModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\SocialMedia\HasSocialMediasModelFactory> */
    use HasFactory;

    protected $table = 'model_has_social_media';
    
    protected $fillable = [
        'social_media_id',
        'model_id',
        'model_type',
    ];

}
