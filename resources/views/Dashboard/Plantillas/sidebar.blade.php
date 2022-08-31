<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/gsap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/content.css') }}" rel="stylesheet">
    <script src="{{ asset('js/sidebar.js') }}"></script>

    <title>Dashboard</title>
</head>

<body>

    <!-- Sidebar container -->
    <div class="sidebar" id="sidebar">

        <div class="sidebarHeader" id="sidebarHeader">
            <span id="companyTitle">
                <h2>Company</h2>
                <h6>Dashboard</h6>
            </span>

            <span id="menuIcon">
                <img src="{{ asset('svg/chevron-back-outline.svg') }}" onclick="collectSidebar(this)" width="35px">
            </span>

            <span id="menuIconBack">
                <img src="{{ asset('svg/chevron-forward-outline.svg') }}" onclick="collectSidebar(this)" width="35px">
            </span>

            <span id="closeIconResponsive">
                <ion-icon name="close-outline" onclick="collectSidebarResponsive(this)"></ion-icon>
            </span>
        </div>

        <div id="sidebarItems">
            <!--<a href="/dashboard/usuario" id="initialItem" @if(str_contains(url()->current(), '/dashboard/usuario'))class="active"@else class="a"@endif> <img src="{{ asset('svg/person-circle-outline.svg') }}" id="ionIconElement"> <span class="textElementMenu" id="spanCollect">Usuarios</span></a>-->
            <a href="/dashboard/administrador" id="initialItem" @if(str_contains(url()->current(), '/dashboard/administrador'))class="active"@else class="a"@endif> <img src="{{ asset('svg/build-outline.svg') }}" id="ionIconElement"> <span class="textElementMenu" id="spanCollect">Administradores</span></a>
            <a href="/dashboard/empleado" @if(str_contains(url()->current(), '/dashboard/empleado'))class="active"@else class="a"@endif> <img src="{{ asset('svg/person-outline.svg') }}" id="ionIconElement"> <span class="textElementMenu" id="spanCollect">Empleados</span></a>
            <a href="/dashboard/cliente" @if(str_contains(url()->current(), '/dashboard/cliente'))class="active"@else class="a"@endif> <img src="{{ asset('svg/people-outline.svg') }}" id="ionIconElement"> <span class="textElementMenu" id="spanCollect">Clientes</span></a>
            <a href="/dashboard/proveedor" @if(str_contains(url()->current(), '/dashboard/proveedor'))class="active"@else class="a"@endif> <img src="{{ asset('svg/storefront-outline.svg') }}" id="ionIconElement"> <span class="textElementMenu" id="spanCollect">Proveedores</span></a>
            <a href="/dashboard/producto" @if(str_contains(url()->current(), '/dashboard/producto'))class="active"@else class="a"@endif> <img src="{{ asset('svg/cube-outline.svg') }}" id="ionIconElement"> <span class="textElementMenu" id="spanCollect">Productos</span></a>  
            <a href="/dashboard/venta" @if(str_contains(url()->current(), '/dashboard/venta'))class="active"@else class="a"@endif> <img src="{{ asset('svg/cart-outline.svg') }}" id="ionIconElement"> <span class="textElementMenu" id="spanCollect">Ventas</span></a>
            <a href="/dashboard/reporte" @if(str_contains(url()->current(), '/dashboard/reporte'))class="active"@else class="a"@endif> <img src="{{ asset('svg/newspaper-outline.svg') }}" id="ionIconElement"> <span class="textElementMenu" id="spanCollect">Reportes</span></a>
            
            <a href="#" id="dropbox" onclick="dropMenu(this)">Complementarios<img src="{{ asset('svg/chevron-down-outline.svg') }}" class="rotateArrow" id="ionIconElement"></a>
            
            <div id="complementarios" class="collect">
                <a href="/dashboard/linea" @if(str_contains(url()->current(), '/dashboard/linea'))class="active"@else class="a"@endif><img src="{{ asset('svg/bookmark-outline.svg') }}" id="ionIconElement"><span class="textElementMenu" id="spanCollect">Lineas</span></a>
                <a href="/dashboard/sublinea" @if(str_contains(url()->current(), '/dashboard/sublinea'))class="active"@else class="a"@endif><img src="{{ asset('svg/bookmarks-outline.svg') }}" id="ionIconElement"><span class="textElementMenu" id="spanCollect">Sublineas</span></a>
                <a href="/dashboard/tipoDocumento" id="hoverComp" @if(str_contains(url()->current(), '/dashboard/tipoDocumento')) class="active"@else class="a" @endif><img src="{{ asset('svg/id-card-outline.svg') }}" id="ionIconElement"><span class="textElementMenu" id="spanCollect">Identificaciones</span></a>
            </div>

            <div id="complementariosHidden">
                <a href="/dashboard/linea" @if(str_contains(url()->current(), '/dashboard/linea'))class="active"@else class="a"@endif><img src="{{ asset('svg/bookmark-outline.svg') }}" id="ionIconElement"><span class="textElementMenu" id="spanCollect">Lineas</span></a>
                <a href="/dashboard/sublinea" @if(str_contains(url()->current(), '/dashboard/sublinea'))class="active"@else class="a"@endif><img src="{{ asset('svg/bookmarks-outline.svg') }}" id="ionIconElement"><span class="textElementMenu" id="spanCollect">Sublineas</span></a>
                <a href="/dashboard/tipoDocumento" id="hoverComp" @if(str_contains(url()->current(), '/dashboard/tipoDocumento'))class="active"@else class="a"@endif><img src="{{ asset('svg/id-card-outline.svg') }}" id="ionIconElement"><span class="textElementMenu" id="spanCollect">Identificaciones</span></a>
            </div>
        </div>

        <!--
        <div id="profileSidebar">
            <a id="profileAncla"><img src="https://www.trecebits.com/wp-content/uploads/2019/02/Persona-1-445x445.jpg" id='imageProfile'>
            <h4 id="tituloProfile">Normal Person</h4></a>
        </div>-->
    </div>

    <!-- Container Main end -->

    <div class="content" id="content">

        <header class="headerContentResponsive">

            <span id="menuIconResponsive">
                <ion-icon name="menu-outline" onclick="collectSidebarResponsive(this)"></ion-icon>
            </span>

            <a id="profileAnclaResponsive"><img src="https://www.trecebits.com/wp-content/uploads/2019/02/Persona-1-445x445.jpg">
            <h4>Normal Person</h4></a>

        </header>

        @yield('content')

    </div>

    <!-- Ion Icons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>