<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Helpers\Helper;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public $module;

    public function __construct(){

    }

    public function index()
    {
        $users = [
            [
                'id' => 1,
                'name' => 'doanh1',
                'email' => 'user1@gmail.com',
                'phone' => '0912345678'
            ],
            [
                'id' => 2,
                'name' => 'doanh2',
                'email' => 'user2@gmail.com',
                'phone' => '0912345678'
            ],
            [
                'id' => 3,
                'name' => 'doanh3',
                'email' => 'user3@gmail.com',
                'phone' => '0912345678'
            ],
        ];
        $template = 'user.index';
        return view('dashboard.layout.home', compact('template', 'users'));
    }
    public function edit($id)
    {
        $users = [
            [
                'id' => 1,
                'name' => 'doanh1',
                'email' => 'user1@gmail.com',
                'phone' => '0912345678'
            ],
            [
                'id' => 2,
                'name' => 'doanh2',
                'email' => 'user2@gmail.com',
                'phone' => '0912345678'
            ],
            [
                'id' => 3,
                'name' => 'doanh3',
                'email' => 'user3@gmail.com',
                'phone' => '0912345678'
            ],
        ];
        foreach ($users as $key => $val) {
            if($val['id'] == $id){
                $users = $users[$key];
            }
        }
        $template = 'user.edit';
        return view('dashboard.layout.home', compact('template', 'users'));
    }

    
}
