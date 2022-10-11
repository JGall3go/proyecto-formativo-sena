let hidBut = document.getElementById('hidBut');

let hidText = document.getElementById('hidText');

hidBut.addEventListener('click', toggleText);

function toggleText() {
    hidText.classList.toggle('show');

    if (hidText.classList.contains('show')) {
        hidBut.innerHTML = 'Ver menos';
    } else {
        hidBut.innerHTML = 'Ver más';
    }
}



/*
document.addEventListener("DOMContentLoaded", function (e) {
    //código a ejecutar cuando el DOM está listo para recibir acciones
    let buscador2 = document.getElementById("buscador");
    
    
    buscador2?.addEventListener("keydown", function (e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
            //let param=document.getElementById("search_clear").value;
            //alert(param);
            //alert("has presionado enter");
            e.preventDefault();
            //buscador2.submit();
            const url =  location.protocol + "//" + location.host + "/store/buscar/"  ;
            //alert(url);
            const xhttp = new XMLHttpRequest()
            xhttp.open("GET",url)
            xhttp.send()
            xhttp.onload = function () {
                //datos.tipo = tipo
                //document.getElementById(data).dataset.datos = JSON.stringify(datos)
                //console.log(datos)
                //alert(this)
                // xmlhttp.readyState==4 && xmlhttp.status==200
                if (this.readyState == 4 && this.status == 200) {
                    alert(JSON.parse(this.responseText))
                    //location.reload();

                }
            }

        }
    });
});
*/

$(function () {
    $("#resultado").hide();
    var path = "/buscar";
    
    var busc = $("#buscador");

    busc.on('keydown', function (e) {

        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
            var param = $("#search_clear").val();
            if (param!='') {
                $.get(path, { query: param }, function (data) {
                    var html ='';
                    data.forEach(element => {
                        console.log(element);
                        html += '<div class="card" style="width: 18rem;"><a href="/store/producto/'+element.titulo+'" style="text-decoration: none; color: #f5f5f5;"><img src="http://192.168.56.1:8002/storage/'+element.detalle[0].imagen+'" class="card-img-top" alt="..."><div class="card-body"> <p class="card-text">'+element.titulo+'</p> <span class="precio">$'+element.detalle[0].valor+'</span></div><form action="/add" method="POST"><input type="hidden" name="csrf" value="'+element.csrf+'"><input type="hidden" value="'+element.detalle[0].idProducto+'" id="id" name="idProducto"><input type="hidden" value="'+element.titulo+'" id="titulo" name="titulo"><input type="hidden" value="'+element.detalle[0].valor+'" id="valor" name="valor"><input type="hidden" value="'+element.detalle[0].imagen+'" id="img" name="imagen"><input type="hidden" value="1" id="quantity" name="quantity"><div class="card-footer" ><div class="row"><button class="btn btn-secondary btn-sm" class="tooltip-test" title="add to cart"><i class="fa fa-shopping-cart"></i> agregar al carrito</button></div></div></form></a></div>';
                        
                    });
                    $("#resultado").html(html);
                    $("#resultado").show();
                });
                
            }
            else{
                $("#resultado").hide();
            }
            e.preventDefault();
           // alert(busc);


        }

    });

});



