<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--Animacion TEST -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
     rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" 
     crossorigin="anonymous">
    <script src="{{ asset ('https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js') }}"></script>
    <script src="{{ asset ('https://cdn.jsdelivr.net/jquery.scrollto/2.1.2/jquery.scrollTo.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/gsap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="{{ asset('js/content.js') }}"></script>
    <link rel="stylesheet" href="{{ asset ('css/perfil.css') }}">
    <title>Perfil</title>
</head>
<body>

    @if(session('keys') && session('keys') != null)
      <style type="text/css">
        
        body {
          overflow: hidden;
        }
        
        .keys-container {
            display: flex;
        }

      </style>
      <div class="keys-container">
        <div class="keys-background" onclick="showForm()"></div>
        <div class="keys-list">
          <h4>Keys:</h4>
          @foreach(session('keys') as $key)
            <span>{{ $key->key }}</span>
          @endforeach
        </div>
      </div>
    @endif

    @extends('plantillas/buscador')

    @section('buscador')

    <div id="resultado" class="content_grid"> </div>
    
    <div class="content">        
    
        <div class="profile-description">
            
            <img src="{{env('DASHBOARD_URL').'/'.session('userImage')}}" id='profile-image'>
            <div class="profile-username animate__animated animate__jackInTheBox animate__delay-3s">
                {{ session('username') }}
            </div>

            <div class="profile-nav-bar">
                <a href="/biblioteca" style="text-decoration: none;"><span class="link-active">Biblioteca</span></a>
                <a href="/configuracion" style="text-decoration: none;"><span>Configuracion</span></a>
            </div>

            <div class="profile-content">

              @if(count($productos) == 0)
              <h4 style="color: #f5f5f5; margin: 15px;">No ha realizado ninguna compra.</h4>
              @endif

              @foreach($productos as $producto)
              <div class="producto">
                <a href="/store/producto/{{ $producto['titulo'] }}" class="img-link"><img src="{{ env('DASHBOARD_URL').$producto['imagen'] }}"></a>
                <div class="producto-texto">
                  <span class="producto-titulo">{{ $producto['titulo'] }}</span>
                  <span class="producto-item"><b>Fecha: {{ $producto['fecha'] }}</b> </span>
                  <span class="producto-item"><b>Items: {{ $producto['cantidad'] }}</b> </span>
                  <a class="detalle-link" href="/biblioteca/{{ $producto['titulo'] }}"><b>Detalle</b></a>
                </div>
                <div class="producto-precio">
                  <span>${{ number_format($producto['total'], 0) }}</span>
                </div>
              </div>
              @endforeach

            
            </div>

        </div>

    </div>

    <footer>
        @extends('plantillas/footer')

        @section('footer')

    </footer>
</body>
</html>