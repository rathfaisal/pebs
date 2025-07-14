@extends('user.template')

@section('title', 'Activity Details')

@section('content')
    <div class="card p-4 mb-4 bg-white border-0" style="width: 100%; margin: 0; position: relative;">
        <div class="d-flex flex-row" style="gap: 2rem;">
            <!-- Left Section: Picture (40%) -->
            <div style="flex: 0 0 40%; max-width: 40%; display: flex; align-items: center; justify-content: center;">
                @if($activity->picture)
                    <img src="{{ asset('storage/' . $activity->picture) }}" alt="Activity Image" class="rounded shadow-lg" style="max-width:90%; max-height:400px; object-fit:cover;">
                @endif
            </div>

            <!-- Right Section: Details (60%) -->
            <div style="flex: 0 0 60%; max-width: 55%;">
                <!-- Title & Location Section -->
                <div class="mb-5 text-black" style="">
                    <h1 class="fw-bold text-uppercase mb-1">{{ $activity->title }}</h1>
                    @if($activity->location)
                        <p class="text-black-50">Happening at: <strong class="fw-medium text-uppercase text-black">{{ $activity->location }}</strong></p>
                    @endif
                </div>

                <!-- Date Section -->
                <div class="mb-5">
                    <div class="d-flex " style="gap: 1rem; align-items: center;">
                        <!-- Date Side -->
                        <div style="flex:0 0; max-width:100px; display:flex; flex-direction:column; justify-content:center; align-items:center;">
                            <div class="p-2 text-center rounded bg-light border" style="min-width:70px;">
                                <span class="text-uppercase small">{{ \Carbon\Carbon::parse($activity->date)->format('M') }}</span><br>
                                <span class="fw-bold fs-4">{{ \Carbon\Carbon::parse($activity->date)->format('d') }}</span>
                            </div>
                        </div>
                        <!-- Day & Time Side -->
                        <div class="" style="flex:1; display:flex; flex-direction:column;">
                            <div class="">
                                <span class="fw-bold text-uppercase">{{ \Carbon\Carbon::parse($activity->date)->format('l') }}</span>
                            </div>
                            <div>
                                <span class="fw-medium">{{ \Carbon\Carbon::parse($activity->date)->format('h:i A') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description Section -->
                <div class="mb-5">
                    <h5 class="mb-2">Details & Information</h5>
                    <p>{{ $activity->description }}</p>
                </div>

                <!-- Buttons & Forms Section -->
                <div class="mb-4">
                    @if($isRegistered)
                        <div class="alert alert-success d-inline-flex align-items-center mb-3" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <div>You have already signed up for this activity.</div>
                        </div>
                        <!-- Feedback form for registered users -->
                        <form action="{{ route('user.activity.feedback', $activity->id) }}" method="POST" class="">
                            @csrf
                            <div class="mb-3">
                                <label for="feedback" class="form-label">Your Feedback</label>
                                <textarea name="feedback" id="feedback" class="form-control" rows="3" required>{{ old('feedback') }}</textarea>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">Submit Feedback</button>
                                <a href="{{ route('home') }}" class="btn btn-secondary">Back</a>
                            </div>

                        </form>
                    @else
                        {{-- <div class="d-flex gap-2 align-items-center">
                            <form action="{{ route('user.activity.register', $activity->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success">Register</button>
                            </form>
                            <a href="{{ route('home') }}" class="btn btn-secondary">Back</a>
                        </div> --}}
                        <form action="{{ route('user.activity.register', $activity->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <div class="d-flex justify-content-between">
                                <div class="d-flex gap-2 align-items-center">
                                    <button type="submit" class="btn btn-success">Register</button>
                                    <div class="text-black-50">
                                        <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                                        <label class="form-check-label" for="terms">
                                            I acknowledge and accept the <a href="#" target="_blank" class="text-black-50 text-decoration-none fst-italic fw-semibold">Terms and Conditions</a> as stated.
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ route('home') }}" class="btn btn-secondary">Back</a>
                                </div>
                            </div>
                        </form>

                    @endif
                </div>
                <!-- Back Button Section (removed, now at top left) -->
            </div>
        </div>
@endsection
