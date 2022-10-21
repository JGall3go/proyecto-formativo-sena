@extends('plantillas/buscador')

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


    <!-- home -->
    <div class="cotanier-fluid">
    
        <!--banner1-->
        @php
            $url=URL::asset('/recursos_css/cyberpunk.jfif');
            @endphp
        <div class="main-image" style="background: url('{{ $url }}') no-repeat center; background-size: cover; ">
            
            <div class="container-banner " >

                <h1> <span>Review</span></h1>
                <span class="cen"> Revisa las ultimas criticas </span>
                <a class="button-banner" href="https://www.metacritic.com/game/pc/cyberpunk-2077" target="_blank"> view more</a>

            </div>
        </div>
        <!-- resultado busqueda -->
        <div id="resultado" class="content_grid">
            @if(session('resultado'))
                @foreach(session('resultado') as $resultado)
                @isset($resultado->detalle[0])
                <div class="card" style="width: 18rem;">
                    <a href="{{ route('detalle.producto', [$resultado->titulo]) }}" style="text-decoration: none; color: #f5f5f5;">
                        <img src="{{ env('DASHBOARD_URL').$resultado->detalle[0]->imagen }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <span class="card-text">{{ $resultado->titulo }}</span>
                            <span class="precio">${{ number_format($resultado->detalle[0]->valor, 0) }}</span>
                            
                        </div>
                        <form action="{{ route('cart.store') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{ $resultado->detalle[0]->idProducto }}" id="id" name="idProducto">
                            <input type="hidden" value="{{ $resultado->titulo }}" id="titulo" name="titulo">
                            <input type="hidden" value="{{ $resultado->detalle[0]->valor }}" id="valor" name="valor">
                            <input type="hidden" value="{{ $resultado->detalle[0]->imagen }}" id="img" name="imagen">
                            <input type="hidden" value="{{ $resultado->detalle[0]->estado }}" id="img" name="estado">

                            <input type="hidden" value="1" id="quantity" name="quantity">
                            <div class="card-footer" >
                                <div class="row">
                                    <button class="btn btn-secondary btn-sm" class="tooltip-test" title="add to cart">
                                        <i class="fa fa-shopping-cart"></i> agregar al carrito
                                    </button>
                                </div>
                            </div>
                        </form>
                    </a>
                </div>
                @endisset
                @endforeach            
            @endif
        </div>
        <!-- galeria 1 -->
        <div class="content_grid">
            @php
                $count = 0;
            @endphp
            <!-- galeria 1 -->
            @foreach ( $data['productos'] as $producto)
            @php
                $count++;
            @endphp
            @if($count <= 12)
            <div class="card" style="width: 18rem;">
                <a href="{{ route('detalle.producto',[$producto->titulo]) }}" style="text-decoration: none; color: #f5f5f5;">
                    <img src="{{ env('DASHBOARD_URL').$producto->imagen }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <span class="card-text">{{ $producto->titulo }}</span>
                        <span class="precio">${{ number_format($producto->valor, 0) }}</span>
                        
                    </div>
                    @if($producto->cantidad > 5)
                    <form action="{{ route('cart.store') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" value="{{ $producto->idProducto }}" id="id" name="idProducto">
                        <input type="hidden" value="{{ $producto->titulo }}" id="titulo" name="titulo">
                        <input type="hidden" value="{{ $producto->valor }}" id="valor" name="valor">
                        <input type="hidden" value="{{ $producto->imagen }}" id="img" name="imagen">
                        <input type="hidden" value="{{ $producto->estado }}" id="img" name="estado">

                        <input type="hidden" value="1" id="quantity" name="quantity">
                        <div class="card-footer" >
                            <div class="row">
                                <button class="btn btn-secondary btn-sm" class="tooltip-test" title="add to cart">
                                    <i class="fa fa-shopping-cart"></i> agregar al carrito
                                </button>
                            </div>
                        </div>
                    </form>
                    @else
                    <section style="width: 100%; display: flex; justify-content: center; flex-direction: column;">
                        <p style="color: #D35555; font-size: 20px; text-align: center;">Agotado</p>
                        <small style="text-align: center;">Se repondrá en unas horas</small>
                    </section>
                    
                    @endif
                </a>
            </div>
            @endif
            
            @endforeach
            
        </div>

        <!--banner2-->
        @php
            $url=URL::asset('/recursos_css/colorful.jfif');
        @endphp
        <div class="main-image-2" style="background: url('{{ $url }}') no-repeat center; background-size: cover; ">

            <div class="container-banner" >

                <h1> <span>News</span></h1>
                <span class="cen"> Descubre proximos lanzamientos</span>
                <a class="button-banner" href="https://gamerant.com/gaming/" target="_blank"> view more</a>

            </div>
        </div>

        <!-- galeria 2 -->
        <div class="content_grid">

            @php
                $count = 0;
            @endphp
            <!-- galeria 1 -->
            @foreach ( $data['productosS2'] as $producto)
            @php
                $count++;
            @endphp
            @if($count <= 12)
            <div class="card" style="width: 18rem;">
                <a href="{{ route('detalle.producto',[$producto->titulo]) }}" style="text-decoration: none; color: #f5f5f5;"><img src="{{ env('DASHBOARD_URL').$producto->imagen }}" class="card-img-top" alt="...">
                <div class="card-body">
                    <span class="card-text">{{ $producto->titulo }}</span>
                    <span class="precio">${{ number_format($producto->valor, 0) }}</span>
                    
                </div>
                <form action="{{ route('cart.store') }}" method="POST">{{ csrf_field() }}
                        <input type="hidden" value="{{ $producto->idProducto }}" id="id" name="idProducto">
                        <input type="hidden" value="{{ $producto->titulo }}" id="titulo" name="titulo">
                        <input type="hidden" value="{{ $producto->valor }}" id="valor" name="valor">
                        <input type="hidden" value="{{ $producto->imagen }}" id="img" name="imagen">

                        <input type="hidden" value="1" id="quantity" name="quantity">
                        <div class="card-footer" >
                            <div class="row">
                                <button class="btn btn-secondary btn-sm" class="tooltip-test" title="add to cart">
                                    <i class="fa fa-shopping-cart"></i> agregar al carrito
                                </button>
                            </div>
                        </div>
                    </form> </a>
            </div>
            @endif
            
            @endforeach


        </div>

        <!-- galeria offtopics-->
        <div class="gal-offtopic" style="margin-bottom: 100px;">
            @php
            $url=URL::asset('/recursos_css/kindred.jpg')
            @endphp
            <div class="cont-gal-off " style="background: url({{$url}}) no-repeat center; background-size: cover;">

                <h1> <span>Indie</span></h1>

                @php
                $count = 0;
                @endphp
                <!-- galeria 1 -->
                @foreach ( $data['productosS2'] as $producto)
                @php
                    $count++;
                @endphp
                @if($count <= 2)
                <div class="card" style="width: 18rem;">
                    <a href="{{ route('detalle.producto',[$producto->titulo]) }}"><img src="{{ env('DASHBOARD_URL').$producto->imagen }}" class="card-img-top" alt="..."></a>
                </div>
                @endif
            
            @endforeach

            </div>

        </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
            <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
            <script src="{{ asset('js/bot.js') }}"></script>
        </div>
        -->

    </div>
    <!--div de cierre -->
    <footer>
        @extends('plantillas/footer')

        @section('footer')

    </footer>

    @endsection



</body>

</html>