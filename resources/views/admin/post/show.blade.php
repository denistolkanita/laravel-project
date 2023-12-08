@extends('layouts.admin')
@section('content')
    <div>
        <div>{{ $post->id }}. {{ $post->title }}</div>
        <div>{{ $post->content }}</div>
    </div>
    <div>
        <a href="{{ route('admin.post.edit', $post->id) }}">Edit</a>
    </div>
    <div>
        <a href="{{ route('admin.post.index') }}">Back</a>
    </div>
    <div>
        <form action="{{ route('admin.post.delete', $post->id) }}" method="post">
            @csrf
            @method('delete')
            <input type="submit" value="Delete" class="btn btn-danger">

        </form>
    </div>
@endsection
