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
            $table->unsignedBigInteger('quantity')->default(0)->nullable();
            $table->string('cost_type')->nullable();
            $table->string('indirect_cost_type')->nullable();
            $table->string('implementing_monitoring_agency')->nullable();
            $table->foreignId('project_year_id')->nullable();
            $table->foreignId('m_o_o_e_group_id')->nullable();
            $table->foreignId('m_o_o_e_expense_id')->nullable();
            $table->foreignId('m_o_o_e_expense_sub_id')->nullable();
            $table->string('specification')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('funding_agency')->nullable();
            $table->decimal('new_amount', 10, 2)->nullable();
            $table->string('agency_where_dost_fund_will_be_allocated')->nullable();
            
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
