<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;



class RoleController extends Controller implements HasMiddleware
{

 public static function middleware(): array
{
    return [
        // examples with aliases, pipe-separated names, guards, etc:
        // 'role_or_permission:manager|edit articles',
        new Middleware('permission:view-roles', only: ['index']),
        new Middleware('permission:edit-roles', only: ['edit']),
        new Middleware('permission:create-roles', only: ['create']),
        new Middleware('permission:delete-roles', only: ['destroy']),


    ];
}


    public function index()
    {
        $role = Role::orderBy('id', 'asc')->paginate(10);
        return view('Role.index', compact('role'));
    }

    public function create()
    {
        $permissions = Permission::orderBy('created_at', 'asc')->get();
        return view('Role.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required|unique:roles|max:255',
        ], [
            'name.required' => 'Role name is required.',
            'name.unique' => 'Role name already exists.',
            'name.max' => 'Role name must not exceed 255 characters.',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v)->withInput();
        }

        // Create Role
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        // Assign permissions safely
        if ($request->has('permissions')) {
            foreach ($request->permissions as $permission) {

                // Assign permission to role
                $role->givePermissionTo($permission);
            }
        } else {
            return redirect()->back()->withInput()->withErrors($v);
        }
        // Assign permissions
        // if ($request->has('permissions')) {
        //     foreach ($request->permissions as $permissionName) {
        //         $role->givePermissionTo($permissionName);

        //     }
        // }

        return redirect()->route('role.index')->with('success', 'Role created successfully.');
    }
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // $role = Role::findOrFail($id);
        // $permissions=$role->permissions->pluck('name','id')->toArray();
        // $roleName=$role->name;

        // // dd($permissions);
        // return view('role.edit', compact('role', 'permissions','roleName'));
        $role = Role::findOrFail($id);
        $hasPermissions = $role->permissions->pluck('name');
        $permissions = Permission::orderBy('name', 'asc')->get();
        // dd($permissions, $hasPermissions);

        return view('role.edit', ['role' => $role, 'permissions' => $permissions, 'hasPermissions' => $hasPermissions]);
    }

    // public function update(Request $request, $id)
    // {
    //     $role = Role::findOrFail($id);

    //     $v = Validator::make($request->all(), [
    //         'name' => 'required|unique:roles|max:255',
    //     ]);

    //     if ($v->fails()) {
    //         return redirect()->back()->withErrors($v)->withInput();
    //     }

    //     $role->update(['name' => $request->name]);


    //     if (!empty($request->permissions)) {
    //         $permissions = $request->permissions;
    //         $role->syncPermissions($permissions);
    //     } else {
    //         return redirect()->route('role.index')->with('error', 'Role update fail.');
    //     }

    //     return redirect()->route('role.index')->with('success', 'Role updated successfully.');
    // }
    public function update(Request $request, $id)
{
    $role = Role::findOrFail($id);

    $request->validate([
        'name' => 'required|max:255|unique:roles,name,' . $role->id,
        'permissions' => 'required|array',
    ]);

    // Update role name
    $role->update(['name' => $request->name]);

    // Sync permissions
    $role->syncPermissions($request->permissions); // now works perfectly

    return redirect()->route('role.index')->with('success', 'Role updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */

        // Assign permissions
        // if ($request->has('permissions')) {
        //     foreach ($request->permissions as $permissionName) {
        //         $role->givePermissionTo($permissionName);

        //     }
        // }



        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|string|max:255',
        //     'permissions' => 'required|array',
        // ], [
        //     'name.required' => 'Permission name is required.',
        //     'name.unique'   => 'Permission name already created.',
        //     'name.max'      => 'Permission name must not exceed 255 characters.',
        // ]);

        // if ($validator->fails()) {
        //     return redirect()->back()
        //         ->withErrors($validator)
        //         ->withInput();
        // }

        // $role = Role::update(
        //     $role->name = $request->name,
        //     $role->permissions()->sync($request->permissions),
        // );
        // return redirect()->route('role.index')->with('success', 'Role updated successfully.');



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $role= Role::findOrFail($id);
        $role->delete();
        return redirect()->route('role.index')->with('success', 'Role deleted successfully.');
    }
}


// <?php

// namespace App\Http\Controllers;

// use App\Models\Permission;
// use App\Models\Role;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Validator;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;

// class RoleController extends Controller
// {
//     /**
//      * Display a listing of the resource.
//      */
//     public function index()
//     {
//         $role=Role::orderBy('id','asc')->paginate(10);

//         return view('Role.index',compact('role'));
//         }

//         /**
//          * Show the form for creating a new resource.
//         */
//         public function create()
//         {
//         $permissions=Permission::orderBy('created_at', 'asc')->get();
//         return view('Role.create',compact('permissions'));
//     }

//     /**
//      * Store a newly created resource in storage.
//      */
//     public function store(Request $request)
//     {
//        $vailidator = Validator::make($request->all(), [
//             'name' => 'required|unique:permissions|max:255',
//         ],[
//             'name.required' => 'Role name is required.',
//             'name.unique' => 'Role name already created.',
//             'name.max' => 'Role name must not exceed 255 characters.',
//         ]);
//         if ($vailidator->passes()) {
//             // dd($request->permissions);
//              $role=Role::create([
//                 'name' => $request->name,
//             ]);

//             if (!empty($request->permissions)) {
//                 foreach ($request->permissions as $name) {
//                     $role->givePermissionTo($name);
//                 }
//             }
//              return redirect()->route('role.index')->with('success', 'Role created successfully.');
//         }elseif ($vailidator->fails()) {
//             return redirect()->back()->withErrors($vailidator)->withInput();
//         }
//     }

//     /**
//      * Display the specified resource.
//      */
//     public function show(Role $role)
//     {
//         //
//     }

//     /**
//      * Show the form for editing the specified resource.
//      */
//     public function edit(Role $role)
//     {
//         //
//     }

//     /**
//      * Update the specified resource in storage.
//      */
//     public function update(Request $request, Role $role)
//     {
//         //
//     }

//     /**
//      * Remove the specified resource from storage.
//      */
//     public function destroy(Role $role)
//     {
//         //
//     }
// }
