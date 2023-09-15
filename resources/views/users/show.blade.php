@extends('layouts.logged_in')
 
@section('title', $title)

@section('h1_title', $title)
@section('content')
@if($user->id === Auth::user()->id)
    [<a href="{{ route('users.edit') }}">プロフィール編集</a>]
@endif
<dl>
    <dt>ユーザー名</dt>
    <dd>{{ $user->name }}</dd>
</dl>
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
                @if($user->id === Auth::user()->id)
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