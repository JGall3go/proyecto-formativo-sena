@extends('platillas/sidebar')

@section('content')

    <section class="contentDashboard">
        
        <link  href="{{ asset ('css/graficas.css') }}" rel="stylesheet">
        <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js' integrity='sha512-sW/w8s4RWTdFFSduOTGtk4isV1+190E/GghVffMA9XczdJ2MDzSzLEubKAs5h0wzgSJOQTRYyaz73L3d6RtJSg==' crossorigin='anonymous' referrerpolicy='no-referrer'></script>
        <script src="{{ asset('js/content.js') }}"></script>
        <script src="{{ asset('js/content.js') }}"></script>

        <div class="breadCrumbs">
            Dashboard <span style="color: #858383">/ Reporte</span>
            <div><h3 style="margin-top: 5px; color: #858383">Reportes</h3></div>
        </div>

        <div class="graficas">

            <div class="canvas">
                <h1>Ventas</h1>

                <form class="formSelectTime" action="{{ route('reporte.index') }}" method="GET">
                    <label>Año</label>
                    <select onchange="this.form.submit()" name='año' class="annualSelect">
                        <!-- Hacer que automaticamente aparezcan los años con ventas registradas -->
                        <option value='2019'>2019</option>
                        <option value='2020'>2020</option>
                        <option value='2021'>2021</option>
                    </select>

                </form>

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
                                label: 'Ventas por Mes del Año 2022',
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