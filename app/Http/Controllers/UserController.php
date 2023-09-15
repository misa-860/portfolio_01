<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;

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
        $posts = Post::where('user_id', $user->id)->latest()->get();
        
        return view('users.show', [
            'title' => 'プロフィール', 
            'user' => $user,
            'posts' => $posts,
        ]);
    }
}
