<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BooksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:admin')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $searchTerm = $request->query('q');

        $categories = Category::query()
            ->orderBy('title')
            ->get();

        $books = Book::query()
            ->when(filled($searchTerm), function ($query) use ($searchTerm) {
                $searchTerm = '%' . $searchTerm . '%';

                $query->where(function ($query) use ($searchTerm) {
                    $query->orWhere('title', 'LIKE', $searchTerm)
                        ->orWhere('author', 'LIKE', $searchTerm)
                        ->orWhere('description', 'LIKE', $searchTerm);

                });

            })
            ->where('is_hidden', false)
            ->latest()
            ->get();

        $favorites = $request->user()->favorites()->pluck('id');

        return view('books.index', [
            'books' => $books,
            'categories' => $categories,
            'searchTerm' => $searchTerm,
            'favorites' => $favorites,
        ]);
    }

    public function create()
    {
        $categories = Category::query()
            ->orderBy('title')
            ->get();

        return view('books.create', [
            'categories' => $categories,
            'book' => new Book(), // nodig voor form.blade.php partial
        ]);
    }

    public function show(Book $book)
    {
        // check of boek is 'favorited'
        // door huidige gebruiker
        $isFavorite = auth()->user()
            ->favorites()
            ->where('book_id', $book->id)
            ->exists();

        return view('books.show', [
            'book' => $book,
            'isFavorite' => $isFavorite,
        ]);
    }

    public function edit(Book $book)
    {
        $categories = Category::query()
            ->orderBy('title')
            ->get();

        return view('books.edit', [
            'book' => $book,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        // de Request object validate methods,
        // geeft array met gevalideerde velden terug
        $validated = $request->validate([
            'title' => 'required',
            'author' => 'required',
            'description' => 'required',
            'image' => 'required',

            'category' => [
                Rule::exists('categories', 'id')
            ],
        ]);

        $book = new Book();
        $book->title = $validated['title'];
        $book->author = $validated['author'];
        $book->description = $validated['description'];
        $book->image = $validated['image'];
        $book->category_id = $validated['category'];
        $book->save();

        return redirect()->route('books.index')
            ->with('success', 'Boek is opgeslagen!');
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required',
            'author' => 'required',
            'description' => 'required',
            'image' => 'required',

            'category' => [
                // minder error gevoelig dan 'category' => ['exists:categories,id']
                Rule::exists('categories', 'id')
            ],
        ]);

        $book->title = $validated['title'];
        $book->author = $validated['author'];
        $book->description = $validated['description'];
        $book->image = $validated['image'];
        $book->category_id = $validated['category'];
        $book->save();

        return redirect()->route('books.index')
            ->with('success', 'Book updated!');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Book deleted!');
    }
}
