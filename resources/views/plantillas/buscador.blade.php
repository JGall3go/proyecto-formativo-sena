<link href="{{ asset('css/buscador.css') }}" rel="stylesheet">

<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

<!-- cosas del carrito del diablo -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
<!-- fin de cosas del carrito del diablo -->

<header class="header_container">

    <a href="{{route('store.index')}}">

        <img class="logo_header" src="{{asset('/img/keys.png')}}" alt="Logo">

    </a>

    <div class="menu_header">

        <div class="navegacion_container">

        <a class="navegacion_link" href="{{ route('condicion') }}">Terminos y condiciones</a>

        <div class="navegacion_link-separacion"></div>

        <a class="navegacion_link" href="{{ route('fap') }}">Soporte 24/7</a>

        </div>

       

        <div class="container_buscador">

            <div class="buscador_icono">

                <i class="buscador uil uil-search"></i>

            </div>


                <form action="{{route('buscar')}}" method="GET" id="buscador" class="buscador_input">

                    <input type="text" id="search_clear" name="query">
                    <i class="clear uil uil-x"></i>
                    <input type="submit" hidden id="search">
                </form>

        </div>

    </div>
 
    <div class="navegacion_link" style=" background-color:#9256F0; border-radius: 20px;     height: 50%;
    margin-left: 65%;">
                <li class="nav-item dropdown" style="margin-top: -20% ;">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="badge badge-pill badge-dark">
                            <i class="fa fa-shopping-cart"></i> {{ \Cart::getTotalQuantity()}}
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" style="width: 450px; padding: 0px; border-color:#9DA0A2">
                        <ul class="list-group" style="margin: 20px;">
                            @include('partials.cart-drop')
                        </ul>
                    </div>
                </li> 
              
                 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
                 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
                 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
                 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

            </div>

    <script>
        let buscador = document.querySelector(".buscador");

        buscador.onclick = function() {

            document.querySelector(".container_buscador").classList.toggle('active');
        }


        let clear = document.querySelector(".clear");


        clear.onclick = function() {

            document.getElementById("search_clear").value = "";

        }
    </script>

    <!-- mas cosas del carrito del insaño -->
    <div>

        
        
        </div>

   
    <div class="login_container">

        @auth
            <!--<span class="usernameText">{{ session('username') }}</span>-->
            <a href="/biblioteca"><img src="{{env('DASHBOARD_URL').'/'.session('userImage')}}" id='imageProfile'></a>
            <a href="/logout"><svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><title>Log Out</title><path d="M304 336v40a40 40 0 01-40 40H104a40 40 0 01-40-40V136a40 40 0 0140-40h152c22.09 0 48 17.91 48 40v40M368 336l80-80-80-80M176 256h256" fill="none" stroke="gray" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/></svg></a>
        @else
            <a href='/login' class="btn btn-outline-success">Login</a>
        @endauth

    </div>

</header>