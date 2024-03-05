
<!DOCTYPE html>
<html class="loading" data-textdirection="ltr" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!-- BEGIN: Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registro Único MLT</title>
    <link rel="apple-touch-icon" href="{{ asset('app-assets/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ secure_asset('app-assets/images/ico/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/vendors/css/vendors.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/themes/bordered-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/themes/semi-dark-layout.css') }}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/plugins/forms/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/pages/authentication.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/style.css') }}">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
    
    <!-- BEGIN: Content-->
    @yield('content')
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{ secure_asset('app-assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    @yield('vendor-script')
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ secure_asset('app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ secure_asset('app-assets/js/core/app.js') }}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    @yield('page-script')
    <!-- END: Page JS-->

    <script>
        $(window).on('load', function() {
            if (feather) {//ver /ocultar password
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })

    // $("#rol2").on('click', function(){
    //     $("#mayoredad").removeClass().addClass("d-block");
    // });

    // $("#rol").on('click', function(){
    //     $("#mayoredad").removeClass().addClass("d-none");

    // });
    </script>
</body>
<!-- END: Body-->

</html>