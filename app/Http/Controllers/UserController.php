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
        return response()->json(['data' => $users], 200);
    }
    public function show($id)
    {
        $users = DB::table('users')->where('id', $id)->first();
        if (!$users) {
            return response()->json(['message' => 'Không tồn tại User'], 404);
        }
        return response()->json(['data' => $users], 200);
    }
    public function store(StoreUserRequest $request)
    {
        $user = DB::table('users')->insert([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => bcrypt($request->input('password')),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return response()->json(['data' => $user], 201);
    }
    public function update(StoreUserRequest $request, $id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user = DB::table('users')->where('id', $id)->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => bcrypt($request->input('password')),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return response()->json(['data' => $user], 200);
    }
    public function destroy($id)
    {
        $user = DB::table('users')->where('id', $id)->delete();
        if (!$user) {
            return response()->json(['message' => 'Không tồn tại User'], 404);
        }
        return response()->json(['message' => 'Xóa thành công User'], 200);
    }
}
