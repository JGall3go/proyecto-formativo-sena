<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
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
            <h6 class="mb-0 pb-3">
              <span>Iniciar Sesion</span>
              <span>Registrarse</span>
            </h6>
            <input class="checkbox" type="checkbox" id="reg-log" name="reg-log"/>
            <label for="reg-log"></label>

            <div class="card-3d-wrap mx-auto">
              <div class="card-3d-wrapper">
                
                <div @if($errors->any()) class="card-back" @else class="card-front" @endif>
                  <div class="center-wrap">
                    <div class="section text-center">
                      <h4 class="mb-4 pb-3">INICIAR SESION</h4>
                      <form method="POST" action="/login">
                        @csrf
                        <div class="form-group">
                          <input required type="email" name="email" class="form-style" placeholder="Correo Electronico" id="logemail" autocomplete="off">
                          <i class="input-icon uil uil-at"></i>
                        </div>
                        <div class="form-group mt-2">
                          <input required type="password" name="password" class="form-style" placeholder="Tu Contraseña" id="logpass" autocomplete="off">
                          <i class="input-icon uil uil-lock-alt"></i>
                        </div>
                        @if(session('response'))
                        <div class="alert-danger" style="text-align: center; margin-top: 15px;">{{session('response')}}</div>
                        @endif
                        <button autofocus type="submit" class="btn mt-4">Entrar</button>
                      </form>
                    </div>
                  </div>
                </div>

                <div @if($errors->any()) class="card-front" @else class="card-back" @endif>
                  <div class="center-wrap">
                    <div class="section text-center">
                      <h4 class="mb-4 pb-3">REGISTRARSE</h4>
                      <form method="POST" action="/signup">
                        @csrf
                        <div class="form-group">
                          <input type="text" name="nombres" class="form-style" placeholder="Ingresa tu Nombre " id="logname" autocomplete="off">
                          <i class="input-icon uil uil-user"></i>
                          <div class="alert-danger">@error("nombres"){{ $message }}@enderror</div>
                        </div>
                        <div class="form-group mt-2"> 
                          <input type="text" name="apellidos" class="form-style" placeholder="Ingresa tu Apellido " id="logname" autocomplete="off">
                          <i class="input-icon uil uil-user"></i>
                          <div class="alert-danger">@error("apellidos"){{ $message }}@enderror</div>
                        </div>  
                        <div class="form-group mt-2"> 
                          <input type="text" name="nombrePerfil" class="form-style" placeholder="Ingresa tu Nickname " id="logname" autocomplete="off">
                          <i class="input-icon bi bi-person-heart"></i>
                          <div class="alert-danger">@error("nombrePerfil"){{ $message }}@enderror</div>
                        </div> 
                        <div class="form-group mt-2"> 
                          <input type="date" name="fechaNacimiento" class="form-style" placeholder="Fecha de Nacimiento" id="logname" autocomplete="off">
                          <i class="input-icon bi bi-calendar2-event"></i>
                          <div class="alert-danger">@error("fechaNacimiento"){{ $message }}@enderror</div>
                        </div>  

                        <div class="form-group mt-2"> 
                          <select class="form-style" name="tipoDocumento">
                            <option selected disabled>Tipo de documento</option>
                            <option value="1">CC</option>
                            <option value="2">CE</option>
                          </select>
                          <i class="input-icon uil uil-user"></i>
                          <div class="alert-danger">@error("tipoDocumento"){{ $message }}@enderror</div>
                        </div> 
                        <div class="form-group mt-2"> 
                          <input type="text" name="documento" class="form-style" placeholder="Documento" id="logname" autocomplete="off">
                          <i class="input-icon uil uil-user"></i>
                          <div class="alert-danger">@error("documento"){{ $message }}@enderror</div>
                        </div> 

                        <div class="form-group mt-2">
                          <input type="email" name="email" class="form-style" placeholder="Ingresa tu correo electronico" id="logemail" autocomplete="off">
                          <i class="input-icon uil uil-at"></i>
                          <div class="alert-danger">@error("email"){{ $message }}@enderror</div>
                        </div>  
                        <div class="form-group mt-2">
                          <input type="password" name="password" class="form-style" placeholder="Ingresa tu contraseña nueva" id="logpass" autocomplete="off">
                          <i class="input-icon uil uil-lock-alt"></i>
                          <div class="alert-danger">@error("password"){{ $message }}@enderror</div>
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
  
</body>
</html>