<?php

namespace Database\Seeders;

use App\Models\IndexA;
use App\Models\IndexB;
use App\Models\IndexC;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WithIndexSeeder extends WithoutIndexAndForeignKeySeeder
{
    public function __construct()
    {
        parent::__construct();
        $this->modelA = IndexA::class;
        $this->modelB = IndexB::class;
        $this->modelC = IndexC::class;
        $this->tableBC = 'index_bc';
    }
}
