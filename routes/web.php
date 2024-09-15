<?php

use App\Models\A;
use App\Models\B;
use App\Models\C;
use App\Models\FkA;
use App\Models\FkB;
use App\Models\FkC;
use App\Models\IndexA;
use App\Models\IndexB;
use App\Models\IndexC;
use Illuminate\Http\Request;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

class XXX {
    public static function testWhereHasMany()
    {
        echo '<hr>';
        echo 'Tìm kiếm a theo điều kiện b.name = 1000 <br>';
        $finalResults = [];
        for($i = 1; $i <= 1; $i++) {
            $results = Benchmark::measure([
                'relation' => function (){
                    A::query()
                        ->whereHas('bs', function ($query) {
                            $query->where('name', '1000');
                        })
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
                'relation index' => function (){
                    IndexA::query()
                        ->whereHas('bs', function ($query) {
                            $query->where('name', '1000');
                        })
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
                'relation fk' => function (){
                    FkA::query()
                        ->whereHas('bs', function ($query) {
                            $query->where('name', '1000');
                        })
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
                'join' => function (){
                    A::query()
                        ->select([
                            'as.*',
                        ])
                        ->join('bs', 'as.id', '=', 'bs.a_id')
                        ->where('bs.name', '1000')
                        ->groupBy('as.id')
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
                'join index' => function (){
                    IndexA::query()
                        ->select([
                            'index_as.*',
                        ])
                        ->join('index_bs', 'index_as.id', '=', 'index_bs.a_id')
                        ->where('index_bs.name', '1000')
                        ->groupBy('index_as.id')
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
                'join fk' => function (){
                    FkA::query()
                        ->select([
                            'fk_as.*',
                        ])
                        ->join('fk_bs', 'fk_as.id', '=', 'fk_bs.a_id')
                        ->where('fk_bs.name', '1000')
                        ->groupBy('fk_as.id')
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
                /**/
                'join sub' => function (){
                    A::query()
                        ->select([
                            'as.*',
                        ])
                        ->joinSub(
                            B::query()->where('name', '1000'),
                            'bs',
                            'as.id',
                            '=',
                            'bs.a_id'
                        )
                        ->groupBy('as.id')
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
                'join index sub' => function (){
                    IndexA::query()
                        ->select([
                            'index_as.*',
                        ])
                        ->joinSub(
                            IndexB::query()->where('name', '1000'),
                            'index_bs',
                            'index_as.id',
                            '=',
                            'index_bs.a_id'
                        )
                        ->groupBy('index_as.id')
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
                'join fk sub' => function (){
                    FkA::query()
                        ->select([
                            'fk_as.*',
                        ])
                        ->joinSub(
                            FkB::query()->where('name', '1000'),
                            'fk_bs',
                            'fk_as.id',
                            '=',
                            'fk_bs.a_id'
                        )
                        ->groupBy('fk_as.id')
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
            ], 1);
            foreach ($results as $key => $result) {
                if (!isset($finalResults[$key])) {
                    $finalResults[$key] = 0;
                }
                $finalResults[$key] += $result;
            }
        }
        asort($finalResults);
        dump($finalResults);
        echo 'Như chúng ta thấy tốc độ giữa join và sub query gần như không có sự khác biệt nếu dược đánh inxdex hoặc fk<br>';
        echo 'Nếu không có index hoặc fk thì join chậm hơn sub query 50-100ms<br>';
    }

    public static function testWhereBelongsToMany()
    {
        echo '<hr>';
        echo 'Tìm kiếm b theo điều kiện c.name = 1000 <br>';
        /* a hasMany b */
        $finalResults = [];
        for($i = 1; $i <= 1; $i++) {
            $results = Benchmark::measure([
                'relation' => function (){
                    B::query()
                        ->whereHas('cs', function ($query) {
                            $query->where('name', '1000');
                        })
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
                'relation index' => function (){
                    IndexB::query()
                        ->whereHas('cs', function ($query) {
                            $query->where('name', '1000');
                        })
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
                'relation fk' => function (){
                    FkB::query()
                        ->whereHas('cs', function ($query) {
                            $query->where('name', '1000');
                        })
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
                'join' => function (){
                    B::query()
                        ->select([
                            'bs.*',
                        ])
                        ->leftJoin('bc', 'bs.id', '=', 'bc.b_id')
                        ->leftJoin('cs', 'bc.c_id', '=', 'cs.id')
                        ->where('cs.name', '1000')
                        ->groupBy('bs.id')
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
                'join index' => function (){
                    IndexB::query()
                        ->select([
                            'index_bs.*',
                        ])
                        ->leftJoin('index_bc', 'index_bs.id', '=', 'index_bc.b_id')
                        ->leftJoin('index_cs', 'index_bc.c_id', '=', 'index_cs.id')
                        ->where('index_cs.name', '1000')
                        ->groupBy('index_bs.id')
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
                'join fk' => function (){
                    FkB::query()
                        ->select([
                            'fk_bs.*',
                        ])
                        ->leftJoin('fk_bc', 'fk_bs.id', '=', 'fk_bc.b_id')
                        ->leftJoin('fk_cs', 'fk_bc.c_id', '=', 'fk_cs.id')
                        ->where('fk_cs.name', '1000')
                        ->groupBy('fk_bs.id')
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
            ], 1);
            foreach ($results as $key => $result) {
                if (!isset($finalResults[$key])) {
                    $finalResults[$key] = 0;
                }
                $finalResults[$key] += $result;
            }
        }
        asort($finalResults);
        dump($finalResults);
        echo 'Như chúng ta thấy tốc độ giữa join và sub query gần như không có sự khác biệt<br>';
        echo 'Nhưng khác biệt giữa fk vs index, index vs không index là rất lớn ~1000ms<br>';
    }

    public static function testWithCountHasMany()
    {
        echo '<hr>';
        echo 'Tìm đếm số lượng b là con của a theo điều kiện b.name = \'1000\'<br>';
        $finalResults = [];
        for($i = 1; $i <= 1; $i++) {
            $results = Benchmark::measure([
                'relation' => function (){
                    A::query()
                        ->withCount([
                            'bs' => function ($query) {
                                $query->where('name', '1000');
                            }
                        ])
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
                'relation index' => function (){
                    IndexA::query()
                        ->withCount([
                            'bs' => function ($query) {
                                $query->where('name', '1000');
                            }
                        ])
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
                'relation fk' => function (){
                    FkA::query()
                        ->withCount([
                            'bs' => function ($query) {
                                $query->where('name', '1000');
                            }
                        ])
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
                /**/
                'join' => function (){
                    A::query()
                        ->select([
                            'as.*',
                            DB::raw('count(IF(bs.name = \'1000\', 1, 0)) as bs_count'),
                        ])
                        ->leftJoin('bs', 'as.id', '=', 'bs.a_id')
                        ->groupBy('as.id')
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
                'join index' => function (){
                    IndexA::query()
                        ->select([
                            'index_as.*',
                            DB::raw('count(IF(index_bs.name = \'1000\', 1, 0)) as bs_count'),
                        ])
                        ->leftJoin('index_bs', 'index_as.id', '=', 'index_bs.a_id')
                        ->groupBy('index_as.id')
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
                'join fk' => function (){
                    FkA::query()
                        ->select([
                            'fk_as.*',
                            DB::raw('count(IF(fk_bs.name = \'1000\', 1, 0)) as bs_count'),
                        ])
                        ->leftJoin('fk_bs', 'fk_as.id', '=', 'fk_bs.a_id')
                        ->groupBy('fk_as.id')
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
                /**/
                'join sub' => function (){
                    A::query()
                        ->select([
                            'as.*',
                            DB::raw('count(IF(bs.name = \'1000\', 1, 0)) as bs_count'),
                        ])
                        ->leftJoinSub(B::query()->where('name', '1000'), 'bs', 'as.id', '=', 'bs.a_id')
                        ->groupBy('as.id')
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
                'join sub index' => function (){
                    IndexA::query()
                        ->select([
                            'index_as.*',
                            DB::raw('count(IF(index_bs.name = \'1000\', 1, 0)) as bs_count'),
                        ])
                        ->leftJoinSub(
                            IndexB::query()->where('name', '1000'),
                            'index_bs',
                            'index_as.id',
                            '=',
                            'index_bs.a_id'
                        )
                        ->groupBy('index_as.id')
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
                'join sub fk' => function (){
                    FkA::query()
                        ->select([
                            'fk_as.*',
                            DB::raw('count(IF(fk_bs.name = \'1000\', 1, 0)) as bs_count'),
                        ])
                        ->leftJoinSub(
                            FkB::query()->where('name', '1000'),
                            'fk_bs',
                            'fk_as.id',
                            '=',
                            'fk_bs.a_id'
                        )
                        ->groupBy('fk_as.id')
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
            ], 1);
            foreach ($results as $key => $result) {
                if (!isset($finalResults[$key])) {
                    $finalResults[$key] = 0;
                }
                $finalResults[$key] += $result;
            }
        }
        asort($finalResults);
        dump($finalResults);
        echo 'trong VD này sub query nhanh hơn join đặc biệt là khi được đánh index và fk<br>';
    }

    public static function testWithCountBelongsToMany()
    {
        echo '<hr>';
        echo 'Tìm đếm số lượng c là con của b theo điều kiện c.name = \'1000\'<br>';
        $finalResults = [];
        for($i = 1; $i <= 1; $i++) {
            $results = Benchmark::measure([
                'relation' => function (){
                    B::query()
                        ->withCount([
                            'cs' => function ($query) {
                                $query->where('name', '1000');
                            }
                        ])
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
                'relation index' => function (){
                    IndexB::query()
                        ->withCount([
                            'cs' => function ($query) {
                                $query->where('name', '1000');
                            }
                        ])
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
                'relation fk' => function (){
                    FkB::query()
                        ->withCount([
                            'cs' => function ($query) {
                                $query->where('name', '1000');
                            }
                        ])
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
                /**/
                // 'join' => function (){
                //     // chạy quá chậm
                //     B::query()
                //         ->select([
                //             'bs.*',
                //             DB::raw('count(IF(cs.name = \'1000\', 1, 0)) as bs_count'),
                //         ])
                //         ->leftJoin('bc', 'bs.id', '=', 'bc.b_id')
                //         ->leftJoin('cs', 'bc.c_id', '=', 'cs.id')
                //         ->groupBy('bs.id')
                //         // ->skip(999)
                //         ->limit(1)
                //         ->ddRawSql()
                //     ;
                // },
                'join index' => function (){
                    IndexB::query()
                        ->select([
                            'index_bs.*',
                            DB::raw('count(IF(index_cs.name = \'1000\', 1, 0)) as bs_count'),
                        ])
                        ->leftJoin('index_bc', 'index_bs.id', '=', 'index_bc.b_id')
                        ->leftJoin('index_cs', 'index_bc.c_id', '=', 'index_cs.id')
                        ->groupBy('index_bs.id')
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
                'join fk' => function (){
                    FkB::query()
                        ->select([
                            'fk_bs.*',
                            DB::raw('count(IF(fk_cs.name = \'1000\', 1, 0)) as bs_count'),
                        ])
                        ->leftJoin('fk_bc', 'fk_bs.id', '=', 'fk_bc.b_id')
                        ->leftJoin('fk_cs', 'fk_bc.c_id', '=', 'fk_cs.id')
                        ->groupBy('fk_bs.id')
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
                /**/
                // 'join sub' => function (){
                //     B::query()
                //         ->select([
                //             'bs.*',
                //             DB::raw('count(IF(cs.name = \'1000\', 1, 0)) as bs_count'),
                //         ])
                //         ->leftJoinSub(
                //             C::query()
                //                 ->select([
                //                     'cs.*',
                //                     'bc.b_id',
                //                 ])
                //                 ->where('name', '1000')
                //                 ->join('bc', 'cs.id', '=', 'bc.c_id')
                //             ,
                //             'cs',
                //             'bs.id',
                //             '=',
                //             'cs.b_id'
                //         )
                //         ->groupBy('bs.id')
                //         ->skip(999)
                //         ->limit(1)
                //         ->get()
                //     ;
                // },
                'join sub index' => function (){
                    IndexB::query()
                        ->select([
                            'index_bs.*',
                            DB::raw('count(IF(index_cs.name = \'1000\', 1, 0)) as bs_count'),
                        ])
                        ->leftJoinSub(
                            IndexC::query()
                                ->select([
                                    'index_cs.*',
                                    'index_bc.b_id',
                                ])
                                ->where('name', '1000')
                                ->join('index_bc', 'index_cs.id', '=', 'index_bc.c_id')
                            ,
                            'index_cs',
                            'index_bs.id',
                            '=',
                            'index_cs.b_id'
                        )
                        ->groupBy('index_bs.id')
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
                'join sub fk' => function (){
                    FkB::query()
                        ->select([
                            'fk_bs.*',
                            DB::raw('count(IF(fk_cs.name = \'1000\', 1, 0)) as bs_count'),
                        ])
                        ->leftJoinSub(
                            FkC::query()
                                ->select([
                                    'fk_cs.*',
                                    'fk_bc.b_id',
                                ])
                                ->where('name', '1000')
                                ->join('fk_bc', 'fk_cs.id', '=', 'fk_bc.c_id')
                            ,
                            'fk_cs',
                            'fk_bs.id',
                            '=',
                            'fk_cs.b_id'
                        )
                        ->groupBy('fk_bs.id')
                        ->skip(999)
                        ->limit(1)
                        ->get()
                    ;
                },
            ], 1);
            foreach ($results as $key => $result) {
                if (!isset($finalResults[$key])) {
                    $finalResults[$key] = 0;
                }
                $finalResults[$key] += $result;
            }
        }
        asort($finalResults);
        dump($finalResults);
        echo 'trong VD này sub query nhanh hơn join đặc biệt là khi được đánh index và fk<br>';
        echo 'join và join sub query không được liệt kê vì chạy quá chậm > 5s<br>';
    }
}

Route::get('xxx', function (Request $request) {
    DB::statement('SHOW TABLE STATUS');
    /**/
    echo 'Ta có 3 bảng a(1000), b(1tr), c(1000), bc(1tr) <a href="'.$request->fullUrl().'"><strong>Reload</strong></a><br>';
    echo 'a hasMany b<br>';
    echo 'b belongsToMany c<br>';
    echo 'Nếu chênh lệch <= 2ms thì được coi là bằng nhau<br>';
    match ($request->input('test')) {
        '1' => XXX::testWhereHasMany(),
        '2' => XXX::testWhereBelongsToMany(),
        '3' => XXX::testWithCountHasMany(),
        '4' => XXX::testWithCountBelongsToMany(),
    };
});
Route::view('3x-performance', '3x-performance');
