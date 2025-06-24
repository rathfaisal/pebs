@extends('user.template')

@section('title', 'User Activity')

@section('content')
    <h1>User Activity</h1>

    @if(count($activities) > 0)
        <ul class="list-group">
            @foreach($activities as $activity)
                <li class="list-group-item">
                    <strong>{{ $activity->name ?? $activity->title }}</strong>
                    <br>
                    {{ $activity->description }}
                    <br>
                    Date: {{ $activity->date }}
                    @if(in_array($activity->id, $registeredIds))
                        <span class="badge bg-success ms-2">Registered</span>
                    @endif
                    <a href="{{ route('user.activity.show', $activity->id) }}" class="btn btn-primary btn-sm float-end">View</a>
                </li>
            @endforeach
        </ul>
    @else
        <p>No activities found.</p>
    @endif
@endsection
