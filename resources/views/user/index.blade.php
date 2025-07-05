@extends('user.template')

@section('title', 'Welcome to PEBS Management System')

@section('content')
    <div class="row mt-4 mb-4">
        <div class="col-12">
            <div class="alert alert-danger text-white" style="background:#e74c3c;font-size:1.5rem;">
                <strong>Welcome to PEBS Management System</strong><br>
                <span style="font-size:1rem;">Your central hub for information and activities related to PeBS Zon 20 under MBSA.</span>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">Latest News</div>
                <div class="card-body">
                    <strong>Important Announcement!</strong><br>
                    Stay tuned for upcoming events and updates. More details will be posted soon.
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-header bg-info text-white">About Us</div>
                <div class="card-body">
                    PeBS Management System is dedicated to serving PeBS Zon 20 under MBSA. Our mission is to provide a seamless experience for members and efficient management for administrators.
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-header bg-success text-white">Our Programs</div>
                <div class="card-body">
                    @php
                        $today = date('Y-m-d');
                        $sortedActivities = $activities->filter(function($a) use ($today) {
                            return $a->date >= $today;
                        })->sortBy('date');
                    @endphp
                    @if($sortedActivities->count())
                        <ul class="list-group">
                            @foreach($sortedActivities as $activity)
                                <li class="list-group-item">
                                    <strong>{{ $activity->title }}</strong> - {{ $activity->date }}<br>
                                    {{ $activity->description }}
                                    <a href="{{ route('user.activity.show', $activity->id) }}" class="btn btn-primary btn-sm float-end">View</a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No upcoming activities found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-header bg-warning text-dark">Gallery</div>
                <div class="card-body">
                    <p>Check out photos from our past events and activities!</p>
                    <div class="row">
                        @php
                            $galleryImages = \App\Models\Gallery::inRandomOrder()->take(4)->get();
                        @endphp
                        @foreach($galleryImages as $image)
                            <div class="col-md-3 mb-3">
                                <div class="card gallery-card h-100" style="position:relative;overflow:hidden;">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top" alt="Gallery Image">
                                    <div class="gallery-info" style="display:none;position:absolute;bottom:0;left:0;width:100%;background:rgba(0,0,0,0.7);color:#fff;padding:10px;">
                                        <strong>{{ $image->activity->title ?? '' }}</strong><br>
                                        Date: {{ $image->activity->date ?? '' }}<br>
                                        Location: {{ $image->activity->location ?? '' }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <script>
                        document.querySelectorAll('.gallery-card').forEach(function(card) {
                            card.addEventListener('mouseenter', function() {
                                this.querySelector('.gallery-info').style.display = 'block';
                            });
                            card.addEventListener('mouseleave', function() {
                                this.querySelector('.gallery-info').style.display = 'none';
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection
