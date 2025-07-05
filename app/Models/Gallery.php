<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
