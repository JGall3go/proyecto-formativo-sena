<?php

namespace App\Http\Controllers\store;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
{
    
    public function vista(Request $item )
    {
    //dump($item);
    $cartCollection = \Cart::getContent();
    //dd($cartCollection);
    return view('store/metodo')->with(['cartCollection' =>
    $cartCollection]);
    }   
}