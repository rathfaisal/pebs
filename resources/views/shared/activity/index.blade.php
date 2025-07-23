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

    <a href="{{ route('s.activity.create') }}" class="btn btn-primary mt-4">Create Activity</a>

    <div class="table-responsive mt-4">
        <table class="table border-0 table-hover mb-0 bg-white">
            <thead class="table-light">
                <tr>
                    <th class="w-[20%] text-left border-0">Title</th>
                    <th class="w-[12%] text-left border-0">Date & Time</th>
                    <th class="w-[15%] text-left border-0">Location</th>
                    <th class="w-[18%] text-left border-0">Description</th>
                    <th class="w-[13%] text-center border-0">Registered Users</th>
                    <th class="w-[14%] text-center border-0">Gallery</th>
                    <th class="w-[8%] text-center border-0">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activities as $activity)
                <tr>
                    <td class="border-0" style="width: 20%;">{{ $activity->title }}</td>
                    <td class="border-0" style="width: 12%;">{{ $activity->date }}</td>
                    <td class="border-0" style="width: 15%;">{{ $activity->location }}</td>
                    <td class="border-0" style="width: 18%;">{{ $activity->description }}</td>
                    {{-- registered users --}}
                    <td class="border-0" style="width: 13%;">
                        <div class="d-flex gap-2 align-items-center justify-content-center">
                            <span class="badge bg-primary">{{ $activity->users->count() }}</span>

                            <a href="{{ route('s.activity.registeredUsers', $activity->id) }}" class="btn btn-info btn-sm" title="View Registered Users">
                                <i class="bi bi-people"></i> View Details
                            </a>
                        </div>
                    </td>
                    {{-- gallery --}}
                    <td class="border-0" style="width: 14%;">
                        <div class="d-flex gap-1 align-items-center justify-content-center">
                            <a href="{{ route('s.activity.gallery', $activity->id) }}" class="btn btn-secondary btn-sm" title="View Gallery">
                                <i class="bi bi-images"></i> View More
                            </a>
                            <a href="{{ route('s.activity.gallery.add', $activity->id) }}" class="btn btn-success btn-sm" title="Add Image">
                                <i class="bi bi-plus-square"></i>
                            </a>
                        </div>
                        {{-- <div class="d-flex gap-1 align-items-center justify-content-center">
                            
                        </div> --}}
                    </td>
                    {{-- actions --}}
                    <td class="border-0" style="width: 8%;">
                        <div class="d-flex gap-1 align-items-center justify-content-center">
                            <a href="{{ route('s.activity.edit', $activity->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('s.activity.destroy', $activity->id) }}" method="POST" class="m-0 p-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @if(Auth::user()->is_super_admin && $activity->deleted_at)
                                <form action="{{ route('s.activity.restore', $activity->id) }}" method="POST" class="m-0 p-0">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" title="Restore">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
