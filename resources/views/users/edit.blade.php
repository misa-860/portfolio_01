@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
    <h1>{{ $title }}</h1>
    [<a href="{{ route('users.show', Auth::user()) }}">戻る</a>]
    <form method="post" action="{{ route('users.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <dl>
            <label>
                <dt>ユーザーID</dt>
                <dd><input type="text" name="name" value="{{ $current_user->name }}"></dd>
            </label>
            <label> 
                <dt>プロフィール:</dt>
                <dd><textarea name="profile">{{ $current_user->profile }}</textarea></dd>
            </label>
            <label>
                <dt>プロフィール画像:</dt>
                <dd><input type="file" name="image"></dd>
            </label>
        </dl>
        <p><input type="submit" value="更新"></p>
    </form>
@endsection