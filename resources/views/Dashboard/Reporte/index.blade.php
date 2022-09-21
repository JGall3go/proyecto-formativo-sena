@extends('Dashboard/Plantillas/sidebar')

@section('content')

    <section class="contentDashboard">
        
        <link  href="{{ asset ('css/graficas.css') }}" rel="stylesheet">
        <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js' integrity='sha512-sW/w8s4RWTdFFSduOTGtk4isV1+190E/GghVffMA9XczdJ2MDzSzLEubKAs5h0wzgSJOQTRYyaz73L3d6RtJSg==' crossorigin='anonymous' referrerpolicy='no-referrer'></script>
        <script src="{{ asset('js/content.js') }}"></script>

        <div class="topBar" id="topBar">
            <div class="breadCrumbs">
                <span class="iconMenu" onclick="collectSidebarResponsive(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><title>Menu</title><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M80 160h352M80 256h352M80 352h352"/></svg>
                </span>
                <div>
                    <span style="color: #b9b9b9; font-size: 12px; font-weight: 600;">Dashboard</span> <span style="color: #818181; font-size: 12px; font-weight: 600;">/ Home</span>
                    <div><h3 style="margin-top: 0px; color: #707070">Reportes</h3></div>
                </div>
            </div>
    
            <a id="profileAncla"><img src="https://hastane.ksu.edu.tr/depo/kullanici/resim/no-avatar.png" id='imageProfile'></a>
        </div>

        <div class="reportes">
            <div class="reporteDiario">
                <span class="gananciaReporte">$50.000</span>
                <span class="textoReporte">Ganancias de hoy</span>
            </div>
            <div class="reporteMensual">
                <span class="gananciaReporte">$802.400</span>
                <span class="textoReporte">Ganacias del mes</span>
            </div>
            <div class="reporteVentas">
                <span class="gananciaReporte">104</span>
                <span class="textoReporte">Ventas del mes</span>
            </div>
        </div>

        <div class="graficas">

            <div class="canvas">
                <h1>Ventas</h1>

                <form class="formSelectTime" action="dashboard/home" method="GET">
                    <label>Año</label>
                    <select onchange="this.form.submit()" name='año' class="annualSelect" id="select">
                        <!-- Automaticamente aparecen los años con ventas registradas -->
                        @foreach ($añosRegistrados as $año)
                            <option value="{{ $año }}">{{ $año }}</option>
                        @endforeach
                    </select>
                </form>

                <!-- Se cambia la opcion seleccionada dependiendo de la variable "año" -->
                <script type="text/javascript">
                    var añoNuevo = "<?= session('año'); ?>";
                    if(añoNuevo != "") {document.getElementById('select').value = añoNuevo;} else {
                        document.getElementById('select').value = '<?php date("Y") ?>';
                    }
                </script>

                <canvas id="graficaVentas"></canvas>
                
                <script>
                    Chart.defaults.font.size = 13;
                    const ctx = document.getElementById('graficaVentas');
                    const mes = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

                    const myChart = new Chart(ctx, {
                        type: 'line',
                        data:{
                            labels: mes,
                            datasets: [{
                                barThickness: 30,
                                label: @isset($año)'Ventas año <?php echo $año; ?>' @else 'Ventas año <?php echo date("Y"); ?>'@endisset,
                                data: @json($y), // Se llama a la variable $y que se paso mediante el controlador.
                                backgroundClor: ['#7182e4'],
                                borderColor: ['#7182e4'],
                                borderWidth: 2.0 
                            }]
                        }
                    })
                </script>
            </div>

            <div class="canvasUsuarios">
                <h1>Ventas</h1>

                <form class="formSelectTime" action="dashboard/home" method="GET">
                    <label>Año</label>
                    <select onchange="this.form.submit()" name='año' class="annualSelect" id="select">
                        <!-- Automaticamente aparecen los años con ventas registradas -->
                        @foreach ($añosRegistrados as $año)
                            <option value="{{ $año }}">{{ $año }}</option>
                        @endforeach
                    </select>
                </form>

                <!-- Se cambia la opcion seleccionada dependiendo de la variable "año" -->
                <script type="text/javascript">
                    var añoNuevo = "<?= session('año'); ?>";
                    if(añoNuevo != "") {document.getElementById('select').value = añoNuevo;} else {
                        document.getElementById('select').value = '<?php date("Y") ?>';
                    }
                </script>

                <canvas id="graficaVentas"></canvas>
                
                <script>
                    Chart.defaults.font.size = 13;
                    const ctx = document.getElementById('graficaVentas');
                    const mes = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

                    const myChart = new Chart(ctx, {
                        type: 'line',
                        data:{
                            labels: mes,
                            datasets: [{
                                barThickness: 30,
                                label: @isset($año)'Ventas año <?php echo $año; ?>' @else 'Ventas año <?php echo date("Y"); ?>'@endisset,
                                data: @json($y), // Se llama a la variable $y que se paso mediante el controlador.
                                backgroundClor: ['#7182e4'],
                                borderColor: ['#7182e4'],
                                borderWidth: 2.0 
                            }]
                        }
                    })
                </script>
            </div>
        </div>
    </section>
@endsection