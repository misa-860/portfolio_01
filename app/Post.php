<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $fillable = ['user_id','contents'];
    
    // Userモデルとのリレーションを設定
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}