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
        $prefix = '';
        Schema::create($prefix.'as', function (Blueprint $table) {
            $table->id();
        });
        Schema::create($prefix.'bs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('a_id');
            $table->string('name');
            /**/


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


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('as');
        Schema::dropIfExists('bs');
        Schema::dropIfExists('cs');
        Schema::dropIfExists('bc');
    }
};
