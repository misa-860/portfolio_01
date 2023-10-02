<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $fillable = ['user_id','contents', 'image'];
    
    // Userモデルとのリレーションを設定
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    // いいねのリレーション 特定の投稿にいいねしたユーザーの一覧を取得
    public function likes(){
        return $this->hasMany('App\Like');
    }
    
    public function likedUsers(){
        return $this->belongsToMany('App\User', 'likes');
    }
    
    public function isLikedBy($user){
        $liked_users_ids = $this->likedUsers->pluck('id');
        $result = $liked_users_ids->contains($user->id);
        return $result;
    }
}