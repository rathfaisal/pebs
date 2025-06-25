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
    {{-- <h1>Activities</h1> --}}

    <a href="{{ route('s.activity.create') }}" class="btn btn-primary">Create Activity</a>

    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Date</th>
                <th>Location</th>
                <th>Registered Users</th>
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
                    <a href="{{ route('s.activity.edit', $activity->id) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="{{ route('s.activity.destroy', $activity->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                    @if(Auth::user()->is_super_admin)
                        @if($activity->deleted_at)
                            <form action="{{ route('s.activity.restore', $activity->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success" data-bs-toggle="tooltip" title="Restore">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </button>
                            </form>
                        @else
                            <button type="button" class="btn btn-sm btn-secondary invisible">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </button>
                        @endif
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
