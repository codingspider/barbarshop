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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_no')->unique();
            $table->foreignId('customer_id')->nullable()->constrained('users')->cascadeOnDelete();
            // $table->foreignId('selected_service_id')->nullable()->constrained('services')->cascadeOnDelete();
            $table->enum('status', ['waiting','assigned','in_service','done','cancelled', 'open', 'completed'])->default('waiting');
            $table->foreignId('assigned_barber_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->timestamp('requested_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->index(['status', 'requested_at']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
