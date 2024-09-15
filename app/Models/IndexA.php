<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndexA extends Base
{
    use HasFactory;

    protected $table = 'index_as';

    public function bs()
    {
        return $this->hasMany(IndexB::class, 'a_id', 'id');
    }
}
