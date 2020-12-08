<?php

use App\Http\Controllers\BooksController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChangeBookVisibilityController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\PanelController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::redirect('/', '/books')->name('home');

Route::get('/books/panel', [PanelController::class, 'index'])->name('books.panel');

Route::put('/books/{book}/visible', [ChangeBookVisibilityController::class, 'makeVisible'])->name('books.visible');
Route::put('/books/{book}/hidden', [ChangeBookVisibilityController::class, 'makeHidden'])->name('books.hidden');

Route::resource('books', BooksController::class);
Route::resource('books.comments', CommentsController::class)->only(['store']);

Route::resource('categories', CategoryController::class)->only(['show']);

Route::resource('favorites', FavoritesController::class)
    //gebruik 'Book' model i.p.v. 'Favorite' model als de controller.
    //verwacht een 'Book' parameter bij de 'update en 'destroy' methodes.
    ->parameter('favorites', 'book')
    //gebruik alleen deze routes voor de resource controller.
    ->only(['index', 'update', 'destroy']);
