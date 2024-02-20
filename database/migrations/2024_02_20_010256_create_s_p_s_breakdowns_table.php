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
        Schema::create('s_p_s_breakdowns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('selected_p_s_id')->nullable;
            $table->foreign('selected_p_s_id')->references('id')->on('selected_ps')->onDelete('cascade');
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
        Schema::dropIfExists('s_p_s_breakdowns');
    }
};
