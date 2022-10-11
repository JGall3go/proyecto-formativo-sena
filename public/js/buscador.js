
<script src="https://www.paypal.com/sdk/js?client-id=AXqavVjm-9FICYV3CYwHLbmzwiiBgkLhVCX0kzB4BurZCpWbPl1fS-GK1WhZyWWPbRS4v_2wxFEz3dIH"></script>

$(function(){


    $(window).scroll(function(){

        var WinTop = $(window).scrollTop();

            if(WinTop >= 30){

                $("body").addClass("sticky-header");

                } else {

                $("body").removeClass("sticky-header");

        }
    })

})

('#btn').click(function(){
    Swal.fire({
        icon: 'succes',
        title: 'El pago a sido realizado exitosamente, ya puedes ver tu juego en la galeria',
        text: 'Something went wrong!',
        footer: '<a href="">Why do I have this issue?</a>'
      })
})

import { loadScript } from "@paypal/paypal-js";
loadScript({ "client-id": CLIENT_ID })
.then((paypal) => {
    // start to use the PayPal JS SDK script
})
.catch((err) => {
    console.error("failed to load the PayPal JS SDK script", err);
});



