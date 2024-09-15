<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $prefix = 'index_';
        Schema::create($prefix.'as', function (Blueprint $table) {
            $table->id();
        });
        Schema::create($prefix.'bs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('a_id');
            $table->string('name');
            /**/
            $table->index(['a_id']);
            $table->index(['a_id', 'name']);
        });
        Schema::create($prefix.'cs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        Schema::create($prefix.'bc', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('b_id');
            $table->unsignedBigInteger('c_id');
            /**/
            $table->index(['b_id', 'c_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('index_as');
        Schema::dropIfExists('index_bs');
        Schema::dropIfExists('index_cs');
        Schema::dropIfExists('index_bc');
    }
};
