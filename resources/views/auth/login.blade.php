@extends('layouts.not_logged_in')

@section('title', 'ログイン')
@section('content')
    <main>
        <h1 class="auth_h1">ログイン</h1>
        <div class="auth_error">
            {{-- エラーメッセージを出力 --}}
            @foreach($errors->all() as $error)
              <p class="error">{{ $error }}</p>
            @endforeach
        </div>
        <div class="auth_content">
            <form method="post" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label>
                        ユーザーID:
                        <div class="auth_form">
                            <input type="text" name="name">
                        </div>
                    </label>
                </div>
                
                <div class="form-group">
                    <label>
                        パスワード:
                        <div class="auth_form">
                            <input type="password" name="password">
                        </div>
                    </label>
                </div>
                
                <div class="auth_submit">
                    <input type="submit" value="ログイン">
                </div>
            </form>
        </div>
    </main>
@endsection