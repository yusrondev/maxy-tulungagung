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
        Schema::create('chat_contents', function (Blueprint $table) {
            $table->id();
            $table->text('username_font');
            $table->text('chat_font');
            $table->text('username_color');
            $table->text('chat_color');
            $table->text('chat_size')->nullable();
            $table->text('chat_sizeName')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
