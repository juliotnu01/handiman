<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolePermissionController extends Controller
{
    public function index()
    {
        // $roles = Role::with('permissions')->get();
        // $permissions = Permission::all();

        return Inertia::render('RolePermission/Index');
    }
    public function rolesypermisos()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();

        return response()->json(["roles" => $roles, "permissions" => $permissions]);
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        $role = Role::create(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->back()->with('success', 'Rol creado exitosamente.');
    }

    public function updateRole(Request $request, Role $role)
    {
        $role->syncPermissions($request->permissions);
        return back()->with('success', 'Permisos del rol actualizados exitosamente.');
    }

    public function deleteRole(Role $role)
    {
        $role->delete();
        return redirect()->back()->with('success', 'Rol eliminado exitosamente.');
    }

    public function storePermission(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        Permission::create(['name' => $request->name]);

        return redirect()->back()->with('success', 'Permiso creado exitosamente.');
    }

    public function deletePermission(Permission $permission)
    {
        $permission->delete();
        return redirect()->back()->with('success', 'Permiso eliminado exitosamente.');
    }
}
