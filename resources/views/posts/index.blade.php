@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Posts</h1>
    <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">Add New Post</a>
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Images</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->description }}</td>
                    <td>
                        @if ($post->images)
                            @foreach ($post->images as $image)
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Image" style="width: 100px; height: 100px;">
                            @endforeach


                        @else
                            <p>No images available</p>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
