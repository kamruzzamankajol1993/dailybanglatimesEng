<div class="container sticky-nav-desktop">
    <nav class="navbar navbar-expand-lg custom-navbar shadow-sm">
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav w-100 justify-content-center flex-wrap">
                
                {{-- ১. হোম আইকন --}}
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('front.index') }}">
                        <i class="fas fa-home"></i>
                    </a>
                </li>

                {{-- ২. ডাইনামিক ক্যাটাগরি লুপ --}}
                @foreach($header_categories as $key => $category)
                    
                    {{-- লজিক: ১০ নম্বর ক্যাটাগরির পর যেগুলো আসবে, সেগুলো ল্যাপটপে (XL এর নিচে) হাইড হয়ে যাবে --}}
                    @php
                        // $key শুরু হয় 0 থেকে, তাই $key > 9 মানে ১১তম আইটেম থেকে শর্ত প্রযোজ্য হবে
                        $responsiveClass = ($key > 9) ? 'd-none d-xl-block' : '';
                    @endphp

                    @if($category->children->count() > 0)
                        {{-- ড্রপডাউন মেনু (যদি চাইল্ড থাকে) --}}
                        <li class="nav-item dropdown {{ $responsiveClass }}">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown{{ $category->id }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $category->eng_name }}
                            </a>
                            <ul class="dropdown-menu border-0 shadow rounded-0" aria-labelledby="navbarDropdown{{ $category->id }}">
                                {{-- প্যারেন্ট ক্যাটাগরি অপশন --}}
                                <li>
                                    <a class="dropdown-item fw-bold" href="{{ route('front.category.news', $category->slug) }}">
                                        {{ $category->eng_name }} (All)
                                    </a>
                                </li>
                                
                                {{-- চাইল্ড ক্যাটাগরি লুপ --}}
                                @foreach($category->children as $child)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('front.category.news', $child->slug) }}">
                                            {{ $child->eng_name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        {{-- সাধারণ মেনু (যদি চাইল্ড না থাকে) --}}
                        <li class="nav-item {{ $responsiveClass }}">
                            <a class="nav-link" href="{{ route('front.category.news', $category->slug) }}">
                                {{ $category->eng_name }}
                            </a>
                        </li>
                    @endif
                @endforeach

                {{-- ৩. বিবিধ অপশন (বাকি ক্যাটাগরিগুলোর জন্য) --}}
                @if($more_categories->count() > 0)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="bibidhoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            বিবিধ
                        </a>
                        <ul class="dropdown-menu border-0 shadow rounded-0" aria-labelledby="bibidhoDropdown">
                            @foreach($more_categories as $moreCategory)
                                <li>
                                    <a class="dropdown-item" href="{{ route('front.category.news', $moreCategory->slug) }}">
                                        {{ $moreCategory->eng_name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif

            </ul>
        </div>
    </nav>
</div>