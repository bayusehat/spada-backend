<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Testimoni;
use Validator;

class TestimoniController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Testimoni',
            'content' => 'testimoni'
        ];
    }
}
