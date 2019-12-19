@extends('layouts.app')

@section('title', 'Post details')

@section('back')
<a class="btn btn-primary hBack align-right" href="{{ route('posts.index') }}">Back</a>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <img src="{{ asset($post->image->image) }}" class="card-img-top">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <small class="text-muted">Posted by: {{ $post->user->username }}</small>
                            <h5 class="card-title">{{ $post->title }}</h5>
                        </div>
                        @if ($post->user_id == Auth::user()->id)
                            <div class="col-md-auto">
                                <form method="GET"
                                    action="{{ route('posts.edit', ['id' => $post->id]) }}">
                                    @csrf
                                    <button class="btn btn-primary" type="submit">Edit</button>
                                </form>
                            </div>
                            <div class="col-md-auto">
                                <form method="POST"
                                    action="{{ route('posts.destroy', ['user_id' => Auth::user()->id, 'id' => $post->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">Delete</button>
                                </form>
                            </div>
                        @endif
                    </div>
                    <p class="card-text">{{ $post->description }}</p>
                    <comment-component :post-id={{$post->id}} :user-id={{Auth::user()->id}}></comment-component>
                </div>
            </div>
        </div>
    </div>
@endsection