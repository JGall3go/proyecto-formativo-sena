<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
     <link href="{{ asset('css/galeria.css') }}" rel="stylesheet">
    <title>""</title>
</head>
<body>
    @foreach($productostore as $pro)
    
    <div class="content_grid">

        <div class="card" style="width: 18rem;">
        <img src="/images/{{ $pro->image_path }}" class="card-img-top" alt="{{ $pro->image_path }}">
        <div class="card-body">
        <p class="card-text">{{ $pro->titulo }}</p>
        <p class="precio">${{ $pro->valor }}</p>
        <form action="{{ route('cart.store') }}" method="POST">{{ csrf_field() }}
            <input type="hidden" value="{{ $pro->id }}" id="id" name="id">
            <input type="hidden" value="{{ $pro->titulo }}" id="titulo"name="titulo">
            <input type="hidden" value="{{ $pro->valor }}" id="valor"name="valor">
            <input type="hidden" value="{{ $pro->imagen_path }}" id="img"name="img">
            <!--<input type="hidden" value="{{ $pro->slug }}" id="slug"name="slug">-->
            <input type="hidden" value="1" id="quantity" name="quantity">
            <div class="card-footer" style="background-color: white;">
            <div class="row">
                <button class="btn btn-secondary btn-sm" class="tooltip-test"title="add to cart">
                    <i class="fa fa-shopping-cart"></i> agregar al carrito
                </button>
            </div>
            </div>
        </form>

        </div>
        </div>

        <div class="card" style="width: 18rem;">
        <img src="./producto-pru/img/tres.jpg" class="card-img-top" alt="...">
        <div class="card-body">
         <p class="card-text"> HALO 3</p>
        </div>
        </div>

         <div class="card" style="width: 18rem;">
        <img src="./producto-pru/img/uno.jpg" class="card-img-top" alt="...">
        <div class="card-body">
         <p class="card-text"> HALO </p>
        </div>
        </div>

        <div class="card" style="width: 18rem;">
        <img src="./producto-pru/img/mc.png" class="card-img-top" alt="...">
        <div class="card-body">
        <p class="card-text">HALO INFINITE </p>
        </div>
        </div>

        <div class="card" style="width: 18rem;">
        <img src="./producto-pru/img/asu.jpg" class="card-img-top" alt="...">
        <div class="card-body">
        <p class="card-text">HALO SPARTAN ASSAULT</p>
        </div>
        </div>

        <div class="card" style="width: 18rem;">
        <img src="..." class="card-img-top" alt="...">
        <div class="card-body">
        <p class="card-text"></p>
        </div>
        </div> 

        <div class="card" style="width: 18rem;">
        <img src="..." class="card-img-top" alt="...">
        <div class="card-body">
        <p class="card-text"></p>
        </div>
        </div>

        <div class="card" style="width: 18rem;">
        <img src="..." class="card-img-top" alt="...">
        <div class="card-body">
        <p class="card-text"></p>
        </div>
        </div>

        <div class="card" id="hide" style="width: 18rem;">
        <img src="..." class="card-img-top" alt="...">
        <div class="card-body">
        <p class="card-text"></p>
        </div>
        </div>
      

    </div>
    @endforeach
    @yield('galery')

</body>
</html>