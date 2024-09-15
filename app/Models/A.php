<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class A extends Base
{
    use HasFactory;

    protected $table = 'as';

    public function bs()
    {
        return $this->hasMany(B::class, 'a_id', 'id');
    }
}
