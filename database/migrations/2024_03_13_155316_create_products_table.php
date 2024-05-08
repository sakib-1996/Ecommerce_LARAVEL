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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug');
            $table->string('product_id')->unique();

            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('cat_id')->nullable();
            $table->unsignedBigInteger('subCat_id')->nullable();
            $table->unsignedBigInteger('childCat_id')->nullable();

            $table->string('weight')->nullable();



            
            $table->string('length')->nullable();
            $table->string('width')->nullable();
            $table->boolean('free_shipping')->default(false);
            


            $table->string('minimum_purchase')->nullable();

            $table->string('barcode')->nullable();
            $table->boolean('refundable')->default(false);
            $table->boolean('cash_on_delivary')->default(false);
            $table->string('thum_img')->nullable();
            $table->longText('description')->nullable();
            $table->json('related_product')->nullable();
            $table->boolean('status')->default(false);
            $table->boolean('druft')->default(false);
            $table->longText('short_des')->nullable();

            $table->timestamps();
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('cat_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('subCat_id')->references('id')->on('sub_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('childCat_id')->references('id')->on('child_categories')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
