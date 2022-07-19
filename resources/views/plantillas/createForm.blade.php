    <h1 class="title">Crear</h1>

    <div class="containerDouble">
        <div class="firstInput">
            <label for="" class="label">Nombres</label>
            <input name="nombres" type="text" class="input" placeholder=" " autocomplete="off" required="required">
        </div>
        <div>
            <label for="" class="label" >Apellidos</label>
            <input name="apellidos" type="text" class="input" placeholder=" " autocomplete="off" required="required">
            <label class="errorLabel">No colocaste el apellido.</label>
        </div>
    </div>

    <div class="containerDouble">
        <div class="firstInput">
            <label for="" class="label">Nombre de Usuario</label>
            <input name="nombreUsuario" type="text" class="input" placeholder=" " autocomplete="off" required="required">
        </div>
        <div>
            <label for="" class="label">Contraseña</label>
            <input name="contrasena" type="text" class="input" placeholder=" " autocomplete="off" required="required">
        </div>
    </div>

    <div class="containerDouble">
        <div class="firstInput">
            <label for="" class="label">Email</label>
            <input name="email" type="email" class="input" placeholder=" " autocomplete="off" required="required">
        </div>
        <div>
            <label for="" class="label">Telefono</label>
            <input name="telefono" type="text" class="input" placeholder=" " autocomplete="off" required="required">
        </div>
    </div>

    <div class="containerDouble">
        <div class="firstInput">
            <label for="" class="label">Tipo de Documento</label>
            <select class="inputSelect" name="tipoDocumento" onchange="selectColor(this)">
                <option disabled selected style="display: none">- Seleccionar -</option>
                @php
                    foreach ($documentosTotales as $documento) {
                        echo "<option value='$documento->idDocumento'>$documento->tipoDocumento</option>";  
                    }
                @endphp 
            </select>
        </div>
        <div>
            <label for="" class="label" id="secondLabel">Documento</label>
            <input name="documento" type="text" class="input" id="inputDouble" placeholder=" " autocomplete="off" required="required">
        </div>
    </div>

    <div class="containerDouble">
        <div class="firstInput">
            <label for="" class="label">Ciudad</label>
            <select class="inputSelect" name="ciudad" onchange="selectColor(this)">
                <option disabled selected style="display: none">- Seleccionar -</option>
                @php
                foreach ($ciudadesTotales as $ciudad) {
                        echo "<option value='$ciudad->idCiudad'>$ciudad->ciudad</option>";
                    }
                @endphp 
            </select>
        </div>
        <div>
            <label for="" class="label">Direccion</label>
            <input name="direccion" type="text" class="input" placeholder=" " autocomplete="off" required="required">            
        </div>
    </div>

    <div class="container">
        <label for="" class="label">Fecha de Nacimiento</label>
        <input type="date" name="fechaNacimiento" class="input" id="inputDate" onchange="resetValue(this, this.value)" value="" min="1900-01-01" max="2022-12-31" placeholder=" " required="required">
    </div>

    <div class="container">
        <label for="" class="label">Estado</label>
        <select class="inputSelect" name='estado_idEstado' id="inputSelect" onchange="selectColor(this)">
            <option disabled selected style="display: none">- Seleccionar -</option>
            @php
                foreach ($estadosTotales as $estado) {
                    echo "<option value='$estado->idEstado'>$estado->estado</option>";
                }
            @endphp
        </select>
    </div>

    <div class="container">
        <label for="" class="label">Rol</label>
        <input type="text" class="input" value="{{$usuario}}" style="color: #b8b8b9" autocomplete="off" readonly>
    </div>
        
    <div class="buttonContainer">
        <input type="submit" class="createButton" value="Crear"> <a class="cancelButton" onclick="showForm()">Cancelar</a>
    </div>
