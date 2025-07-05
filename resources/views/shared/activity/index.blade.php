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

@section('title', 'Activities')

@section('content')
    <h1>Activities</h1>

    <a href="{{ route('s.activity.create') }}" class="btn btn-primary">Create Activity</a>

    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Date</th>
                <th>Location</th>
                <th>Registered Users</th>
                <th>Gallery</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activities as $activity)
            <tr>
                <td>{{ $activity->title }}</td>
                <td>{{ $activity->description }}</td>
                <td>{{ $activity->date }}</td>
                <td>{{ $activity->location }}</td>
                <td>
                    <a href="{{ route('s.activity.registeredUsers', $activity->id) }}" class="btn btn-info btn-sm">View Registered Users</a>
                </td>
                <td>
                    <a href="{{ route('s.activity.gallery', $activity->id) }}" class="btn btn-secondary btn-sm">View Gallery</a>
                    <a href="{{ route('s.activity.gallery.add', $activity->id) }}" class="btn btn-success btn-sm">Add Image</a>
                </td>
                <td>
                    <a href="{{ route('s.activity.edit', $activity->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('s.activity.destroy', $activity->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                    @if(Auth::user()->is_super_admin && $activity->deleted_at)
                        <form action="{{ route('s.activity.restore', $activity->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">Restore</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
