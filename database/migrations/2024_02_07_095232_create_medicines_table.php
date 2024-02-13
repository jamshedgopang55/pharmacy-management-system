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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('generic_name');
            $table->integer('buying_price');
            $table->integer('selling_price');
            $table->enum('stock_type',[0,1]);
            $table->integer('stock');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
