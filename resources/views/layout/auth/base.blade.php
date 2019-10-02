<!DOCTYPE html>
<html lang="id" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Pintaar Auth | @yield('title')</title>

    <link rel="shortcut icon" href="{{ asset('img/Pintaar-Logo.jpg') }}">

    <link rel="stylesheet" href="{{ asset('lib/AdminLTE-2.4.18/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/AdminLTE-2.4.18/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/AdminLTE-2.4.18/bower_components/Ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/AdminLTE-2.4.18/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/AdminLTE-2.4.18/plugins/iCheck/square/blue.css') }}">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @yield('extra-fonts')
    @yield('prerender-js')
    @yield('extra-css')
  </head>
  <body class="hold-transition register-page">
    @yield('content')
    <script src="{{ asset('lib/AdminLTE-2.4.18/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('lib/AdminLTE-2.4.18/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('lib/AdminLTE-2.4.18/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' /* optional */
        });
      });
    </script>

    <script src="{{ asset('js/app.js') }}"></script>

    @yield('extra-js')
  </body>
</html>
