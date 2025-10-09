<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
   public function landing_page(){

    $products = Product::latest()->paginate(12);
    return view('home.landing-page', compact('products'));
   }
}
