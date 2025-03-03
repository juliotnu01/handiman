<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use App\Models\Certification;
use App\Models\PaymentMethod;
use App\Models\BasicInformationUser;
use DB;

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

        $query = User::with(['certifications', 'paymentMethods']);

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

    public function storePaymentMethod(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'titular_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:20',
            'id_titular' => 'required|string|max:20',
            'type_account' => 'required|string|max:20',
            'user_id' => 'required|exists:users,id',
        ]);

        $paymentMethod = new PaymentMethod([
            'bank_name' => $request->input('bank_name'),
            'titular_name' => $request->input('titular_name'),
            'account_number' => $request->input('account_number'),
            'id_titular' => $request->input('id_titular'),
            'type_account' => $request->input('type_account'),
            'user_id' => $request->input('user_id'),
        ]);

        $paymentMethod->save();

        return response()->json(['message' => 'Método de pago registrado con éxito'], 200);
    }

    public function storeBasicInformation(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'banner_photo' => 'nullable|image|mimes:jpg,png|max:2048',
                'title_user' => 'nullable|string|max:255',
                'user_mobile' => 'nullable|string|max:20',
                'main_address' => 'nullable|string|max:255',
                'abount_user' => 'nullable|string',
                'first_name' => 'nullable|string|max:255',
                'second_name' => 'nullable|string|max:255',
                'first_last_name' => 'nullable|string|max:255',
                'second_last_name' => 'nullable|string|max:255',
                'nationality' => 'nullable|string|max:255',
                'website' => 'nullable|string|max:255',
                'birthdate' => 'nullable|date',
            ]);

            DB::transaction(function () use ($request) {
                $user_id = $request->input('user_id');
                $bannerPhotoUrl = null;

                if ($request->hasFile('banner_photo')) {
                    $bannerPhotoUrl = $request->file('banner_photo')->storeAs("public/banner_photos/user/{$user_id}", $request->file('banner_photo')->getClientOriginalName());
                    $bannerPhotoUrl = Storage::url($bannerPhotoUrl);
                }

                $data = [
                    'title_user' => $request->input('title_user'),
                    'user_mobile' => $request->input('user_mobile'),
                    'main_address' => $request->input('main_address'),
                    'abount_user' => $request->input('abount_user'),
                    'first_name' => $request->input('first_name'),
                    'second_name' => $request->input('second_name'),
                    'first_last_name' => $request->input('first_last_name'),
                    'second_last_name' => $request->input('second_last_name'),
                    'nationality' => $request->input('nationality'),
                    'website' => $request->input('website'),
                    'birthdate' => $request->input('birthdate'),
                ];

                if ($bannerPhotoUrl) {
                    $data['banner_photo_url'] = $bannerPhotoUrl;
                }

                BasicInformationUser::updateOrCreate(
                    ['user_id' => $user_id],
                    $data
                );
            });

            return response()->json(['message' => 'Información básica guardada con éxito'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al guardar la información básica', 'details' => $e->getMessage()], 500);
        }
    }

    public function getUserWithBasicInformation($id)
    {
        try {
            $user = User::with('basicInformation')->findOrFail($id);

            return response()->json(['user' => $user], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener la información del usuario', 'details' => $e->getMessage()], 500);
        }
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
