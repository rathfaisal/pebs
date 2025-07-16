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
    <div class="mb-4">
        <a href="{{ route('s.activity.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Activities
        </a>
    </div>
    <h2 class="text-black-50">Add Image to Gallery for <strong class="fs-normal text-black text-uppercase">{{ $activity->title }}</strong></h2>
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
        <div class="form-group mb-4">
            <label for="images">Images</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple required>
        </div>
        <button type="submit" class="btn btn-primary mt-4">Upload</button>
    </form>
@endsection
