<?php

namespace App\Http\Controllers;

use App\Models\Products;

class IndexController extends Controller
{
    public function show()
    {
        return view('index', ['products' => Products::all()]);
    }
}
