@extends('super-admin.template')

@section('title', 'Create Admin')

@section('content')
    <div class="mb-4">
        <a href="{{ route('sa.admin.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Admins
        </a>
    </div>
    <h1>Create New Admin</h1>

    <form action="{{ route('sa.admin.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endsection
