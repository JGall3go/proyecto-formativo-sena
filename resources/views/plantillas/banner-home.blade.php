<!DOCTYPE html>
<html lang="es">
    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('css/banner.css') }}" rel="stylesheet">

        <title>Banner</title>
    
    </head>
    <body>
        <div class="main-image" >
            <div class="container-banner">
                <style>
                    .main-image{
                    position: relative;
                    background: url("{{URL::asset('/recursos_css/—Pngtree—watercolor illustration ink clear star_615990.jpg')}}") no-repeat center;
                    background-size: cover;
                    height: 350px;
                    overflow: hidden;
                    margin-top: 30px;
}
                </style>
                <h1> <span>banner</span></h1>
                <span class="cen">  web designer y developer </span>
               <a class="button-banner" href="#"> view more</a>

            </div>
        </div>

     @yield('banner')
    </body>
</html>