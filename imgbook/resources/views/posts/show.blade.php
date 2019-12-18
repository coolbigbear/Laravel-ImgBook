@extends('layouts.app')

@section('title', 'Post details')

@section('content')

    <ul>
        <li>Title: {{ $post->title  ?? 'Untitled'}}</li>
        <li>Image: <img src="{{ asset($post->image->image) ?? 'No Image'}}"></li>
        <li>Description: {{ $post->description ?? 'No description'}}</li>
        <li>User: {{ $post->user->username ?? 'Error with retrieving user'}}</li>
    </ul>
    @if ($post->user_id == $user_id)
        <form method="POST"
            action="{{ route('posts.destroy', ['user_id' => $user_id, 'id' => $post->id]) }}">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>
        <form method="GET"
            action="{{ route('posts.edit', ['id' => $post->id]) }}">
            @csrf
            <button type="submit">Edit</button>
        </form>
    @endif
    

    <p><a href="{{ route('posts.index') }}">Back</a></p>

    <comment-component :post-id={{$post->id}} :user-id={{Auth::user()->id}}></comment-component>
@endsection