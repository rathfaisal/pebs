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
        <p><img src="{{ asset('storage/' . $activity->picture) }}" alt="Activity Image" style="max-width:300px;"></p>
    @endif
    @if($isRegistered)
        <button class="btn btn-success" disabled>Registered</button>
        <span class="text-success ms-2">You have already signed up for this activity.</span>
        <!-- Feedback form for registered users -->
        <form action="{{ route('user.activity.feedback', $activity->id) }}" method="POST" class="mt-3">
            @csrf
            <div class="mb-3">
                <label for="feedback" class="form-label">Your Feedback</label>
                <textarea name="feedback" id="feedback" class="form-control" rows="3" required>{{ old('feedback') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Feedback</button>
        </form>
    @else
        <form action="{{ route('user.activity.register', $activity->id) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-success">Register</button>
        </form>
    @endif
    <a href="{{ route('home') }}" class="btn btn-secondary">Back</a>
@endsection
