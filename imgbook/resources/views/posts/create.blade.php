@extends('layouts.app')

@if ($update)
    @section('title', 'Edit Post')
@else
    @section('title', 'Create Post')   
@endif

@section('content')
    @if ($update)
        <form method="POST" action="{{ route('posts.update', ['id' => $post->id]) }}">
            @csrf
            <p>Title: <input type="text" name="title" 
                value="{{$post->title}}"></p>
            <p>Description: <input type="text" name="description" 
                value="{{$post->description}}"></p>
            <input type="submit" value="Update">
            <a href="{{ route('posts.show', ['id' => $post->id]) }}">Cancel</a>
            <br>
            <img src="{{ asset($post->image->image) ?? 'No Image'}}"></li>
        </form>
    @else
        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf
            <p>Title: <input type="text" name="title" 
                value="{{ old('title') }}"></p>
            <input type="file" name="image">
            <p>Description: <input type="text" name="description" 
                value="{{ old('description') }}"></p>
            <input type="submit" value="Submit">
            <a href="{{ route('posts.index') }}">Cancel</a>
        </form>
    @endif
@endsection