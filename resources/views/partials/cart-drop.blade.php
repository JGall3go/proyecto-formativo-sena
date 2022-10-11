@if(count(\Cart::getContent()) > 0)
@foreach(\Cart::getContent() as $item)
<li class="list-group-item">
    <div class="row">
        <div class="col-lg-3">
            <img src="{{ env('DASHBOARD_URL').$item->attributes->imagen }}" style="width: 50px; height: 50px;"><!-- esta vaina puede que toque cambiarla para las imagenes perros-->
        </div>
        <div class="col-lg-6">
            <b>{{$item->titulo}}</b>
            <br><small>Qty: {{$item->quantity}}</small>
        </div>
        <div class="col-lg-3">
            <p>${{ \Cart::get($item->idProducto)->getPriceSum() }}</p>
        </div>
        <hr>
    </div>
</li>
@endforeach
<br>
<li class="list-group-item">
    <div class="row">
        <div class="col-lg-10">
            <b>Total: </b>${{ \Cart::getTotal() }}
        </div>
        <div class="col-lg-2">
            <form action="{{ route('cart.clear') }}" method="POST"><!-- aca debe ser el rpoblema del clear-->
                {{ csrf_field() }}
                <button class="btn btn-secondary btn-sm"><i class="fa fa-trash"></i></button>
            </form>
        </div>
    </div>
</li>
<br>
<div class="row" style="margin: 0px;">
    <a class="btn btn-dark btn-sm btn-block" href="{{ route('cart.index') }}">
        CARRITO <i class="fa fa-arrow-right"></i>
    </a>
    <a class="btn btn-dark btn-sm btn-block" href="/checkout">
        CHECKOUT <i class="fa fa-arrow-right"></i>
    </a>
</div>
@else
<li class="list-group-item">Tu carrito esta vacío</li>
@endif