@extends('layouts.app')

@section('title', 'Posts')

@section('content')
    @auth
        <a href="{{ route('posts.create') }}">Create a post</a>
    @endauth
    <ul>
        @foreach ($posts ?? '' as $post)
            <li><a href="{{ route('posts.show', ['id' => $post->id])}}">{{$post ->title}}</a></li>
        @endforeach
    </ul>
    {{ $posts ?? ''->links() }}
@endsection