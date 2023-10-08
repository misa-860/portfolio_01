@extends('layouts.default_not_message')

@section('header')
    <header>
        <ul class="header_nav_login">
            <div>
                <li class="header_title" >
                    <a href="{{ route('posts.index') }}">
                        グルメTREE
                    </a>
                </li>
            </div>
            <div class="header_nav_right">
                <li class="header_link">
                    <a href="{{ route('posts.create') }}">
                        新規投稿
                    </a>
                </li>
                <li class="header_link">
                    <a href="{{ route('users.show', Auth::user()) }}">
                    プロフィール
                    </a>
                </li>
                <li class="header_link">
                    <a href="{{ route('follows.index') }}">フォロー</a>
                </li>
                <li>
                    <form method="post" action="{{ route('logout') }}" class="logout">
                        @csrf
                        <div class="heder_logout_link">
                            <input  type="submit" value="ログアウト">
                        </div>
                    </form>
                </li>
            </div>
        </ul>
    </header>

@endsection