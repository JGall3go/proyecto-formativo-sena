@extends('/plantillas.pago')

@section('metodo')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset ('css/metodo.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <script src="https://www.paypal.com/sdk/js?client-id=AXqavVjm-9FICYV3CYwHLbmzwiiBgkLhVCX0kzB4BurZCpWbPl1fS-GK1WhZyWWPbRS4v_2wxFEz3dIH&currency=USD"></script>

    <!--Container que contiene toda la parte de pago-->
    <div class="fluid-container">

        @if(session('status'))
            @if(session('status') == "true")
                <div class="pay-alert-container">
            
                    <div class="pay-alert">
                        <span> Compra realizada con éxito </span>
                    </div>

                    <div class="pay-text">
                        <span>

                            Se envio un aviso a su correo electrónico anclado a su perfil de KeysGuardian, si no recibió este correo por favor contactar con el soporte para revisar su pedido. Los códigos de producto comprados estaran a su disposición en la sección <a href="/biblioteca">biblioteca</a> de su perfil.

                            <br><br>
                            Tenga en cuenta que el código se considerará como "usado" una vez que haya sido aceptado y validado en la plataforma del Desarrollador, así que no nos hacemos responsables del mal uso del código después de ser comprado. <a href="/terminos">(Art 9.1)</a>
                        </span>
                    </div>

                    <div class="pay-buttons">
                        <a href="/biblioteca" class="biblioteca-button">Ver tu biblioteca</a>
                        <a href="/store" class="store-button">Ir a la tienda</a>
                    </div>

                </div>
            @else
                <div class="pay-alert-container">
            
                    <div class="pay-alert" style="background-color: #D15252">
                        <span> No se pudo procesar la compra </span>
                    </div>

                    <div class="pay-text">
                        <span>

                            Se produjo un error al realizar el pago, contacte con nuestro soporte si tuvo algun problema durante este proceso.     
                        </span>
                    </div>

                    <div class="pay-buttons">
                        <a href="/checkout" class="biblioteca-button">Volver atras</a>
                        <a href="/store" class="store-button">Ir a la tienda</a>
                    </div>

                </div>
            @endif
        @else

        @if(\Cart::getTotalQuantity() > 0)
        <div class="contenido">

            <div class="resumen-de-pago">
                <div class="card productos-card">
                    <div class="card-body productos">
                        @foreach($cartCollection as $item)
                        <div class="producto">
                            <a href="{{ route('detalle.producto', [$item->titulo]) }}"><img src="{{ env('DASHBOARD_URL').$item->attributes->imagen }}" alt="..."></a>
                            <div class="precio">
                                <p style="text-align: left;">{{ $item->quantity }} x {{ $item->titulo }}: ${{ $item->valor }}</p> 
                            </div>
                        </div>
                        @endforeach
                        <hr>
                        <div class="precio">
                          <span><b>Total: </b>${{ \Cart::getTotal() }}</li></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="boton-de-pago">
                <div class="card">
                    <div class="card-body">
                        <div class="precio">
                            <span> Pagar con PayPal </span>
                        </div>

                        <br>
                        <form action="/checkout" method="POST">
                            {{ csrf_field() }}
                            <button type="submit" class="btn-paypal" id="btn"><img src="{{ asset('img/paypal.png') }}" class="cvc" width="100px"></button>
                        </form>
                        <hr>
                        <small>Haciendo clic en "Comprar" reconozco haber aceptado los términos y condiciones, y la política de privacidad.</small>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="contenido notfound">
            <h2>No tienes productos en tu carrito</h2>
            <div class="pay-buttons">
                <a href="/store" class="store-button">Volver a la tienda</a>
            </div>
        </div>
        @endif
        @endif
    </div>
    
    <script src="{{ asset('js/buscador.js') }}"></script>
    <script src="{{ asset('paypal-api.js') }}"></script>
    <script src="{{ asset('servidor.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>

@endsection