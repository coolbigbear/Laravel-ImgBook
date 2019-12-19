@extends('layouts.app')

@section('title', 'Posts')

@section('content')
<div class="row justify-content-center">
    @foreach ($posts ?? '' as $post)
    <div class=" col-md-2">

    <div class="card">
        <img src="{{ asset($post->image->image) }}" class="card-img-top">

        <div class="card-body">
            <small class="text-muted">Posted by: {{ $post->user->username }}</small>
            <h5 class="card-title">{{ $post->title }}</h5>

            <p class="card-text">{{ $post->description }}</p>
        </div>
    </div>
</div>

    @endforeach
</div>
{{ $posts ?? ''->links() }}
@endsection