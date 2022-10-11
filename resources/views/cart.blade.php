<!DOCTYPE html>

<html>

<head>
    <title>Cart</title>    
</head>

<body>
    <header>
    @extends('plantillas/buscador')

    @section('buscador')
    </header>

    <div class="container" style="margin-top: 120px; width: 100%;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Tienda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cart</li>
            </ol>
        </nav>
        @if(session()->has('success_msg'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session()->get('success_msg') }}
            <!--<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>-->
        </div>
        @endif
        @if(session()->has('alert_msg'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session()->get('alert_msg') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        @endif
        @if(count($errors) > 0)
        @foreach($errors0>all() as $error)
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $error }}
            <!--<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>-->
        </div>
        @endforeach
        @endif
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <br>
                @if(\Cart::getTotalQuantity()>0)
                <h4>{{ \Cart::getTotalQuantity()}} Producto(s) en el carrito</h4><br>
                @else
                <h4>No Product(s) In Your Cart</h4><br>
                <a href="/" class="btn btn-dark">Continue en la tienda</a>
                @endif
                @foreach($cartCollection as $item)
                <div class="row">
                    <div class="col-lg-3">
                        <img src="{{ env('DASHBOARD_URL').$item->attributes->imagen }}" class="img-thumbnail" width="200" height="200">
                    </div>
                    <div class="col-lg-5">
                        <p>
                            <b><a href="/store/producto/{{ $item->titulo }}">{{ $item->titulo}}</a></b><br>
                            <b>Precio: </b>${{ $item->valor }}<br>
                            <b>Sub Total: </b>${{ \Cart::get($item->idProducto)->getPriceSum() }}<br>
                            {{-- <b>With Discount: </b>${{\Cart::get($item->idProducto)->getPriceSumWithConditions() }}--}}
                        </p>
                    </div>
                    
                    <div class="col-lg-4">
                        <div style="display: flex; flex-direction: row;">
                            <form action="{{ route('cart.update') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group row">
                                    <input type="hidden" value="{{ $item->idProducto}}" id="idProducto" name="idProducto">
                                    <input type="number" class="form-control form-control-sm" value="{{ $item->quantity }}" id="quantity" name="quantity" min="1" style="width: 70px; margin-right:10px;">
                                    <button class="btn btn-secondary btn-sm" style="margin-right:25px; width:40px; height: 30px;"><i class="fa fa-edit"></i></button>
                                </div>
                            </form>
                            <form action="{{ route('cart.remove') }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" value="{{ $item->idProducto }}" id="idProducto" name="idProducto">
                                <button class="btn btn-dark btn-sm" style="margin-right: 10px; width:40px; height: 30px;"><i class="fa fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <hr style="background-color: gray;">
                @endforeach
                @if(count($cartCollection)>0)
                <form action="{{ route('cart.clear') }}" method="POST">
                    {{ csrf_field() }}
                    <button class="btn btn-secondary btn-md">Borrar Carrito</button>
                </form>
                @endif
            </div>
            @if(count($cartCollection)>0)
            <div class="col-lg-5">
                <div class="card">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><b>Total: </b>${{ \Cart::getTotal() }}</li>
                    </ul>
                </div>
                <br><a href="/" class="btn btn-dark">Continue en la tienda</a><!-- cambiar ruta al store -->
                <a href="/checkout" class="btn btn-success">Proceder al Checkout</a> <!-- metodo de pago -->
            </div>
            @endif
        </div>
        <br><br>
    </div>
</body>
</html>