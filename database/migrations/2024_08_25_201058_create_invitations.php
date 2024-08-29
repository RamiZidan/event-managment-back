<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surname_id')->nullable()->nullOnDelete();
            $table->foreignId('group_id')->nullable()->nullOnDelete(); // nullable for public(form,)

            $table->string('formal_title')->nullable(); // nullable for public(form,)
            $table->string('invitation_code')->nullable(); // nullable for public(form,)
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('additional_email')->nullable() ; // nullable for public (form,)
            $table->string('party');
            $table->string('whatsapp_number')->nullable(); // nullable for public(form,)
            $table->string('phone_number')->nullable(); // nullable for private
            $table->string('position')->nullable() ; // nullable for private (maybe)
            $table->enum('invitation_lang', ['english' , 'arabic'])->nullable(); // nullable for public(form,)
            $table->boolean('send_whatsapp')->nullable(); // nullable for public(form,)
            $table->boolean('send_email')->nullable(); // nullable for public(form,)
            $table->enum('type' , ['public' , 'private']);
            $table->enum('status' , [ 'processing' ,'confirmed' ,'apologized' ] )->nullable(); // nullable for private 
            $table->boolean('attended')->nullable(); // nullable for private 
            $table->date('confirmed_at')->nullable(); // nullable for public (from,)
            $table->integer('qr_code')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');

    }
};
