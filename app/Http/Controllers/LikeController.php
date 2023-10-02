<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;
use App\Post;
use App\User;

class LikeController extends Controller
{
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
