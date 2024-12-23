@extends('posts.layout')

@section('content')
    <h1>Create New Post</h1>
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>

        <div class="form-group">
            <label for="images" class="form-label">Upload Images</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple>
        </div>

        <button type="submit" class="btn btn-primary">Create Post</button>
    </form>

@endsection
