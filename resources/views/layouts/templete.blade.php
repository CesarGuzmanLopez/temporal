
<!DOCTYPE html>
<html class="loading" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-textdirection="ltr">
  <!-- BEGIN: Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <title>Dashboard MLT</title>
    <link rel="apple-touch-icon" href="{{ secure_asset('app-assets/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ secure_asset('app-assets/images/ico/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/fonts/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/vendors/css/extensions/jstree.min.css')}}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/themes/dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/themes/bordered-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/themes/semi-dark-layout.css')}}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/plugins/extensions/ext-component-tree.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/pages/app-file-manager.css')}}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/style.css') }}">
    <!-- END: Custom CSS-->

    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/cropper.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/image.css') }}">

</head>
<!-- END: Head-->

  <!-- BEGIN: Body-->
  <body class="vertical-layout vertical-menu-modern 1-column navbar-floating footer-static   menu-collapsed" data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
    <!-- BEGIN: Header-->
    @yield('header')
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    @yield('menu')
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    @yield('content')
    <!-- END: Content-->


    <!-- BEGIN: Customizer-->
   
    <!-- End: Customizer-->

    <!-- Buynow Button-->
    
    <!-- BEGIN: Footer-->
    @yield('footer')
    <!-- END: Footer-->


<!-- BEGIN: Vendor JS-->
<script src="{{ secure_asset('app-assets/vendors/js/vendors.min.js')}}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{ secure_asset('app-assets/vendors/js/extensions/jstree.min.js')}}"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ secure_asset('app-assets/js/core/app-menu.js')}}"></script>
<script src="{{ secure_asset('app-assets/js/core/app.js')}}"></script>
<!-- END: Theme JS-->

<script src="{{ secure_asset('app-assets/js/scripts/forms/form-rest-complete.js') }}"></script>
<script src="{{ secure_asset('app-assets/js/scripts/images/cropper.js') }}"></script>
<script src="{{ secure_asset('app-assets/js/scripts/images/main.js') }}"></script>

    <script>
      $(window).on('load',  function(){
        if (feather) {
          feather.replace({ width: 14, height: 14 });
        }
      })
    </script>
  </body>
  <!-- END: Body-->
</html>