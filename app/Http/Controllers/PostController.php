<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;
use App\User;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    // ログインしていないと入れない設定
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        // ログインユーザーを読み込む
        $user = \Auth::user();
        $follow_user_ids = $user->follow_users->pluck('id');
        
        $user_posts = $user->posts()->orWhereIn('user_id', $follow_user_ids)->latest()->get();
        return view('posts.index',[
            'title' => '投稿一覧',
            'posts' => $user_posts,
            'recommend_users' => User::recommend($user->id)->get(),
        ]);
    }
    
    public function create()
    {
        return view('posts.create', [
            'title' => '新規投稿' 
        ]);
    }
    
    public function store(PostRequest $request)
    {
        $posts = Post::create([
            'user_id' => \Auth::user()->id,
            'contents' => $request->contents,
        ]);
        session()->flash('success', '投稿を追加しました！');
        
        return redirect()->route('posts.index');
    }
    
    public function show($id)
    {
        //
    }
    
    public function edit($id)
    {
        $post = Post::find($id);
        
        return view('posts.edit', [
            'title' => '投稿編集', 
            'post' => $post,
        ]);
    }
    
    public function update(PostRequest $request, $id)
    {
        $post = Post::find($id);
        $post->update($request->only(['contents']));
        
        session()->flash('success', '投稿を編集しました！');
        
        // リダイレクト
        return redirect()->route('posts.index');
    }
    
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        
        session()->flash('success', '投稿を削除しました！');
        
        // リダイレクト
        return redirect()->route('posts.index');
    }
}
