<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
            <div class="profile-username">
                {{ session('username') }}
            </div>

            <div class="profile-nav-bar">
                <a href="/biblioteca"><span>Biblioteca</span></a>
                <a href="/configuracion"><span class="link-active">Configuracion</span></a>
            </div>

            <div class="profile-content">
              
              <form action="/configuracion" method="POST" class="profile-form" enctype="multipart/form-data">

                @foreach($errors as $error)
                  <p>{{$error}}</p>
                @endforeach
                
                @csrf

                <!--<div class="image-container">
                  <label>Imagen</label>
                  <input type="file" name="imagen" accept="image/png, image/jpeg">
                </div>-->

                <div class="input-container">
                  <label>Nombres</label>
                  <input name="nombres" value="{{ $perfil->nombres }}">
                </div>
                @error('nombres'){{ $message }}@enderror

                <div class="input-container">
                  <label>Apellidos</label>
                  <input name="apellidos" value="{{ $perfil->apellidos }}">
                </div>
                @error('apellidos'){{ $message }}@enderror

                <div class="input-container">
                  <label>Nickname</label>
                  <input name="nombrePerfil" value="{{ $perfil->nombrePerfil }}">
                </div>
                @error('nombrePerfil'){{ $message }}@enderror

                <div class="input-container">
                  <label>Contraseña</label>
                  <input name="contrasena" value="">
                </div>
                @error('contrasena'){{ $message }}@enderror

                <div class="input-container">
                  <label>Telefono</label>
                  <input name="telefono" value="{{ $perfil->telefono }}">
                </div>
                @error('telefono'){{ $message }}@enderror

                <div class="input-container">
                  <label>Documento</label>
                  <input name="documento" value="{{ $perfil->documento }}">
                </div>
                @error('documento'){{ $message }}@enderror

                <div class="input-container">
                  <label>Direccion</label>
                  <input name="direccion" value="{{ $perfil->direccion }}">
                </div>
                @error('direccion'){{ $message }}@enderror

                <div class="input-container">
                  <label>Ciudad</label>
                  <select onchange="selectColor(this)" name="ciudad" style="color: #f5f5f5">
                    <option disabled selected style="display: none">- Seleccionar -</option>
                    @php
                        foreach ($ciudadesTotales as $ciudad) {
                            if(isset($usuariosEdit)){
                                if($datosContactoEdit->ciudad_idCiudad == $ciudad->idCiudad){
                                    echo "<option value='$ciudad->idCiudad' selected>$ciudad->ciudad</option>";
                                } else {
                                    echo "<option value='$ciudad->idCiudad'>$ciudad->ciudad</option>";
                                }
                            }  else {
                                echo "<option value='$ciudad->idCiudad'>$ciudad->ciudad</option>";
                            }   
                        }
                    @endphp 
                  </select>
                </div>
                @error('ciudad'){{ $message }}@enderror

                <div class="submit-container">
                  <input type="submit" value="Enviar" class="submit-input">
                </div>

              </form>
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