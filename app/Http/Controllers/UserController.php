<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;

class UserController extends Controller
{
    public $module;

    public function __construct()
    {
    }

    public function index()
    {
        $users = User::all();
        $template = 'user.index';
        return view('dashboard.layout.home', compact('template', 'users'));
    }

    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'Không tồn tại user');
        }
        $template = 'user.show';
        return view('dashboard.layout.home', compact('template', 'user'));
    }

    public function create()
    {
        $method = 'create';
        $template = 'user.store';
        return view('dashboard.layout.home', compact('template', 'method'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => bcrypt($request->input('password')),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        return redirect()->route('users.index')->with('success', 'Thêm mới người dùng thành công');
    }

    public function edit($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'Không tồn tại user');
        }
        $method = 'edit';
        $template = 'user.store';
        return view('dashboard.layout.home', compact('template', 'user', 'method'));
    }

    public function update(StoreUserRequest $request, $id)
    {
        $id = (int) $id;
        $update = User::where('id', $id)->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => bcrypt($request->input('password')),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        return redirect()->route('users.index')->with('success', 'Thêm mới người dùng thành công');
    }

    public function delete($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'Không tồn tại user');
        }
        else{
            $deleted = User::destroy($id);
            if ($deleted) {
                return redirect()->route('users.index')->with('success', 'Xóa người dùng thành công');
            } else {
                return redirect()->route('users.index')->with('error', 'Không tồn tại user');
            }
        }            
    }
}
