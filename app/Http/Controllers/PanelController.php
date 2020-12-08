<?php

namespace App\Http\Controllers;

use App\Models\Book;

class PanelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:admin');
    }

    public function index()
    {
        $books = Book::query()
            ->orderBy('id')
            ->get();


        return view('books.panel', [
            'books' => $books,
        ]);
    }
}
