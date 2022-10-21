<?php

namespace App\Http\Controllers\store;

use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class CartController extends Controller
{

    public function cart()
    {
        $cartCollection = \Cart::getContent();

        foreach ($cartCollection as $productos) {
            
            $producto = DB::table('producto')
            ->join('estado', 'estado_idEstado', '=', 'idEstado') // Tabla de Estado (Activo, Inactivo)
            ->select('estado', 'cantidad')
            ->where('idProducto', 'Like', '%' . $productos->idProducto . '%')
            ->first();

            /* Si el producto se inactiva en el momento de hacer la compra
            se removera de la lista del carrito y por ende de la compra*/
            if ($producto->estado == "Inactivo" || $producto->cantidad <= 5) {

                \Cart::remove($productos->idProducto);
                $cartCollection = \Cart::getContent();
            }
        }

        return view('cart')->with(['cartCollection' => $cartCollection]);

        // dd($cartCollection);
    }

    public function remove(Request $request)
    {
        \Cart::remove($request->idProducto);
        return redirect()->route('cart.index')->with('success_msg', 'Item is removed!');
    }

    public function add(Request $request)
    {
        $producto = DB::table('producto')
          ->join('estado', 'estado_idEstado', '=', 'idEstado') // Tabla de Estado (Activo, Inactivo)
          ->select('estado', 'cantidad')
          ->where('idProducto', 'Like', '%' . $request->idProducto . '%')
          ->first();

        if ($producto->estado == "Activo" && $producto->cantidad > 5) {
                
            \Cart::add(array(
                'idProducto' => $request->idProducto,
                'titulo' => $request->titulo,
                'valor' => $request->valor,
                'quantity' => $request->quantity,
                'attributes' => array(
                    'imagen' => $request->imagen,
                    'stock' => $producto->cantidad,
                    //'slug' => $request->slug
                )
            ));

            return redirect()->route('cart.index')->with('success_msg', 'Item Agregado a sú Carrito!');

        } else {

            return redirect()->route('cart.index')->with('success_msg', 'No hay suficiente stock de este producto!');
        }
    }

    public function update(Request $request)
    {

        $producto = DB::table('producto')
          ->join('estado', 'estado_idEstado', '=', 'idEstado') // Tabla de Estado (Activo, Inactivo)
          ->select('estado', 'cantidad')
          ->where('idProducto', 'Like', '%' . $request->idProducto . '%')
          ->first();

        if ($request->quantity <= 2) {

            \Cart::update(
                $request->idProducto,
                array(
                    'quantity' => array(
                        'relative' => false,
                        'value' => $request->quantity
                    ),
                )
            );

            return redirect()->route('cart.index')->with('success_msg', 'Se actualizo el carrito!');

        } else {
            return redirect()->route('cart.index')->with('success_msg', 'No puedes tener mas de 2 productos de cada uno!');
        }
    }

    public function clear()
    {
        
        \Cart::clear();
        return redirect()->route('cart.index')->with('success_msg', 'Carrito limpio!');
    }
}
