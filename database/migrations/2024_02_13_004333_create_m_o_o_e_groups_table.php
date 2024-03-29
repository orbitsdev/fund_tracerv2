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
        Schema::create('m_o_o_e_groups', function (Blueprint $table) {
            $table->id();
            $table->string('cost_type')->nullable();
            $table->string('parent_title')->nullable();
            $table->string('title')->nullable();
            $table->boolean('has_option')->default(true);
            $table->decimal('amount', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_o_o_e_groups');
    }
};
