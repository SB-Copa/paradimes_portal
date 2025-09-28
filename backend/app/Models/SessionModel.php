<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionModel extends Model
{
    //

    protected $table = 'sessions';

    public $timestamps = false;
    protected $guarded = [];

    public function authenticatable()
    {
        return $this->morphTo();
    }

}
