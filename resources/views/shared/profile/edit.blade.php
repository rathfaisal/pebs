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

@section('title', 'Edit Profile')

@section('content')
    <h1>Edit Profile</h1>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
        <form action="{{ route('shared.profile.update') }}" method="POST" class="w-100" style="">
            @csrf

            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-md-9 col-lg-7 mb-4">
                    <h3 class="text-black mb-3">Basic Information</h3>
                    <div class="">
                        <div class="mb-4">
                            <label for="name" class="form-label text-black-50">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="email" class="form-label text-black-50">Email</label>
                                <input type="email" name="email" id="email" class="form-control " value="{{ old('email', $user->email) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label text-black-50">Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control" disabled placeholder="coming soon..">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="bio" class="form-label text-black-50">Bio</label>
                            <textarea name="bio" id="bio" class="form-control" rows="2" disabled placeholder="coming soon..">{{ old('bio', $user->bio ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="col-md-9 col-lg-7 mb-4">
                    <h3 class="text-black-50">Change Password</h3>
                    <div class="mb-3">
                        <label for="old_password" class="form-label text-black-50">Old Password</label>
                        <input type="password" name="old_password" id="old_password" class="form-control">
                    </div>
                        <div class="mb-3">
                            <label for="password" class="form-label text-black-50">New Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                            <small class="form-text text-muted">Leave blank to keep current password.</small>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label text-black-50">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row d-flex justify-content-center align-items-center">
                    <div class="d-flex justify-content-between col-md-9 col-lg-7">
                        <button type="submit" class="btn btn-success">Update Profile</button>
                        <a href="{{ route('home') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
        <style>
            .custom-focus-ring:focus {
                outline: none;
                box-shadow: 0 0 0 3px black; /* Change color and size as needed */
                border-color: #4F8A8B;
            }
        </style>
    </div>
@endsection
