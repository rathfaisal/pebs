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

@section('title', 'Add Image to Gallery for ' . $activity->title)

@section('content')
    <h1>Add Image to Gallery for {{ $activity->title }}</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('s.activity.gallery.store', $activity->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-3">
            <label for="images">Images</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
        <a href="{{ route('s.activity.gallery', $activity->id) }}" class="btn btn-secondary">Back to Gallery</a>
    </form>
@endsection
