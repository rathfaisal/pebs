@php
    $template = null;
    $user = auth()->user();
    if ($user && $user->is_super_admin) {
        $template = 'super-admin.template';
    } elseif ($user && $user->is_admin) {
        $template = 'admin.template';
    } else {
        $template = 'user.template';
    }
@endphp

@extends($template)

@section('title', 'Profile')

@section('content')
    <h1>Profile</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <p><strong>Name:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <a href="{{ route('shared.profile.edit') }}" class="btn btn-primary">Edit Profile</a>
@endsection
