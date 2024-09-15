<?php

namespace Database\Seeders;

use App\Models\A;
use App\Models\B;
use App\Models\C;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WithoutIndexAndForeignKeySeeder extends Seeder
{
    protected $modelA;
    protected $modelB;
    protected $modelC;
    protected string $tableBC;

    public function __construct()
    {
        $this->modelA = A::class;
        $this->modelB = B::class;
        $this->modelC = C::class;
        $this->tableBC = 'bc';
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::enableQueryLog();
        // create 1000 records A
        $newAs = [];
        $newBs = [];
        $newCs = [];
        $newBCs = [];
        for($i = 1; $i <= 1000; $i++) {
            $newAs[] = [
                'id' => $i,
            ];
            $newCs[] = [
                'id' => $i,
                'name' => $i,
            ];
            for ($j = 1; $j <= 1000; $j++) {
                $newBCs[] = [
                    'id' => ($i - 1) * 1000 + $j,
                    'b_id' => $i,
                    'c_id' => $j,
                ];
                $newBs[] = [
                    'id' => ($i - 1) * 1000 + $j,
                    'a_id' => $j,
                    'name' => ($i - 1) * 1000 + $j,
                ];
            }
        }
        // chunk insert 1000
        collect($newAs)->chunk(1000)->each(function($chunk) {
            $this->modelA::query()->insert($chunk->toArray());
        });
        collect($newBs)->chunk(1000)->each(function($chunk) {
            $this->modelB::query()->insert($chunk->toArray());
        });
        collect($newCs)->chunk(1000)->each(function($chunk) {
            $this->modelC::query()->insert($chunk->toArray());
        });
        collect($newBCs)->chunk(1000)->each(function($chunk) {
            DB::table($this->tableBC)->insert($chunk->toArray());
        });
        $totalTime = 0;
        $queryLogs = DB::getQueryLog();
        foreach ($queryLogs as $queryLog) {
            $totalTime += $queryLog['time'];
        }
        dump(compact('totalTime'));
        DB::disableQueryLog();
        DB::flushQueryLog();
    }
}
