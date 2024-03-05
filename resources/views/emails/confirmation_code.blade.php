<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('app-assets/css/style.css') }}">

</head>
<body>

<div class="col-8 col-sm-8 col-md-6 col-lg-8 px-xl-2 mx-auto">
    <div class="shadow p-2 mb-1 bg-white rounded">
        <div class="col-6 col-sm-6 col-md-4">
            <img src="{{ secure_asset('app-assets/images/logo/logo_MacMillan.png') }}" alt="Macmillan Latam">
        </div>
   <p><strong> Estimado usuario: {{ $email }} </strong></p> 

    <p>Hemos recibido su solicitud de registro de su cuenta en Servicios Macmillan Latam.</p>

    <p>Por favor, haga clic en el botón de abajo para verificar su dirección de correo electrónico.</p>

    <div class="col-10 col-sm-12 col-md-8 col-lg-6 mx-auto">
        <a href="{{ url('/register/verify/' . $confirmation_code) }}" class="btn btn-primary" role="button" >
       Confirme su correo electrónico
        </a>
    </div></br>

    <p>Si no ha creado una cuenta, no se requiere ninguna acción adicional.</p>
    
    <p>Saludos,</p>
    <p><strong>Servicios Macmillan Latam.</strong></p>
    </div>
                           
</div>

    
</body>
</html>