@extends('layouts.default')

@section('header')
    <header>
        <ul class="header_nav_login">
            <div>
                <li>
                    <a href="{{ route('posts.index') }}">
                        グルメblog
                    </a>
                </li>
            </div>
            <div class="header_nav_right">
                <li>
                    <a href="{{ route('posts.create') }}">
                        新規投稿
                    </a>
                </li>
                <li>
                    <a href="{{ route('users.show', Auth::user()) }}">
                    プロフィール
                    </a>
                </li>
                <li>
                    <form method="post" action="{{ route('logout') }}" class="logout">
                        @csrf
                        <input type="submit" value="ログアウト">
                    </form>
                </li>
            </div>
        </ul>
    </header>

@endsection