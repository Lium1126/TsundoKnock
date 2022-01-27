<?php

namespace App\Http\Controllers\Book;

use App\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function all_books_get(Request $request) {
        $books = Book::where('user_id', Auth::user()->id)->get();
        
        return view('home', [
            'books' => $books
        ]);
    }
}
