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
                <span style="color: #b9b9b9; font-size: 12px; font-weight: 600;">Dashboard</span> <span style="color: #818181; font-size: 12px; font-weight: 600;">/ Administrador</span>
                <div><h3 style="margin-top: 0px; color: #707070">Administradores</h3></div>
            </div>
        </div>

        <span id="profileAncla"><span class="usernameText">{{ session('username') }}</span><img src="{{asset('storage').'/'.session('userImage')}}" id='imageProfile'>
        <a href="/dashboard/logout"><svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><title>Log Out</title><path d="M304 336v40a40 40 0 01-40 40H104a40 40 0 01-40-40V136a40 40 0 0140-40h152c22.09 0 48 17.91 48 40v40M368 336l80-80-80-80M176 256h256" fill="none" stroke="gray" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/></svg></a></span>
    </div>

    @if($puedeVer == 1)
    <div class="tableContent">

        <div class="tableHeaderContent">

            <div class="firstSection">
                <form class="formSelect" action="{{ route('administrador.index') }}" method="GET">
                    <select onchange="this.form.submit()" name='registros'  class="registersSelect" id="select">
                        <option value='5'>5 Reg</option>
                        <option value='10'>10 Reg</option>
                        <option value='20'>20 Reg</option>
                        <option value='30'>30 Reg</option>
                    </select>
                </form>

                @if($puedeCrear == 1)
                <a onclick="showForm()" class="createLink"><svg xmlns="http://www.w3.org/2000/svg" class="addIcon" viewBox="0 0 512 512"><title>Add</title><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="64" d="M256 112v288M400 256H112"/></svg><span>Administrador</span></a>
                @endif
            </div>

            <!-- Se cambia la opcion seleccionada dependiendo de la variable "paginate"-->
            <script type="text/javascript">
                var paginate = "<?= session('paginate'); ?>";
                document.getElementById('select').value = paginate;
            </script>

            <div class="searchBar">
                <form action="{{ route('administrador.index') }}" method="GET" class="searchForm">
                    <input type="text" name="busqueda" class="searchInput" value="{{session('busqueda1')}}"  placeholder="Buscar..." autocomplete="off">
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
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Fecha de nacimiento</th>
                    <th>Estado</th>
                    <th>Telefono</th>
                    <th>Documento</th>
                    <th>Direccion</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @if(count($perfiles) <= 0)
                    <tr><td colspan="100%">No se encontraron resultados.</td></tr>
                @else

                @foreach($perfiles as $perfil)
                <tr>
                    <td>{{ $perfil->idContinua}}</td>
                    <td>{{$perfil->nombres}} {{$perfil->apellidos}}</td>
                    <td>{{ $perfil->nombrePerfil}}</td>
                    <td>{{ $perfil->fechaNacimiento}}</td>
                    <td><span @if($perfil->estado == "Activo")class="activeState"@else class="inactiveState" @endif>{{ $perfil->estado}}<span></td>
                    <td>{{ $perfil->telefono}}</td>
                    <td>{{ $perfil->tipoDocumento }} - {{ $perfil->documento }}</td>
                    <td>{{ $perfil->ciudad}} - {{ $perfil->direccion}}</td>
                    <td>{{ $perfil->email}}</td>
                    <td>{{ $perfil->rol}}</td>
                    <td class="actionButton">
                        <div>

                            @if($puedeEditar == 1)
                            <form action="{{ url('dashboard/administrador/'.$perfil->idPerfil.'/edit') }}">
                                <button type="submit" class="botonEditar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="pencilSvg" viewBox="0 0 24 24"><path d="M14.078 4.232l-12.64 12.639-1.438 7.129 7.127-1.438 12.641-12.64-5.69-5.69zm-10.369 14.893l-.85-.85 11.141-11.125.849.849-11.14 11.126zm2.008 2.008l-.85-.85 11.141-11.125.85.85-11.141 11.125zm18.283-15.444l-2.816 2.818-5.691-5.691 2.816-2.816 5.691 5.689z"/></svg>
                                </button>
                            </form>
                            @endif
        
                            @if($puedeBorrar == 1)
                            <form action="{{ url('dashboard/administrador/'.$perfil->idPerfil) }}" method="POST">
                                {{ method_field('DELETE')}}
                                {{ csrf_field() }}
                                <button type="submit" class="botonEliminar" onclick="return confirm('Quieres borrar este registro?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="trashSvg" viewBox="0 0 512 512" ><title>Trash</title><path d="M112 112l20 320c.95 18.49 14.4 32 32 32h184c17.67 0 30.87-13.51 32-32l20-320" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><path stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M80 112h352"/><path d="M192 112V72h0a23.93 23.93 0 0124-24h80a23.93 23.93 0 0124 24h0v40M256 176v224M184 176l8 224M328 176l-8 224" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/></svg>
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

        <div class="paginatorButtons">

            <!-- Paginator Section -->

            @php

                $registrosTotales = count($perfilesTotales);
                $perfilesActuales = count($perfiles);
                $registros = count($perfilesTotales) / session('paginate');

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

                echo "<p class='paginatorText'>Mostrando $perfilesActuales de $registrosTotales registros</p>";

                echo "
                <div class='paginatorArrows'>
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

    <div class="forms" @isset($formDisplay)style="display: flex" @endisset @isset($formError)style="display: flex"@endisset>

        <a class="formBackground" @isset($perfilesEdit) href="/dashboard/administrador" @else onclick="showForm('create')" @endisset></a>

        <div class="createForm" @if(isset($formError) && !isset($perfilesEdit))style="display: flex" @endisset>

            <form action="{{url('/dashboard/administrador')}}" method="POST" enctype="multipart/form-data" class="form">
    
                @csrf
                @include('Dashboard/Plantillas/createForm', ['usuario' => 'Administrador'])
    
            </form>
        </div>
    
        <div class="updateForm" @isset($formDisplay)style="display: flex" @endisset>
    
            <form @isset($perfilesEdit) action="{{ url('dashboard/administrador/'.$perfilesEdit->idPerfil) }}" method="POST" @endisset enctype="multipart/form-data" class="form" id="secondForm">
                
                @csrf
                {{ method_field('PATCH') }}
    
                @php
                    if(isset($perfilesEdit)){$perfilesEdit = $perfilesEdit;} else { $perfilesEdit = null;}
                @endphp
    
                @include('Dashboard/Plantillas/updateForm', ['usuario' => 'Administrador', 'edit' => $perfilesEdit, 'url' => '/dashboard/administrador'])
    
            </form>
        </div>
    </div>

</section>

@endsection