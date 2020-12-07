<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Category $category)
    {
        $books = $category->book;
        $categories = Category::all();

        return view('books.index', compact('books', 'categories'));

    }
}