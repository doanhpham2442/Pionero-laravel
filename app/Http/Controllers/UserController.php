<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use JWTAuth;
use JWTAuthException;
use Hash;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{   
    public $module;

    public function __construct(){
    }
   
    public function register(Request $request){
        $user = DB::table('users')->insert([
          'name' => $request->get('name'),
          'email' => $request->get('email'),
          'password' => Hash::make($request->get('password')),
        ]);

        return response()->json([
            'status'=> 200,
            'message'=> 'User created successfully',
            'data'=>$user
        ]);
    }
    
    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        $token = null;
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['invalid_email_or_password'], 422);
            }
        } catch (JWTAuthException $e) {
            return response()->json(['failed_to_create_token'], 500);
        }
        return response()->json(compact('token'));
    }

    public function userInfo(Request $request){
        $user = JWTAuth::toUser($request->token);
        return response()->json(['result' => $user]);
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
            return response()->json(['message' => 'Không tồn tại User'], 404);
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
