<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('.css/vista-home.css') }}" rel="stylesheet">
    <link href="{{ asset('css/galeria.css') }}" rel="stylesheet">
    <link href="{{ asset('css/banner.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">


    <title>Store</title>
</head>

<body style="background-color:black ;">

    <header>
        @extends('plantillas/buscador')

        @section('buscador')
    </header>
    <!-- home -->
    <div class="cotanier-fluid">


        <!-- galeria 1 -->
        <div class="content_grid">
            <!-- galeria 1 -->

          

        </div>

    </div>
    <!--div de cierre perron -->
    <footer>
        @extends('plantillas/footer')

        @section('footer')


    </footer>

    @endsection



</body>

</html>