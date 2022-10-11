<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="{{asset ('css/login.css')}}"/>
</head>

<body>

  <div class="section">
    <div class="container">
      <div class="row full-height justify-content-center">
        <div class="col-12 text-center align-self-center py-5">
          <div class="section pb-5 pt-5 pt-sm-2 text-center">

            <div class="card-3d-wrap mx-auto">
              <div class="card-3d-wrapper">
                <div class="card-front">
                  <div class="center-wrap">
                    <div class="section text-center">
                      <div class="card-front">
                        <div class="center-wrap">
                          <div class="section text-center">
                            <h4 class="mb-4 pb-3">REGISTRARSE</h4>
                            <form method="POST" action="/signup">
                              @csrf
                              <div class="form-group">
                                <input type="text" name="nombres" class="form-style" placeholder="Ingresa tu Nombre " id="logname" autocomplete="off">
                                <i class="input-icon uil uil-user"></i>
                                @error("nombres"){{ $message }}@enderror
                              </div>
                              <div class="form-group mt-2"> 
                                <input type="text" name="apellidos" class="form-style" placeholder="Ingresa tu Apellido " id="logname" autocomplete="off">
                                <i class="input-icon uil uil-user"></i>
                                @error("apellidos"){{ $message }}@enderror
                              </div>  
                              <div class="form-group mt-2"> 
                                <input type="text" name="nombrePerfil" class="form-style" placeholder="Ingresa tu Nickname " id="logname" autocomplete="off">
                                <i class="input-icon bi bi-person-heart"></i>
                                @error("nombrePerfil"){{ $message }}@enderror
                              </div> 
                              <div class="form-group mt-2"> 
                                <input type="date" name="fechaNacimiento" class="form-style" placeholder="Fecha de Nacimiento" id="logname" autocomplete="off">
                                <i class="input-icon bi bi-calendar2-event"></i>
                                @error("fechaNacimiento"){{ $message }}@enderror
                              </div>       
                              <div class="form-group mt-2">
                                <input type="email" name="email" class="form-style" placeholder="Ingresa tu correo electronico" id="logemail" autocomplete="off">
                                <i class="input-icon uil uil-at"></i>
                                @error("email"){{ $message }}@enderror
                              </div>  
                              <div class="form-group mt-2">
                                <input type="password" name="password" class="form-style" placeholder="Ingresa tu contraseña nueva" id="logpass" autocomplete="off">
                                <i class="input-icon uil uil-lock-alt"></i>
                                @error("password"){{ $message }}@enderror
                              </div>
                              <button type="submit" class="btn mt-4">Enviar</button>
                            </form>
                      
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


</body>