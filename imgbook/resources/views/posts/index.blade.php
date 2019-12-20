@extends('layouts.app')

@section('title', 'Posts')
@section('back')
<small class="text-muted">Logged in as: {{ Auth::user()->username }}</small>
@endsection
@section('content')
<div class="row justify-content-center">
    <div class=" col-md-8">
        <div class="card-columns">
            @foreach ($posts ?? '' as $post)
            <div class="card">
                <img src="{{ asset($post->image->image) }}" class="card-img-top">

                <div class="card-body">
                    <small class="text-muted">Posted by: {{ $post->user->username }}</small>
                    <h5 class="card-title">{{ $post->title }}</h5>

                    <p class="card-text">{{ $post->description }}</p>
                </div>
                <div class="card-footer">
                    <small class="text-muted">Posted at: {{ $post->created_at }}</small>
                </div>
                <a href="{{ route('posts.show', ['id' => $post->id]) }}" class="stretched-link"></a>
            </div>
            @endforeach
        </div>
    </div>
</div>
<div class="row justify-content-center">
    {{ $posts ?? ''->links() }}
</div>
@endsection