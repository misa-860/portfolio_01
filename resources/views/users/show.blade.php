@extends('layouts.logged_in')
 
@section('title', $title)

@section('h1_title', $title)
@section('content')
    <div>ユーザー名:{{ $user->name }}</div>
    <dl>
        <dt>プロフィール画像</dt>
        <dd>
            @if($user->image !== '')
                <img class="user_image" src="{{ asset('storage/'. $user->image) }}">
            @else
                <img class="user_image" src="{{ asset('images/no_image.png') }}">
            @endif
        </dd>
        <dt>自己紹介</dt>
        @if($user->profile !== '')
            <dd>{{ $user->profile }}</dd>
        @else
            <dd>プロフィールが設定されていません。</dd>
        @endif
    </dl>
@if($user->id === Auth::user()->id)
    [<a href="{{ route('users.edit') }}">プロフィール編集</a>]
@endif
<!--自分以外のユーザーのフォローボタン表示-->
@if($user->id !== Auth::user()->id)
    @if(Auth::user()->isFollowing($user))
        <form method="post" action="{{ route('follows.destroy', $user) }}">
            @csrf
            @method('delete')
            <input type="submit" value="フォロー解除">
        </form> 
    @else
        <form method="post" action="{{ route('follows.store') }}">
            @csrf
            <input type="hidden" name="follow_id" value="{{ $user->id }}">
            <input type="submit" value="フォローする">
        </form>
    @endif
@endif

<h2>{{ $user->name }}の投稿一覧</h2>
<ul>
    <li>
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
    </li>
    @empty
        <li>投稿はありません。</li>
    @endforelse
</ul>
    </div>
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