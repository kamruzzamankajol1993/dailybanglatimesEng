<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="robots" content="index, follow">

    {{-- ডায়নামিক মেটা ট্যাগ সেকশন --}}
    @hasSection('meta')
        @yield('meta')
    @else
        {{-- ডিফল্ট মেটা ট্যাগ (হোম পেজ ও অন্যান্য পেজের জন্য) --}}
        <meta name="description" content="{{ $front_ins_d }}">
        <meta name="keywords" content="{{ $front_ins_k }}">
        <meta name="author" content="{{ $front_ins_name }} Team">

        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="{{ $front_ins_name }}">
        <meta property="og:description" content="{{ $front_ins_d }}">
        <meta property="og:image" content="{{ $front_admin_url }}{{ $front_english_header_logo }}">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $front_ins_name }}">
        <meta name="twitter:description" content="{{ $front_ins_d }}">
        <meta name="twitter:image" content="{{ $front_admin_url }}{{ $front_english_header_logo }}">
    @endif
   
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/') }}public/front/css/style.css">
    <link rel="shortcut icon" href="{{ $front_admin_url }}{{ $front_icon_name }}">
      @yield('css')
</head>
<body class="bg-light">


    <!-- Top Header Include -->
    @include('front.include.topHeader')
    <!-- End Top Header Include -->

     <!-- Header include -->
     @include('front.include.header')
    <!-- End Header include -->

    <!-- Headline Include -->
    @include('front.include.headline')
    <!-- End Headline Include -->

    <!-- Last Header Include -->
    @include('front.include.lastHeader')
    <!-- End Last Header Include -->


    <!-- Main Content -->
    @yield('body')
    <!-- End Main Content -->

    <!-- Footer Include -->
    @include('front.include.footer')
    <!-- End Footer Include -->

    <!-- Offcanvas Include -->
    @include('front.include.offcanvas')
    <!-- End Offcanvas Include -->
   
   
    
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script>
    function updateTime() {
        const date = new Date();
        const options = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            second: 'numeric',
            hour12: true,
            timeZone: 'Asia/Dhaka'
        };
        
        // Changed 'bn-BD' to 'en-US' to display in English
        let formattedDate = new Intl.DateTimeFormat('en-US', options).format(date);
        
        // Removed the .replace() lines since English AM/PM is default
        
        // Keeps the same ID 'banglaTime' so you don't have to change your HTML
        document.getElementById('banglaTime').innerHTML = '<i class="far fa-clock text-danger"></i> ' + formattedDate;
    }
    setInterval(updateTime, 1000);
    updateTime(); // Initial call
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // এলিমেন্ট সিলেক্ট করা
        var mobileHeader = document.querySelector('.sticky-top-mobile');
        var desktopNav = document.querySelector('.sticky-nav-desktop');
        var body = document.body;

        // ডেস্কটপের জন্য একটি ফাকা জায়গা (Placeholder) তৈরি করা যাতে মেনু ফিক্সড হলে কন্টেন্ট লাফ না দেয়
        var navPlaceholder = document.createElement("div");
        if (desktopNav) {
            navPlaceholder.style.height = desktopNav.offsetHeight + "px";
            navPlaceholder.style.display = "none"; // শুরুতে লুকানো থাকবে
            desktopNav.parentNode.insertBefore(navPlaceholder, desktopNav);
        }

        function handleStickyNavigation() {
            var width = window.innerWidth;
            var scrollPosition = window.scrollY;

            // ==========================================
            // ১. মোবাইল ভার্সন (Width < 992px)
            // ==========================================
            if (width < 992) {
                // ডেস্কটপ সেটিংস রিসেট করা
                if (desktopNav) {
                    desktopNav.style.position = '';
                    desktopNav.style.top = '';
                    navPlaceholder.style.display = "none";
                }

                if (mobileHeader) {
                    // মোবাইল হেডার ফিক্সড করা
                    mobileHeader.style.position = 'fixed';
                    mobileHeader.style.top = '0';
                    mobileHeader.style.left = '0';
                    mobileHeader.style.width = '100%';
                    mobileHeader.style.zIndex = '1030';
                    mobileHeader.style.boxShadow = '0 2px 5px rgba(0,0,0,0.1)';
                    
                    // বডি কন্টেন্ট যেন হেডারের নিচে না চলে যায়, তাই প্যাডিং দেওয়া
                    body.style.paddingTop = mobileHeader.offsetHeight + 'px';
                }
            } 

            // ==========================================
            // ২. ডেস্কটপ ভার্সন (Width >= 992px)
            // ==========================================
            else {
                // মোবাইল সেটিংস রিসেট করা
                if (mobileHeader) {
                    mobileHeader.style.position = '';
                    mobileHeader.style.width = '';
                    body.style.paddingTop = '0px';
                }

                if (desktopNav) {
                    // উপরের লোগো এবং টিকার সেকশনের হাইট (আনুমানিক ১৫০ পিক্সেল স্ক্রল করলে মেনু আটকাবে)
                    var triggerHeight = 260; 

                    if (scrollPosition > triggerHeight) {
                        // মেনু স্টিকি করা
                        desktopNav.style.position = 'fixed';
                        desktopNav.style.top = '0';
                        desktopNav.style.left = '0';
                        desktopNav.style.width = '100%';
                        desktopNav.style.maxWidth = '100%'; // কন্টেইনারের সাইজ ওভাররাইড করে ফুল উইডথ করা
                        desktopNav.style.zIndex = '1030';
                        desktopNav.style.backgroundColor = '#f42a41'; // লাল ব্যাকগ্রাউন্ড নিশ্চিত করা
                        desktopNav.style.boxShadow = '0 4px 6px rgba(0,0,0,0.1)';
                        
                        // প্লেসহোল্ডার দেখানো (কন্টেন্ট লাফানো বন্ধ করতে)
                        navPlaceholder.style.display = "block";
                        navPlaceholder.style.height = desktopNav.offsetHeight + "px";
                    } else {
                        // মেনু স্বাভাবিক অবস্থায় ফেরত আনা
                        desktopNav.style.position = 'relative'; // বা static
                        desktopNav.style.maxWidth = ''; // কন্টেইনার সাইজ ফেরত
                        desktopNav.style.boxShadow = 'none';
                        desktopNav.style.backgroundColor = ''; 
                        
                        // প্লেসহোল্ডার লুকানো
                        navPlaceholder.style.display = "none";
                    }
                }
            }
        }

        // স্ক্রল এবং রিসাইজ ইভেন্ট লিসেনার যোগ করা
        window.addEventListener('scroll', handleStickyNavigation);
        window.addEventListener('resize', handleStickyNavigation);
        
        // পেজ লোড হওয়ার সাথে সাথে একবার ফাংশনটি কল করা
        handleStickyNavigation();
    });
</script>
  @yield('scripts')
</body>
</html>