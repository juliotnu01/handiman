<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;
use DB;
use App\Events\ServicioStoreEvent;

class ServicioController extends Controller
{
    public function index()
    {
        try {
            
            $servicio = new Servicio();
            return response()->json($servicio->all([
            'id',
            'codigo',
            'servicio',
            'tipo_servicio',
            'ubicacion',
            'coordenadas',
            'status',
            'precio',
            'usr_creador',
            'usr_solicitante']));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store(Request $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $servicio = new Servicio();
                $servicio->codigo = $request->codigo;
                $servicio->servicio = $request->servicio;
                $servicio->tipo_servicio = $request->tipo_servicio;
                $servicio->ubicacion = $request->ubicacion;
                $servicio->coordenadas = $request->coordenadas;
                $servicio->status = $request->status;
                $servicio->precio = $request->precio;
                $servicio->usr_creador = $request->usr_creador;
                $servicio->usr_solicitante = $request->usr_solicitante;
                $servicio->save();
                event(new ServicioStoreEvent($servicio));
            }, 5);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
