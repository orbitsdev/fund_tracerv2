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
        Schema::create('selected_p_s', function (Blueprint $table) {
            $table->id();
            $table->string('cost_type')->nullable();
            $table->string('indirect_cost_type')->nullable();
            $table->string('implementing_monitoring_agency')->nullable();
            $table->foreignId('project_year_id')->nullable();
            $table->foreignId('p_s_group_id')->nullable();
            $table->foreignId('p_s_expense_id')->nullable();
            $table->unsignedBigInteger('number_of_positions')->default(0)->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->unsignedBigInteger('duration')->default(0)->nullable();
            $table->string('funding_agency')->nullable();
            $table->decimal('amount_of_counterpart_fund', 10, 2)->nullable();
            $table->string('agency_where_dost_fund_will_be_allocated')->nullable();
            $table->text('percent_time_devoted_to_the_project')->nullable();
            $table->text('responsibilities')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selected_p_s');
    }
};
