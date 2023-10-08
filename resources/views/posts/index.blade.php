@extends('layouts.logged_in_not_message')
 
@section('title', $title)

@section('h1_title', $title)

@section('content')
    <div class="search_recommend_box">
        <div>
            <h1>{{ $title }}</h1>
            <form method="get" action="{{ route('posts.index') }}">
                <input type="text" name="keyword" placeholder="検索キーワードを入力" value="{{ $keyword }}">
                <input type="submit" value="検索">
            </form>
            {{-- 成功メッセージを出力 --}} 
            @if (\Session::has('success'))
                <div class="success">
                    {{ \Session::get('success') }}
                </div>
            @endif
        </div>
        <div>
            <h2>おすすめユーザー</h2>
            <ul class="recommend_users">
                @forelse($recommend_users as $recommend_user)
                    <li class="recommend_users_list">
                        <a href="{{ route('users.show', $recommend_user) }}">
                        {{ $recommend_user->name }}
                        </a>
                    </li>
                @empty
                    <li>他のユーザーが存在しません。</li>
                @endforelse
            </ul>
        </div>
    </div>
<ul>
    <div class="main_content">
        @forelse($posts as $post)
            <div class="post">
                <div class="post_header">
                    @if(!Auth::user()->isFollowing($post->user))
                       {{ $post->user->name }} {{ $post->created_at }}
                    @else
                        <a href="{{ route('users.show', $post->user->id) }}">{{ $post->user->name }}</a>
                        {{ $post->created_at }}
                    @endif
                </div>
                <div class="post_contents">
                    @if($post->image !== '' && !Auth::user()->isFollowing($post->user))
                        <img class="post_images" src="{{ asset('storage/'. $post->image) }}">
                    @else
                        <img class="post_follow_images" src="{{ asset('storage/'. $post->image) }}">
                    @endif
                    {!! nl2br(e($post->contents)) !!}
                </div>
                <div class="post_footer">
                    <a class="like_button">{{ $post->isLikedBy(Auth::user()) ? '★' : '☆' }}</a>
                    <form method="post" class="like" action="{{ route('likes.toggle_like', $post) }}">
                      @csrf
                      @method('patch')
                    </form>
                    <div class="user_link_area">
                        @if(Auth::user()->id === $post->user_id)
                            <a class="edit_button" href="{{ route('posts.edit', $post) }}">編集</a>
                            <form method="post" action="{{ route('posts.destroy', $post) }}">
                                @csrf
                                @method('DELETE')
                                <div class="delete_button">
                                    <input type="submit" value="削除">
                                </div>
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