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
    <h1>Announcements</h1>
    <a href="{{ route('announcements.create') }}" class="btn btn-primary mt-4">Add Announcement</a>

    <div class="table-responsive mt-4">
        <table class="table border-0 table-hover mb-0 bg-white">
            <thead class="table-light">
                <tr>
                    <th class="w-[20%] text-left border-0">Title</th>
                    <th class="w-[45%] text-left border-0">Description</th>
                    <th class="w-[27%] text-center border-0">Image</th>
                    <th class="w-[8%] text-center border-0">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($announcements as $announcement)
                    <tr>
                        <td class="border-0" style="width: 20%;">{{ $announcement->title }}</td>
                        <td class="border-0" style="width: 45%;">{{ $announcement->description }}</td>
                        {{-- image --}}
                        <td class="border-0" style="width: 27%;">
                            <div class="d-flex gap-1 align-items-center justify-content-center">
                                @if($announcement->image_path)
                                    <img src="{{ asset('storage/' . $announcement->image_path) }}" alt="Announcement Image" width="100" height="100" class="img-fluid rounded">
                                @endif
                            </div>   
                        </td>
                        {{-- actions --}}
                        <td class="border-0" style="width: 8%;">
                            <div class="d-flex gap-1 align-items-center justify-content-center">
                                <a href="{{ route('announcements.edit', $announcement->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('announcements.destroy', $announcement->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this announcement?')" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('link')
<style>
    @media (max-width: 991.98px) {
        .img-fluid {
            max-width: 80px;
            max-height: 80px;
        }
    }
    
    @media (max-width: 767.98px) {
        .img-fluid {
            max-width: 50px;
            max-height: 50px;
        }
    }
</style>
@endsection
