<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JWTAuth;
use JWTAuthException;
use Hash;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;

class UserController extends Controller
{   
    public $module;

    public function __construct(){
    }
   
    public function register(Request $request){
        $user = User::create([
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
                return response()->json(['invalid_email_or_password'], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        } catch (JWTAuthException $e) {
            return response()->json(['failed_to_create_token'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(compact('token'));
    }

    public function userInfo(Request $request){
        $user = JWTAuth::toUser($request->token);
        return response()->json(['result' => $user]);
    }

    public function index()
    {
        $users = User::all();
        $template = 'user.index';
        return response()->json(['data' => $users], Response::HTTP_OK);
    }
    
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Không tồn tại User'], Response::HTTP_BAD_REQUEST);
        }
        return response()->json(['data' => $user], Response::HTTP_OK);
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
        return response()->json(['message' => 'Tạo mới thành công User'], Response::HTTP_OK);
    }
    
    public function update(StoreUserRequest $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Không tồn tại User'], Response::HTTP_BAD_REQUEST);
        }
        $update = User::where('id', $id)->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => bcrypt($request->input('password')),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        
        return response()->json(['message' => 'Cập nhật thành công User'], Response::HTTP_OK);
    }
    
    public function destroy($id)
    {  
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Không tồn tại User'], Response::HTTP_BAD_REQUEST);
        }
        else{
            $deleted = User::destroy($id);
            if ($deleted) {
                return response()->json(['message' => 'Xóa thành công User'], Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'Không tồn tại User'], Response::HTTP_BAD_REQUEST);
            }
        }
    }
}  