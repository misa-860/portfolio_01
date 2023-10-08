@extends('layouts.logged_in')
 
@section('title', $title)

@section('h1_title', $title)
@section('content')
    <dl class="profile_box">
        <div>
            <dd>
                @if($user->image !== '')
                    <img class="user_image" src="{{ asset('storage/'. $user->image) }}">
                @else
                    <img class="user_image" src="{{ asset('images/no_image.png') }}">
                @endif
            </dd>
        </div>
        <div class="profile_box2">
            <div class="userid_edit_area">
                <div>ユーザーID:{{ $user->name }}</div>
                <div>
                    @if($user->id === Auth::user()->id)
                        [<a href="{{ route('users.edit') }}">プロフィール編集</a>]
                    @endif
                    <!--自分以外のユーザーのフォローボタン表示-->
                    @if($user->id !== Auth::user()->id)
                        @if(Auth::user()->isFollowing($user))
                            <form class="follow_delete_button" method="post" action="{{ route('follows.destroy', $user) }}">
                                @csrf
                                @method('delete')
                                <input type="submit" value="フォロー解除">
                            </form> 
                        @else
                            <form class="follow_button" method="post" action="{{ route('follows.store') }}">
                                @csrf
                                <input type="hidden" name="follow_id" value="{{ $user->id }}">
                                <input type="submit" value="フォローする">
                            </form>
                        @endif
                    @endif
                </div>
            </div>
            <dt>自己紹介</dt>
            @if(mb_ereg_replace('\s', '', $user->profile) !== '')
                <dd>{!! nl2br(e($user->profile)) !!}</dd>
            @else
                <dd>プロフィールが設定されていません。</dd>
            @endif
        </div>
    </dl>

<h2>{{ $user->name }}の{{ Request::is('likes*') ? 'いいね' : '投稿' }}一覧</h2>
<div class="profile_search_box">
    <div>
        <form method="get" action="{{ Request::is('likes*') ? route('likes.show', $user) : route('users.show', $user) }}">
            <input type="text" name="keyword" placeholder="{{ Request::is('likes*') ? 'いいね一覧から検索' : '投稿一覧から検索'}}" value="{{ $keyword }}">
            {{--value="{{ $keyword }}"--}}
            <input type="submit" value="検索">
        </form>
    </div>
    <div>
        @if($user->id === Auth::user()->id)
            <div class="user_activity_section">
                <form class="user_activity_button" method="get" action="{{ route('users.show', $user) }}">
                    <input type="submit" value="投稿一覧"></input>
                </form>
                <form class="user_activity_button2" method="get" action="{{ route('likes.show', $user) }}">
                    <input type="submit" value="いいね一覧"></input>
                </form>
            </div>
        @endif
    </div>
</div>

<ul class="main_content">
    @forelse($posts as $post)
        <li class="post">
                <div class="post_header">
                    @if($post->user->name === Auth::user()->name)
                        {{ $post->user->name }} {{ $post->created_at }} 
                    @else
                        <a href="{{ route('users.show', $post->user->id) }}">{{ $post->user->name }}</a>
                        {{ $post->created_at }}
                    @endif
                </div>
                <div class="post_contents">
                    @if($post->image !== '')
                        <img class="{{ Request::is('users*') ? 'post_images' : 'post_images_like' }}" src="{{ asset('storage/'. $post->image) }}">
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
        </li>
    @empty
        <li>{{ Request::is('likes*') ? 'いいねした投稿はありません。' : '投稿はありません。' }}</li>
    @endforelse
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