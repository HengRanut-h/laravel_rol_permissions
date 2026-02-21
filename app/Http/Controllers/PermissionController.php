<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PermissionController extends Controller
{

    // public static function middleware(): array
    // {
    //     return [
    //         new Middleware('permission:view-permissions', only: ['index']),
    //         new Middleware('permission:edit-permissions', only: ['edit']),
    //         new Middleware('permission:create-permissions', only: ['create']),
    //         new Middleware('permission:delete-permissions', only: ['destroy']),
    //     ];
    // }


    //This method will show permissions list page
    public function index()
    {
        $permissions = Permission::orderBy('created_at', 'asc')->paginate(10);
        return view('Permissions.index', compact('permissions'));
    }

    // This method will show create permission page
    public function create()
    {
        return view('Permissions.Create');
    }

    // This method will store the permission in database
    public function store(Request $request)
    {
        // $vailidated = $request->validate([
        //     'name' => 'required|unique:permissions|max:255',
        // ]);
        // Permission::create($vailidated);
        // return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
        $vailidator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions|max:255',
        ], [
            'name.required' => 'Permission name is required.',
            'name.unique' => 'Permission name already created.',
            'name.max' => 'Permission name must not exceed 255 characters.',
        ]);
        if ($vailidator->passes()) {
            Permission::create([
                'name' => $request->name,
                'guard_name' => 'web',
            ]);
            return redirect()->route('permissions.create')->with('success', 'Permission created successfully.');
        } elseif ($vailidator->fails()) {
            return redirect()->back()->withErrors($vailidator)->withInput();
        }
    }

    // This method will show the permission details
    public function show(Permission $permission)
    {
        //
    }

    // This method will show edit permission page
    public function edit($id,)
    {
        // Find the permission by id
        $permission = Permission::findOrFail($id);
        return view('permissions.edit', compact('permission'));
    }

    // This method will update the permission in database
    public function update($id, Request $request)
    {

        $permission = Permission::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:permissions,name,' . $id . ',id',
        ], [
            'name.required' => 'Permission name is required.',
            'name.unique'   => 'Permission name already created.',
            'name.max'      => 'Permission name must not exceed 255 characters.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $permission->update([
            'name' => $request->name,
        ]);

        return redirect()->route('permissions.index')
            ->with('success', 'Permission updated successfully.');
    }

    //create methos by yourself

    // This method will delete the permission from database
    // public function delete(Request $request)
    // {
    //     $id = $request->id;
    //    $permission = Permission::findOrFail($id);
    //    $permission->delete();
    //     return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
    // }

    // using blade

    //     public function destroy($id)
    // {
    //     $permission = Permission::findOrFail($id);
    //     $permission->delete();

    //     return redirect('permissions')
    //             ->with('success', 'Permission deleted successfully.');;
    // }

    //using by ajax

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        session()->flash('success', 'Permission deleted successfully.');
        return response()->json([
            'status' => 'success',
            'message' => 'Permission deleted successfully.'
        ]);
    }
}
