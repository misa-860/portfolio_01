<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    // ログインしていないと入れない設定
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function show(Request $request, $id)
    {
        $user = User::find($id);
        
        //検索キーワードを取得
        $keyword = $request->input('keyword');
        
        //入力されていない状態
        $query = Post::where('user_id', $user->id);
        
        // キーワードが入力された場合、検索条件を追加
        if (!empty($keyword)) {
            $query = Post::where('user_id', $user->id)->where('contents', 'like', '%' . $keyword . '%');
        }

        $posts = $query->latest()->get();
        
        return view('users.show', [
            'title' => 'プロフィール', 
            'keyword' => $keyword,
            'user' => $user,
            'posts' => $posts,
        ]);
    }
    
    public function edit()
    {
        $current_user = \Auth::user();
        
        return view('users.edit', [
            'title' => 'プロフィール編集',
            'current_user' => $current_user,
        ]);
    }
    
    public function update(UserRequest $request)
    {
        $user = \Auth::user();
        $user->update($request->only(['name','profile']));
        
        $path = '';
        $image = $request->file('image');
        
        if ($image) {
            // 新しいプロフィール画像がアップロードされた場合の処理
            $path = $image->store('photos', 'public');
    
            if ($user->image !== '') {
                \Storage::disk('public')->delete($user->image);
            }
    
            $user->update([
                'image' => $path, // 新しいファイルを保存
            ]);
        } else {
            // 新しい画像がアップロードされなかった場合、何もしない
        }
        
        session()->flash('success', 'プロフィールを更新しました！');
        return redirect()->route('users.show', $user);
    }
}
