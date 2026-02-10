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
        Schema::create('chat_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name')->nullable(); // AI-generated chat name
            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();
        });

        // Add session_id to chats table
        Schema::table('chats', function (Blueprint $table) {
            $table->foreignId('session_id')->nullable()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->dropColumn('session_id');
        });
        Schema::dropIfExists('chat_sessions');
    }
};
