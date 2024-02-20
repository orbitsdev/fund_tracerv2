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
        Schema::create('c_o_breakdowns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('selected_c_o_id')->nullable;
            $table->foreign('selected_c_o_id')->references('id')->on('selected_c_o_s')->onDelete('cascade');
            $table->string('description')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c_o_breakdowns');
    }
};
