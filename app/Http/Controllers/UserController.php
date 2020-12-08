<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function favorites(Request $request)
    {
        $books = $request->user()->favorites()->latest()->get();

        return true;
    }

}
