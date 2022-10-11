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

                            Los códigos de producto fueron enviados a su correo electrónico anclado a su perfil de KeysGuardian, si no recibió este correo por favor contactar con el soporte para revisar su pedido. Estos códigos de producto estaran a su disposición en la sección <a href="/biblioteca">biblioteca</a> de su perfil.

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
        <div class="Plataformas">

            <p class="text_name">Tarjeta de credito
                <img src="{{ asset('img/Mastercard.png') }}" class="imga">
                <img src="{{ asset('img/visa.png') }}" class="imga">
            </p>

            <div class="card card-credit">

                <div class="input-group">
                    <input type="text" class="form-control" placeholder="123-456-789" aria-label="Text input with radio button" required>
                </div>

                <div class="input-group mb-3 input-credit">
                    <span class="input-group-text">MM/AA</span>
                    <input type="text" class="form-control" placeholder="11/22" aria-label="Username">
                    <span class="input-group-text"><img src="{{ asset('img/cvc.png') }}" class="cvc" width="40px"></span>
                    <input type="text" class="form-control" placeholder="123" aria-label="Server">
                </div>

                <input type="submit" class="btn btn-success" id="btn" value="Pagar con tarjeta" style="margin: 15px;">
            </div>
        </div>

        <div class="contenido">

            <h5> Productos </h5>
            <div class="resumen-de-pago">
                <div class="card">
                    <div class="card-body">
                        <div class="producto">
                            <span></span>
                        </div>
                        @foreach($cartCollection as $item) 
                            <div class="precio">
                                <p>{{ $item->titulo}}</p> 
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
        @endif
    </div>
    
    <script src="{{ asset('js/buscador.js') }}"></script>
    <script src="{{ asset('paypal-api.js') }}"></script>
    <script src="{{ asset('servidor.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>

@endsection