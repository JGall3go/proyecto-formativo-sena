    <h1 class="title">Editar</h1>

    <div class="container">
        <label for="" class="label">Nombres</label>
        <input name="nombres" type="text" class="input" @isset($usuariosEdit) value="{{ $usuariosEdit->nombres }}"@endisset placeholder=" " autocomplete="off">
    </div>

    <div class="container">
        <label for="" class="label" id="secondLabel">Apellidos</label>
        <input name="apellidos" type="text" class="input" @isset($usuariosEdit) value="{{ $usuariosEdit->apellidos }}"@endisset placeholder=" " autocomplete="off">
    </div>

    <div class="container">
        <label for="" class="label">Nombre de Usuario</label>
        <input name="nombrePerfil" type="text" class="input" @isset($perfilesEdit) value="{{ $perfilesEdit->nombrePerfil }}"@endisset placeholder=" " autocomplete="off">
    </div>

    <div class="container">
        <label for="" class="label" id="secondLabel">Contraseña</label>
        <input name="contrasena" type="text" class="input" @isset($usuariosEdit) value="{{ $usuariosEdit->contrasena }}"@endisset placeholder=" " autocomplete="off">
    </div>

    <div class="container">
        <label for="" class="label">Email</label>
        <input name="email" type="email" class="input" @isset($datosContactoEdit) value="{{ $datosContactoEdit->email }}"@endisset placeholder=" " autocomplete="off">
    </div>

    <div class="container">
        <label for="" class="label" id="secondLabel">Telefono</label>
        <input name="telefono" type="text" class="input" @isset($datosContactoEdit) value="{{ $datosContactoEdit->telefono }}"@endisset placeholder=" " autocomplete="off">
    </div>

    <div class="containerSelect">
        <label for="" class="label" id="secondLabel">Tipo de Documento</label>
        <select class="inputSelect" onchange="selectColor(this)" name="tipoDocumento" style="color: #686666">
            <option disabled selected style="display: none">- Seleccionar --</option>
            @php
                foreach ($documentosTotales as $documento) {
                    if(isset($usuariosEdit)){
                        if($usuariosEdit->tipo_documento_idDocumento == $documento->idDocumento){
                            echo "<option value='$documento->idDocumento' selected>$documento->tipoDocumento</option>";
                        } else {
                            echo "<option value='$documento->idDocumento'>$documento->tipoDocumento</option>";
                        }
                    }  else {
                        echo "<option value='$documento->idDocumento'>$documento->tipoDocumento</option>";
                    }   
                }
            @endphp
        </select>
    </div>

    <div class="container">
        <label for="" class="label" id="secondLabel">Documento</label>
        <input name="documento" type="text" class="input" id="inputDouble" @isset($usuariosEdit) value="{{ $usuariosEdit->documento }}"@endisset placeholder=" " autocomplete="off">
    </div>

    <div class="containerSelect">
        <label for="" class="label">Ciudad</label>
        <select class="inputSelect" onchange="selectColor(this)" name="ciudad" style="color: #686666">
            <option disabled selected style="display: none">- Seleccionar -</option>
            @php
                foreach ($ciudadesTotales as $ciudad) {
                    if(isset($usuariosEdit)){
                        if($datosContactoEdit->ciudad_idCiudad == $ciudad->idCiudad){
                            echo "<option value='$ciudad->idCiudad' selected>$ciudad->ciudad</option>";
                        } else {
                            echo "<option value='$ciudad->idCiudad'>$ciudad->ciudad</option>";
                        }
                    }  else {
                        echo "<option value='$ciudad->idCiudad'>$ciudad->ciudad</option>";
                    }   
                }
            @endphp 
        </select>
    </div>

    <div class="container">
        <label for="" class="label"  id="secondLabel">Direccion</label>
        <input name="direccion" type="text" class="input" id="inputDouble" @isset($datosContactoEdit) value="{{ $datosContactoEdit->direccion }}"@endisset placeholder=" " autocomplete="off">            
    </div>

    <div class="container">
        <label for="" class="label">Fecha de Nacimiento</label>
        <input type="date" name="fechaNacimiento" class="input" id="inputDate" @isset($usuariosEdit) value="{{ $usuariosEdit->fechaNacimiento }}"@endisset onchange="resetValue(this, this.value)" value="" min="1900-01-01" max="2022-12-31" placeholder=" ">
    </div>

    <div class="containerSelect">
        <label for="" class="label">Estado</label>
        <select class="inputSelect" name='estado_idEstado' onchange="selectColor(this)" style="color: #686666">
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
    </div>

    <div class="containerSelect">
        <label for="" class="label">Rol</label>
        <select class="inputSelect" name='rol' onchange="selectColor(this)" style="color: #686666">
            @php
                # Se comprueba si hay roles repetidos para no colocarlos.
                $rolAnterior = '';
                foreach ($rolesTotales as $roles) {
                    if ($rolAnterior != $roles->rol) {
                        if($roles->rol == $usuario){
                            echo "<option value='$roles->idRol' selected>$roles->rol</option>";
                            $rolAnterior = $roles->rol;
                        }else{
                            echo "<option value='$roles->idRol'>$roles->rol</option>";
                            $rolAnterior = $roles->rol;
                        }
                    }
                }
            @endphp
        </select>
    </div>

    <div class="buttonContainer">
        <input type="submit" class="updateButton" value="Editar" @isset($edit) @else disabled @endisset> <a class="cancelButton" href="{{ $url }}">Cancelar</a>
    </div>