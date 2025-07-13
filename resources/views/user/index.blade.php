@extends('user.template')

@section('title', 'Welcome to PEBS Management System')

@section('content')

    {{-- Welcome Section --}}
    <div class="row my-4">
        <div class="col-12">
            <div class="p-0 rounded-4 text-center position-relative overflow-hidden" style="height: 400px; min-height: 250px;">
                <video id="welcomeVideo" autoplay loop muted playsinline preload="auto" class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" style="object-fit:cover;z-index:0;filter: blur(8px) brightness(0.7);">
                    <source src="{{ asset('videos/selangor-flag-loop.mp4') }}" type="video/mp4">
                </video>
                {{-- bg vid motion control --}}
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var vid = document.getElementById('welcomeVideo');
                        if (vid) vid.playbackRate = 0.40;
                    });
                </script>
                <div class="position-relative d-flex flex-column justify-content-center align-items-center h-100 text-white-50 shadow" style="z-index:2;">
                    <h1 class="display-4 fw-bold mb-3 animate__animated animate__fadeInDown">Welcome to <span class="text-warning">PEBS Management System</span></h1>
                    <p class="lead mb-0 animate__animated animate__fadeInUp animate__delay-1s text-white-50">Your central hub for information and activities related to <span class="fw-semibold text-warning">PeBS Zon 20</span> under <span class="fw-semibold text-warning">MBSA</span>.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Announcement Section --}}
    <div class="row mb-5 mt-5">
        <div class="col-12">
            <div class="card border-0 mb-3 animate__animated animate__fadeInUp" style="background: rgba(255, 255, 255, 0.95);">
                <div class="card-header border-0 d-flex align-items-center gap-2" style="min-height:60px; color: #410B09; background: rgba(255, 255, 255, 0.95);">
                    <i class="bi bi-megaphone-fill align-self-center" style="font-size: 2.5rem;"></i>
                    <div class="d-flex flex-column justify-content-center ml-2">
                        <span class="fw-bold fs-4">Updates You Don’t Wanna Miss</span>
                        <span class="text-black-50 small">Latest announcements and updates from PeBS Zon 20</span>
                    </div>
                </div>
                <div class="card-body py-4">
                    @php
                        $announcements = \App\Models\Announcement::latest()->take(10)->get();
                    @endphp
                    @if($announcements->count() > 0)
                        <div id="announcementSlider" class="overflow-hidden position-relative" style="height: 200px;">
                            <div id="announcementSliderInner" class="d-flex flex-row transition-slider" style="width:100%;height:100%;">
                                @foreach($announcements as $announcement)
                                    <div class="d-flex align-items-stretch gap-0 py-2 px-2 announcement-slider-item flex-shrink-0" style="width:100%;min-width:100%;max-width:100%;min-height:180px;">
                                        {{-- announcement image side --}}
                                        <div class="d-flex align-items-center justify-content-center rounded-3 overflow-hidden" style="width:60%;min-height:180px;max-height:220px;">
                                            <img src="{{ asset('storage/' . $announcement->image_path) }}" alt="Announcement Image" class="w-100 h-100 object-fit-cover" style="object-fit:cover;min-height:180px;max-height:220px;">
                                        </div>
                                        {{-- announcement title/desc side --}}
                                        <div class="d-flex flex-column justify-content-between align-items-stretch ps-4 pe-3 py-2" style="width:40%;min-height:180px;max-height:220px; color: #410B09;">
                                            {{-- announcement title --}}
                                            <div class="mb-2">
                                                <h5 class="fw-bold announcement-title mb-0" style="text-transform: uppercase;">{{ $announcement->title }}</h5>
                                            </div>
                                            {{-- announcement description --}}
                                            <div class="flex-grow-1" style="min-height:40px;max-height:70px;overflow:auto;">
                                                <p class="text-black-50 mb-0 small" style="white-space:pre-line;word-break:break-word;">
                                                    {{ \Illuminate\Support\Str::words($announcement->description, 30, '...') }}
                                                </p>
                                            </div>
                                            {{-- announcement created at --}}
                                            <div class="mt-2">
                                                <span class="badge bg-opacity-10 px-3 py-2" style="background: #E97C77;font-size:0.9em;backdrop-filter:blur(2px);">{{ $announcement->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="d-flex flex-column align-items-center gap-2 mt-3">
                            <div id="sliderIndicators" class="d-flex justify-content-center align-items-center gap-1 mb-1"></div>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const items = document.querySelectorAll('.announcement-slider-item');
                                const inner = document.getElementById('announcementSliderInner');
                                const indicators = document.getElementById('sliderIndicators');
                                let current = 0;
                                let autoScrollTimer;
                                function updateSlider() {
                                    inner.style.transform = `translateX(-${current * 100}%)`;
                                    // Update indicators
                                    if (indicators) {
                                        Array.from(indicators.children).forEach((dot, i) => {
                                            dot.classList.toggle('active', i === current);
                                        });
                                    }
                                }
                                function resetAutoScroll() {
                                    if (autoScrollTimer) clearInterval(autoScrollTimer);
                                    autoScrollTimer = setInterval(function() {
                                        current = (current + 1) % items.length;
                                        updateSlider();
                                    }, 7500); // Adjusted to 7.5sec for better user experience
                                }
                                // Create indicators
                                if (indicators) {
                                    indicators.innerHTML = '';
                                    for (let i = 0; i < items.length; i++) {
                                        const dot = document.createElement('span');
                                        dot.className = 'slider-dot' + (i === 0 ? ' active' : '');
                                        dot.style.cssText = 'display:inline-block;width:10px;height:10px;border-radius:50%;background:#E97C77;margin:0 2px;cursor:pointer;transition:background 0.2s;';
                                        dot.onclick = function() {
                                            current = i;
                                            updateSlider();
                                            resetAutoScroll();
                                        };
                                        indicators.appendChild(dot);
                                    }
                                }
                                updateSlider();
                                resetAutoScroll();
                            });
                        </script>
                        <style>
                            .slider-dot.active {
                                background: #410B09 !important;
                            }
                            .transition-slider {
                                transition: transform 0.8s cubic-bezier(.77,0,.175,1);
                                will-change: transform;
                            }
                        </style>
                    @else
                        <div class="text-center text-black-50 py-5">
                            <i class="bi bi-emoji-frown fs-1 mb-2"></i>
                            <div>No announcements found.</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>



    {{-- <div class="row mb-4">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-header bg-info text-white">About Us</div>
                <div class="card-body">
                    PeBS Management System is dedicated to serving PeBS Zon 20 under MBSA. Our mission is to provide a seamless experience for members and efficient management for administrators.
                </div>
            </div>
        </div>
    </div> --}}


    {{-- Upcoming Activities Section --}}
    <div class="row mb-5 mt-5">
        <div class="col-12">
            <div class="card border-0 animate__animated animate__fadeInUp">
                <div class="card-header border-0 d-flex align-items-center gap-2" style="min-height:60px; color: #410B09; background: rgba(255, 255, 255, 0.95);">
                    <i class="bi bi-calendar-event fs-4"></i>
                    <span class="fw-bold fs-4">Coming Up in Our Community</span>
                </div>
                <div class="card-body border-0 py-4">
                    @php
                        $today = date('Y-m-d');
                        $sortedActivities = $activities->filter(function($a) use ($today) {
                            return $a->date >= $today;
                        })->sortBy('date')->take(6)->values();
                    @endphp
                    @if($sortedActivities->count())
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                            @foreach($sortedActivities as $idx => $activity)
                                <div class="col d-flex">
                                    <div class="card h-100 w-100 border-0 shadow-sm activity-card position-relative animate__animated animate__fadeInUp p-0 overflow-hidden" style="background: #222; min-height: 320px;">
                                        <div class="activity-bg-img position-absolute top-0 start-0 w-100 h-100" style="background: url('{{ asset('storage/' . ($activity->image_path ?? 'images/pebs-logo.png')) }}') center center/cover no-repeat; opacity:0.25; z-index:1;"></div>
                                        <div class="card-body d-flex flex-column justify-content-between position-relative" style="z-index:2; min-height:320px;">
                                            <div class="row w-100 mb-2 g-0 align-items-start">
                                                <div class="col-8 pe-1">
                                                    {{-- activity title --}}
                                                    <h5 class="card-title fw-bold mb-0 text-uppercase text-wrap" style="font-size:1.1rem; max-width:100%;" title="{{ $activity->title }}">{{ $activity->title }}</h5>
                                                </div>
                                                <div class="col-4 ps-1 d-flex justify-content-end">
                                                    {{-- event date badge at top right corner --}}
                                                    <span class="px-3 py-2" style="font-size:0.95em;background-color:#E97C77; color:#fff; border-radius:0.5rem; display: inline-block; white-space:nowrap;">
                                                        <i class="bi bi-calendar-event me-1"></i>
                                                        {{ \Carbon\Carbon::parse($activity->date)->format('d M Y') }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="d-flex w-100 align-items-end justify-content-end gap-2" style="position:absolute;bottom:1rem;right:0;padding:0 1rem;">
                                                {{-- countdown timer --}}
                                                <span class="countdown-timer text-white small fw-bold" data-date="{{ $activity->date }}" style="background: #E97C77; border-radius:8px; padding:0.25rem 0.75rem;"></span>
                                                {{-- view button --}}
                                                <a href="{{ route('user.activity.show', $activity->id) }}"
                                                   class="btn btn-sm px-4 rounded"
                                                   style="background-color:#DA251D ;color:#fff;transition:background 0.2s,color 0.2s;"
                                                   onmouseover="this.style.backgroundColor='#410B09'"
                                                   onmouseout="this.style.backgroundColor='#DA251D '"
                                                   onfocus="this.style.backgroundColor='#410B09'"
                                                   onblur="this.style.backgroundColor='#DA251D'"
                                                >View</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            function updateCountdowns() {
                                document.querySelectorAll('.countdown-timer').forEach(function(el) {
                                    var dateStr = el.getAttribute('data-date');
                                    var eventDate = new Date(dateStr);
                                    var now = new Date();
                                    var diff = eventDate - now;
                                    if (diff > 0) {
                                        var days = Math.floor(diff / (1000*60*60*24));
                                        var hours = Math.floor((diff / (1000*60*60)) % 24);
                                        // var mins = Math.floor((diff / (1000*60)) % 60); // if you want to include minutes
                                        el.textContent = days + 'd ' + hours + 'h ';
                                        // el.textContent = days + 'd ' + hours + 'h ' + mins + 'm left'; // if you want to include minutes
                                    } else {
                                        el.textContent = 'Started';
                                    }
                                });
                            }
                            updateCountdowns();
                            setInterval(updateCountdowns, 360000); // update every 1 hour
                            // setInterval(updateCountdowns, 60000); // if you want to include minutes and update every minutes
                        });
                        </script>
                        <style>
                        .activity-card .activity-bg-img { pointer-events:none; }
                        .activity-card .card-title.text-shadow { text-shadow: 0 2px 8px #fff, 0 1px 2px #000; }
                        .activity-card .card-body { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(5px); }
                        </style>
                    @else
                        <div class="text-center text-black-50 py-5">
                            <i class="bi bi-emoji-frown fs-1 mb-2"></i>
                            <div>No upcoming activities found.</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>



    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 mb-3">
                <div class="card-header border-0 d-flex align-items-center gap-2" style="min-height:60px; color: #410B09; background: rgba(255, 255, 255, 0.95);">
                    <i class="bi bi-image-fill align-self-center" style="font-size: 2.5rem;"></i>
                    <div class="d-flex flex-column justify-content-center ml-2">
                        <span class="fw-bold fs-4 mb-0 pb-0">Gallery</span>
                        <span class="text-black-50 small mt-0 pt-0">See the Magic We’ve Made Together</span>
                    </div>
                </div>
                <div class="card-body border-0 bg-white">
                    @php
                        $galleryImages = \App\Models\Gallery::inRandomOrder()->take(9)->get();
                    @endphp
                    <div class="bento-gallery-grid d-grid gap-3" style="grid-template-columns: repeat(8, 1fr); grid-template-rows: repeat(6, 120px);">
                        @foreach($galleryImages as $image)
                            <div class="bento-item position-relative overflow-hidden rounded-3 shadow-sm gallery-popup-trigger" tabindex="0" data-img="{{ asset('storage/' . $image->image_path) }}" data-title="{{ $image->activity->title ?? '' }}" data-date="{{ $image->activity->date ?? '' }}" data-location="{{ $image->activity->location ?? '' }}" style="cursor:pointer;">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Gallery Image" class="w-100 h-100 object-fit-cover" style="object-fit:cover;">
                                <div class="bento-overlay position-absolute bottom-0 start-0 w-100 px-2 py-1" style="background:rgba(0,0,0,0.45);color:#fff;font-size:0.95em;">
                                    <span class="fw-semibold">{{ $image->activity->title ?? '' }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Popup Modal -->
                    <div id="galleryModal" class="modal fade" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="galleryModalTitle"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body text-center">
                            <img id="galleryModalImg" src="" alt="Gallery Image" class="img-fluid rounded mb-3" style="max-height:400px;object-fit:contain;">
                            <div id="galleryModalDetails" class="text-start small"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Bento grid responsive sizing
                        const style = document.createElement('style');
                        style.innerHTML = `
                            .bento-gallery-grid { grid-template-columns: repeat(8, 1fr); grid-template-rows: repeat(6, 120px); gap: 18px; }
                            /* Eye-catching bento arrangement */
                            .bento-item:nth-child(1) { grid-column: 1 / span 2; grid-row: 1 / span 2; }
                            .bento-item:nth-child(2) { grid-column: 3 / span 3; grid-row: 1 / span 2; }
                            .bento-item:nth-child(3) { grid-column: 6 / span 3; grid-row: 1 / span 2; }

                            .bento-item:nth-child(4) { grid-column: 1 / span 3; grid-row: 3 / span 2; }
                            .bento-item:nth-child(5) { grid-column: 4 / span 2; grid-row: 3 / span 2; }
                            .bento-item:nth-child(6) { grid-column: 6 / span 3; grid-row: 3 / span 2; }

                            .bento-item:nth-child(7) { grid-column: 1 / span 3; grid-row: 5 / span 2; }
                            .bento-item:nth-child(8) { grid-column: 4 / span 3; grid-row: 5 / span 2; }
                            .bento-item:nth-child(9) { grid-column: 7 / span 2; grid-row: 5 / span 2; }

                            /* fallback for extra images */
                            .bento-item { grid-column: span 1; grid-row: span 1; border-radius: 18px; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 4px 18px rgba(64,0,32,0.10); }
                            .bento-item:hover, .bento-item:focus { transform: scale(1.02); box-shadow: 0 8px 32px rgba(218,37,29,0.10); z-index:3; }
                            .bento-item img { filter: brightness(0.93) saturate(1.15); transition: filter 0.2s; }
                            .bento-item:hover img { filter: brightness(1.05) saturate(1.25); }
                            .bento-overlay { background: linear-gradient(0deg, rgba(0,0,0,0.55) 80%, rgba(0,0,0,0.05) 100%); }
                            @media (max-width: 1200px) { .bento-gallery-grid { grid-template-columns: repeat(3, 1fr); grid-template-rows: repeat(8, 120px); } }
                            @media (max-width: 768px) { .bento-gallery-grid { grid-template-columns: repeat(2, 1fr); grid-template-rows: repeat(12, 120px); } }
                            @media (max-width: 576px) { .bento-gallery-grid { grid-template-columns: 1fr; grid-template-rows: repeat(24, 120px); } }
                        `;
                        document.head.appendChild(style);

                        // Popup logic
                        document.querySelectorAll('.gallery-popup-trigger').forEach(function(card) {
                            card.addEventListener('click', function() {
                                const img = this.getAttribute('data-img');
                                const title = this.getAttribute('data-title');
                                const date = this.getAttribute('data-date');
                                const location = this.getAttribute('data-location');
                                document.getElementById('galleryModalImg').src = img;
                                document.getElementById('galleryModalTitle').textContent = title || 'Gallery Image';
                                document.getElementById('galleryModalDetails').innerHTML =
                                    (date ? `<div><strong>Date:</strong> ${date}</div>` : '') +
                                    (location ? `<div><strong>Location:</strong> ${location}</div>` : '');
                                var modal = new bootstrap.Modal(document.getElementById('galleryModal'));
                                modal.show();
                            });
                        });
                    });
                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection
