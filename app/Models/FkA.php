<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FkA extends Base
{
    use HasFactory;

    protected $table = 'fk_as';

    public function bs()
    {
        return $this->hasMany(FkB::class, 'a_id', 'id');
    }
}
