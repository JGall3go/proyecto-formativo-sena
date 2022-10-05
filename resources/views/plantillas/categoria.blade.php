<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    
    <div class="mas">
        <div class="cont">
            <div class="title">
                <h2>Categorias</h2>
            </div>
        </div>
        <!-- fila 1 caracteristicas -->

        <div class="container">
            <div class="card">
                <a href="">
                    <img src="{{URL::asset('/img/wach.jpg')}}">
                </a>
            <!-- hoover y efectos-->
                <div class="overlay">
                <div class="text">ACCION</div>
                      </div>
            </div>

            <div class="card">
                <a href="">
                    <img src="img/metal.jpg">
                </a>
                <div class="overlay">
                <div class="text">ARCADE</div>
                      </div>
            </div>

            <div class="card">
                <a href="">
                    <img src="img/aventura.jpg">
                </a>
                <div class="overlay">
                <div class="text">AVENTURA</div>
                      </div>
            </div>
        </div>

        <!-- flia 2 caracteristicas -->

        <div class="container">
            <div class="card">
                <a href="">
                    <img src="img/estrategia.jpg">
                </a>
                <div class="overlay">
                <div class="text">ESTRATEGIA</div>
                      </div>
            </div>

            <div class="card">
                <a href="">
                    <img src="img/fps.jpg">
                </a>
                <div class="overlay">
                <div class="text">SHOOTER</div>
                      </div>
            </div>

            <div class="card">
                <a href="">
                    <img src="img/lucha.jpg">
                </a>
                <div class="overlay">
                <div class="text">FIGTHER</div>
                      </div>
            </div>
        </div>

        <!-- fila 3 caracteristicas -->

        <div class="container">
            <div class="card">
                <a href="">
                    <img src="img/rpg.jpg">
                </a>
                <div class="overlay">
                <div class="text">RPG</div>
                      </div>
            </div>

            <div class="card">
                <a href="">
                    <img src="img/uno.jpeg">
                </a>
                <div class="overlay">
                <div class="text">SURVIVAL</div>
                      </div>
            </div>

            <div class="card">
                <a href="">
                    <img src="img/vr.jpg">
                </a>
                <div class="overlay">
                <div class="text">VIRTUAL-REALITY</div>
                      </div>
            </div>
        </div>

        <div class="more">

        </div>

        <!-- ver mas o menos -->

        <!-- fila 1 caracteristicas ver mas -->

        <span class="hid" id="hidText">

            <div class="container">
                <div class="card">
                    <a href="">
                        <img src="img/carrera.jpg">
                    </a>
                    <div class="overlay">
                <div class="text">RACER</div>
                      </div>
                </div>

                <div class="card">
                    <a href="">
                        <img src="img/multijugador.jpeg">
                    </a>
                    <div class="overlay">
                <div class="text">BATTLE-GROUND</div>
                      </div>
                </div>

                <div class="card">
                    <a href="">
                        <img src="img/mmo.jpg">
                    </a>
                    <div class="overlay">
                <div class="text">MMO</div>
                      </div>
                </div>
            </div>

            <!-- fila 2 caracteristicas ver mas -->

                <div class="container">
                    <div class="card">
                        <a href="">
                            <img src="img/cooli.jpg">
                        </a>
                        <div class="overlay">
                         <div class="text">COOPERATIVO</div>
                      </div>
                    </div>

                    <div class="card">
                        <a href="">
                            <img src="img/depor.jpg">
                        </a>
                        <div class="overlay">
                        <div class="text">DEPORTES</div>
                      </div>
                    </div>

                    <div class="card">
                        <a href="">
                            <img src="img/cooduo.jpg">
                        </a>
                        <div class="overlay">
                      <div class="text">FANTASIA</div>
                      </div>
                    </div>
                </div>

            </span>

            <!-- boton mas o menos -->

            <button class="but" id="hidBut">Ver mas</button>

    </div>
    <script src="{{ asset('js/bot.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    @yield('categoria')
</body>

</html>