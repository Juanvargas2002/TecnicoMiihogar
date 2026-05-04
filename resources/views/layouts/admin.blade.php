<!DOCTYPE html>
<html lang="en" class="">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel - Mi Hogar</title>

  <!-- Tailwind is included -->
  <link rel="stylesheet" href="{{ asset('admin/css/main.css?v=1628755089081') }}">

 @vite(['resources/css/app.css', 'resources/js/app.js'])

  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo_1.png') }}"/>
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo_32_21.png') }}"/>
  
</head>
<body>

<div id="app">

<nav id="navbar-main" class="navbar fixed top-0 right-0">
  @include('partials.header')
</nav>

<aside class="aside fixed top-0 left-0 flex-1 h-full">
    @include('partials.navbar')
</aside>

<section class="section main-section mt-10">
    @yield('content')
</section>

<footer class="section footer">
  @include('partials.footer')
</footer>

</div>

<!-- Scripts below are for demo only -->
<script type="text/javascript" src="{{ asset('admin/js/main.min.js?v=1628755089081') }}"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

<script type="text/javascript" src="{{ asset('admin/js/chart.sample.min.js') }}"></script>

<!-- Icons below are for demo only. Feel free to use any icon pack. Docs: https://bulma.io/documentation/elements/icon/ -->
<link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css">

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggleButton = document.querySelector('.my-aside-toggle');
        const html = document.documentElement; // or document.body if that's where you put the class styling

        if (toggleButton) {
            toggleButton.addEventListener('click', (e) => {
                e.preventDefault();
                html.classList.toggle('is-sidebar-hidden');
            });
        }
    });
</script>

@stack('scripts')
</body>
</html>
