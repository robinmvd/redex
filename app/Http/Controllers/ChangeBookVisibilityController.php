<?php

namespace App\Http\Controllers;

use App\Models\Book;

class ChangeBookVisibilityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:admin');
    }

    /**
     * @param Book $book
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeVisible(Book $book)
    {
        $book->is_hidden = false;
        $book->save();

        return response()->json(['message' => 'Book visibility updated successfully.']);
    }

    /**
     * @param Book $book
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeHidden(Book $book)
    {
        $book->is_hidden = true;
        $book->save();

        return response()->json(['message' => 'Book visibility updated successfully.']);
    }
}
