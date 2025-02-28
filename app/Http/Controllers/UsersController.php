<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use App\Models\Certification;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');
        $searchBy = $request->input('search_by');
    
        $query = User::with('certifications');
    
        if ($search && $searchBy) {
            $query->where($searchBy, 'like', '%' . $search . '%');
        }
    
        $usuarios = $query->paginate($perPage)->appends($request->query());
    
        return Inertia::render('Usuarios', [
            'usuarios' => $usuarios,
        ]);
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
        //
    }

    public function storeCertications(Request $request)
    {
        $request->validate([
            'files.*' => 'required|mimes:pdf|max:2048',
            'user_id' => 'required|exists:users,id',
        ]);


        $user_id = $request->input('user_id');
        $certifications = [];

        foreach ($request->file('files') as $index =>  $file) {
            $path = $file->storeAs("public/certificados/users/{$user_id}", $file->getClientOriginalName());

            $certifications[] = [
                'certification_name' => $file->getClientOriginalName(),
                'certificatin_path' => Storage::url($path),
                'description' => $request->input('descriptions')[$index] ?? null,
                'user_id' => $user_id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Certification::insert($certifications);

        return response()->json(['message' => 'Certificados subidos con exito'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
