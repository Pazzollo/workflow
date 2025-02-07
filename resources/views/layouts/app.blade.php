<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="icon" href="/docs/5.3/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  {{-- <script type="text/javascript">
    function showTime() {
      var date = new Date(),
          utc = new Date(Date.UTC(
            date.getFullYear(),
            date.getMonth(),
            date.getDate(),
            date.getHours()-2,
            date.getMinutes(),
            date.getSeconds()
          ));

      document.getElementById('time').innerHTML = utc.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
    }

    setInterval(showTime, 3000);
  </script> --}}
  <body>
    @include('partials.header')

    <div class="container-fluid">
        <div class="row">
        @auth
            <div class="col-1 p-0" id="sidebar">
                @include('partials.sidebar')
            </div>
        @endauth
            <div class="{{ Auth::check() ? 'col-11' : 'col-12' }}">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
<script src="https://kit.fontawesome.com/cc622e456c.js" crossorigin="anonymous"></script>
<script>
    let w = window.innerWidth;
    console.log(w);
    let sidebar = document.getElementById('sidebar');
    let resp = document.getElementsByClassName('resp');
    if (w < 1300) {
        for (let i = 0; i < resp.length; i++) {
            resp[i].style.display = 'none';
        }
    }
</script>
