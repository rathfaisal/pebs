@extends('user.template')

@section('title', 'Activity Details')

@section('content')
    <h1>{{ $activity->title }}</h1>
    <p><strong>Description:</strong> {{ $activity->description }}</p>
    <p><strong>Date:</strong> {{ $activity->date }}</p>
    @if($activity->location)
        <p><strong>Location:</strong> {{ $activity->location }}</p>
    @endif
    @if($activity->picture)
        <p><img src="{{ asset('images/' . $activity->picture) }}" alt="Activity Image" style="max-width:300px;"></p>
    @endif
    @if($isRegistered)
        <button class="btn btn-success" disabled>Registered</button>
        <span class="text-success ms-2">You have already signed up for this activity.</span>
    @else
        <form action="{{ route('user.activity.register', $activity->id) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-success">Register</button>
        </form>
    @endif
    <a href="{{ route('home') }}" class="btn btn-secondary">Back</a>
@endsection
