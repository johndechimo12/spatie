<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Gate; 

class Spatielook extends Controller
{
   
    public function index()
    {
       
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();

        return view('spatielook.index', compact('roles', 'permissions'));
    }

  
    public function storeRole(Request $request)
    {
   
        $request->validate([
            'name' => 'required|unique:roles,name|string|max:255',
        ]);

        
        $roleName = htmlspecialchars($request->name);

       
        Role::create(['name' => $roleName]);

        return back()->with('success', 'Role created successfully!');
    }

  
    public function storePermission(Request $request)
    {
        
        $request->validate([
            'name' => 'required|unique:permissions,name|string|max:255',
        ]);

        $permissionName = htmlspecialchars($request->name);

     
        Permission::create(['name' => $permissionName]);

        return back()->with('success', 'Permission created successfully!');
    }

 
    public function assignPermission(Request $request)
    {
       
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'array|exists:permissions,name', 
        ]);

        
        $role = Role::findOrFail($request->role_id);

        
        $permissions = array_map('htmlspecialchars', $request->permissions ?? []);

       
        $role->syncPermissions($permissions);

        return back()->with('success', 'Permissions updated successfully!');
    }

  
    public function updateRole(Request $request)
    {
        
        $request->validate([
            'id' => 'required|exists:roles,id',
            'name' => 'required|string|max:255|unique:roles,name,' . $request->id,
        ]);

        $role = Role::findOrFail($request->id);

       
        $roleName = htmlspecialchars($request->name);

        
        $role->update(['name' => $roleName]);

        return back()->with('success', 'Role updated successfully!');
    }

   
    public function updatePermission(Request $request)
    {
        
        $request->validate([
            'id' => 'required|exists:permissions,id',
            'name' => 'required|string|max:255|unique:permissions,name,' . $request->id,
        ]);

       
        $permission = Permission::findOrFail($request->id);

       
        $permissionName = htmlspecialchars($request->name);

       
        $permission->update(['name' => $permissionName]);

        return back()->with('success', 'Permission updated successfully!');
    }

   
    public function destroyRole($id)
    {
     
        $role = Role::findOrFail($id);

       
        $role->delete();

        return back()->with('success', 'Role deleted successfully!');
    }

   
    public function destroyPermission($id)
    {
       
        $permission = Permission::findOrFail($id);

        
        $permission->delete();

        return back()->with('success', 'Permission deleted successfully!');
    }
}
