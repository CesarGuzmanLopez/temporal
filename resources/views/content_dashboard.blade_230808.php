<!-- BEGIN: Content-->
<div class="app-content content ">
  <div class="content-overlay"></div>
<div class="header-navbar-shadow"></div>
  <div class="content-wrapper container-xxl pt-3">
      <div class="content-header floating-nav">
          <div class="content-header-left col-8 ">
            <ul class="nav nav-pills">
              <li class="align-self-center">
                <a class="align-items-center modern-nav-toggle" href="#">
                  <div class="icon-wrapper">
                    <i data-feather='menu'></i>
                  </div>
                </a>
              </li>
              <li>
                <div class="mb-0 px-1">
                    <h2 class="display-6">
                      {{__('Mis plataformas')}}
                      <img src="{{asset('app-assets/images/icons/dashboard_icons/ico_Info.svg')}}"  height="50" width="50" class="img_dashboard">
                    </h2>
                    
                </div>
              </li>
            </ul>
            {{-- @isset($cct)
            <span>CCT: {{$cct}} </span>
            @endisset  --}}
          </div>
      </div>
      <div class="content-body">
       
        {{-- {{Auth::user();}} --}}

          <!-- Plataformas -->
          {{-- <section id="Plataformas" class="ml-200" style="margin-left: 200px"> --}}
            <section id="Plataformas" class="ml-200">
              <!--si hay un error-->
              
           
            @isset($plataformas)
            <div class="row">
              <div class="col-12">
                @isset($existeenBL)
                  @if($existeenBL==1) {{-- si ya han ingresado una licencia aparece un boton para agregar más --}}
                    <div class="col-sm-1 col-2 col-xs-1 w-sm ms-auto">
                        <a href="#" id="addNewFile" data-bs-toggle="modal" data-bs-target="#modal-BL" aria-haspopup="true" aria-expanded="true" class="btn btn-primary btn-square-m position-fixed p-1" style="
                        z-index: 9;"><i data-feather='plus-circle' ></i><span class="align-middle"> Activa Licencia</span></a>
                    </div>
                  @endif
                @endisset
              </div>
            </div>
            <div class="row">
                  
                  <div class="col-11 mx-auto">
                      @if (session('success'))
                      <div class="alert alert-success alert-dismissible fade show  ml-1" role="alert">
                        <div class="alert-body">
                          {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                      @endif
                      @if (session('fail'))
                      <div class="alert alert-danger alert-dismissible fade show ml-1" role="alert">
                        <div class="alert-body">
                          {{ session(__('fail')) }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                      @endif
                      @if($errors->any())
                      <div class="alert alert-danger alert-dismissible fade show ml-1" role="alert">
                        <div class="alert-body">
                          Ups! Existió un problema con la conexión, intenta más tarde.
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                      @endif
                      <div class="card  shadow-0">
                        <div class="alert alert-warning ml-1" role="alert">
                          @if($compruebaLicencia===0 or $publica_appCastillo===0)
                            <h4 class="alert-heading p-2"><i data-feather='alert-circle'></i> De clic en cada icono para activar y/o acceder a cada plataforma.</h4>
                          @endif
                        </div>
                       
                        <div class="card-body">
                          {{-- <p class="card-text mb-0">
                              Use a class <code>.btn-outline-{color}</code> to quickly create a outline button.
                          </p> --}}
                          <div class="row">
                            <!-- Outline buttons -->
                            <div class="col-11 mx-auto">
                              <div class="row">
                                @foreach ($plataformas as $plataforma)
                              
                                  @if($plataforma->sso =='BlinkLearning' and $compruebaLicencia == 1)
                                  
                                    @if (Auth::check())

                                    <div class="col-lg-4">
                                      <div class="contenedor_button border d-block mx-auto pt-4 mb-4">
                                        <button type="button"  class="btn btn-link p-0 shadow d-block mx-auto mb-2"
                                        onclick="window.open('{{url('getssorequest',['post' => $plataforma->sso,'usuario_cct_id'=> $usuario_cct_id])}}' , '_blank');">
                                        <img src="{{secure_asset('app-assets/images/icons/dashboard_icons/'.$plataforma->icono)}}" alt="platform_icon" >
                                        </button>
                                        <p class="card-text mx-auto">
                                          <h4 class="card-title fw-bold mb-1 text-center">{{$plataforma->nombre}}</h4>
                                          {{$plataforma->descripcion}}
                                        </p>
                                        <button type="submit" class="btn btn-outline-danger mx-auto d-block" onclick="window.open('{{url('getssorequest',['post' => $plataforma->sso,'usuario_cct_id'=> $usuario_cct_id])}}' , '_blank');">
                                          Acceder
                                        </button>
                                      </div>
                                    </div>
                                    
                                    @endif
              
                                    @elseif ($plataforma->sso == 'BlinkLearning')

                                    <div class="col-lg-4">
                                      <div class="contenedor_button border d-block mx-auto pt-4 mb-4">
                                        <button type="button"  class="btn btn-link p-0 shadow d-block mx-auto mb-2 opacity-50" data-bs-toggle="modal" data-bs-target="#modal-BL" aria-haspopup="true" aria-expanded="true">
                                          <img src="{{secure_asset('app-assets/images/icons/dashboard_icons/'.$plataforma->icono)}}" alt="platform_icon">
                                        </button>
                                        <p class="card-text mx-auto">
                                          <h4 class="card-title fw-bold mb-1 text-center">{{$plataforma->nombre}}</h4>
                                          {{$plataforma->descripcion}}
                                        </p>
                                        <button type="submit" class="btn btn-outline-danger mx-auto d-block" data-bs-toggle="modal" data-bs-target="#modal-BL">
                                          Acceder
                                        </button>
                                      </div>
                                    </div>

                                  <!--  @elseif ($plataforma->sso == 'MarometaDigCO')

                                    <div class="col-lg-4">
                                      <div class="contenedor_button border d-block mx-auto pt-4 mb-4">
                                        <button type="button"  class="btn btn-link p-0 shadow d-block mx-auto mb-2 opacity-50" data-bs-toggle="modal" data-bs-target="#modal-BL" aria-haspopup="true" aria-expanded="true">
                                          <img src="{{secure_asset('app-assets/images/icons/dashboard_icons/'.$plataforma->icono)}}" alt="platform_icon">
                                        </button>
                                        <p class="card-text mx-auto">
                                          <h4 class="card-title fw-bold mb-1 text-center">{{$plataforma->nombre}}</h4>
                                          {{$plataforma->descripcion}}
                                        </p>
                                        <button type="submit" class="btn btn-outline-danger mx-auto d-block" data-bs-toggle="modal" data-bs-target="#modal-BL">
                                          Acceder
                                        </button>
                                      </div>
                                    </div>-->
                                    
                
                                    @elseif ($plataforma->sso == '360Macmillan')

                                    <div class="col-lg-4">
                                      <div class="contenedor_button border d-block mx-auto pt-4 mb-4">
                                        <form action="{{$plataforma->url}}" method="post" target="_blank">
                                          @csrf
                                          <input type="hidden" value="{{$matricula.'_'.$usuario_cct_id}}" name="token">
                                          <button type="submit"  class="btn btn-link p-0 shadow d-block mx-auto mb-2">
                                            <img src="{{secure_asset('app-assets/images/icons/dashboard_icons/'.$plataforma->icono)}}" alt="platform_icon" >
                                          </button>
                                        </form>
                                        <p class="card-text mx-auto">
                                          <h4 class="card-title fw-bold mb-1 text-center">{{$plataforma->nombre}}</h4>
                                          {{$plataforma->descripcion}}
                                        </p>
                                        <form action="{{$plataforma->url}}" method="post" target="_blank">
                                          @csrf
                                          <input type="hidden" value="{{$matricula.'_'.$usuario_cct_id}}" name="token">
                                          <button type="submit"  class="btn btn-outline-danger mx-auto d-block">
                                          Acceder
                                          </button>
                                        </form>
                                      </div>
                                    </div>
                                    
                                    
                                    @elseif ($plataforma->sso == '360Castillo')

                                    <div class="col-lg-4">
                                      <div class="contenedor_button border d-block mx-auto pt-4 mb-4">
                                        <form action="{{$plataforma->url}}" method="post" target="_blank">
                                          @csrf
                                          <input type="hidden" value="{{$matricula.'_'.$usuario_cct_id}}" name="token">
                                          <button type="submit"  class="btn btn-link p-0 shadow d-block mx-auto mb-2">
                                            <img src="{{secure_asset('app-assets/images/icons/dashboard_icons/'.$plataforma->icono)}}" alt="platform_icon" >
                                          </button>
                                        </form>
                                        <p class="card-text mx-auto">
                                          <h4 class="card-title fw-bold mb-1 text-center">{{$plataforma->nombre}}</h4>
                                          {{$plataforma->descripcion}}
                                        </p>
                                        <form action="{{$plataforma->url}}" method="post" target="_blank">
                                          @csrf
                                          <input type="hidden" value="{{$matricula.'_'.$usuario_cct_id}}" name="token">
                                          <button type="submit"  class="btn btn-outline-danger mx-auto d-block">
                                          Acceder
                                          </button>
                                        </form>
                                      </div>
                                    </div>
                                    
              
                                    @elseif($plataforma->sso == 'AppCastillo' and $publica_appCastillo == 0)
                                    @if (Auth::check())

                                    <div class="col-lg-4">
                                      <div class="contenedor_button border d-block mx-auto pt-4 mb-4">
                                        <button type="submit"  class="btn btn-link p-0 shadow d-block mx-auto mb-2 opacity-50"  onclick="window.open('{{url('get-libros/'.Auth::user()->id.'/'.$cct)}}' , '_self');">
                                          <img src = "{{secure_asset('app-assets/images/icons/dashboard_icons/'.$plataforma->icono)}}" alt="platform_icon">
                                        </button>
                                        <p class="card-text mx-auto">
                                          <h4 class="card-title fw-bold mb-1 text-center">{{$plataforma->nombre}}</h4>
                                          {{$plataforma->descripcion}}
                                        </p>
                                        <button type="submit"  class="btn btn-outline-danger mx-auto d-block" onclick="window.open('{{url('get-libros/'.Auth::user()->id.'/'.$cct)}}' , '_self');">
                                          Acceder
                                         </button>
                                      </div>
                                    </div>
                                    
                                    @endif
              
                                    @elseif($plataforma->sso == 'AppCastillo' and $publica_appCastillo == 1)

                                    <div class="col-lg-4">
                                      <div class="contenedor_button border d-block mx-auto pt-4 mb-4">
                                        <button type="submit"  class="btn btn-link p-0 shadow d-block mx-auto mb-2" data-bs-toggle="modal" data-bs-target="#modal-appCastillo" aria-haspopup="true" aria-expanded="true">
                                          <img src="{{secure_asset('app-assets/images/icons/dashboard_icons/'.$plataforma->icono)}}" alt="platform_icon" >
                                        </button>
                                        <p class="card-text mx-auto">
                                          <h4 class="card-title fw-bold mb-1 text-center">{{$plataforma->nombre}}</h4>
                                          {{$plataforma->descripcion}}
                                        </p>
                                        <button type="submit"  class="btn btn-outline-danger mx-auto d-block" data-bs-toggle="modal" data-bs-target="#modal-appCastillo">
                                          Acceder
                                         </button>
                                      </div>
                                    </div>

                                    @elseif($plataforma->sso == 'AppMacmillan' and $publica_appMacmillan== 0)
                                    @if (Auth::check())

                                    <div class="col-lg-4">
                                      <div class="contenedor_button border d-block mx-auto pt-4 mb-4">
                                        <button type="submit"  class="btn btn-link p-0 shadow d-block mx-auto mb-2 opacity-50"  onclick="window.open('{{url('get-libros/'.Auth::user()->id.'/'.$cct)}}' , '_self');">
                                          <img src = "{{secure_asset('app-assets/images/icons/dashboard_icons/'.$plataforma->icono)}}" alt="platform_icon">
                                        </button>
                                        <p class="card-text mx-auto">
                                          <h4 class="card-title fw-bold mb-1 text-center">{{$plataforma->nombre}}</h4>
                                          {{$plataforma->descripcion}}
                                        </p>
                                        <button type="submit"  class="btn btn-outline-danger mx-auto d-block" onclick="window.open('{{url('get-libros/'.Auth::user()->id.'/'.$cct)}}' , '_self');">
                                          Acceder
                                         </button>
                                      </div>
                                    </div>
                                    
                                    @endif
              
                                    @elseif($plataforma->sso == 'AppMacmillan' and $publica_appMacmillan == 1)

                                    <div class="col-lg-4">
                                      <div class="contenedor_button border d-block mx-auto pt-4 mb-4">
                                        <button type="submit"  class="btn btn-link p-0 shadow d-block mx-auto mb-2" data-bs-toggle="modal" data-bs-target="#modal-appMacmillan" aria-haspopup="true" aria-expanded="true">
                                          <img src="{{secure_asset('app-assets/images/icons/dashboard_icons/'.$plataforma->icono)}}" alt="platform_icon" >
                                        </button>
                                        <p class="card-text mx-auto">
                                          <h4 class="card-title fw-bold mb-1 text-center">{{$plataforma->nombre}}</h4>
                                          {{$plataforma->descripcion}}
                                        </p>
                                        <button type="submit"  class="btn btn-outline-danger mx-auto d-block" data-bs-toggle="modal" data-bs-target="#modal-appMacmillan">
                                          Acceder
                                         </button>
                                      </div>
                                    </div>
                                    
                                    @elseif($plataforma->sso == 'CED')

                                    <div class="col-lg-4">
                                      <div class="contenedor_button border d-block mx-auto pt-4 mb-4">
                                        <button type="button"  class="btn btn-link p-0 shadow d-block mx-auto mb-2"
                                        onclick="loginCED({{$usuario_cct_id }});">
                                          <img src="{{secure_asset('app-assets/images/icons/dashboard_icons/'.$plataforma->icono)}}" alt="platform_icon" >
                                        </button>
                                        <p class="card-text mx-auto">
                                          <h4 class="card-title fw-bold mb-1 text-center">{{$plataforma->nombre}}</h4>
                                          {{$plataforma->descripcion}}
                                        </p>
                                
                                        <button type="submit"  class="btn btn-outline-danger mx-auto d-block" onclick="loginCED({{$usuario_cct_id }});">
                                          Acceder
                                         </button>
                                         
                                      </div>
                                    </div>

                                    @elseif ($plataforma->sso == 'Guias' and $publica_appCastillo == 1)

                                    <div class="col-lg-4">
                                      <div class="contenedor_button border d-block mx-auto pt-4 mb-4">
                                        <form action="https://guias.edicionescastillo.com/sso/Sso/ssoLogin" method="post" target="_blank">
                                          @csrf
                                          <input type="hidden" value="{{$matricula}}" name="token">
                                          <button type="submit"  class="btn btn-link p-0 shadow d-block mx-auto mb-2">
                                            <img src="{{secure_asset('app-assets/images/icons/dashboard_icons/'.$plataforma->icono)}}" alt="platform_icon" >
                                          </button>
                                        </form>
                                        <p class="card-text mx-auto">
                                          <h4 class="card-title fw-bold mb-1 text-center">{{$plataforma->nombre}}</h4>
                                          {{$plataforma->descripcion}}
                                        </p>
                                        <form action="https://guias.edicionescastillo.com/sso/Sso/ssoLogin" method="post" target="_blank">
                                          @csrf
                                          <input type="hidden" value="{{$matricula}}" name="token">
                                          <button type="submit"  class="btn btn-outline-danger mx-auto d-block">
                                          Acceder
                                          </button>
                                        </form>
                                      </div>
                                    </div>

                                    @elseif ($plataforma->sso == 'Guias' and $publica_appCastillo == 0)

                                    <div class="col-lg-4">
                                      <div class="contenedor_button border d-block mx-auto pt-4 mb-4 ">
                                        <button type="button"  class="btn btn-link p-0 shadow d-block mx-auto mb-2 opacity-50"
                                        onclick="window.open('{{url('validaguias',['idusuario'=> Auth::user()->id ])}}' , '_blank');">
                                        <img src="{{secure_asset('app-assets/images/icons/dashboard_icons/'.$plataforma->icono)}}" alt="platform_icon" >
                                        </button>
                                        <p class="card-text mx-auto">
                                          <h4 class="card-title fw-bold mb-1 text-center">{{$plataforma->nombre}}</h4>
                                          {{$plataforma->descripcion}}
                                        </p>
                                        <button type="submit" class="btn btn-outline-danger mx-auto d-block" onclick="window.open('{{url('validaguias',['idusuario'=> Auth::user()->id ])}}' , '_blank');">
                                          Acceder
                                        </button>
                                      </div>
                                    </div>

                                  @endif
                                @endforeach
                              </div><!--fin row-->

                            </div><!-- fin Outline buttons -->
                          </div><!--fin row-->
                          
                        </div><!--fin card-body-->
                      
                      </div>
                  </div>
              </div>
            @endisset

            
          </section>
          <!-- Fin Plataformas -->

      

      

      <!-- Tutoriales-->
      {{-- <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
          <h2 class="mb-0">{{__('Mis tutoriales')}}</h2>  
        </div>
      </div>
      <section id="Tutoriales">
          <div class="row">
              <div class="col-12">
                  <div class="card">
                      <div class="card-body">
                          <div class="row">
                              <div class="col-lg-4 col-md-12 mb-1">
                                <div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/728195293?h=b636615311&title=0&byline=0&portrait=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>
                              </div>
                              <div class="col-lg-4 col-md-12 mb-1">
                                <div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/728194780?h=0fd8c649cd&title=0&byline=0&portrait=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>
                              </div>
                              <div class="col-lg-4 col-md-12 mb-1">
                                <div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/728195517?h=a7a4bc53f6&title=0&byline=0&portrait=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </section> --}}
      <!-- Fin Tutoriales -->
      </div>
  </div>
</div>
<!-- END: Content-->



<!-- Create modal-BL Starts-->
<div class="modal fade" id="modal-BL">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Activa Licencia</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{Route('activa.licencia')}}" method="POST">
      @csrf
      @if (Auth::check())
      <input type="hidden" name="usuario_cct_id" id="usuario_cct_id" value="{{ $usuario_cct_id }}" >
      @endif
      <div class="modal-body">
        <h6 class="files-section-title mt-2 mb-75">La licencia se encuentra en la primera página de tu libro.</h6>
        <input type="text" class="form-control" name="nueva_licencia" id="nueva_licencia" value="" placeholder="" required>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light" >Activar</button>
      </form>
        <button type="button" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<!-- /Create modal-BL Ends -->


<!-- Create modal-appCastillo Starts-->
<div class="modal fade" id="modal-appCastillo">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">App Castillo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h6 class="text-left">1. Descargar e instalar la APP en su dispositivo preferente.</h6>
        <a href="https://app.edicionescastillo.com/basica/apps/castillo.dmg" target="_blank"><span class="et_pb_image_wrap "><img src="https://www.edicionescastillo.com/nuevositio2020/wp-content/uploads/2020/05/uiu-graphic-macos.svg" alt="" title=""></span></a>
        <a href="https://apps.apple.com/mx/app/castillo-digital/id1249306149" target="_blank"><span class="et_pb_image_wrap "><img src="https://www.edicionescastillo.com/nuevositio2020/wp-content/uploads/2020/05/ui-graphic-appstore.svg" alt="" title=""></span></a>
        <a href="https://play.google.com/store/apps/details?id=mx.com.macmillan.castillo" target="_blank"><span class="et_pb_image_wrap "><img src="https://www.edicionescastillo.com/nuevositio2020/wp-content/uploads/2020/05/ui-graphic-googleplay.svg" alt="" title=""></span></a>
        <a href="https://app.edicionescastillo.com/basica/apps/castillo.exe" target="_blank"><span class="et_pb_image_wrap "><img src="https://www.edicionescastillo.com/nuevositio2020/wp-content/uploads/2020/05/ui-graphic-windows.svg" alt="" title=""></span></a>
        <h6 class="text-left">2. Ingresar con el mismo usuario y contraseña.</h6>
      </div>
      </div>
    </div>
</div>
<!-- /Create modal-BL Ends -->

<!-- Create modal-appCastillo Starts-->
<div class="modal fade" id="modal-appMacmillan">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">App Macmillan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h6 class="text-left">1. Descargar e instalar la APP en su dispositivo preferente.</h6>
        <a href="https://app.macmillanlatam.com/mm/apps/macmillan_latam_4.dmg" target="_blank"><span class="et_pb_image_wrap "><img src="https://www.edicionescastillo.com/nuevositio2020/wp-content/uploads/2020/05/uiu-graphic-macos.svg" alt="" title=""></span></a>
        <a href="https://apps.apple.com/us/app/macmillan-profesional/id1451460020?ls=1" target="_blank"><span class="et_pb_image_wrap "><img src="https://www.edicionescastillo.com/nuevositio2020/wp-content/uploads/2020/05/ui-graphic-appstore.svg" alt="" title=""></span></a>
        <a href="https://play.google.com/store/apps/details?id=mx.com.macmillan.profesional" target="_blank"><span class="et_pb_image_wrap "><img src="https://www.edicionescastillo.com/nuevositio2020/wp-content/uploads/2020/05/ui-graphic-googleplay.svg" alt="" title=""></span></a>
        <a href="https://app.macmillanlatam.com/mm/apps/macmillan_latam_4.exe" target="_blank"><span class="et_pb_image_wrap "><img src="https://www.edicionescastillo.com/nuevositio2020/wp-content/uploads/2020/05/ui-graphic-windows.svg" alt="" title=""></span></a>
        <h6 class="text-left">2. Ingresar con el mismo usuario y contraseña.</h6>
      </div>
      </div>
    </div>
</div>
<!-- /Create modal-BL Ends -->



<!-- Create modal-CED Starts-->
{{-- <div class="modal fade" id="modal-CED">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Activa Licencia CED</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{Route('activa.licenciaCED')}}" method="POST">
      @csrf
      @if (Auth::check())
      <input type="hidden" name="usuario_id" id="usuario_id" value="{{ Auth::user()->id }}" >
      @endif
      <div class="modal-body">
        <h6 class="files-section-title mt-2 mb-75">La licencia se encuentra en la primera página de tu libro.</h6>
        <input type="text" class="form-control" name="nueva_licencia" id="nueva_licencia" value="" placeholder="8 caracteres">
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light" data-bs-dismiss="modal"  >Activar</button>
      </form>
        <button type="button" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal">Cancel</button>
        @isset($plataforma)
        <button type="button" class="btn btn-outline-secondary waves-effect" onclick="window.open('{{url('getssorequest',['post' => 'CED','idusuario'=> Auth::user()->id ])}}' , '_blank');">Continuar al CED</button>
        @endisset
        @if (session('msg'))
        
          
          <META HTTP-EQUIV="REFRESH" CONTENT="0;URL='{{ session('msg') }}'">
        
        @endif
        
      </div>
    </div>
  </div>
</div> --}}
<!-- /Create modal-CED Ends -->


<script src="{{ asset('app-assets/js/scripts/jquery-3.6.1.min.js') }}"></script>
<script>
  
  $( document ).ready(function() {
    console.log( "ready!" );

    


    

    

    
  });

  function loginCED(usuarioID){
      //var usuarioID= '{!!Auth::user()->id!!}';
      console.log("entre CED");
        $.ajax({
            type : "GET",
            url: "/loginCED/"+usuarioID,
            dataType: "json",
            success: function(response){
              console.log(response);
              window.open(response.urlCED, 'Nombre Ventana');
            }
        });
    }
</script>