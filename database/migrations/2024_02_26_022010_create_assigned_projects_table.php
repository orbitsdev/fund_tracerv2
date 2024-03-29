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
        Schema::create('assigned_projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assigned_projectable_id')->nullable();
            $table->string('assigned_projectable_type')->nullable();
            $table->foreignId('project_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigned_projects');
    }
};
