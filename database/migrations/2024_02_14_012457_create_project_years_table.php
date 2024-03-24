<?php

use App\Models\ProjectYear;
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
        Schema::create('project_years', function (Blueprint $table) {
            $table->id();
            $table->foreignId('year_id')->nullable();
            $table->foreignId('project_id')->nullable();
            $table->string('status')->default(ProjectYear::STATUS_FOR_EDITING)->nullable();
            $table->boolean('is_active')->default(false)->nullable();
            $table->date('year_dated')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_years');
    }
};
