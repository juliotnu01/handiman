<?php

namespace App\Http\Controllers;

use App\Models\VerificationID;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class VerificationIDController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $validated = $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,pdf',
            'user_id' => 'required|integer|exists:users,id',
            'type' => 'required|string|in:front,back',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $file = $validated['file'];
                $userId = $validated['user_id'];
                $type = $validated['type'];
                $path = $file->storeAs("identificaciones/user/{$userId}/{$type}", $file->getClientOriginalName(), 'public');

                $verificationID = VerificationID::create([
                    'type' => $type,
                    'id_path' => $path,
                ]);

                $user = User::find($userId);
                $user->verificationIDs()->attach($verificationID->id);
            });

            return response()->json(['message' => 'File uploaded successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'File upload failed', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(VerificationID $verificationID)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VerificationID $verificationID)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VerificationID $verificationID)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VerificationID $verificationID)
    {
        //
    }
}
