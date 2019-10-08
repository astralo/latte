<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ $title ?? 'Dashboard' }}</title>

  <link rel="stylesheet" href="{{ elixir('css/app.css') }}">

  @stack('header')

</head>
<body>

<div class="container">
  @yield('content')
</div>

<script src="{{ elixir('js/app.js') }}"></script>

@stack('footer')

</body>
</html>
