@extends('layouts.logged_in')
 
@section('title', $title)

@section('h1_title', $title)
@section('content')
<a href="javascript:history.back()">戻る</a>
  <form method="post" action="{{ route('posts.update', $post) }}">
    @csrf
    @method('patch')
      <div>
          <textarea name="contents">{{ $post->contents }}</textarea>
      </div>
      <p><input type="submit" value="更新"></p>
  </form>
@endsection