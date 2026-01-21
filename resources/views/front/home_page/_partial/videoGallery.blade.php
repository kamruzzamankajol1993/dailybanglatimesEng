<section class="video-gallery-section py-4 bg-light">
    <div class="container">
        
        <div class="d-flex justify-content-between align-items-end mb-3" style="border-bottom: 3px solid #dc3545;">
           
           <a href="{{ route('front.video.gallery') }}" class="text-decoration-none">
            <h5 class="bg-success text-white d-inline-block px-3 py-2 m-0 fw-bold">
                ভিডিও গ্যালারি <i class="fas fa-chevron-right small ms-2"></i>
            </h5>
           </a>
            
            <div class="video-nav-buttons mb-2">
                <button class="btn btn-outline-dark rounded-circle btn-sm me-1" type="button" data-bs-target="#videoCarousel" data-bs-slide="prev">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="btn btn-outline-dark rounded-circle btn-sm" type="button" data-bs-target="#videoCarousel" data-bs-slide="next">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

        @if(isset($videoGalleryNews) && count($videoGalleryNews) > 0)
            <div id="videoCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
                <div class="carousel-inner">
                    
                    {{-- ৩টি করে ভিডিও এক একটি স্লাইডে গ্রুপ করা হচ্ছে --}}
                    @foreach($videoGalleryNews->chunk(3) as $key => $chunk)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                            <div class="row g-4">
                                @foreach($chunk as $video)
                                    <div class="col-lg-4 col-md-6">
                                        <div class="card border-0 text-white h-100 video-card-modern">
                                            <div class="position-relative h-100 overflow-hidden rounded">
                                                {{-- থাম্বনেইল --}}
                                                <img  onerror="this.onerror=null;this.src='{{ $front_admin_url }}{{ $front_logo_name }}';" src="{{ $video->thumbnail ? $front_admin_url.$video->thumbnail : 'https://placehold.co/400x250/333/fff?text=Video' }}" 
                                                     class="card-img h-100 object-fit-cover" 
                                                     alt="{{ $video->title }}">
                                                
                                                <div class="video-overlay p-3 d-flex flex-column justify-content-end">
                                                    {{-- টাইটেল --}}
                                                    <h5 class="card-title fw-bold hover-red">
                                                        <a href="{{ route('front.video.details', $video->slug) }}" class="text-white text-decoration-none">
                                                            {{ Str::limit($video->title, 60) }}
                                                        </a>
                                                       
                                                    </h5>
                                                    
                                                    {{-- প্লে বাটন (ডিটেইলস পেজে নিয়ে যাবে) --}}
                                                    <a href="{{ route('front.video.details', $video->slug) }}" class="stretched-link play-trigger">
                                                        <i class="fas fa-play-circle text-danger fs-1 bg-white rounded-circle"></i>
                                                    </a>
                                                    
                                                    {{-- সময় --}}
                                                    <small class="text-light-50 mt-2">
                                                        <i class="far fa-clock"></i> {{ bangla_date($video->created_at) }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        @else
            <div class="text-center text-muted py-5">
                <p>কোনো ভিডিও পাওয়া যায়নি।</p>
            </div>
        @endif

    </div>
</section>