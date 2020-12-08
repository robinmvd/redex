<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritesTable extends Migration
{
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('book_id')
                ->constrained('books')
                ->cascadeOnDelete();

            //door de PK als een 'composite key'
            // (combi van `user_id` and `book_id`) te gebruiken
            // zorgt ervoor dat een user niet meer dan 1 keer
            // aan hetzelfde boek gekoppeld kan worden in DB
            $table->primary(['user_id', 'book_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('favorites');
    }
}
