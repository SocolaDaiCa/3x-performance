<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndexB extends Base
{
    use HasFactory;

    protected $table = 'index_bs';

    public function cs()
    {
        return $this->belongsToMany(IndexC::class, 'index_bc', 'b_id', 'c_id');
    }
}
