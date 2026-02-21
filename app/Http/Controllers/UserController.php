<?php

namespace App\Http\Controllers;


use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{

 public static function middleware(): array
{
    return [
        // examples with aliases, pipe-separated names, guards, etc:
        // 'role_or_permission:manager|edit articles',
        new Middleware('permission:view-users', only: ['index']),
        new Middleware('permission:edit-users', only: ['edit']),
        new Middleware('permission:create-users', only: ['create']),
        new Middleware('permission:delete-users', only: ['destroy']),


    ];
}

    public function index()
    {
        $users = User::all();
        // dd($users);
        return view('user.index', compact('users'));
    }


    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            return redirect()->route('user.index')->with('success', 'User created successfully');
        }
    }


    public function show(User $user)
    {
        //
    }

    public function edit($id)
    {
        $user=User::findOrFail($id);
        $roles = Role::all();
        $hasRoles = $user->roles->pluck('id');
        // dd( $hasRoles);
        return view('user.edit', compact('user', 'roles', 'hasRoles'));
    }

    public function update(Request $request,$id)
    {
        $user=User::findOrFail($id);
         $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {

            $user ->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            $user->syncRoles($request->role); //syncRoles is a method provided by Laravel's Role model to sync the roles of a user

            return redirect()->route('user.index')->with('success', 'User updated successfully');
        }
    }

    public function destroy($id)
    {
        $user=User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully');
    }
}
