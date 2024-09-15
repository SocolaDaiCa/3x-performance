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
        $prefix = 'fk_';
        Schema::create($prefix.'as', function (Blueprint $table) {
            $table->id();
        });
        Schema::create($prefix.'bs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('a_id');
            $table->string('name');
            /**/
            $table->foreign('a_id')->references('id')->on('fk_as');
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
            $table->foreign('b_id')->references('id')->on('fk_bs');
            $table->foreign('c_id')->references('id')->on('fk_cs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fk_as');
        Schema::dropIfExists('fk_bs');
        Schema::dropIfExists('fk_cs');
        Schema::dropIfExists('fk_bc');
    }
};
