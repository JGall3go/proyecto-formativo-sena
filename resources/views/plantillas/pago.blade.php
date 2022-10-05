<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{asset('css/metodo.css')}}" rel="stylesheet" >
     <!-- CSS only -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    
    <title>Document</title>
</head>
<body>
    <header class="header_container_pago">

        <a href="{{ route('store.index') }}" class="logo_pago"><img src="{{ asset('/img/keys.png') }}" alt="" class="img"></a>

        <div class="barra_progreso_pago">

            <div class="step_active">

                <div class="icono"></div>

                <span class="texto_progreso">Pedido Realizado</span>

            </div>

            <div class="spacer"></div>

            <span class="step">

                <span class="texto_progreso">Pago</span>

            </span>

            <div class="spacer_inactive"></div>

            <span class="step_inactive">

                <span class="texto_progreso">Activacion del juego</span>

            </span>

        </div>

        <div class="seguridad_pago">

            <div class="icono_seguridad uil uil-padlock"> 

                <img src="{{ asset('img/candado.png') }}" alt="" class="icono">

            </div>

            <span>Pago Seguro</span>

        </div>

    </header>
 
    
</body>

    @yield('metodo')

</html>