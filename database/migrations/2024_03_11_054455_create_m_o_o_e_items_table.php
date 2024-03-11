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
        Schema::create('m_o_o_e_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('m_o_o_e_expense_sub_id')->nullable();
            $table->string('title')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_o_o_e_items');
    }
};
