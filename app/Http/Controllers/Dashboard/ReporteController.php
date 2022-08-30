<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Venta;

// Laravel Modules
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReporteController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['año'] = trim($request->get('año')); // Dato necesario (cuando el usuario quiere ver las ventas de un año)
        $añoActual = date("Y");

        /* Se comprueba si se requiere cambiar la variable de session o no */
        function actualizarSession($nuevoValor, $session, $defaultValue){
            if (session()->exists($session)) {
                if($nuevoValor != ""){
                    session([$session => intval($nuevoValor)]);}
            } else {
                session([$session => $defaultValue]);}
        }

        actualizarSession($data['año'], 'año', $añoActual);
        
        function busquedaDB(){

            // Se pone en formato de fecha la variable de session.
            $añoSession = session('año');
            $añoSiguiente = session('año')+1;
            $fechaRequerida = date_create("$añoSession-01-01");
            $fechaSiguiente = date_create("$añoSiguiente-01-01");

            // Se obtienen las fechas en el rango especifico, en este caso es del 2019 al 2020.
            $data['ventas'] = DB::table('venta')->select('fecha')->where('fecha', '>=', date_format($fechaRequerida,"Y/m/d"))->where('fecha', '<', date_format($fechaSiguiente,"Y/m/d"))->get(); 
            $ventasTotales = DB::table('venta')->select('fecha')->get();
        
            $data['y'] = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0); // Son 12 ceros ya que son 12 meses en total.

            foreach($data['ventas'] as $venta) {
                $mes = date('m', strtotime($venta->fecha));

                // Se verifica se el mes esta repetido para asi aumentar 1 a la cantidad de la venta de ese mes.
                if($mes == '01') {$data['y'][0]++;}
                if($mes == '02') {$data['y'][1]++;}
                if($mes == '03') {$data['y'][2]++;}
                if($mes == '04') {$data['y'][3]++;}
                if($mes == '05') {$data['y'][4]++;}
                if($mes == '06') {$data['y'][5]++;}
                if($mes == '07') {$data['y'][6]++;}
                if($mes == '08') {$data['y'][7]++;}
                if($mes == '09') {$data['y'][8]++;}
                if($mes == '10') {$data['y'][9]++;}
                if($mes == '11') {$data['y'][10]++;}
                if($mes == '12') {$data['y'][11]++;}
                                
            }

            $data['añosRegistrados'] = array(); // En esta variable se registran todos los años que tienen ventas.

            foreach($ventasTotales as $venta) {
                $año = date('Y', strtotime($venta->fecha));

                if(!in_array($año, $data['añosRegistrados'])) {array_push($data['añosRegistrados'], $año);}
            } 
            array_push($data['añosRegistrados'], date('Y')); // Se añade el año actual para tener una vista predeterminada en la grafica.

            return $data;
        }

        $data = busquedaDB();

        return view('Dashboard.Reporte.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reporte  $reporte
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reporte  $reporte
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reporte $reporte)
    {
        //
    }
}
