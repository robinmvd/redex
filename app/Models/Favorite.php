<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
/**
 * Favorite` extends van `Pivot` i.p.v. `Model`.
 * `Pivot` is al een sub-class van `Model` maar met extra methodes die handig zijn voor pivot models.
 * https://laravel.com/docs/8.x/eloquent-relationships#defining-custom-intermediate-table-models
 * */

class Favorite extends Pivot
{
    protected $table = 'favorites';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
