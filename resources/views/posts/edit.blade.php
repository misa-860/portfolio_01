@extends('layouts.logged_in')
 
@section('title', $title)

@section('h1_title', $title)
@section('content')
  <form method="post" action="{{ route('posts.update', $post) }}">
    @csrf
    @method('patch')
      <div>
          <textarea name="contents">{{ $post->contents }}</textarea>
      </div>
      <p><input type="submit" value="更新" value="更新ボタン"></p>
  </form>
@endsection