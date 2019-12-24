<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'title'   => 'Dashboard',
            'content' => 'dashboard',
            'url'     => 'home'
        ];

        return view('layout.index', ['data' => $data]);
    }
}
