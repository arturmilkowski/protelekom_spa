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
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('condition_id')->constrained()->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('name')->unique();
            $table->decimal('price', 6, 2)->default(0);
            $table->decimal('promo_price', 6, 2)->default(0);
            $table->unsignedTinyInteger('quantity')->default(0);
            $table->boolean('hide')->default(false);
            $table->text('description')->nullable();
            $table->string('img')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('types');
    }
};
