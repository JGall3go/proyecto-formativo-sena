@extends('Dashboard/Platillas/sidebar')

@section('content')

<section class="forms">
    
    <div class="createForm">
        <form action="" class="form">
          <h1 class="title">Crear</h1>
    
          <div class="inputContainer">
            <input type="text" class="inputCreate" placeholder=" ">
            <label for="" class="label">Email</label>
          </div>
    
          <div class="inputContainer">
            <input type="text" class="inputCreate" placeholder=" ">
            <label for="" class="label">Username</label>
          </div>
    
          <div class="inputContainer">
            <input type="text" class="inputCreate" placeholder=" ">
            <label for="" class="label">Password</label>
          </div>
    
          <div class="inputContainer">
            <input type="text" class="inputCreate" placeholder=" ">
            <label for="" class="label">Confirm Password</label>
          </div>
    
          <input type="submit" class="createButton" value="Crear">
        </form>
    </div>
    
    <div class="updateForm">
        <form action="" class="form">
          <h1 class="title">Actualizar</h1>
    
          <div class="inputContainer">
            <input type="text" class="inputUpdate" placeholder=" ">
            <label for="" class="label">Email</label>
          </div>
    
          <div class="inputContainer">
            <input type="text" class="inputUpdate" placeholder=" ">
            <label for="" class="label">Username</label>
          </div>
    
          <div class="inputContainer">
            <input type="text" class="inputUpdate" placeholder=" ">
            <label for="" class="label">Password</label>
          </div>
    
          <div class="inputContainer">
            <input type="text" class="inputUpdate" placeholder=" ">
            <label for="" class="label">Confirm Password</label>
          </div>
    
          <input type="submit" class="updateButton" value="Actualizar">
        </form>
    </div>

</section>

@endsection