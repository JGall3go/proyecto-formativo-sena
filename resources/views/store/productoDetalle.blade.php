@extends('plantillas.buscador')

@section('produ')
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @isset($productos)
    <title>{{$productos->titulo }}</title>
    @endisset
   
    <link href="{{ asset('css/producto.css') }}" rel="stylesheet">
    <script src="{{ asset('js/content.js') }}"></script>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href="{{ asset('css/descripcion.css') }}" rel="stylesheet">

</head>>

<body>

    @isset($productos)
        <!-- Este es la imgen del header y el lading page -->

    <div class="header_producto">

        @isset($productos)
        <div class="producto_waves">
            <img src="{{ env('DASHBOARD_URL').$productos->imagen }}" id="imagen"> 
        </div>
        @endisset
        
        <!-- Contenido Datos -->

        <div class="container_datos">

            <div class="datos_presentacion">

            </div>

            @isset($productos)
            <!-- Este es el container donde va estar todo lo relacionado con el producto -->

            <div class="panel_producto-datos">

                <div class="name_producto">

                    <h1 class="titulo_producto" style="font-weight: bold;"> {{$productos->titulo }} </h1>

                </div>

                <!-- Subinfo del producto -->
                <div class="subinfo_producto">

                    <a target="_blank" style="color: #f5f5f5">

                        <!-- Iconos de las secciones del Subinfo -->
                        <div class=""></div>

                        {{ $productos->nombrePerfil }}

                        <!-- Espacio entre cada sección del Subinfo -->
                        <div class="espacio_subinfo-producto"></div>

                    </a>

                    <div class="descarga_producto">
                        <!-- Iconos de las secciones del Subinfo -->
                        <div class="uil uil-check"></div>

                        Descarga Digital

                    </div>

                </div>

                <div class="botones-producto">
                    @if($productos->cantidad > 5)
                    <form action="{{ route('cart.store') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" value="{{ $productos->idProducto }}" id="id" name="idProducto">
                        <input type="hidden" value="{{ $productos->titulo }}" id="titulo" name="titulo">
                        <input type="hidden" value="{{ $productos->valor }}" id="valor" name="valor">
                        <input type="hidden" value="{{ $productos->imagen }}" id="img" name="imagen">
                        <input type="hidden" value="{{ $productos->estado }}" id="img" name="estado">

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
                    <span style="color: #D35555; font-size: 20px; margin-top: 15px;">Stock Insuficiente</span>
                    @endif
                </div>


                <div class="precio_producto">

                    <!--<div class="descuento_precio-producto">

                        <div class="uil uil-bell"> -27USD </div>

                    </div>

                    <div class="descuento"> -67 </div>-->

                    <div class="total"> ${{$productos->valor }}</div>

                </div>

                <div class="comprar_producto">



                </div>


            </div>
            @endisset

        </div>

        <!-- Seccion de Descripcion -->
        <div class="diuv">
            <div>
                <h2 class="text" >Descripción</h2>
                <p class="text" >{{ $productos->descripcion }}</p class="text">

            </div>
            <span class="hid" id="hidText">

                @php
                    $requisitosMinimos = $productos->requisitosMinimos;
                    $requisitosRecomendados = $productos->requisitosRecomendados;
                @endphp

                <h2 class="text">Requisitos Minimos</h2>
                <p class="text" id="rm">
                    
                </p class="text"> <br>
                
                <h2 class="text">Requisitos Recomendados</h2>
                <p class="text" id="rc">

                <script>
                    const requisitosMinimos = @json($requisitosMinimos);
                    const requisitosRecomendados = @json($requisitosRecomendados);

                    var rm = document.getElementById("rm");
                    var rc = document.getElementById("rc");

                    temprm = document.createElement('span');
                    temprc = document.createElement('span');
                    temprm.innerHTML = requisitosMinimos;
                    temprc.innerHTML = requisitosRecomendados;

                    rm.append(temprm);
                    rc.append(temprc);
                </script>
                    
                </p>
            </span>

            <button class="boton" id="hidBut"> + </button>
        </div>
        <script src="{{ asset('js/mas.js') }}"></script>

    @else
        <div class="notfound">
            <div>
                <h1>Producto no encontrado</h1>
            </div>
        </div>
    @endisset

</body>

</html>

<footer>
    @extends('plantillas.footer')
</footer>