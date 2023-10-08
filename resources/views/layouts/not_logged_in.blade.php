@extends('layouts.default_not_message')

@section('header')
    <header>
        <ul class="header_nav">
            <li class="header_link">
                <a href="{{ route('register') }}">
                    ユーザー登録
                </a>
            </li>
            <li class="header_link">
                <a href="{{ route('login') }}">
                    ログイン
                </a>
            </li>
        </ul>
    </header>
@endsection