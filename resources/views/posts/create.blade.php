@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('h1_title', $title)
@section('content')
    <div class="create_box">
        <form method="post" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf
            <label>
                画像:<input type="file" name="image">
            </label>
            <div>
                <textarea class="create_textarea" name="contents"></textarea>
            </div>
            <p class="create_edit_button"><input type="submit" value="投稿" value="投稿ボタン"></p>
        </form>
  </div>
@endsection