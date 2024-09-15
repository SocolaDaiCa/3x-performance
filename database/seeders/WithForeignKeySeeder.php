<?php

namespace Database\Seeders;

use App\Models\FkA;
use App\Models\FkB;
use App\Models\FkC;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WithForeignKeySeeder extends WithoutIndexAndForeignKeySeeder
{
    public function __construct()
    {
        parent::__construct();
        $this->modelA = FkA::class;
        $this->modelB = FkB::class;
        $this->modelC = FkC::class;
        $this->tableBC = 'fk_bc';
    }
}
