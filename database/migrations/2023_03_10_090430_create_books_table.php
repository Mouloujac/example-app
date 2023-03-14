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
        Schema::disableForeignKeyConstraints();

        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('googlebook_id', 200)->unique();
            $table->string('title', 400)->nullable();
            $table->string('author', 250)->nullable();
            $table->longText('description')->nullable();
            $table->longText('img')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
