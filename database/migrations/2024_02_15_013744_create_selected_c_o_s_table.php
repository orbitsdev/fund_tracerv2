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
        Schema::create('selected_c_o_s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_year_id')->nullable();
            $table->string('cost_type')->nullable();
            // $table->boolean('specify')->default(false)->nullable();
            $table->string('indirect_cost_type')->nullable();
            $table->string('implementing_monitoring_agency')->nullable();
            $table->string('description')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->decimal('new_amount', 10, 2)->nullable();
            $table->unsignedBigInteger('quantity')->default(0)->nullable();
            $table->string('funding_agency')->nullable();
            $table->string('agency_where_dost_fund_will_be_allocated')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selected_c_o_s');
    }
};
