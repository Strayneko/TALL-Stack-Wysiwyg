<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class PostController extends Controller
{
    //

    public function index(): View
    {
        return view('post.index');
    }

    public function create(): View
    {
        return view('post.create');
    }
}
