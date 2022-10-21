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
    <script src="{{ asset ('autofocus.js') }}"></script>
    <link rel="stylesheet" href="{{ asset ('css/perfil.css') }}">
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
                <a href="/biblioteca" style="text-decoration: none;"><span>Biblioteca</span></a>
                <a href="/configuracion" style="text-decoration: none;"><span class="link-active">Configuracion</span></a>
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
                  <input name="nombres" value="{{ $perfil->nombres }}" type="text">
                </div>
                @error('nombres'){{ $message }}@enderror

                <div class="input-container">
                  <label>Apellidos</label>
                  <input name="apellidos" value="{{ $perfil->apellidos }}" type="text">
                </div>
                @error('apellidos'){{ $message }}@enderror

                <div class="input-container">
                  <label>Nickname</label>
                  <input name="nombrePerfil" value="{{ $perfil->nombrePerfil }}">
                </div>
                @error('nombrePerfil'){{ $message }}@enderror

                <div class="input-container">
                  <label>Contraseña</label>
                  <input name="contrasena" value="" type="password">
                </div>
                @error('contrasena'){{ $message }}@enderror

                <div class="input-container">
                  <label>Telefono</label>
                  <input name="telefono" value="{{ $perfil->telefono }}">
                </div>
                @error('telefono'){{ $message }}@enderror

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
                                    echo "<option value='$ciudad->idCiudad' selected style='background-color: #545454;'>$ciudad->ciudad</option>";
                                } else {
                                    echo "<option value='$ciudad->idCiudad' style='background-color: #545454;'>$ciudad->ciudad</option>";
                                }
                            }  else {
                                echo "<option value='$ciudad->idCiudad' style='background-color: #545454;'>$ciudad->ciudad</option>";
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

    <footer>
        @extends('plantillas/footer')

        @section('footer')

    </footer>
</body>
</html>