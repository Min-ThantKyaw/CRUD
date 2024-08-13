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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('body');
            $table->integer('status')->default(1);
            $table->unsignedBigInteger('created_user_id');
            $table->unsignedBigInteger('updated_user_id')->nullable();
            $table->unsignedBigInteger('deleted_user_id')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
            $table->foreign('created_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_user_id')->references('id')->on('users')->cascadeOnUpdate();
            $table->foreign('deleted_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
