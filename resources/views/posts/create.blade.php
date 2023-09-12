@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('h1_title', $title)
@section('content')
  <form method="post" action="{{ route('posts.store') }}">
      @csrf
      <div>
          <textarea name="contents"></textarea>
      </div>
      <p><input type="submit" value="投稿" value="投稿ボタン"></p>
  </form>
@endsection