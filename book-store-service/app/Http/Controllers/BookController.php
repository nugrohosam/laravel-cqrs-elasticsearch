<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function store(Request $request)
    {
        $book = new Book();

        $book->name = $request->name;
        $book->year = $request->year;

        $book->save();
    }
    
    public function update($id, Request $request)
    {
        $book = Book::find($id);

        $book->name = $request->name;
        $book->year = $request->year;

        $book->save();
    }

    public function delete($id)
    {
        Book::find($id)->delete();
    }
}
