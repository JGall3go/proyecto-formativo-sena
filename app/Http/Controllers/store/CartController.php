<?php

namespace App\Http\Controllers\store;

use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class CartController extends Controller
{

    public function cart()
    {
        $cartCollection = \Cart::getContent();
        //dd($cartCollection);
        return view('cart')->with(['cartCollection' =>
        $cartCollection]);;
    }
    public function remove(Request $request)
    {
        \Cart::remove($request->idProducto);
        return redirect()->route('cart.index')->with('success_msg', 'Item is removed!');
    }
    public function add(Request $request)
    {
        //dd($request);
        \Cart::add(array(
            'idProducto' => $request->idProducto,
            'titulo' => $request->titulo,
            'valor' => $request->valor,
            'quantity' => $request->quantity,
            'attributes' => array(
                'imagen' => $request->imagen,
                //'slug' => $request->slug
            )
        ));
        //dd($request);
        return redirect()->route('cart.index')->with('success_msg', 'Item Agregado a sú Carrito!');
    }
    public function update(Request $request)
    {
        \Cart::update(
            $request->idProducto,
            array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $request->quantity
                ),
            )
        );
        return redirect()->route('cart.index')->with('success_msg', 'Cart is Updated!');
    }
    public function clear()
    {
        \Cart::clear();
        return redirect()->route('cart.index')->with('success_msg', 'Car is cleared!');
    }
}
