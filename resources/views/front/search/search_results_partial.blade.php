<div class="d-flex flex-column gap-4">
    @forelse($results as $post)
        <div class="search-item d-flex align-items-start border-bottom pb-3">
            <div class="flex-shrink-0 me-3">
                <a href="{{ route('front.news.details', $post->slug) }}">
                    <img src="{{ $post->image ? $front_admin_url.$post->image : 'https://placehold.co/180x110/ddd/333?text=No+Image' }}" 
                         class="rounded-1 object-fit-cover" 
                         width="180" height="110" alt="{{ $post->title }}">
                </a>
            </div>
            <div class="flex-grow-1">
                <a href="{{ route('front.news.details', $post->slug) }}" class="text-decoration-none text-dark">
                    <h5 class="fw-bold hover-red mb-1">
                        {{-- Basic Highlight Logic --}}
                        @if(!empty($query))
                            {!! str_ireplace($query, '<span class="search-highlight">'.$query.'</span>', $post->title) !!}
                        @else
                            {{ $post->title }}
                        @endif
                    </h5>
                </a>
                <div class="search-meta mb-2">
                    <span class="text-danger fw-bold">
                        {{ $post->categories->first()->eng_name ?? 'News' }}
                    </span>
                    <span class="mx-1">•</span>
                    <i class="far fa-clock small"></i> 
                    {{ $post->created_at->format('d M, Y') }}
                </div>
                <p class="text-secondary small mb-0 text-truncate-2">
                    @if($post->subtitle)
                        {{ Str::limit($post->subtitle, 150) }}
                    @else
                        {{ Str::limit(strip_tags($post->content), 150) }}
                    @endif
                </p>
            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <h4 class="text-muted">Sorry! No news matched your search.</h4>
            <p class="text-secondary">Check spelling or use different keywords.</p>
        </div>
    @endforelse
</div>

{{-- Custom Pagination Design (No Bootstrap) --}}
@if ($results->hasPages())
<div class="mt-5 d-flex justify-content-center custom-pagination-wrapper">
    <div class="custom-pagination">
        
        {{-- Previous Link --}}
        @if ($results->onFirstPage())
            <span class="page-link disabled"><i class="fas fa-angle-left"></i></span>
        @else
            <a href="{{ $results->previousPageUrl() }}" class="page-link" rel="prev"><i class="fas fa-angle-left"></i></a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($results->getUrlRange(max(1, $results->currentPage() - 2), min($results->lastPage(), $results->currentPage() + 2)) as $page => $url)
            @if ($page == $results->currentPage())
                <span class="page-link active">{{ $page }}</span>
            @else
                <a href="{{ $url }}" class="page-link">{{ $page }}</a>
            @endif
        @endforeach

        {{-- Next Link --}}
        @if ($results->hasMorePages())
            <a href="{{ $results->nextPageUrl() }}" class="page-link" rel="next"><i class="fas fa-angle-right"></i></a>
        @else
            <span class="page-link disabled"><i class="fas fa-angle-right"></i></span>
        @endif
    </div>
</div>
@endif