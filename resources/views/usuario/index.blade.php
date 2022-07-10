@extends('platillas/sidebar')

@section('content')

<section class="contentDashboard">

    <script src="{{ asset('js/content.js') }}"></script>

    <div class="breadCrumbs">
        Dashboard <span style="color: #858383">/ Usuario</span>
        <div><h3 style="margin-top: 5px; color: #858383">Usuarios</h3></div>
    </div>

    <div class="tableContent">

        <div class="tableHeaderContent">

            <form class="formSelect" action="{{ route('usuario.index') }}" method="GET">
                <select onchange="this.form.submit()" name='registros' id="select">
                    <option value='5'>5</option>
                    <option value='10'>10</option>
                    <option value='15'>15</option>
                </select>
            </form>

            <!-- Se cambia la opcion seleccionada dependiendo de la variable "paginate"-->
            <script type="text/javascript">
                var paginate = "<?= session('paginate'); ?>";
                document.getElementById('select').value = paginate;
            </script>

            <div class="searchBar">
                <form action="{{ route('usuario.index') }}" method="GET" class="searchForm">
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
                    <th>Nombre</th>
                    <th>Fecha de nacimiento</th>
                    <th>Contraseña</th>
                    <th>Estado</th>
                    <th>Telefono</th>
                    <th>Ciudad</th>
                    <th>Direccion</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @if(count($usuarios)<=0)
                    <tr><td colspan="100%">No se encontraron resultados.</td></tr>
                @else

                @foreach($usuarios as $usuario)

                <tr>
                    <td>{{ $usuario->idUsuario}}</td>
                    <td>{{ $usuario->nombreUsuario}}</td>
                    <td>{{ $usuario->fechaNacimiento}}</td>
                    <td>{{ $usuario->contrasena}}</td>
                    <td><span @if($usuario->estado == "Activo")class="activeState"@else class="inactiveState" @endif>{{ $usuario->estado}}<span></td>
                    <td>{{ $usuario->telefono}}</td>
                    <td>{{ $usuario->ciudadResidencia}}</td>
                    <td>{{ $usuario->direccion}}</td>
                    <td>{{ $usuario->email}}</td>
                    <td class="actionButton">

                        <form action="{{ url('dashboard/usuario/'.$usuario->idUsuario.'/edit') }}">
                            <button type="submit" class="botonEditar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="pencilSvg" viewBox="0 0 24 24"><path d="M14.078 4.232l-12.64 12.639-1.438 7.129 7.127-1.438 12.641-12.64-5.69-5.69zm-10.369 14.893l-.85-.85 11.141-11.125.849.849-11.14 11.126zm2.008 2.008l-.85-.85 11.141-11.125.85.85-11.141 11.125zm18.283-15.444l-2.816 2.818-5.691-5.691 2.816-2.816 5.691 5.689z"/></svg>
                                <!--<img src="{{ asset('svg/pencil-outline.svg') }}" id="ionIconElement">-->
                            </button>
                        </form>

                        <form action="{{ url('dashboard/usuario/'.$usuario->idUsuario) }}" method="POST">
                            {{ method_field('DELETE')}}
                            {{ csrf_field() }}
                            <button type="submit" class="botonEliminar" onclick="return confirm('Quieres borrar este registro?')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="trashSvg" viewBox="0 0 512 512" ><title>Trash</title><path d="M112 112l20 320c.95 18.49 14.4 32 32 32h184c17.67 0 30.87-13.51 32-32l20-320" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><path stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M80 112h352"/><path d="M192 112V72h0a23.93 23.93 0 0124-24h80a23.93 23.93 0 0124 24h0v40M256 176v224M184 176l8 224M328 176l-8 224" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/></svg>
                                <!--<img src='{{ asset('svg/trash-outline.svg') }}' id="ionIconElement">-->
                            </button>
                        </form> 
                    </td>
                </tr>
                @endforeach
                @endif  
            </tbody>
        </table>

        <div class="paginatorButtons">

            <!-- Paginator Section -->

            @php

                $registrosTotales = count($usuariosTotales);
                $usuariosActuales = count($usuarios);
                $registros = count($usuariosTotales) / session('paginate');

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
                
                echo "<p class='paginatorText'>Mostrando $usuariosActuales de $registrosTotales registros</p>";

                echo "
                <div class='paginatorArrows'>
                    <p class='paginatorText'>Pagina $page de $paginasTotales</p>
                    <a href='?page=$paginaAnterior' class='backForwardPaginator' id=$textBack><svg xmlns='http://www.w3.org/2000/svg' class='paginatorSvg' viewBox='0 0 512 512'><title>Atras</title><path fill='none' stroke-linecap='round' stroke-linejoin='round' stroke-width='48' d='M328 112L184 256l144 144'/></svg></a>
                    <a href='?page=$paginaSiguiente' class='backForwardPaginator' id=$textForward><svg xmlns='http://www.w3.org/2000/svg' class='paginatorSvg' viewBox='0 0 512 512'><title>Adelante</title><path fill='none' stroke-linecap='round' stroke-linejoin='round' stroke-width='48' d='M184 112l144 144-144 144'/></svg></a>
                </div>";
            @endphp

            <!--
            <a class="backForwardIconPaginator"><svg xmlns="http://www.w3.org/2000/svg" class="paginatorSvg" viewBox="0 0 512 512"><title>Atras</title><path fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M328 112L184 256l144 144"/></svg></a>
            <a class="numberPaginator" id="Active"><p>1</p></a>
            <a class="numberPaginator"><p>2</p></a>
            <a class="numberPaginator"><p>3</p></a>
            <a class="numberPaginator"><p>...</p></a>
            <a class="numberLastPaginator"><p>5</p></a>
            <a class="backForwardIconPaginator"><svg xmlns="http://www.w3.org/2000/svg" class="paginatorSvg" viewBox="0 0 512 512"><title>Adelante</title><path fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M184 112l144 144-144 144"/></svg></a>
            -->
        </div>

    </div>

    <div class="forms">
        <div class="createForm">
            <form action="{{url('/dashboard/usuario')}}" method="POST" enctype="multipart/form-data" class="form">
    
                @csrf
    
                <h1 class="title">Crear</h1>
            
                <div class="inputContainer">
                    <input name="nombreUsuario" type="text" class="input" placeholder=" " autocomplete="off">
                    <label for="" class="label">Nombre de Usuario</label>
                </div>

                <div class="inputContainer">
                    <input name="contrasena" type="text" class="input" placeholder=" " autocomplete="off">
                    <label for="" class="label">Contraseña</label>
                </div>
            
                <div class="inputContainer">
                    <input name="telefono" type="text" class="input" placeholder=" " autocomplete="off">
                    <label for="" class="label">Telefono</label>
                </div>

                <div class="inputContainer">
                    <input name="ciudadResidencia" type="text" class="input" placeholder=" " autocomplete="off">
                    <label for="" class="label">Ciudad de Residencia</label>
                </div>

                <div class="inputContainer">
                    <input name="direccion" type="text" class="input" placeholder=" " autocomplete="off">
                    <label for="" class="label">Direccion</label>
                </div>
            
                <div class="inputContainer">
                    <input name="email" type="email" class="input" placeholder=" " autocomplete="off">
                    <label for="" class="label">Email</label>
                </div>

                <div class="inputContainer">
                    <input type="date" name="fechaNacimiento" class="input" id="inputDate" onchange="resetValue(this, this.value)" value="" min="1900-01-01" max="2022-12-31" placeholder=" " required="required">
                    <label for="" class="label">Fecha de Nacimiento</label>
                </div>

                <div class="inputContainerSelect">
                    <select class="input" name='estado_idEstado' id="inputSelect" style="-webkit-appearance: none;">
                        @php
                            # Se comprueba si hay roles repetidos para no colocarlos.
                            $estadoAnterior = '';
                            foreach ($estadosTotales as $estado) {
                                echo "<option value='$estado->idEstado'>$estado->estado</option>";
                            }
                        @endphp
                    </select>
                    <label for="" class="label">Estado</label>
                </div>
            
                <input type="submit" class="createButton" value="Crear">
            </form>
        </div>
        
        <div class="updateForm">

            <form @isset($usuariosEdit) action="{{ url('dashboard/usuario/'.$usuariosEdit->idUsuario) }}" method="POST" @endisset enctype="multipart/form-data" class="form" id="secondForm">
                
                @csrf
                {{ method_field('PATCH') }}

                <h1 class="title">Editar</h1>
                
                <div class="inputContainer">
                    <input name="nombreUsuario" type="text" class="input" @isset($usuariosEdit) value="{{ $usuariosEdit->nombreUsuario }}"@endisset placeholder=" " autocomplete="off">
                    <label for="" class="label">Nombre de Usuario</label>
                </div>

                <div class="inputContainer">
                    <input name="contrasena" type="text" class="input" @isset($usuariosEdit) value="{{ $usuariosEdit->contrasena }}"@endisset placeholder=" " autocomplete="off">
                    <label for="" class="label">Contraseña</label>
                </div>

                <div class="inputContainer">
                    <input name="telefono" type="text" class="input" @isset($datosContactoEdit) value="{{ $datosContactoEdit->telefono }}"@endisset placeholder=" " autocomplete="off">
                    <label for="" class="label">Telefono</label>
                </div>
            
                <div class="inputContainer">
                    <input name="ciudadResidencia" type="text" class="input" @isset($datosContactoEdit) value="{{ $datosContactoEdit->ciudadResidencia }}"@endisset placeholder=" " autocomplete="off">
                    <label for="" class="label">Ciudad de Residencia</label>
                </div>

                <div class="inputContainer">
                    <input name="direccion" type="text" class="input" @isset($datosContactoEdit) value="{{ $datosContactoEdit->direccion }}"@endisset placeholder=" " autocomplete="off">
                    <label for="" class="label">Direccion</label>
                </div>
            
                <div class="inputContainer">
                    <input name="email" type="email" class="input" @isset($datosContactoEdit) value="{{ $datosContactoEdit->email }}"@endisset placeholder=" " autocomplete="off">
                    <label for="" class="label">Email</label>
                </div>

                <div class="inputContainer">
                    <input type="date" name="fechaNacimiento" class="input" id="inputDate" @isset($usuariosEdit) value="{{ $usuariosEdit->fechaNacimiento }}"@endisset onchange="resetValue(this, this.value)" value="" min="1900-01-01" max="2022-12-31" placeholder=" " required="required">
                    <label for="" class="label">Fecha de Nacimiento</label>
                </div>

                <div class="inputContainerSelect" id="lastInput">
                    <select class="input" name='estado_idEstado' id="inputSelect" style="-webkit-appearance: none;">
                        @php
                            foreach ($estadosTotales as $estado) {
                                if(isset($usuariosEdit)){
                                    if($usuariosEdit->estado_idEstado == $estado->idEstado){
                                        echo "<option value='$estado->idEstado' selected>$estado->estado</option>";
                                    } else {
                                        echo "<option value='$estado->idEstado'>$estado->estado</option>";
                                    }
                                }  else {
                                    echo "<option value='$estado->idEstado'>$estado->estado</option>";
                                }   
                            }
                        @endphp
                    </select>
                    <label for="" class="label">Estado</label>
                </div>
                
                <div class="updateButtonContainer">
                    <input type="submit" class="updateButton" value="Actualizar" @isset($usuariosEdit) @else disabled @endisset> <a class="cancelButton" @isset($usuariosEdit) href="/dashboard/usuario" @endisset>Cancelar</a>
                </div>
            </form>
        </div>
    </div>

</section>

@endsection