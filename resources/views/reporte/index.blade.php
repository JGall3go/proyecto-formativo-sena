@extends('platillas/sidebar')

@section('content')

    <link  href="{{ asset ('css/graficas.css') }}" rel="stylesheet">
    
    <div class="graficas">
        <div class="canvas">
            <h1>Reporte de Ventas</h1>
            <canvas id="MyChart" height="500" width="500"></canvas>
        </div>
        
        <div class="canvas">
            <h1>Reporte de Ventas</h1>
            <canvas id="MyChart2" height="500" width="500"></canvas>
        </div>
    </div>

    <script src="{{ asset ('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js')}}" 
    integrity="{{ asset ('sha512-sW/w8s4RWTdFFSduOTGtk4isV1+190E/GghVffMA9XczdJ2MDzSzLEubKAs5h0wzgSJOQTRYyaz73L3d6RtJSg==')}}" 
    crossorigin="{{ asset ('anonymous')}}" 
    referrerpolicy="{{ asset ('no-referrer')}}"></script>

    <script src="{{ asset ('js/graficas.js')}}"></script>

    

@endsection