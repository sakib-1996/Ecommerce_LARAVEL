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
        Schema::create('available_districts', function (Blueprint $table) {
            $table->id();
            $table->string('district_name');
            $table->string('base_cost');
            $table->string('cost_by_condition');
            $table->unsignedBigInteger('country_id');
            $table->timestamps();
            $table->foreign('country_id')->references('id')->on('available_countries')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('available_districts');
    }
};
