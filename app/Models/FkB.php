<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FkB extends Base
{
    use HasFactory;

    protected $table = 'fk_bs';

    public function cs()
    {
        return $this->belongsToMany(FkC::class, 'fk_bc', 'b_id', 'c_id');
    }
}
