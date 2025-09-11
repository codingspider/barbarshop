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
        Schema::create('order_item_addons', function (Blueprint $table) {
            $table->id();
            // Link to order
            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            // Link to addon (if you have an addons table)
            $table->foreignId('addon_id')
                ->constrained('addons')   // assumes addons table exists
                ->cascadeOnDelete();

            $table->string('name'); // keep snapshot of addon name at the time of order
            $table->integer('qty')->default(1);
            $table->decimal('price', 10, 2);
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_item_addons');
    }
};
