<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitation_seat', function (Blueprint $table) {
            $table->id();
            $table->enum('status' , ['active' , 'inactive']);

            $table->foreignId('seat_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('invitation_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitation_seat');

    }
};
