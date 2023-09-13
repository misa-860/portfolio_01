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
    
    public function index(Request $request)
    {
        // ログインユーザーを読み込む
        $user = \Auth::user();
        $follow_user_ids = $user->follow_users->pluck('id');
        
        //検索キーワードを取得
        $keyword = $request->input('keyword');
        
        //入力されていない状態
        $query = $user->posts()->orWhereIn('user_id', $follow_user_ids);

        // キーワードが入力された場合、検索条件を追加
        if (!empty($keyword)) {
            $query = Post::where('user_id', '!=', $user->id)->where('contents', 'like', '%' . $keyword . '%');
        }
        
        $user_posts = $query->latest()->get();
        
        return view('posts.index', [
            'title' => '投稿一覧',
            'posts' => $user_posts,
            'keyword' => $keyword,
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
