@php
    $template = null;
    $user = auth()->user();
    if ($user && $user->is_super_admin) {
        $template = 'super-admin.template';
    } elseif ($user && $user->is_admin) {
        $template = 'admin.template';
    }
@endphp

@extends($template)

@section('title', 'Edit Announcement')

@section('content')
    <div class="mb-4">
        <a href="{{ route('announcements.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Announcements
        </a>
    </div>
    <h1>Edit Announcement</h1>
    <form action="{{ route('announcements.update', $announcement->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group mt-4">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $announcement->title }}">
        </div>
        <div class="form-group mt-4">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description">{{ $announcement->description }}</textarea>
        </div>
        <div class="form-group mt-4">
            <label for="image">Image</label>
            <input type="file" class="form-control" id="image" name="image">
            @if($announcement->image_path)
                <img src="{{ asset('storage/' . $announcement->image_path) }}" alt="Announcement Image" width="500" height="200" class="img-fluid rounded mt-2">
            @endif
        </div>
        <button type="submit" class="btn btn-primary mt-4">Update</button>
    </form>

@endsection
