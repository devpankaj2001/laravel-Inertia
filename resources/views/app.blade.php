<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Site Title Favicon (WR Monogram) -->
  <link rel="icon" type="image/svg+xml" href="{{ asset('asset/wr-favicon.svg') }}">
  <link rel="alternate icon" type="image/png" href="{{ asset('asset/wr-favicon.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('asset/wr-favicon.png') }}">

  <!-- Preconnect & Google Fonts for Core Web Vitals -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- Tailwind CSS CDN -->
  <script>
    (function () {
      var origWarn = console.warn;
      console.warn = function () {
        if (arguments[0] && String(arguments[0]).indexOf('cdn.tailwindcss.com') !== -1) return;
        return origWarn.apply(console, arguments);
      };
    })();
  </script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Urbanist', 'sans-serif'],
            heading: ['Urbanist', 'sans-serif'],
          },
          colors: {
            themeRed: '#ff3b30',
            themeDark: '#161514',
            bgWarm: '#faf7f2',
            cardWarm: '#f5efe6',
            borderWarm: '#e6dfd3',
          }
        }
      }
    }
  </script>

  <!-- FontAwesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- jQuery & Owl Carousel 2 -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

  <!-- Reference Design System Stylesheet -->
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <link rel="stylesheet" href="{{ asset('css/blog.css') }}">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css">

  @routes
  @viteReactRefresh
  @vite(['resources/js/app.jsx'])
  @inertiaHead
</head>
<body data-theme="red" class="bg-[#faf7f2] text-[#1a1816]">
  @inertia

  <!-- External JavaScript Libraries -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script src="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>
  <script src="https://unpkg.com/@turf/turf@6/turf.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>

  <!-- Core Custom Interactive Script -->
  <script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
