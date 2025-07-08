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

@section('title', 'Announcement')

@section('content')
    <div class="container">
        <h1>Announcements</h1>
        <a href="{{ route('announcements.create') }}" class="btn btn-primary">Add Announcement</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($announcements as $announcement)
                    <tr>
                        <td>{{ $announcement->title }}</td>
                        <td>{{ $announcement->description }}</td>
                        <td>
                            @if($announcement->image_path)
                                <img src="{{ asset('storage/' . $announcement->image_path) }}" alt="Announcement Image" width="100">
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('announcements.edit', $announcement->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('announcements.destroy', $announcement->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this announcement?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
