<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Follow;
use App\User;

class FollowController extends Controller
{
    public function index(Request $request)
    {
        $follow_users = \Auth::user()->follow_users;
        $user = \Auth::user();
        
        //検索キーワードを取得
        $keyword = $request->input('keyword');

        $search_users = '';
        // キーワードが入力された場合、検索条件を追加
        if (!empty($keyword)) {
            $search_users = User::where('id', '!=', $user->id)
                ->where('name', 'like', $keyword . '%')->latest()->limit(3)->get();
        }
    
        return view('follows.index', [
           'title' => 'ユーザー検索',
           'follow_users' => $follow_users,
           'search_users' => $search_users,
           'keyword' => $keyword,
        ]); 
    }
    
    public function store(Request $request)
    {
        $user = \Auth::user();
        Follow::create([
           'user_id' => $user->id,
           'follow_id' => $request->follow_id,
        ]);
        \Session::flash('success', 'フォローしました');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $follow = \Auth::user()->follows->where('follow_id', $id)->first();
        $follow->delete();
        \Session::flash('success', 'フォローを解除しました');
        
        return redirect()->back();
    }
}
