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

@section('title', 'Gallery for ' . $activity->title)

@section('content')
    <div class="mb-3">
        <a href="{{ route('s.activity.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Activities
        </a>
    </div>
    <h2 class="text-black-50">Gallery for <strong class="fs-normal text-black text-uppercase">{{ $activity->title }}</strong></h2>
    <a href="{{ route('s.activity.gallery.add', $activity->id) }}" class="btn btn-success mb-3">Add Image</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="row">
        @forelse($gallery as $image)
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top" alt="Gallery Image">
                    <form action="{{ route('s.activity.gallery.delete', [$activity->id, $image->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this image?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm mt-2">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <p>No images in the gallery yet.</p>
        @endforelse
    </div>
@endsection
