<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{
    public $module;

    public function __construct()
    {
    }

    public function index()
    {
        $users = DB::table('users')->get();
        $template = 'user.index';
        return view('dashboard.layout.home', compact('template', 'users'));
    }
    public function show($id)
    {
        $users = DB::table('users')->where('id', $id)->first();
        $template = 'user.show';
        return view('dashboard.layout.home', compact('template', 'users'));
    }
    public function create()
    {
        $method = 'create';
        $template = 'user.store';
        return view('dashboard.layout.home', compact('template', 'method'));
    }
    public function store(StoreUserRequest $request)
    {
        DB::table('users')->insert([
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
        $user = DB::table('users')->where('id', $id)->first();
        $method = 'edit';
        $template = 'user.store';
        return view('dashboard.layout.home', compact('template', 'user', 'method'));
    }
    public function update(StoreUserRequest $request, $id)
    {
        $id = (int) $id;
        DB::table('users')->where('id', $id)->update([
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
        // $user = DB::table('users')->where('id', $id)->first();
        // if (isset($_POST) && is_array($_POST) && count($_POST)) {
            DB::table('users')->where('id', $id)->delete();
            return redirect()->route('users.index')->with('success', 'Xóa người dùng thành công');
        // }
        // $method = 'delete';
        // $template = 'user.delete';
        // return view('dashboard.layout.home', compact('template', 'user', 'method'));
    }
}
