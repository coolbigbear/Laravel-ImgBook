@extends('layouts.app')

@if ($update)
@section('title', 'Edit Post')
@else
@section('title', 'Create Post')
@endif

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        @if ($update)
        <div class="alert alert-warning">
            <strong>Warning!</strong>
            <br>
            To change the picture please delete the post and repost it.
        </div>
        <form method="POST" action="{{ route('posts.update', ['id' => $post->id]) }}">
            @csrf
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control" placeholder="Enter title" value="{{$post->title}}">
            </div>
            <div class="form-group">
                <label>Description</label>
                <input type="textarea" name="description" class="form-control" placeholder="Enter description"
                    value="{{$post->description}}">
            </div>
            @php
                $checked = false;
            @endphp
            @foreach($tags as $tag)
                <div class="form-check form-check-inline">
                    @foreach ($post->tags as $postTag)
                        @if ($tag->id == $postTag->id)
                            @php
                                $checked = true;
                            @endphp
                        @endif
                    @endforeach
                    <input class="form-check-input" name="checkbox[{{$tag->id}}]" type="checkbox"
                    @if ($checked) 
                        checked="checked" 
                        @php
                            $checked = false;   
                        @endphp
                    @endif>
                    <label class="form-check-label">{{ $tag->tag }}</label>
                </div>
            @endforeach
            <div>&nbsp;</div> {{-- add single space --}}
            <button type="submit" class="btn btn-primary">Update</button>
            <a class="btn btn-danger" href="{{ route('posts.show', ['id' => $post->id]) }}">Cancel</a>
            <div>&nbsp;</div> {{-- add single space --}}
            <img class="img-fluid" src="{{ asset($post->image->image) ?? 'No Image'}}"></li>
        </form>
        @else
        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control" placeholder="Enter title"
                    value="{{ old('title') }}">
            </div>
            <div class="form-group">
                <label for="exampleFormControlFile1">Attach image to your post</label>
                <input type="file" name="image" class="form-control-file" value="{{ old('image') }}">
            </div>
            <div class="form-group">
                <label>Description</label>
                <input type="textarea" name="description" class="form-control" placeholder="Enter description"
                    value="{{ old('description') }}">
            </div>
            @foreach($tags as $tag)
            <div class="form-check form-check-inline">
                <input class="form-check-input" name="checkbox[{{$tag->id}}]" type="checkbox">
                <label class="form-check-label">{{ $tag->tag }}</label>
            </div>
            @endforeach
            <hr />
            <button type="submit" class="btn btn-primary">Submit</button>
            <a class="btn btn-danger" href="{{ route('posts.index') }}">Cancel</a>
        </form>
        @endif
    </div>
</div>
@endsection