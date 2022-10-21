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
    <link rel="stylesheet" href="{{ asset ('css/perfil.css') }}">
    <script src="{{ asset ('https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js') }}"></script>
    <script src="{{ asset ('https://cdn.jsdelivr.net/jquery.scrollto/2.1.2/jquery.scrollTo.js') }}"></script>
    <script src="{{ asset ('autofocus.js') }}"></script>
    <title>Perfil</title>
</head>
<body>

    <header>
        @extends('plantillas/buscador')

        @section('buscador')
    </header>

    <div class="content">
    
        <div class="profile-description">
            
            <img src="{{env('DASHBOARD_URL').'/'.session('userImage')}}" id='profile-image'>
            <div class="profile-username animate__animated animate__jackInTheBox animate__delay-3s">
                {{ session('username') }}
            </div>

            <div class="profile-nav-bar">
                <a href="/biblioteca"><span class="link-active">Biblioteca</span></a>
                <a href="/configuracion"><span>Configuracion</span></a>
            </div>

            <div class="profile-content">

              @if(count($productos) == 0)
              <h4 style="color: #f5f5f5; margin: 15px;">No ha realizado ninguna compra.</h4>
              @endif

              @foreach($productos as $producto)
              <div class="producto">
                <img src="{{ env('DASHBOARD_URL').$producto[0]->imagen }}">
                <div class="producto-texto">
                  <span class="producto-titulo">{{ $producto[0]->titulo }}</span>
                  <span class="producto-item"><b>Fecha: {{ $producto[0]->fecha }}</b> </span>
                  <span class="producto-item"><b>Items: {{ $producto[0]->cantidad }}</b> </span>
                  <a class="producto-detalle"><b>Detalle</b></a>
                </div>
                <div class="producto-precio">
                  <span>${{ number_format($producto[0]->total, 0) }}</span>
                </div>
              </div>
              @endforeach

            
            </div>

        </div>

    </div>

  <!--
  <div class="banner">
    <img src="{{asset('Iconos/figura.svg')}}">
  </div> 
  <div class="fotoperfil">
    <img class="imagen" src="https://pbs.twimg.com/media/Duaj62BU8AEU_E9.jpg" width="200px" height="200px">
        </img> 
      </div>
  <div class="nombre">
    <p>8374GAMER</p>
  </div>


    <div class="grid text-center" >
    <ul class="nav nav-pills nav-justified">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="perfil">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="biblioteca">Biblioteca</a>
        </li>
        {{-- <li class="nav-item">
          <a class="nav-link" href="wishlist">Wishlist</a>
        </li> --}}
        {{-- <li class="nav-item">
          <a class="nav-link" href="reviews">Reviews</a>
        </li> --}}
        <li class="nav-item">
          <a class="nav-link" href="config"><img src="{{asset ('Iconos/icon_config.svg')}}"> Configuración</a>
        </li>
      </ul>
      </div> 
      </div>

      <hr>

      <div class="widgets" >
        <div class="card" style="width: 500px; height: 300px;">
          <div class="card-body">
            <img class="icono" src="{{ asset ('Iconos/icon_vista.svg') }}">
            <hr>
            <h5 class="card-title">Vista General</h5>
            {{-- <p class="card-text">Reviews 0</p> --}}
            {{-- <p class="card-text">Wishlist 0</p> --}}
            <p class="card-text">Juegos 0</p>
          </div>
        </div>

        {{-- <div class="card" style="width: 500px; height: 300px;">
          <div class="card-body">
            <img class="icono" src="{{asset ('Iconos/icon_estrella.svg') }}">
            <hr>
            <h5 class="card-title">Ultimo juegos agregados a la wishlist</h5>
            <p class="card-text">No hay juegos agregados todavía</p>
             <a href="wishlist" class="btn btn-secondary btn-lg active)" role="button" 
             aria-pressed="true" autofocus> Ingresa a tu wishlist</a>
          </div>
        </div> --}}
</div>
<hr>-->
</body>
</html>