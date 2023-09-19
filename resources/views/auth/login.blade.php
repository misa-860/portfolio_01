@extends('layouts.not_logged_in')

@section('h1_title', 'ログイン')
@section('content')
    <main>
        <div class="auth_content">

            <form method="post" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label>
                        <div class="auth-form">
                        ユーザー名:
                            <input type="text" name="name">
                        </div>
                    </label>
                </div>
                
                <div class="form-group">
                    <label>
                        <div class="auth-form">
                        パスワード:
                            <input type="password" name="password">
                        </div>
                    </label>
                </div>
                
                <div class="auth-submit">
                    <input type="submit" value="ログイン">
                </div>
            </form>
        </div>
    </main>
@endsection