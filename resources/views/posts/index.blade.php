@extends('layouts.logged_in')
 
@section('title', $title)

@section('h1_title', $title)

@section('content')
<form method="get" action="{{ route('posts.index') }}">
    <input type="text" name="keyword" placeholder="検索キーワードを入力" value="{{ $keyword }}">
    <input type="submit" value="検索">
</form>
<h2>おすすめユーザー</h2>
<ul class="recommend_users">
    @forelse($recommend_users as $recommend_user)
        <li>
            <a href="{{ route('users.show', $recommend_user) }}">
            {{ $recommend_user->name }}
            </a>
        </li>
    @empty
        <li>他のユーザーが存在しません。</li>
    @endforelse
</ul>
<ul>
    <div class="main_content">
        @forelse($posts as $post)
        <div class="post">
            <div class="post_header">
               {{ $post->user->name }} {{ $post->created_at }} 
            </div>
            <div class="post_contents">
                {!! nl2br(e($post->contents)) !!}
            </div>
            <div class="post_footer">
                @if(Auth::user()->id === $post->user_id)
                    <a href="{{ route('posts.edit', $post) }}">編集</a>
                    <form method="post" action="{{ route('posts.destroy', $post) }}">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="削除">
                    </form>
                @endif
            </div>
        </div>
        @empty
            <li>投稿はありません。</li>
        @endforelse
</ul>
    </div>
@endsection