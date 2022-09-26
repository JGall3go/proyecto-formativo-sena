@extends('Dashboard/Plantillas/sidebar')

@section('content')

<div class="topBar" id="topBar">
    <div class="breadCrumbs">
        <span class="iconMenu" onclick="collectSidebarResponsive(this)">
            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><title>Menu</title><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M80 160h352M80 256h352M80 352h352"/></svg>
        </span>
        <div class="breadCrumbsText">
            <span style="color: #b9b9b9; font-size: 12px; font-weight: 600;">Dashboard</span> <span style="color: #818181; font-size: 12px; font-weight: 600;">/ Linea</span>
            <div><h3 style="margin-top: 0px; color: #707070">Lineas</h3></div>
        </div>
    </div>

    <span id="profileAncla"><span class="usernameText">{{ session('username') }}</span><img src="https://t4.ftcdn.net/jpg/00/64/67/63/360_F_64676383_LdbmhiNM6Ypzb3FM4PPuFP9rHe7ri8Ju.webp" id='imageProfile'>
        <a href="/dashboard/logout"><svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><title>Log Out</title><path d="M304 336v40a40 40 0 01-40 40H104a40 40 0 01-40-40V136a40 40 0 0140-40h152c22.09 0 48 17.91 48 40v40M368 336l80-80-80-80M176 256h256" fill="none" stroke="gray" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/></svg></a></span>
</div>

<section class="contentDashboard">

    <script src="{{ asset('js/content.js') }}"></script>

    @if($puedeVer == 1)
    <div class="tableContent">

        <div class="tableHeaderContent">

            <div class="firstSection">
                <form class="formSelect" action="{{ route('linea.index') }}" method="GET">
                    <select onchange="this.form.submit()" name='registros' class="registersSelect" id="select">
                        <option value='5'>5 Reg</option>
                        <option value='10'>10 Reg</option>
                        <option value='20'>20 Reg</option>
                        <option value='30'>30 Reg</option>
                    </select>
                </form>

                @if($puedeCrear == 1)
                <a onclick="showForm('create')" class="createLink"><svg xmlns="http://www.w3.org/2000/svg" class="addIcon" viewBox="0 0 512 512"><title>Add</title><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="64" d="M256 112v288M400 256H112"/></svg><span>Linea</span></a>
                @endif
            </div>

            <!-- Se cambia la opcion seleccionada dependiendo de la variable "paginate"-->
            <script type="text/javascript">
                var paginate = "<?= session('paginate'); ?>";
                document.getElementById('select').value = paginate;
            </script>

            <div class="searchBar">
                <form action="{{ route('linea.index') }}" method="GET" class="searchForm">
                    <input type="text" name="busqueda" class="searchInput"  @isset($busqueda)value="{{$busqueda}}"@endisset  placeholder="Buscar..." autocomplete="off">
                    <button type="submit" class="searchButton">
                        <img src="{{ asset('svg/search.svg') }}" id="ionIconElement">
                    </button>
                </form>
            </div>
        </div>

        <div class="tableContainer">

            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Linea</th>
                        <th class="actionButtonContainer">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($lineas) <= 0)
                        <tr><td colspan="100%">No se encontraron resultados.</td></tr>
                    @else

                    @foreach($lineas as $linea)
                    <tr>
                        <td style="width: 50%;">{{ $linea->idLinea}}</td>
                        <td style="width: 50%;">{{ $linea->linea}}</td>
                        <td class="actionButton" id="productActionButton" style="width: 50%;">

                            <div>
                                @if($puedeEditar == 1)
                                <form action="{{ url('dashboard/linea/'.$linea->idLinea.'/edit') }}">
                                    <button type="submit" class="botonEditar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="pencilSvg" viewBox="0 0 24 24"><path d="M14.078 4.232l-12.64 12.639-1.438 7.129 7.127-1.438 12.641-12.64-5.69-5.69zm-10.369 14.893l-.85-.85 11.141-11.125.849.849-11.14 11.126zm2.008 2.008l-.85-.85 11.141-11.125.85.85-11.141 11.125zm18.283-15.444l-2.816 2.818-5.691-5.691 2.816-2.816 5.691 5.689z"/></svg>
                                    </button>
                                </form>
                                @endif
            
                                @if($puedeBorrar == 1)
                                <form action="{{ url('dashboard/linea/'.$linea->idLinea) }}" method="POST">
                                    {{ method_field('DELETE')}}
                                    {{ csrf_field() }}
                                    <button type="submit" class="botonEliminar" onclick="return confirm('Quieres borrar este registro?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="trashSvg" viewBox="0 0 512 512" ><title>Eliminar</title><path d="M112 112l20 320c.95 18.49 14.4 32 32 32h184c17.67 0 30.87-13.51 32-32l20-320" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><path stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M80 112h352"/><path d="M192 112V72h0a23.93 23.93 0 0124-24h80a23.93 23.93 0 0124 24h0v40M256 176v224M184 176l8 224M328 176l-8 224" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif  
                </tbody>
            </table>
        </div>
        
        <div class="paginatorButtons">

            <!-- Paginator Section -->
            @php

                $registrosTotales = count($lineasTotales);
                $lineasActuales = count($lineas);
                $registros = count($lineasTotales) / session('paginate');

                /* Se comprubea si la variable registros tiene decimales, si los tiene se le suma una pagina ya que
                ese decimal es una pagina con menos de 5 registros */
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

                echo "<p class='paginatorText'>Mostrando $lineasActuales de $registrosTotales registros</p>";

                echo "<div class='paginatorArrows'>
                    <p class='paginatorText'>Pagina $paginaActual de $paginasTotales</p>
                    <a href='?page=$paginaAnterior' class='backForwardPaginator' id=$textBack><svg xmlns='http://www.w3.org/2000/svg' class='paginatorSvg' viewBox='0 0 512 512'><title>Atras</title><path fill='none' stroke-linecap='round' stroke-linejoin='round' stroke-width='48' d='M328 112L184 256l144 144'/></svg></a>
                    <a href='?page=$paginaSiguiente' class='backForwardPaginator' id=$textForward><svg xmlns='http://www.w3.org/2000/svg' class='paginatorSvg' viewBox='0 0 512 512'><title>Adelante</title><path fill='none' stroke-linecap='round' stroke-linejoin='round' stroke-width='48' d='M184 112l144 144-144 144'/></svg></a>
                </div>";
            @endphp
        </div>
    </div>

    @else
        <div class="errorMessage">
            <h2>No tienes acceso a esta pagina.</h2>
        </div>
    @endif

    @php

        if($errors->any()) {
            $formError = true;
        }

    @endphp

    <div class="forms" @isset($formDisplay)style="display: flex"@endisset @isset($formError)style="display: flex"@endisset>

        <a class="formBackground" @isset($lineasEdit) href="/dashboard/linea" @else onclick="showForm('create')" @endisset></a>

        <div class="createForm" id="product" @if(isset($formError) && !isset($perfilesEdit))style="display: flex" @endisset>

            <form action="{{url('/dashboard/linea')}}" method="POST" enctype="multipart/form-data" class="form" onkeydown="return event.key != 'Enter';">
    
                @csrf

                <h1 class="title">Crear</h1>

                <div class="container">
                    <label for="" class="label">Linea</label>
                    <input name="linea" type="text" class="input" placeholder=" " autocomplete="off">
                </div>

                <div class="buttonContainer">
                    <input type="submit" class="createButton" value="Crear"> <a class="cancelButton" onclick="showForm('create')">Cancelar</a>
                </div>

            </form>
        </div>
        

        <!-- UPDATE FORM -->
 
        <div class="updateForm" @isset($formDisplay)style="display: flex" @endisset id="product">

            <form @isset($productosEdit) action="{{ url('dashboard/linea/'.$lineasEdit->idLinea) }}" method="POST" @endisset enctype="multipart/form-data" class="form" onkeydown="return event.key != 'Enter';">
                
                @csrf
                {{ method_field('PATCH') }}

                <h1 class="title">Editar</h1>

                <div class="container">
                    <label for="" class="label">Linea</label>
                    <input name="linea" type="text" class="input" @isset($lineasEdit) value="{{$lineasEdit->linea}}"@endisset  placeholder=" " autocomplete="off">
                </div>

                <div class="buttonContainer">
                    <input type="submit" class="createButton" value="Editar"> <a class="cancelButton" href="{{ url('dashboard/linea/') }}">Cancelar</a>
                </div>

            </form>

        </div>
    </div>
</section>
@endsection