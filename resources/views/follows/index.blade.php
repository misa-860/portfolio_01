@extends('layouts.logged_in_not_message')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>
    <form  class="search_user" method="get" action="{{ route('follows.index') }}">
        <input type="text" name="keyword" placeholder="ユーザーを探す" value="{{ $keyword }}">
        <input type="submit" value="検索">
    </form>
    {{-- 成功メッセージを出力 --}} 
    @if (\Session::has('success'))
        <div class="success">
            {{ \Session::get('success') }}
        </div>
    @endif
    <ul class="search_user_area">
        @if($search_users != '')
            @forelse($search_users as $search_user)
                <li>
                    @if($search_user->image !== '')
                        <img class="user_image" src="{{ asset('storage/' . $search_user->image) }}">
                    @else
                        <img class="user_image" src="{{ asset('images/no_image.png') }}">
                    @endif
                    <a href="{{ route('users.show', $search_user) }}">{{ $search_user->name }}</a>
                    @if(!$follow_users->contains('id', $search_user->id))
                        <form class="follow_button" method="post" action="{{ route('follows.store') }}">
                            @csrf
                            <input type="hidden" name="follow_id" value="{{ $search_user->id }}">
                            <input type="submit" value="フォローする">
                        </form>
                    @else
                        @foreach($follow_users as $follow_user)
                            @if($follow_user->id === $search_user->id)
                                <form class="follow_delete_button" method="post" action="{{ route('follows.destroy', $follow_user) }}" class="follow">
                                    @csrf
                                    @method('delete')
                                    <input type="submit" value="フォロー解除">
                                </form>
                            @endif
                        @endforeach
                    @endif
                </li>
            @empty
                <li>該当のユーザーはいません。</li>
            @endforelse
        @endif
    </ul>
    <h2>フォローユーザー</h2>
    <ul class="follow_users">
        @forelse($follow_users as $follow_user)
            <li>
                @if($follow_user->image !== '')
                <img class="user_image" src="{{ asset('storage/' . $follow_user->image) }}">
                @else
                <img class="user_image" src="{{ asset('images/no_image.png') }}">
                @endif
                <a href="{{ route('users.show', $follow_user) }}">
                    {{ $follow_user->name }}
                </a>
                <form class="follow_delete_button" method="post" action="{{route('follows.destroy', $follow_user)}}" class="follow">
                    @csrf
                    @method('delete')
                    <input type="submit" value="フォロー解除">
                </form>
            </li>
        @empty
            <li>
                フォローしているユーザーはいません。
            </li>
        @endforelse
    </ul>
@endsection
