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
        Schema::create('product_meta_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_meta_key_id')->constrained('product_meta_keys')->cascadeOnDelete();
            $table->mediumInteger('product_id')->nullable();
            $table->string('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_meta_values');
    }
};
