@extends('layouts.logged_in')
 
@section('title', $title)

@section('h1_title', $title)
@section('content')
[<a href="javascript:history.back()">戻る</a>]
<div class="edit_box">
    <div class="edit_image_area">
        @if($post->image !== '')
            <img class="edit_image" src="{{ asset('storage/' . $post->image) }}">
        @endif
    </div>
    <form method="post" action="{{ route('posts.update', $post) }}">
        @csrf
        @method('patch')
        <div>
            <textarea class="edit_textarea" name="contents">{{ $post->contents }}</textarea>
        </div>
        <p class="create_edit_button"><input type="submit" value="更新"></p>
    </form>
</div>
@endsection