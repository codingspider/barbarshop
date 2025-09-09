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
        Schema::create('printers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('connection_type', ['network', 'usb'])->default('network');
            $table->string('capability_profile')->default('simple');
            $table->integer('characters_per_line')->default(42);
            $table->string('ip_address')->nullable();
            $table->integer('port')->default(9100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('printers');
    }
};
