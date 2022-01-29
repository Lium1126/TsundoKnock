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
        return view('home', [
            'msg' => "",
            'books' => Book::where('user_id', Auth::user()->id)->get()
        ]);
    }

    public function add_book(Request $request) {
        $book = [
            "isbn" => $request["isbn"],
            "title" => $request["title"],
            "cover_url" => $request["cover"],
            "full_page" => $request["num_of_pages"]
        ];

        try {
            Book::insert(
                ['user_id' => Auth::user()->id, 'isbn' => $book["isbn"], 'title' => $book["title"], 'cover_url' => $book["cover_url"], 'full_page' => $book["full_page"], 'reading_page' => 0]
            );

            return view('home', [
                'msg' => "",
                'books' => Book::where('user_id', Auth::user()->id)->get()
            ]);
        } catch (Exception $e) {
            return view('home', [
                'msg' => $e->getMessage(),
                'books' => Book::where('user_id', Auth::user()->id)->get()
            ]);
        }
    }
}
