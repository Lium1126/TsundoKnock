<?php

namespace App\Http\Controllers\Book;

use App\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function all_books_get(Request $request) {
        return view('home', [
            'msg' => "",
            'books' => Book::where('user_id', Auth::user()->id)->get(),
            'total_progress' => Book::select(DB::raw("sum(reading_page) as progress_pages,sum(full_page) as total_pages"))->where("user_id", Auth::user()->id)->get()
        ]);
    }

    public function dojob(Request $request) {
        $error_msg = "";

        if ($request["jobtype"] == "add") {
            $book = [
                "isbn" => $request["isbn"],
                "title" => $request["title"],
                "cover_url" => $request["cover"],
                "full_page" => $request["num_of_pages"]
            ];

            try {
                Book::insert(['user_id' => Auth::user()->id, 'isbn' => $book["isbn"], 'title' => $book["title"], 'cover_url' => $book["cover_url"], 'full_page' => $book["full_page"], 'reading_page' => 0]);
            } catch (Exception $e) {
                $error_msg = $e->getMessage();
            }
        }
        else if ($request["jobtype"] == "delete") {
            try {
                Book::where('id', $request["book_id"])->delete();
            } catch (Exception $e) {
                $error_msg = $e->getMessage();
            }
        }
        else if ($request["jobtype"] == "update") {
            try {
                Book::where('id', $request['book_id'])->update(['reading_page' => $request["progress_num"]]);
            } catch (Exception $e) {
                $error_msg = $e->getMessage();
            }
        }

        return view('home', [
            'msg' => $error_msg,
            'books' => Book::where('user_id', Auth::user()->id)->get(),
            'total_progress' => Book::select(DB::raw("sum(reading_page) as progress_pages,sum(full_page) as total_pages"))->where("user_id", Auth::user()->id)->get()
        ]);
    }
}
