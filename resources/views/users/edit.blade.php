@extends('layouts.logged_in')
 
@section('title', $title)

@section('h1_title', $title)
@section('content')
    [<a href="{{ route('users.show', Auth::user()) }}">戻る</a>]
    <div class="user_edit_box">
        <form method="post" action="{{ route('users.update') }}" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <dl>
                <label>
                    <dt class="user_edit_dt">ユーザーID:</dt>
                    <dd><input type="text" name="name" value="{{ $current_user->name }}"></dd>
                </label>
                <label> 
                    <dt class="user_edit_dt">プロフィール:</dt>
                    <dd><textarea name="profile" class="user_edit_textarea">{{ $current_user->profile }}</textarea></dd>
                </label>
                <label>
                    <dt class="user_edit_dt">プロフィール画像:</dt>
                    <dd>
                        @if($current_user->image !== '')
                            <img class="user_image" src="{{ asset('storage/' . $current_user->image) }}">
                        @else
                            <img class="user_image" src="{{ asset('images/no_image.png') }}">
                        @endif
                    </dd>
                    <dt class="user_edit_dt">
                        <input type="file" name="image">
                    </dt>
                </label>
            </dl>
            <p class="create_edit_button"><input type="submit" value="更新"></p>
        </form>
    </div>
@endsection