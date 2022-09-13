<?php

use App\Models\AccessLevel;
use App\Models\Book;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('access_level_book', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(AccessLevel::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Book::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('access_level_book');
    }
};
