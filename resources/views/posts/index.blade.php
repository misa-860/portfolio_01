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
                @if($post->image !== '')
                    <img class="post_images" src="{{ asset('storage/'. $post->image) }}">
                @endif
                {!! nl2br(e($post->contents)) !!}
            </div>
            <div class="post_footer">
                <a class="like_button">{{ $post->isLikedBy(Auth::user()) ? '★' : '☆' }}</a>
                <form method="post" class="like" action="{{ route('posts.toggle_like', $post) }}">
                  @csrf
                  @method('patch')
                </form>
                <div class="user_link_area">
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
        </div>
        @empty
            <li>投稿はありません。</li>
        @endforelse
    </div>
</ul>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
      /* global $ */
      $('.like_button').each(function(){
        $(this).on('click', function(){
          $(this).next().submit();
        });
      });
    </script>
@endsection