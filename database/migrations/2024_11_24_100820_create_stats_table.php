<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stats', function (Blueprint $table) {
            $table->string("id")->unique()->primary();
            $table->integer("value");
            $table->timestamps();
        });

        DB::table('stats')->insert([
            'id' => 'transfers_count',
            'value' => 0,
        ]);

        DB::table('stats')->insert([
            'id' => 'size_transferred',
            'value' => 0,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stats');
    }
};
