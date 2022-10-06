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
  <title>Document</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
  <script src="https://www.paypal.com/sdk/js?client-id=AXqavVjm-9FICYV3CYwHLbmzwiiBgkLhVCX0kzB4BurZCpWbPl1fS-GK1WhZyWWPbRS4v_2wxFEz3dIH&currency=USD"></script>
  <!--Container que contiene toda la parte de pago-->
  <div class="fluid-container">
    <!--El form se encuentra contenido aquí, porque todo hace parte de un mismo formulario
      en instagaming sale así tons supongo que funciona xd-->

    <div class="Plataformas">
      <!--Contiene la primera columna (los datos de envío y el método de pago)-->
      <div>
        <h5>Dirección de facturación</h5>
      </div>
      <br>
      <div class="Dirección-de-envío">
        <div class="nombre-apellido">
          <br>
          <br>
          <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Nombre Completo" required>
          </div>
          <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Correo Electronico" required>
          </div>
        </div>
        <!--fin del div="nombre-apellido"-->
        <div class="input-group">
          <select class="form-select">
            <option selected>Elige la ciudad</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
          </select>
        </div>
      </div>

      <p class="text_name">Tarjeta de credito
        
        <img src="{{ asset('img/Mastercard.png') }}" class="imga">
        <img src="{{ asset('img/visa.png') }}" class="imga">
      
      </p>

      <div class="input-group">
        <input type="text" class="form-control" placeholder="123-456-789" aria-label="Text input with radio button" required>
      </div>

      <div class="input-group mb-3">
        <span class="input-group-text">MM/AA</span>
        <input type="text" class="form-control" placeholder="11/22" aria-label="Username">
        <span class="input-group-text"><img src="{{ asset('img/cvc.png') }}" class="cvc"></span>
        <input type="text" class="form-control" placeholder="123" aria-label="Server">
      </div>
    

      <!--fin del div="Direccion-de-envío"-->
    </div>
    <!--fin del div="plataformas"-->
    <div class="contenido">

      <!--Contiene la segunda columna (resumen de pago y boton para pagar)-->
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
          </div>
        </div>

      </div>
      <!--fin del div="resumen-de-pago"-->

      <div class="boton-de-pago">
        <div class="card">
          <div class="card-body">
            <div class="producto">

            </div>
            <div class="precio">
              <span><b>Total: </b>${{ \Cart::getTotal() }}</li></span>
            </div>

            <br>
            <button type="button" class="btn btn-success" id="btn">Comprar</button>
            <hr>
            <small>Haciendo clic en "Comprar"
              reconozco haber aceptado los términos y condiciones, y la política de privacidad.</small>
          </div>
        </div>
      </div>
      <!--fin del div="boton de pago"-->
    </div>
    <!--fin del div="Contenido"-->

  </div>
  <!--fin del div="fluid-container"-->

  <script src="{{ asset('js/buscador.js') }}"></script>
  <script src="{{ asset('paypal-api.js') }}"></script>
  <script src="{{ asset('servidor.js') }}"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>

@endsection