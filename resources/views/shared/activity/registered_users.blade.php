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

@section('title', 'Registered Users')

@section('content')
    <div class="mb-3">
        <a href="{{ route('s.activity.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Activities
        </a>
    </div>

    <h2 class="text-black-50">Registered Users for Activity: <strong class="fs-normal text-black text-uppercase">{{ $activity->title }}</strong></h2>

    <div class="table-responsive mt-4">
        <table class="table border-0 table-hover mb-0 bg-white">
            <thead class="table-light">
                <tr>
                    <th class="w-[15%] border-0">Name</th>
                    <th class="w-[15%] border-0">Email</th>
                    <th class="w-[60%] border-0">Feedback</th>
                    <th class="w-[10%] border-0 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($registeredUsers as $user)
                <tr>
                    <td class="border-0" style="width: 15%;">{{ $user->name }}</td>
                    <td class="border-0" style="width: 15%;">{{ $user->email }}</td>
                    <td class="border-0" style="width: 60%;">{{ $user->pivot->feedback ?? '-' }}</td>
                    <td class="border-0" style="width: 10%;">
                        <div class="d-flex gap-1 align-items-center justify-content-center">
                            <form action="{{ route('s.activity.unregister', [$activity->id, $user->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this registration?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


@endsection
