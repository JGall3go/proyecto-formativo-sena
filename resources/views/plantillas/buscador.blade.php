<link href="{{ asset('css/buscador.css') }}" rel="stylesheet">

<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">


<header class="header_container">

    <a href="{{route('store.index')}}">

        <img class="logo_header" src="{{asset('/img/keys.png')}}" alt="Logo">

    </a>

    <div class="menu_header">

        <div class="navegacion_container">

            <a class="navegacion_link" href=""> Juegos del momento</a>
            <a class="navegacion_link" href=""> Reservas</a>
            <a class="navegacion_link" href="">Más vendidos</a>
            <div class="navegacion_link-separacion"></div>
            <a class="navegacion_link" href="">Soporte 24/7</a>

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