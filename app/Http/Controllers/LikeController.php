<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;
use App\Post;
use App\User;

class LikeController extends Controller
{
    // ログインしていないと入れない設定
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request ,$id)
    {
        $user = \Auth::user();
        
        // 検索キーワードを取得
        $keyword = $request->input('keyword');
        
        // 入力されていない状態
        $query = $user->likePosts()->orderBy('created_at', 'asc');
        
        if(!empty($keyword)) {
            $query = $user->likePosts()->orderBy('created_at', 'asc')->
                where('contents', 'like', '%' . $keyword . '%');
        }
        
        $like_posts = $query->get();
        
        return view('users.show',[
            'title' => 'プロフィール',
            'keyword' => $keyword,
            'user' => $user,
            'posts' => $like_posts,
        ]);

    }

    public function toggleLike($id){
        $user = \Auth::user();
        $post = Post::find($id);
        if($post->isLikedBy($user)){
          // いいねの取り消し
          $post->likes->where('user_id', $user->id)->first()->delete();
          \Session::flash('success', 'いいねを取り消しました。');
        } else {
          // いいねを設定
          Like::create([
              'user_id' => $user->id,
              'post_id' => $post->id,
          ]);
          \Session::flash('success', 'いいねしました！');
        }
        return redirect()->back();
    }
}
