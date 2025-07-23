@extends('super-admin.template')

@section('title', 'Admin CRUD')

@section('link')

@endsection

@section('content')
    <h1>Admin CRUD Page</h1>

    <a href="{{ route('sa.admin.create') }}" class="btn btn-primary mt-4">Add New Admin</a>

    <div class="table-responsive mt-4">
        <table class="table border-0 table-hover mb-0 bg-white">
            <thead class="table-light">
                <tr>
                    <th class="w-[15%] border-0">Name</th>
                    <th class="w-[15%] border-0">Email</th>
                    <th class="w-[60%] border-0"></th>
                    <th class="w-[10%] border-0 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $admin)
                <tr>
                    <td class="border-0" style="width: 15%;">{{ $admin->name }}</td>
                    <td class="border-0" style="width: 15%;">{{ $admin->email }}</td>
                    <td class="border-0" style="width: 60%;"></td>
                    <td class="border-0" style="width: 10%;">
                        <div class="d-flex gap-1 align-items-center justify-content-center">
                            <a href="{{ route('sa.admin.edit', $admin->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('sa.admin.destroy', $admin->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
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


@section('script')

@endsection
