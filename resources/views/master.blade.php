<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0,
                    maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title')</title>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
          crossorigin="anonymous">
    <link rel="stylesheet" href="/css/masterstyle.css" >

    {{--<script src="/js/pace.js"></script>--}}
    {{--<link rel="stylesheet" href="/css/pace-theme-mac-osx.css" >--}}

    @yield('head')

</head>
<body>

  <div class="container">

    {{-- -- -- -- language menu on top of every page -- -- -- -- -- --}}
    @section('langmenu')

    <div class="dropdown">
      <button class="btn btn-success dropdown-toggle"
              type="button" id="dropdownMenu1" data-toggle="dropdown"
              style="display:inline-block; position:relative; z-index:1;"
              aria-haspopup="true"
              aria-expanded="false">
              Language
              <span class="caret"></span>
      </button>
        <ul class="dropdown-menu" style="min-width:100%"
            aria-labelledby="dropdownMenu1">
          <li><a href="/english">English</a></li>
          <li><a href="/finnish">Suomeksi</a></li>
        <!--  <li><a href="/french">French</a></li> -->
        </ul>
    </div>
    @show

  {{-- -- -- -- -- -- -- page heading(s) -- -- -- -- -- -- -- -- --}}
  <div class="heading">
    @yield('heading')
  </div>
  

  {{-- -- -- -- -- -- -- navigation bar -- -- -- -- -- -- -- -- --}}
  <div class="navbar">
        @yield('navbar')
  </div>

  {{-- -- -- -- -- -- -- main content of the page -- -- -- -- -- --}}
        @yield('content')


  {{-- -- -- -- -- footer for all pages -- -- -- -- -- --}}
  <footer>
      <p>2017 Real-time traffic flow on the streets of Tampere</p>
  </footer>

</div> <!-- container ends -->

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>

</body>
</html>