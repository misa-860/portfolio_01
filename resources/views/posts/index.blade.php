@extends('layouts.logged_in')
 
@section('title', $title)

@section('h1_title', $title)
@section('content')
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
                <a href="{{ route('posts.edit', $post) }}">編集</a>
                <form method="post" action="{{ route('posts.destroy', $post) }}">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="削除">
                </form>
            </div>
        </div>
        @empty
            <li>投稿はありません。</li>
        @endforelse
</ul>
    </div>
@endsection