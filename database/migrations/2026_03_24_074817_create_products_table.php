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
            // $table->foreignId('category_id')
            //     ->constrained('categories')
            //     ->cascadeOnDelete()
            //     ->cascadeOnUpdate();

            // $table->foreignId('brand_id')
            //     ->constrained('brands')
            //     ->cascadeOnDelete()
            //     ->cascadeOnUpdate();

            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category')->nullable();
            $table->string('unit')->nullable();
            $table->text('description')->nullable();
            $table->string('tag')->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->json('image')->nullable();
            $table->decimal('price', 10, 2);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false); // fix typo ise_featured
            $table->boolean('in_stock')->default(true);
            $table->boolean('on_sale')->default(false);
            $table->timestamps();
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
