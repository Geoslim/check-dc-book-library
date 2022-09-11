<?php

use App\Models\Book;
use App\Models\Lending;
use App\Models\User;
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
        Schema::create('lendings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Book::class);
            $table->dateTime('date_time_borrowed');
            $table->dateTime('date_time_due');
            $table->dateTime('date_time_returned')->nullable();
            $table->integer('points')->default(0);
            $table->string('status')->default(Lending::STATUS['not_due']);
            $table->timestamps();

            $table->index(['date_time_due', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('lendings');
    }
};
