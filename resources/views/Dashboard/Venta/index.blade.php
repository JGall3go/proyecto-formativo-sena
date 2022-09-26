@extends('Dashboard/Plantillas/sidebar')

@section('content')

<section class="contentDashboard">

    <script src="{{ asset('js/content.js') }}"></script>

    <div class="topBar" id="topBar">
        <div class="breadCrumbs">
            <span class="iconMenu" onclick="collectSidebarResponsive(this)">
                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><title>Menu</title><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M80 160h352M80 256h352M80 352h352"/></svg>
            </span>
            <div class="breadCrumbsText">
                <span style="color: #b9b9b9; font-size: 12px; font-weight: 600;">Dashboard</span> <span style="color: #818181; font-size: 12px; font-weight: 600;">/ Venta</span>
                <div><h3 style="margin-top: 0px; color: #707070">Ventas</h3></div>
            </div>
        </div>

        <span id="profileAncla"><span class="usernameText">{{ session('username') }}</span><img src="https://t4.ftcdn.net/jpg/00/64/67/63/360_F_64676383_LdbmhiNM6Ypzb3FM4PPuFP9rHe7ri8Ju.webp" id='imageProfile'>
        <a href="/dashboard/logout"><svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><title>Log Out</title><path d="M304 336v40a40 40 0 01-40 40H104a40 40 0 01-40-40V136a40 40 0 0140-40h152c22.09 0 48 17.91 48 40v40M368 336l80-80-80-80M176 256h256" fill="none" stroke="gray" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/></svg></a></span>
    </div>

    @if($puedeVer == 1)
    <div class="tableContent">

        <div class="tableHeaderContent">

            <div class="firstSection">
                <form class="formSelect" action="{{ route('proveedor.index') }}" method="GET">
                    <select onchange="this.form.submit()" name='registros'  class="registersSelect" id="select">
                        <option value='5'>5 Reg</option>
                        <option value='10'>10 Reg</option>
                        <option value='20'>20 Reg</option>
                        <option value='30'>30 Reg</option>
                    </select>
                </form>
            </div>

            <!-- Se cambia la opcion seleccionada dependiendo de la variable "paginate"-->
            <script type="text/javascript">
                var paginate = "<?= session('paginate'); ?>";
                document.getElementById('select').value = paginate;
            </script>

            <div class="searchBar">
                <form action="{{ route('proveedor.index') }}" method="GET" class="searchForm">
                    <input type="text" name="busqueda" class="searchInput"  @isset($busqueda)value="{{$busqueda}}"@endisset  placeholder="Buscar..." autocomplete="off">
                    <button type="submit" class="searchButton">
                        <img src="{{ asset('svg/search.svg') }}" id="ionIconElement">
                    </button>
                </form>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Detalle</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Metodo de Pago</th>
                    <th>Cliente</th>
                </tr>
            </thead>
            <tbody>
                @if(count($ventas) <= 0)
                    <tr><td colspan="100%">No se encontraron resultados.</td></tr>
                @else

                @foreach($ventas as $venta)
                <tr>
                    <td>{{ $venta->idVenta}}</td>
                    <td>
                      <form action="{{ url('dashboard/venta/'.$venta->idVenta) }}" method="GET">
                        <button type="submit" class="showDescriptionButton">
                        <svg xmlns="http://www.w3.org/2000/svg" class="eyeIcon" viewBox="0 0 512 512"><title>Eye</title><path d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z" fill="none" stroke="gray" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><circle cx="256" cy="256" r="80" fill="none" stroke="gray" stroke-miterlimit="10" stroke-width="32"/></svg>
                        </button>
                      </form>
                    </td>
                    <td>{{ $venta->fecha}}</td>
                    <td>{{ $venta->total}}</td>
                    <td>{{ $venta->metodo}}</td>
                    <td>{{ $venta->nombrePerfil}}</td>
                </tr>
                @endforeach
                @endif  
            </tbody>
        </table>

        <div class="paginatorButtons">

            <!-- Paginator Section -->

            @php

                $registrosTotales = count($ventasTotales);
                $ventasActuales = count($ventas);
                $registros = count($ventasTotales) / session('paginate');

                /* Se comprubea si la variable registros tiene decimales, si los tiene se le suma una pagina ya que
                    ese decimal es una pagina con menos de 5 registros*/
                if(is_numeric( $registros ) && floor($registros) != $registros){$registros++;}
                $paginasTotales = intval($registros);

                if($page == ""){$page = 1;}
                
                $textBack = 'Inactive';
                $textForward = 'Inactive';
                $paginaAnterior = 1;
                $paginaSiguiente = $paginasTotales;
                    
                // Si la pagina actual es mayor a 1 se podra volver a atras en el paginador.
                if($page > 1){$textBack = 'Active'; $paginaAnterior = $page - 1;}

                // Si la pagina actual es menor a la cantidad de paginas totales se podra avanzar en el paginador.
                if($page < $paginasTotales){$textForward = 'Active'; $paginaSiguiente = $page + 1;}   
                            
                // Si la pagina siguiente es igual a 0 entonces la pagina actual sera 0;
                $paginaActual = $page;
                if($paginasTotales == 0){ $paginaActual = 0; }

                echo "<p class='paginatorText'>Mostrando $ventasActuales de $registrosTotales registros</p>";

                echo "
                <div class='paginatorArrows'>
                    <p class='paginatorText'>Pagina $paginaActual de $paginasTotales</p>
                    <a href='?page=$paginaAnterior' class='backForwardPaginator' id=$textBack><svg xmlns='http://www.w3.org/2000/svg' class='paginatorSvg' viewBox='0 0 512 512'><title>Atras</title><path fill='none' stroke-linecap='round' stroke-linejoin='round' stroke-width='48' d='M328 112L184 256l144 144'/></svg></a>
                    <a href='?page=$paginaSiguiente' class='backForwardPaginator' id=$textForward><svg xmlns='http://www.w3.org/2000/svg' class='paginatorSvg' viewBox='0 0 512 512'><title>Adelante</title><path fill='none' stroke-linecap='round' stroke-linejoin='round' stroke-width='48' d='M184 112l144 144-144 144'/></svg></a>
                </div>";
            @endphp
        </div>
    </div>

    <div class="descripcionContainer" @isset($ventaDetalle)style="display: flex"@else style="display: none" @endisset>
        <a class="descriptionBackground" href="/dashboard/venta"></a>

        <div class="descriptionContent">
            <div class="descriptionText" >
                <div>
                    <h3>Detalle de venta</h3>
                    <div class="listaProductos">
                    @isset($ventaDetalle)
                        @foreach($ventaDetalle as $venta)
                            <span>- <b>{{ $venta->titulo }} ( x{{$venta->cantidad}} ):</b> ${{ $venta->total }}</span>
                        @endforeach
                    @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>

    @else
    <div class="errorMessage">
        <h2>No tienes acceso a esta pagina.</h2>
    </div>
    @endif

</section>

@endsection