
<!DOCTYPE html>
<html class="loading" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-textdirection="ltr">
  <!-- BEGIN: Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <title>Registro Único - Completa Datos</title>
    <link rel="apple-touch-icon" href="{{ secure_asset('app-assets/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ secure_asset('app-assets/images/ico/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/vendors/css/forms/wizard/bs-stepper.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/vendors/css/forms/select/select2.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/bootstrap-extended.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/colors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/components.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/themes/dark-layout.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/themes/bordered-layout.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/themes/semi-dark-layout.min.css') }}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/core/menu/menu-types/vertical-menu.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/plugins/forms/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/plugins/forms/form-wizard.css') }}">
    <!-- END: Page CSS-->

   <!-- BEGIN: Custom CSS-->
   <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/style.css') }}">
   <!-- END: Custom CSS-->

  </head>
  <!-- END: Head-->

  <!-- BEGIN: Body-->
  <body class="vertical-layout vertical-menu-modern 1-column navbar-floating footer-static   menu-collapsed" data-open="click" data-menu="vertical-menu-modern" data-col="1-column">

    <!-- BEGIN: Header-->
    @yield('header')
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    {{-- @yield('menu') --}}
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
    <script src="{{ secure_asset('app-assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ secure_asset('app-assets/vendors/js/forms/wizard/bs-stepper.min.js') }}"></script>
    <script src="{{ secure_asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ secure_asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ secure_asset('app-assets/js/core/app-menu.min.js') }}"></script>
    <script src="{{ secure_asset('app-assets/js/core/app.min.js') }}"></script>
    <script src="{{ secure_asset('app-assets/js/scripts/customizer.min.js') }}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ secure_asset('app-assets/js/scripts/forms/form-wizard.js') }}"></script>
    <!-- END: Page JS-->

    <script src="{{ secure_asset('app-assets/js/scripts/forms/form-rest-complete.js') }}"></script>
  </body>
  <!-- END: Body-->
</html>