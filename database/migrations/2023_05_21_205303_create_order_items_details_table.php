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
        Schema::create('order_items_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('item_id')
                ->foreign()
                ->references('items')
                ->on('id');
            $table->integer('order_item_id')
                ->foreign()
                ->references('order_items')
                ->on('id')
                ->cascadeOnDelete();
            $table->float('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items_details');
    }
};
