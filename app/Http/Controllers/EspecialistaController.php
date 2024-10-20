<?php

namespace App\Http\Controllers;

use App\Models\{Especialista, DocumentosEspecialista};
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Storage;

class EspecialistaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $especialista = Especialista::with(['servicios', 'certificados'])->get();
            return $especialista;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            return DB::transaction(function () use ($request) {


                $folder = 'especialistas/' . $request['numero_identificacion'];

                $especialista = new Especialista();
                $especialista->nombre = $request['nombre'];
                $especialista->apellido = $request['apellido'];
                $especialista->fecha_nacimiento = $request['fecha_nacimiento'];
                $especialista->correo = $request['correo'];
                $especialista->numero_identificacion = $request['numero_identificacion'];
                $especialista->status = false;
                $especialista->revision = true;


                if ($request->hasFile('documento_identidad.frontal')) {
                    $frontalPath = $request->file('documento_identidad.frontal')->store($folder, 'public');
                    $especialista->url_documento_identificacion_frontal = asset(Storage::url($frontalPath));
                }

                if ($request->hasFile('documento_identidad.trasera')) {
                    $traseraPath = $request->file('documento_identidad.trasera')->store($folder, 'public');
                    $especialista->url_documento_identificacion_trasera = asset(Storage::url($traseraPath));
                }

                if ($request->hasFile('avatar')) {
                    $avatarPath = $request->file('avatar')->store($folder, 'public');
                    $especialista->url_avatar = asset(Storage::url($avatarPath));
                }

                $especialista->save();

                if ($request->has('servicios')) {
                    $servicioIds = collect($request->servicios)->map(function ($servicio) {
                        $decodedServicio = json_decode($servicio, true);
                        return $decodedServicio['id'];
                    })->toArray();
                    $especialista->servicios()->sync($servicioIds);
                }


                if ($request->hasFile('certificados')) {
                    $certificadosFolder = $folder . '/certificados';

                    foreach ($request->file('certificados') as $certificado) {
                        $certificadoPath = $certificado->store($certificadosFolder, 'public');
                        $documentoEspecialista = new DocumentosEspecialista();
                        $documentoEspecialista->url_documento_especialista = asset(Storage::url($certificadoPath));
                        $documentoEspecialista->especialista_id = $especialista->id;
                        $documentoEspecialista->save();
                    }
                }
            }, 5);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Especialista $especialista)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Especialista $especialista)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Especialista $especialista)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     */
    public function updateStatusEspecialista(Request $request, $id)
    {
        try {
            $newStatus = !$request->status;
            $especialista = new Especialista();
            $especialista->find($id)->update([
                "status" => $newStatus
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function updateRevisionEspecialista(Request $request, $id)
    {
        try {
            $newStatus = !$request->revision;
            $especialista = new Especialista();
            $especialista->find($id)->update([
                "revision" => $newStatus
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Especialista $especialista)
    {
        //
    }
}
