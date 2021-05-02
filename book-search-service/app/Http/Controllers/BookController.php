<?php

namespace App\Http\Controllers;

use App\Applications\BookSearchApplication;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request, BookSearchApplication $bookSearchApplication)
    {
        $search = $request->search ?? '';
        $searchArr = str_split($search);
        $search = implode('*', $searchArr);

        $response = $bookSearchApplication->getSearch($search);
        return response()->json($response);
    }
}
