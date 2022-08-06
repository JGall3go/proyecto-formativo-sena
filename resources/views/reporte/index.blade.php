@extends('plantillas/sidebar')

@section('content')

    <section class="contentDashboard">
        
        <link  href="{{ asset ('css/graficas.css') }}" rel="stylesheet">
        <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js' integrity='sha512-sW/w8s4RWTdFFSduOTGtk4isV1+190E/GghVffMA9XczdJ2MDzSzLEubKAs5h0wzgSJOQTRYyaz73L3d6RtJSg==' crossorigin='anonymous' referrerpolicy='no-referrer'></script>
        <script src="{{ asset('js/content.js') }}"></script>
        <script src="{{ asset('js/content.js') }}"></script>

        <div class="topBar" id="topBar">
            <div class="breadCrumbs">
                <span style="color: #b9b9b9; font-size: 12px; font-weight: 600;">Dashboard</span> <span style="color: #818181; font-size: 12px; font-weight: 600;">/ Reporte</span>
                <div><h3 style="margin-top: 0px; color: #707070">Reportes</h3></div>
            </div>
    
            <a id="profileAncla"><img src="https://hastane.ksu.edu.tr/depo/kullanici/resim/no-avatar.png" id='imageProfile'></a>
        </div>

        <div class="graficas">

            <div class="canvas">
                <h1>Ventas</h1>

                <form class="formSelectTime" action="{{ route('reporte.index') }}" method="GET">
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