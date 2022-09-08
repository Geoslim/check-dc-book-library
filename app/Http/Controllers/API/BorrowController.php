<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    public function __construct()
    {
    }

    public function borrowedBooks(Request $request)
    {

    }

    public function returnedBooks(Request $request)
    {

    }

    public function borrowBook(Request $request)
    {
        // needs to be on a plan
        // needs to be in the range og an access level
//        return $request->user()->accessLevel();
        dd($request->user()->accessLevel(), $request->user()->activeSubscription());
    }
}
