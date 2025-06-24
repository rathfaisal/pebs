@extends('super-admin.template')

@section('title', 'Admin CRUD')

@section('link')

@endsection

@section('content')
    <h1>Admin CRUD Page</h1>

    <a href="{{ route('sa.admin.create') }}" class="btn btn-primary">Add New Admin</a>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($admins as $admin)
            <tr>
                <td>{{ $admin->name }}</td>
                <td>{{ $admin->email }}</td>
                <td>
                    <a href="{{ route('sa.admin.edit', $admin->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('sa.admin.destroy', $admin->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('script')

@endsection
