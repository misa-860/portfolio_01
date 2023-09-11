<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    // ログインしていないと入れない設定
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function show($id)
    {
        $user = User::find($id);
        
        return view('users.show', [
            'title' => 'ユーザー詳細', 
            'user' => $user,
        ]);
    }
}
