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
        Schema::create('selected_m_o_o_e_s', function (Blueprint $table) {
            $table->id();
            $table->string('cost_type')->nullable();
            $table->foreignId('project_year_id')->nullable();
            $table->foreignId('m_o_o_e_group_id')->nullable();
            $table->foreignId('m_o_o_e_expense_id')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->unsignedBigInteger('quantity')->default(0)->nullable();
            $table->decimal('new_amount', 10, 2)->nullable();
            $table->unsignedBigInteger('specification')->default(0)->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selected_m_o_o_e_s');
    }
};
