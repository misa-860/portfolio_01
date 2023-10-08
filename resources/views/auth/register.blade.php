@extends('layouts.not_logged_in')

@section('title', 'ユーザー作成')
@section('content')
    <h1 class="auth_h1">ユーザー作成</h1>
    <div class="auth_error">
        {{-- エラーメッセージを出力 --}}
        @foreach($errors->all() as $error)
          <p class="error">{{ $error }}</p>
        @endforeach
    </div>
    <div class="auth_content">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div>
              <label>
                ユーザーID:
                <div class="auth_form">
                    <input type="text" name="name">
                </div>
              </label>
            </div>
            
            <div>
              <label>
                パスワード:
                <div class="auth_form">
                    <input type="password" name="password">
                </div>
              </label>
            </div>
            
            <div>
              <label>
                パスワード（確認用）:
                <div class="auth_form">
                    <input type="password" name="password_confirmation" >
                </div>
              </label>
            </div>
            
            <div class="auth_submit">
              <input type="submit" value="登録">
            </div>
        </form>
    </div>
@endsection