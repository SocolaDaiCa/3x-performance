<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class B extends Base
{
    use HasFactory;

    protected $table = 'bs';

    public function cs()
    {
        return $this->belongsToMany(C::class, 'bc', 'b_id', 'c_id');
    }
}
