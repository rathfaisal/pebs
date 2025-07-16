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

@section('title', 'Add Announcement')

@section('content')
    <div class="mb-4">
        <a href="{{ route('announcements.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Announcements
        </a>
    </div>
    <h1>Add Announcement</h1>
    <form action="{{ route('announcements.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group mt-4">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group mt-4">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <div class="form-group mt-4">
            <label for="image">Image</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>
        <button type="submit" class="btn btn-primary mt-4">Create</button>
    </form>
@endsection
