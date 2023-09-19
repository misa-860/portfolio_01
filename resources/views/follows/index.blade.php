@extends('layouts.logged_in')

@section('title', $title)

@section('h1_title', $title)
@section('content')
    <form method="get" action="{{ route('follows.index') }}">
        <input type="text" name="keyword" placeholder="ユーザーを探す" value="{{ $keyword }}">
        <input type="submit" value="検索">
    </form>
    <ul>
        @if($search_users != '')
            @forelse($search_users as $search_user)
                <li>
                    <a href="{{ route('users.show', $search_user) }}">
                        {{ $search_user->name }}
                    </a>
                    
                @if(!$follow_users->contains('id', $search_user->id))
                    <form method="post" action="{{ route('follows.store') }}">
                        @csrf
                        <input type="hidden" name="follow_id" value="{{ $search_user->id }}">
                        <input type="submit" value="フォローする">
                    </form>
                @else
                    @foreach($follow_users as $follow_user)
                        @if($follow_user->id === $search_user->id)
                            <form method="post" action="{{ route('follows.destroy', $follow_user) }}" class="follow">
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
    @forelse($follow_users as $follow_user)
        <ul class="follow_users">
            <li>
                @if($follow_user->image !== '')
                <img class="user_image" src="{{ asset('storage/' . $follow_user->image) }}">
                @else
                <img class="user_image" src="{{ asset('images/no_image.png') }}">
                @endif
                <a href="{{ route('users.show', $follow_user) }}">
                    {{ $follow_user->name }}
                </a>
                <form method="post" action="{{route('follows.destroy', $follow_user)}}" class="follow">
                    @csrf
                    @method('delete')
                    <input type="submit" value="フォロー解除">
                </form>
            </li>
        </ul>
    @empty
        <li>
            フォローしているユーザーはいません。
        </li>
    @endforelse
@endsection
