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

@section('title', 'Edit Activity')

@section('content')
    <h1>Edit Activity</h1>

    <form action="{{ route('s.activity.update', $activity->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $activity->title }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" required>{{ $activity->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="datetime-local" class="form-control" id="date" name="date" value="{{ $activity->date }}" required>
        </div>
        <div class="mb-3">
            <label for="picture" class="form-label">Picture</label>
            <input type="file" class="form-control" id="picture" name="picture">
            @if($activity->picture)
                <img src="{{ asset('images/' . $activity->picture) }}" alt="Activity Picture" width="100">
            @endif
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ $activity->location }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
    @if(Auth::user()->is_super_admin && $activity->deleted_at)
        <form action="{{ route('s.activity.restore', $activity->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-success">Restore</button>
        </form>
    @endif
@endsection
