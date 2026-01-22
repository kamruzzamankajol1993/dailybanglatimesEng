@extends('front.master.master')

@section('title')
Search: {{ request('q') }} - {{ $front_ins_name ?? 'News' }} 
@endsection

@section('css')
 <style>
    .search-highlight {
        background-color: #fff3cd;
        color: #856404;
        padding: 0 2px;
        border-radius: 2px;
    }
    .search-item {
        transition: background-color 0.2s;
    }
    .search-item:hover {
        background-color: #f8f9fa;
    }
    .search-meta {
        font-size: 13px;
        color: #6c757d;
    }
    .filter-box {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        padding: 15px;
    }
    
    /* Custom Pagination CSS from your list.blade.php */
    .custom-pagination {
        display: flex;
        gap: 8px;
        align-items: center;
    }
    .custom-pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border: 1px solid #ddd;
        color: #333;
        text-decoration: none;
        font-weight: bold;
        border-radius: 0;
        transition: all 0.3s ease;
        background: #fff;
        cursor: pointer;
    }
    .custom-pagination .page-link:hover {
        background-color: #f8f9fa;
        color: #dc3545;
        border-color: #dc3545;
    }
    .custom-pagination .page-link.active {
        background-color: #dc3545;
        color: #fff;
        border-color: #dc3545;
    }
    .custom-pagination .page-link.disabled {
        color: #ccc;
        pointer-events: none;
        background: #f9f9f9;
        border-color: #eee;
    }
    
    /* Loading Overlay */
    #loading-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(255, 255, 255, 0.8);
        z-index: 10;
        display: none;
        align-items: center;
        justify-content: center;
    }
    #search-results-container {
        position: relative;
        min-height: 200px;
    }
</style>
@endsection

@section('body')

<section class="py-4">
    <div class="container">
        
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8">
                <form action="{{ route('front.search') }}" method="GET" class="d-flex shadow-sm">
                    <input class="form-control form-control-lg rounded-0 border-end-0" 
                           type="text" 
                           name="q" 
                           value="{{ request('q') }}" 
                           placeholder="What are you looking for?">
                    <button class="btn btn-danger rounded-0 px-4 fw-bold" type="submit">Search</button>
                </form>
                
                @if(isset($results) && $results->count() > 0)
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <small class="text-secondary">Results: About {{ $results->total() }} news found</small>
                </div>
                @endif
            </div>
        </div>

        <div class="row g-4">
            
            <div class="col-lg-8">
                
                {{-- Filter Form --}}
                <form action="{{ route('front.search') }}" method="GET" id="filterForm">
                    <input type="hidden" name="q" value="{{ request('q') }}">

                    <div class="filter-box mb-4 d-flex gap-3 align-items-center flex-wrap rounded">
                        <span class="fw-bold small text-muted"><i class="fas fa-filter me-1"></i> Filter:</span>
                        
                        <select class="form-select form-select-sm w-auto border-0 shadow-sm" name="category" onchange="document.getElementById('filterForm').submit()">
                            <option value="all">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->eng_name }}
                                </option>
                            @endforeach
                        </select>
                        
                        <select class="form-select form-select-sm w-auto border-0 shadow-sm" name="time" onchange="document.getElementById('filterForm').submit()">
                            <option value="">Any time</option>
                            <option value="24h" {{ request('time') == '24h' ? 'selected' : '' }}>Last 24 hours</option>
                            <option value="7d"  {{ request('time') == '7d' ? 'selected' : '' }}>Last 1 week</option>
                            <option value="30d" {{ request('time') == '30d' ? 'selected' : '' }}>Last 1 month</option>
                        </select>

                        <div class="ms-auto">
                            <button type="submit" name="sort" value="{{ request('sort') == 'old' ? 'desc' : 'old' }}" class="btn btn-sm btn-outline-secondary border-0">
                                <i class="fas fa-sort-amount-{{ request('sort') == 'old' ? 'up' : 'down' }}"></i> 
                                {{ request('sort') == 'old' ? 'Oldest first' : 'Newest first' }}
                            </button>
                        </div>
                    </div>
                </form>

                {{-- AJAX Container --}}
                <div id="search-results-container">
                    
                    <div id="loading-overlay">
                        <div class="spinner-border text-danger" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    {{-- Include Partial View --}}
                    @include('front.search.search_results_partial')

                </div>

            </div>

            <div class="col-lg-4">
                <div class="sticky-top" style="top: 100px;">
                    <div class="bg-light p-3 border rounded mb-4">
                        <h6 class="fw-bold border-bottom pb-2 mb-2"><i class="fas fa-lightbulb text-warning me-2"></i>Search Tips</h6>
                        <ul class="small text-secondary m-0 ps-3">
                            <li>Check if the spelling is correct.</li>
                            <li>Try using different words or synonyms.</li>
                            <li>Keep search terms short and specific.</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        
        // Handle Custom Pagination Click for Search
        $(document).on('click', '.custom-pagination .page-link', function(event) {
            event.preventDefault(); 
            
            let pageUrl = $(this).attr('href');
            
            if(!pageUrl || pageUrl === '#' || $(this).hasClass('disabled') || $(this).hasClass('active')) {
                return;
            }

            // 1. Show Loading State
            $('#loading-overlay').fadeIn(200);
            $('#search-results-container').css('opacity', '0.6');

            // 2. Perform AJAX
            $.ajax({
                url: pageUrl,
                type: "get",
                datatype: "html",
            })
            .done(function(data) {
                // 3. Update Content
                $('#search-results-container').empty().html(data);
                
                // Re-add loading overlay structure (hidden)
                $('#search-results-container').prepend(`
                    <div id="loading-overlay">
                        <div class="spinner-border text-danger" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                `);

                // 4. Update URL History
                window.history.pushState({path: pageUrl}, '', pageUrl);
                
                // 5. Scroll to top of results
                $('html, body').animate({
                    scrollTop: $("#search-results-container").offset().top - 150
                }, 500);

                // 6. Restore Opacity
                $('#search-results-container').css('opacity', '1');
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('No response received from the server.');
                $('#loading-overlay').fadeOut();
                $('#search-results-container').css('opacity', '1');
            });
        });
    });
</script>
@endsection