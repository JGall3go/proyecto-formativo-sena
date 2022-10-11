
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ asset('css/footer.css') }}" rel="stylesheet">
        <title></title>
    </head>
    <body>
    <footer>
    <div class="content_footer" >

        <div class="box1_footer">
        <figure>
        <a href="">

            <img src="{{URL::asset('/img/keys.png')}}" alt="blank" class="logo_icon">

        </a> 
        </figure>   
        </div>

        <div class="box2_footer">
            <ul class = "list_footer">
                <li><a href="{{ route('condicion') }}" class="footer_li">Terminos y condiciones</a></li>
                <li><a href="{{ route('politic') }}" class="footer_li">Polictica de privacidad</a></li>
                <li><a href="" class="footer_li">Contacto</a></li>
                <li><a href="{{ route('faq') }}" class="footer_li">FAQ</a></li>
            </ul>
        </div>

        <div class="social_media_footer">
            <figure>

            <a href=""><img src="{{URL::asset('/img/feisbu.png')}}" alt="facebook" class="icons_media"></a>
            <a href=""><img src="{{URL::asset('/img/ig.png')}}" alt="instagram" class="icons_media"></a>
            <a href=""><img src="{{URL::asset('/img/telegram.png')}}" alt="telegram" class="icons_media"></a>
            <a href=""><img src="{{URL::asset('/img/twiter.png')}}" alt="twitter" class="icons_media"></a>
            <a href=""><img src="{{URL::asset('/img/wasa.png')}}" alt="whatsapp" class="icons_media"></a>

            </figure>
        </div>



    </div>
        
    <div class="footer_ending">
        <small><p> Copyright © 2022 keys guardian - All rights reserved</p>
    </div>
        

    @yield('footer')
    </footer>

    </body>
 
    
</html>