@extends('layouts.app')

@section('content')

    <div class="container">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <storng>{{ $message }}</storng>
            </div>
        @endif
            <div class="dropdown">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Categorieën</a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="/books/">Alle</a>
                    @foreach($categories as $category)
                        <a class="dropdown-item" href="{{url('/books/categories/'.$category->title)}}">{{$category->title}}</a>
                    @endforeach
                </div>
            </div>
        <div class="row flex justify-content-center">

            @foreach($books as $book)

                @if ($book->status === 0)
                <div class="col-md-3 card border-9 text-center m-1 p-2">
                @else
                <div class="d-none">
                @endif
                    <img src="{{$book->image}}" alt="{{$book->title}}" class="card-img">
                    <h2 class="card-title">{{$book->title}}</h2>
                    <p class="card-text">{{$book->author}}</p>
                    <p class="card-text">{{$book->category->title}}</p>
                    <a  class="btn btn-light m-1" href="{{route('books.show', $book->id)}}">Lees meer</a>
                    <form action="{{route('favorite.store')}}" id="favorite_form" method="post">
                        {{csrf_field()}}
                        <input name="user_id" type="hidden" value="{{Auth::user()->id}}" />
                        <input name="book_id" type="hidden" value="{{$book->id}}" />
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="far fa-heart"></i>
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
@endsection
