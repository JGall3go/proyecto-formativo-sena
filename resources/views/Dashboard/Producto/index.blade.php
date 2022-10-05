@extends('Dashboard/Plantillas/sidebar')

@section('content')

<div class="topBar" id="topBar">
    <div class="breadCrumbs">
        <span class="iconMenu" onclick="collectSidebarResponsive(this)">
            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><title>Menu</title><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M80 160h352M80 256h352M80 352h352"/></svg>
        </span>
        <div class="breadCrumbsText">
            <span style="color: #b9b9b9; font-size: 12px; font-weight: 600;">Dashboard</span> <span style="color: #818181; font-size: 12px; font-weight: 600;">/ Producto</span>
            <div><h3 style="margin-top: 0px; color: #707070">Productos</h3></div>
        </div>
    </div>

    <span id="profileAncla"><span class="usernameText">{{ session('username') }}</span><img src="{{asset('storage').'/'.session('userImage')}}" id='imageProfile'>
        <a href="/dashboard/logout"><svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><title>Log Out</title><path d="M304 336v40a40 40 0 01-40 40H104a40 40 0 01-40-40V136a40 40 0 0140-40h152c22.09 0 48 17.91 48 40v40M368 336l80-80-80-80M176 256h256" fill="none" stroke="gray" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/></svg></a></span>
</div>

<section class="contentDashboard">

    <script src="{{ asset('js/content.js') }}"></script>

    @if($puedeVer == 1)
    <div class="tableContent">

        <div class="tableHeaderContent">

            <div class="firstSection">
                <form class="formSelect" action="{{ route('producto.index') }}" method="GET">
                    <select onchange="this.form.submit()" name='registros' class="registersSelect" id="select">
                        <option value='5'>5 Reg</option>
                        <option value='10'>10 Reg</option>
                        <option value='20'>20 Reg</option>
                        <option value='30'>30 Reg</option>
                    </select>
                </form>

                @if($puedeCrear == 1)
                <a onclick="showForm('create')" class="createLink"><svg xmlns="http://www.w3.org/2000/svg" class="addIcon" viewBox="0 0 512 512"><title>Add</title><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="64" d="M256 112v288M400 256H112"/></svg><span>Producto</span></a>
                @endif
            </div>

            <!-- Se cambia la opcion seleccionada dependiendo de la variable "paginate"-->
            <script type="text/javascript">
                var paginate = "<?= session('paginate'); ?>";
                document.getElementById('select').value = paginate;
            </script>

            <div class="searchBar">
                <form action="{{ route('producto.index') }}" method="GET" class="searchForm">
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
                        <th>Imagen</th>
                        <th>Titulo</th>
                        <th>Descripcion</th>
                        <th>Valor</th>
                        <th>Cantidad</th>
                        <th>Linea y Sublinea</th>
                        <th>Proveedor</th>
                        <th class="actionButtonContainer">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($productos) <= 0)
                        <tr><td colspan="100%">No se encontraron resultados.</td></tr>
                    @else

                    @foreach($productos as $producto)
                    <tr>
                        <td>{{ $producto->idProducto}}</td>
                        <td><img src="{{asset('storage').'/'.$producto->imagen}}" class="productImage"></td>
                        <td>{{$producto->titulo}}</td>
                        <td>
                            <form action="{{ url('dashboard/producto/'.$producto->idProducto) }}" method="GET">
                                <button type="submit" class="showDescriptionButton">
                                <svg xmlns="http://www.w3.org/2000/svg" class="eyeIcon" viewBox="0 0 512 512"><title>Eye</title><path d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z" fill="none" stroke="gray" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><circle cx="256" cy="256" r="80" fill="none" stroke="gray" stroke-miterlimit="10" stroke-width="32"/></svg>
                                </button>
                            </form>
                            
                        </td>
                        <td>{{ $producto->valor}}</td>
                        <td>{{ $producto->cantidad}}</td>
                        <td>{{ $producto->linea}} - {{ $producto->sublinea}}</td>
                        <td>{{ $producto->nombrePerfil}}</td>
                        <td class="actionButton" id="productActionButton">

                            <div>
                                @if($puedeEditar == 1)
                                <form action="{{ url('dashboard/producto/'.$producto->idProducto.'/edit') }}">
                                    <button type="submit" class="botonEditar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="pencilSvg" viewBox="0 0 24 24"><path d="M14.078 4.232l-12.64 12.639-1.438 7.129 7.127-1.438 12.641-12.64-5.69-5.69zm-10.369 14.893l-.85-.85 11.141-11.125.849.849-11.14 11.126zm2.008 2.008l-.85-.85 11.141-11.125.85.85-11.141 11.125zm18.283-15.444l-2.816 2.818-5.691-5.691 2.816-2.816 5.691 5.689z"/></svg>
                                    </button>
                                </form>
                                @endif
            
                                @if($puedeBorrar == 1)
                                <form action="{{ url('dashboard/producto/'.$producto->idProducto) }}" method="POST">
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

                $registrosTotales = count($productosTotales);
                $productosActuales = count($productos);
                $registros = count($productosTotales) / session('paginate');

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

                echo "<p class='paginatorText'>Mostrando $productosActuales de $registrosTotales registros</p>";

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

    <div class="descripcionContainer" @isset($descripcion)style="display: flex"@else style="display: none" @endisset>
        <a class="descriptionBackground" href="/dashboard/producto"></a>

        <div class="descriptionContent">
            <div class="descriptionText" >
                <div>
                    <h3>Descripcion</h3>
                    <span>@isset($descripcion){{ $descripcion->descripcion }}@endisset</span>
                </div>
                <div>
                    <h3>Requisitos Minimos</h3>    
                    <span>@isset($descripcion){{ $descripcion->requisitosMinimos }}@endisset</span>
                </div>
                <div>
                    <h3>Requisitos Recomendados</h3>
                    <span>@isset($descripcion){{ $descripcion->requisitosRecomendados }}@endisset</span>
                </div>
            </div>
        </div>
    </div>

    @php

        if($errors->any()) {
            $formError = true;
        }

    @endphp

    <div class="forms" @isset($formDisplay)style="display: flex"@endisset @isset($formError)style="display: flex"@endisset>

        <a class="formBackground" @isset($productosEdit) href="/dashboard/producto" @else onclick="showForm('create')" @endisset></a>

        <div class="createForm" id="product" @if(isset($formError) && !isset($productosEdit))style="display: flex" @endisset>

            <form action="{{url('/dashboard/producto')}}" method="POST" enctype="multipart/form-data" class="form" onkeydown="return event.key != 'Enter';">
    
                @csrf

                <h1 class="title">Crear Producto</h1>

                <div class="imageContainer">
                    <label for="" class="label">Imagen</label>
                    <div class="dropArea-1">

                        <div class="dropTextArea">
                            <span class="dropText">Tamaño recomendado 800px x 800px</span>
                            <span class="dropText">Click para buscar imagen en el dispositivo</span>
                            <!--<span class="dropText">Arrastra la imagen aqui o presiona para buscarla</span>
                            <span class="dropText">Tamaño recomendado 800px x 800px</span>-->
                        </div>
                        
                        <!--<div class="dropZoneImage"></div>-->
                        <input type="file" name="imagen" class="dropAreaInput" accept="image/png, image/jpeg, image/jpg">
                    </div>
                </div>
                @error('imagen')<div class="alert-danger">{{ $message }}</div>@enderror

                <div class="container">
                    <label for="" class="label">Titulo</label>
                    <input name="titulo" type="text" class="input" placeholder=" " autocomplete="off">
                </div>
                @error('titulo')<div class="alert-danger">{{ $message }}</div>@enderror

                <div class="container">
                    <label for="" class="label">Valor</label>
                    <input name="valor" type="number" class="input" placeholder=" " autocomplete="off"> 
                </div>
                @error('valor')<div class="alert-danger">{{ $message }}</div>@enderror

                <div class="tagsContainer">
                    <input name="keys" type="text" class="inputAllTags" autocomplete="off">
                    <input name="cantidad" type="number" id="inputAmount" value="0" autocomplete="off"> 
                    <label for="" class="label">Keys <span class="opaqueLabelText"> - Cantidad 0</span></label>

                    <div class="tagger" id="tagger">
                        <!-- Todas las Tags son mostradas aqui -->
                    </div>

                    <div class="addTagSection" id="addTagSection">
                        <input onkeydown="createTag(event, 'create')" class="addTagInput" type="text" autocomplete="off" placeholder="Añadir nueva clave de producto...">
                        <div onclick="createTag(event, 'create')" class="addTagButton"><svg xmlns="http://www.w3.org/2000/svg" class="addTagIcon" viewBox="0 0 512 512"><title>Add</title><path fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 112v288M400 256H112"/></svg></div>
                    </div>

                    <label class="errorLabel" id="repeatedKey">No puedes añadir Keys repetidas</label>

                </div>
                @error('keys')<div class="alert-danger">{{ $message }}</div>@enderror
                
                <div class="containerSelect">
                    <label for="" class="label">Linea</label>
                    <select class="inputSelect" name="linea" onchange="selectColor(this)">
                        <option disabled selected style="display: none">- Seleccionar -</option>
                        @php
                            foreach ($lineasTotales as $linea) {
                                echo "<option value='$linea->idLinea'>$linea->linea</option>";  
                            }
                        @endphp 
                    </select>
                </div>
                @error('linea')<div class="alert-danger">{{ $message }}</div>@enderror

                <div class="containerSelect">
                    <label for="" class="label">Sublinea</label>
                    <select class="inputSelect" name="sublinea" onchange="selectColor(this)">
                        <option disabled selected style="display: none">- Seleccionar -</option>
                        @php
                            foreach ($sublineasTotales as $sublinea) {
                                echo "<option value='$sublinea->idSublinea'>$sublinea->sublinea</option>";  
                            }
                        @endphp 
                    </select>
                </div>
                @error('sublinea')<div class="alert-danger">{{ $message }}</div>@enderror

                <div class="containerSelect">
                    <label for="" class="label">Proveedor</label>
                    <select class="inputSelect" name="proveedor" onchange="selectColor(this)">
                        <option disabled selected style="display: none">- Seleccionar -</option>
                        @php
                            foreach ($proveedoresTotales as $proveedor) {
                                echo "<option value='$proveedor->idPerfil'>$proveedor->nombrePerfil</option>";  
                            }
                        @endphp 
                    </select>
                </div>
                @error('proveedor')<div class="alert-danger">{{ $message }}</div>@enderror

                <div class="textareaContainer">
                    <label for="" class="label">Descripcion</label>
                    <textarea name="descripcion"></textarea>                    
                </div>
                @error('descripcion')<div class="alert-danger">{{ $message }}</div>@enderror

                <div class="textareaContainer">
                    <label for="" class="label">Requisitos minimos</label>
                    <textarea name="requisitosMinimos"></textarea>                    
                </div>
                @error('requisitosMinimos')<div class="alert-danger">{{ $message }}</div>@enderror

                <div class="textareaContainer">
                    <label for="" class="label">Requisitos recomendados</label>
                    <textarea name="requisitosRecomendados"></textarea>                    
                </div>
                @error('requisitosRecomendados')<div class="alert-danger">{{ $message }}</div>@enderror

                <div class="buttonContainer">
                    <input type="submit" class="createButton" value="Crear"> <a class="cancelButton" onclick="showForm('create')">Cancelar</a>
                </div>

            </form>
        </div>
        

        <!-- UPDATE FORM -->
 
        <div class="updateForm" @isset($formDisplay)style="display: flex" @endisset id="product">

            <form @isset($productosEdit) action="{{ url('dashboard/producto/'.$productosEdit->idProducto) }}" method="POST" @endisset enctype="multipart/form-data" class="form" onkeydown="return event.key != 'Enter';">
                
                @csrf
                {{ method_field('PATCH') }}

                <h1 class="title">Editar</h1>

                <div class="imageContainer">
                    <label for="" class="label">Imagen</label>
                    <div class="dropArea-2">

                        <div class="dropAreaImage">
                            <img class="updateDefaultImage" @isset($productosEdit)src="{{url('storage/'.$productosEdit->imagen)}}"@endisset>
                        </div>

                        <input type="file" name="imagen" class="dropAreaInput" accept="image/png, image/jpeg">

                    </div>
                </div>

                <div class="container">
                    <label for="" class="label">Titulo</label>
                    <input name="titulo" type="text" class="input" @isset($descripcionesEdit) value="{{$descripcionesEdit->titulo}}"@endisset  placeholder=" " autocomplete="off">
                    <label class="errorLabel">No colocaste el titulo.</label>
                </div>

                <div class="container">
                    <label for="" class="label">Valor</label>
                    <input name="valor" type="number" class="input" @isset($productosEdit) value="{{ $productosEdit->valor }}"@endisset placeholder=" " autocomplete="off"> 
                </div>

                <div class="tagsContainer">
                    @isset($keysEncoded)
                        @php
                            echo "<script>$keysEncoded.forEach(key => {keysArray.push(key);});</script>";
                        @endphp
                    @endisset
                    <input name="keys" type="text" class="inputAllTags" autocomplete="off" @isset($keysParsed)value="{{ $keysParsed }}"@endisset>
                    <input name="cantidad" type="number" id="inputAmount2" @isset($keys)value="{{ count($keys) }}"@endisset autocomplete="off"> 
                    <label for="" class="label">Keys <span class="opaqueLabelText"> - Cantidad @isset($keys){{ count($keys) }}@endisset</span></label>

                    <div class="tagger" id="tagger">
                        <!-- Todas las Tags son mostradas aqui -->
                        @isset($keys)
                            @for($i = 0; $i < count($keys); $i++)
                                <div class="tag">
                                    <div class="tagNumber">{{ $i+1 }}</div>
                                    <div class="tagText">{{ $keys[$i] }}</div>
                                        <div onclick="deleteTag(this, 'edit')" class="tagButton"><svg xmlns="http://www.w3.org/2000/svg" class="deleteIcon" viewBox="0 0 512 512"><title>Eliminar</title><path fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M368 368L144 144M368 144L144 368"/></svg>
                                    </div>
                                </div>
                            @endfor
                        @endisset
                    </div>

                    <div class="addTagSection" id="addTagSection" onkeydown="return event.key != 'Enter';">
                        <input onkeydown="createTag(event, 'edit')" class="addTagInput" type="text" autocomplete="off" placeholder="Añadir nueva clave de producto...">
                        <div onclick="createTag(event, 'edit')" class="addTagButton"><svg xmlns="http://www.w3.org/2000/svg" class="addTagIcon" viewBox="0 0 512 512"><title>Add</title><path fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 112v288M400 256H112"/></svg></div>
                    </div>

                    <label class="errorLabel" id="repeatedKey">No puedes añadir Keys repetidas</label>
                </div>
                
                <div class="containerSelect">
                    <label for="" class="label">Linea</label>
                    <select class="inputSelect" name="linea" onchange="selectColor(this)" style="color: #686666">
                        <option disabled selected style="display: none">- Seleccionar -</option>
                        @php
                            foreach ($lineasTotales as $linea) {
                                if(isset($lineasEdit)){
                                    if($lineasEdit->idLinea == $linea->idLinea){
                                        echo "<option value='$linea->idLinea' selected>$linea->linea</option>";
                                    } else {
                                        echo "<option value='$linea->idLinea'>$linea->linea</option>";
                                    }
                                }  else {
                                    echo "<option value='$linea->idLinea'>$linea->linea</option>";
                                }   
                            }
                        @endphp
                    </select>
                </div>

                <div class="containerSelect">
                    <label for="" class="label">Sublinea</label>
                    <select class="inputSelect" name="sublinea" onchange="selectColor(this)" style="color: #686666">
                        <option disabled selected style="display: none">- Seleccionar -</option>
                        @php
                            foreach ($sublineasTotales as $sublinea) {
                                if(isset($sublineasEdit)){
                                    if($sublineasEdit->idSublinea == $sublinea->idSublinea){
                                        echo "<option value='$sublinea->idSublinea' selected>$sublinea->sublinea</option>";
                                    } else {
                                        echo "<option value='$sublinea->idSublinea'>$sublinea->sublinea</option>";
                                    }
                                }  else {
                                    echo "<option value='$sublinea->idSublinea'>$sublinea->sublinea</option>";
                                }   
                            }
                        @endphp
                    </select>
                </div>

                <div class="containerSelect">
                    <label for="" class="label">Proveedor</label>
                    <select class="inputSelect" name="proveedor" onchange="selectColor(this)" style="color: #686666">
                        <option disabled selected style="display: none">- Seleccionar -</option>
                        @php
                            foreach($proveedoresTotales as $proveedor) {
                                if(isset($proveedoresEdit)){
                                    if($proveedoresEdit->idPerfil == $proveedor->idPerfil){
                                        echo "<option value='$proveedor->idPerfil' selected>$proveedor->nombrePerfil</option>";
                                    } else {
                                        echo "<option value='$proveedor->idPerfil'>$proveedor->nombrePerfil</option>";  
                                    }
                                }  else {
                                    echo "<option value='$proveedor->idPerfil'>$proveedor->nombrePerfil</option>";  
                                }   
                            }
                        @endphp
                    </select>
                </div>

                <div class="textareaContainer">
                    <label for="" class="label">Descripcion</label>
                    <textarea name="descripcion">@isset($descripcionesEdit){{$descripcionesEdit->descripcion}}@endisset</textarea>  
                </div>

                <div class="textareaContainer">
                    <label for="" class="label">Requisitos minimos</label>
                    <textarea name="requisitosMinimos">@isset($descripcionesEdit){{$descripcionesEdit->requisitosMinimos}}@endisset</textarea>                    
                </div>

                <div class="textareaContainer">
                    <label for="" class="label">Requisitos recomendados</label>
                    <textarea name="requisitosRecomendados">@isset($descripcionesEdit){{$descripcionesEdit->requisitosRecomendados}}@endisset</textarea>                    
                </div>

                <div class="buttonContainer">
                    <input type="submit" class="createButton" value="Editar"> <a class="cancelButton" href="{{ url('dashboard/producto/') }}">Cancelar</a>
                </div>

            </form>

        </div>
    </div>
</section>
@endsection