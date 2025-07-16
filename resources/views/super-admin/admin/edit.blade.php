@extends('super-admin.template')

@section('title', 'Edit Admin')

@section('content')
    <div class="mb-4">
        <a href="{{ route('sa.admin.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Admins
        </a>
    </div>
    <h1>Edit Admin</h1>

    <form action="{{ route('sa.admin.update', $admin->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $admin->name }}">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $admin->email }}">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
