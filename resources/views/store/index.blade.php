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
    
        <!--banner1-->
        @php
            $url=URL::asset('/recursos_css/cyberpunk.jfif');
            @endphp
        <div class="main-image" style="background: url('{{ $url }}') no-repeat center; background-size: cover; ">
            
            <div class="container-banner " >

                <h1> <span>banner</span></h1>
                <span class="cen"> web designer y developer </span>
                <a class="button-banner" href="#"> view more</a>

            </div>
        </div>
        <!-- resultado busqueda -->
        <div id="resultado" class="content_grid"> </div>
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

        <!--banner2-->
        @php
            $url=URL::asset('/recursos_css/colorful.jfif');
            @endphp
        <div class="main-image-2" style="background: url('{{ $url }}') no-repeat center; background-size: cover; ">
          

            <div class="container-banner" >

                <h1> <span>banner</span></h1>
                <span class="cen"> web designer y developer </span>
                <a class="button-banner" href="#"> view more</a>

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
        <div class="gal-offtopic">
            @php
            $url=URL::asset('/recursos_css/kindred.jfif')
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

        <!--categorias -->
        <div class="mas">
            <div class="cont">
                <div class="title">
                    <h1 class="underline_title">Categorias</h1>
                </div>
            </div>
            <!-- fila 1 caracteristicas -->

            <div class="container">
                <div class="card">
                    <a href="">
                        <img src="{{URL::asset('/img/wach.jpg')}}">
                    </a>
                    <!-- hoover y efectos-->
                    <div class="overlay">
                        <div class="text">ACCION</div>
                    </div>
                </div>

                <div class="card">
                    <a href="">
                        <img src="img/metal.jpg">
                    </a>
                    <div class="overlay">
                        <div class="text">ARCADE</div>
                    </div>
                </div>

                <div class="card">
                    <a href="">
                        <img src="img/aventura.jpg">
                    </a>
                    <div class="overlay">
                        <div class="text">AVENTURA</div>
                    </div>
                </div>
            </div>

            <!-- flia 2 caracteristicas -->

            <div class="container">
                <div class="card">
                    <a href="">
                        <img src="img/estrategia.jpg">
                    </a>
                    <div class="overlay">
                        <div class="text">ESTRATEGIA</div>
                    </div>
                </div>

                <div class="card">
                    <a href="">
                        <img src="img/fps.jpg">
                    </a>
                    <div class="overlay">
                        <div class="text">SHOOTER</div>
                    </div>
                </div>

                <div class="card">
                    <a href="">
                        <img src="img/lucha.jpg">
                    </a>
                    <div class="overlay">
                        <div class="text">FIGTHER</div>
                    </div>
                </div>
            </div>

            <!-- fila 3 caracteristicas -->

            <div class="container">
                <div class="card">
                    <a href="">
                        <img src="img/rpg.jpg">
                    </a>
                    <div class="overlay">
                        <div class="text">RPG</div>
                    </div>
                </div>

                <div class="card">
                    <a href="">
                        <img src="img/uno.jpeg">
                    </a>
                    <div class="overlay">
                        <div class="text">SURVIVAL</div>
                    </div>
                </div>

                <div class="card">
                    <a href="">
                        <img src="img/vr.jpg">
                    </a>
                    <div class="overlay">
                        <div class="text">VIRTUAL-REALITY</div>
                    </div>
                </div>
            </div>

            <div class="more">

            </div>

            <!-- ver mas o menos -->

            <!-- fila 1 caracteristicas ver mas -->

            <span class="hid" id="hidText">

                <div class="container">
                    <div class="card">
                        <a href="">
                            <img src="img/carrera.jpg">
                        </a>
                        <div class="overlay">
                            <div class="text">RACER</div>
                        </div>
                    </div>

                    <div class="card">
                        <a href="">
                            <img src="img/multijugador.jpeg">
                        </a>
                        <div class="overlay">
                            <div class="text">BATTLE-GROUND</div>
                        </div>
                    </div>

                    <div class="card">
                        <a href="">
                            <img src="img/mmo.jpg">
                        </a>
                        <div class="overlay">
                            <div class="text">MMO</div>
                        </div>
                    </div>
                </div>

                <!-- fila 2 caracteristicas ver mas -->

                <div class="container">
                    <div class="card">
                        <a href="">
                            <img src="img/cooli.jpg">
                        </a>
                        <div class="overlay">
                            <div class="text">COOPERATIVO</div>
                        </div>
                    </div>

                    <div class="card">
                        <a href="">
                            <img src="img/depor.jpg">
                        </a>
                        <div class="overlay">
                            <div class="text">DEPORTES</div>
                        </div>
                    </div>

                    <div class="card">
                        <a href="">
                            <img src="img/cooduo.jpg">
                        </a>
                        <div class="overlay">
                            <div class="text">FANTASIA</div>
                        </div>
                    </div>
                </div>

            </span>

            <!-- boton mas o menos -->

            <button class="but" id="hidBut">Ver mas</button>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
            <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
            <script src="{{ asset('js/bot.js') }}"></script>
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