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
        Schema::create('f_r_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('dv_number')->unique()->nullable();
            $table->string('cost_type')->nullable();
            $table->string('seleted_dropdown')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('ada_number')->nullable();
            $table->string('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('f_r_transactions');
    }
};
