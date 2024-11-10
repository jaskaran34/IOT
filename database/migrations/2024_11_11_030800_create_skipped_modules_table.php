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
        Schema::create('skipped_modules', function (Blueprint $table) {
            
            $table->id();
            $table->unsignedBigInteger('module_id'); // Reference to the Module
            $table->timestamp('skipped_at');         // Date and time when the module was skipped
            $table->string('reason')->nullable();    // Optional reason for skipping
            $table->timestamps();

            // Foreign key to modules table
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skipped_modules');
    }
};
