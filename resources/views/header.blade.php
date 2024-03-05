
<div class="header-navbar navbar floating-nav" style="width: 100% !important;">
  <div class="col-3 d-flex">
    <div class="row" style="margin-left: 20px !important;">
      <div class="col-5"><img src="{{ asset('app-assets/images/logo/logo_macmillan_header.svg') }}" width="200" height="80"></div>
    </div>
  </div>
  <nav class="header-navbar navbar navbar-expand-lg align-items-center navbar-light">
    <div class="navbar-container d-flex content">
      
      <ul class="nav navbar-nav align-items-center ms-auto">

        <li class="list-item align-items-center">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">
            <img src="{{asset('app-assets/images/icons/dashboard_icons/ico_Mesa_de_ayuda.svg')}}"  height="35" width="35" class="">
          </a>
          <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
              <div class="card mb-0">
                <div class="card-body p-1">
                  <h4 class="notification-title mb-1 me-auto">Mesa de Ayuda</h4>
                  <span>Si usted tiene algún comentario, duda o incidencia respecto a nuestros recursos digitales, puede escribirnos a:
                   <br>
                   <a href="mailto:mx.explico@macmillaneducation.com">México: mx.explico@macmillaneducation.com</a><br>
                   <a href="mailto:co.explico@macmillaneducation.com">Colombia: co.explico@macmillaneducation.com</a><br>

                   o al WhatsApp <a href="https://wa.me/+525538562290" target="_blank">+52 55-3856-2290</a>, donde será un gusto atenderlo.</span>
                </div>
              </div>
          </ul>
        </li>

        <!--<li class="nav-item dropdown dropdown-language">
          <a class="nav-link dropdown-toggle" id="dropdown-flag" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="selected-language">
              <img src="{{asset('app-assets/images/icons/dashboard_icons/ico_Menu_redes.svg')}}"  height="35" width="35" class="">
            </span>
          </a>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-flag">
            <a class="dropdown-item" href="{{route('set_language', ['es'])}}" data-language="es">
              <i class="flag-icon flag-icon-mx"></i> {{ __('Spanish') }}</a>
            <a class="dropdown-item" href="{{route('set_language', ['en'])}}" data-language="en">
              <i class="flag-icon flag-icon-us"></i> {{ __('English') }}</a>
            {{-- <a class="dropdown-item" href="#" data-language="de"><i class="flag-icon flag-icon-de"></i> German</a>
            <a class="dropdown-item" href="#" data-language="pt"><i class="flag-icon flag-icon-pt"></i> Portuguese</a> --}}
          </div>
        </li>-->
  
        <li class="nav-item dropdown dropdown-notification me-25">
          @if (Session('user'))
          <!--<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" >
            <img src="{{asset('app-assets/images/icons/dashboard_icons/ico_Menu_plataformas.svg')}}"  height="35" width="35" class="">
          </a>-->
          @endif
          
          {{-- <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
            <div class="card mb-0">
              <div class="card-body p-1">
                <h5 class="notification-title mb-1 me-auto text-center">Mis plataformas</h5>
                @if (Session('user'))
                <a href="{{route('assemble',session('user')[0]->usuario_cct_id)}}" class="btn btn-primary waves-effect waves-float waves-light p-0 w-50 mx-auto">Ver plataformas</a>
                @endif
              </div>
            </div>
          </ul> --}}
        </li>

        {{-- <li class="nav-item dropdown dropdown-notification me-25">
          <a class="nav-link" href="#" data-bs-toggle="dropdown">
            <svg xmlns="http://www.w3.org/2000/svg" id="Capa_1" viewBox="0 0 36 36" width="35px" height="35px"><defs><style>.cls-1{fill:#fff;}.cls-2{fill:#999;}</style></defs><rect class="cls-2" x="2.76" y="2.76" width="30.48" height="30.48" rx="5.33" ry="5.33"/><g><g><path class="cls-1" d="M19.79,26.91c-.61,.06-1.21,.09-1.79,.09s-1.18-.03-1.8-.09c-.17,.3-.27,.65-.27,1.02,0,1.14,.92,2.07,2.07,2.07s2.07-.92,2.07-2.07c0-.37-.1-.72-.27-1.02Z"/><path class="cls-1" d="M19.38,7.38c0,.25-.07,.49-.18,.69-.38-.09-.78-.14-1.19-.14s-.81,.05-1.2,.14h0c-.12-.2-.18-.44-.18-.69,0-.76,.62-1.38,1.38-1.38s1.38,.62,1.38,1.38Z"/></g><path class="cls-1" d="M27,23.45l-.03-.19-.07-.44c-.19-1.17-2.43-3.17-2.52-4.46l-.11-1.55h0l-.15-2.08c-.14-1.96-1.09-3.7-2.52-4.9h.01s-.07-.06-.11-.09c-.17-.14-.36-.26-.54-.38-.11-.07-.21-.15-.33-.22-.28-.16-.56-.3-.86-.42-.03-.01-.06-.03-.09-.04-.53-.21-1.1-.31-1.67-.31h0c-.57,0-1.14,.1-1.67,.31-.03,.01-.06,.03-.09,.04-.3,.12-.59,.26-.86,.42-.11,.07-.22,.14-.32,.22-.19,.12-.37,.25-.54,.39-.03,.03-.07,.05-.11,.08h.01c-1.44,1.21-2.38,2.95-2.52,4.91l-.15,2.08h0l-.11,1.55c-.09,1.3-2.33,3.29-2.52,4.46l-.07,.45-.03,.19c-.01,.09,0,.17,0,.26,.01,.6,.38,1.15,.97,1.34h0c3.15,1.02,5.59,1.53,8.03,1.53,2.44,0,4.87-.51,8.03-1.53,.59-.19,.95-.73,.97-1.33,0-.09,.02-.18,0-.27Z"/></g></svg><span class="badge rounded-pill bg-danger badge-up">5</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
            <li class="dropdown-menu-header">
              <div class="dropdown-header d-flex">
                <h4 class="notification-title mb-0 me-auto">Notificationes</h4>
                <div class="badge rounded-pill badge-light-primary">5 Nuevos</div>
              </div>
            </li>
            <li class="scrollable-container media-list">
              <a class="d-flex" href="#">
                <div class="list-item d-flex align-items-start">
                  <div class="me-1">
                    <div class="avatar bg-light-danger">
                      <div class="avatar-content"><i class="avatar-icon" data-feather="x"></i></div>
                    </div>
                  </div>
                  <div class="list-item-body flex-grow-1">
                    <p class="media-heading"><span class="fw-bolder">Lorem Ipsum</span>&nbsp;is simply dummy text of the printing</small>
                  </div>
                </div>
              </a>
              <a class="d-flex" href="#">
                <div class="list-item d-flex align-items-start">
                  <div class="me-1">
                    <div class="avatar bg-light-success">
                      <div class="avatar-content"><i class="avatar-icon" data-feather="check"></i></div>
                    </div>
                  </div>
                  <div class="list-item-body flex-grow-1">
                    <p class="media-heading"><span class="fw-bolder">Lorem ipsum</span>&nbsp;lorem</p><small class="notification-text"> Lorem Ipsum has been the industry's standard dummy</small>
                  </div>
                </div>
              </a>
              <a class="d-flex" href="#">
                <div class="list-item d-flex align-items-start">
                  <div class="me-1">
                    <div class="avatar bg-light-warning">
                      <div class="avatar-content"><i class="avatar-icon" data-feather="alert-triangle"></i></div>
                    </div>
                  </div>
                  <div class="list-item-body flex-grow-1">
                    <p class="media-heading"><span class="fw-bolder">Lorem Ipsum</span>&nbsp;lorem</p><small class="notification-text"> Lorem Ipsum has been the industry's standard dummyy</small>
                  </div>
                </div>
              </a>
            </li>
          </ul>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-ED" aria-haspopup="true" aria-expanded="true">
                  <i class="me-50 far fa-edit" ></i>{{ __('Editar datos') }}</button>

                  <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-EP" aria-haspopup="true" aria-expanded="true">
                    <i class="me-50 fas fa-key" ></i>{{ __('Editar password') }}</button>

                  
                  <i class="me-50" data-feather="power"></i>{{ __('Logout') }}</a>
                  <form id="logout-form" action="{{ route('logout') }}" method="GET" class="d-none">
                    @csrf
                </form>
                
          </div>
        </li> --}}
        
        <li class="nav-item dropdown dropdown-notification me-25">
          <a class="nav-link" href="#" data-bs-toggle="dropdown">
            <img class="rounded-circle" width="35px" height="35px" src="{{session('photoPerfil') ? asset('app-assets/images/profile/user-uploads') . '/'.session('photoPerfil') : asset('app-assets/images/profile/user-uploads/ico_Avatar.svg')}}" alt="imagen usuario" style="object-fit: cover;  ">
          </a>

          <!--inicio de deplegable-->
          <ul class="dropdown-menu dropdown-menu-small dropdown-menu-end">
            <li class="scrollable-container media-list">
              <div class="dropdown-menu dropdown-menu-end border" aria-labelledby="dropdown-user">
                <li class="list-item align-items-center">
                  <div class="card mb-0">
                    <div class="card-body p-1">
                      <div class="user-avatar-section">
                        <div class="d-flex align-items-center flex-column">
                          <img class="rounded-circle" width="110px" height="110px" src="{{session('photoPerfil') ? asset('app-assets/images/profile/user-uploads') . '/'.session('photoPerfil') : asset('app-assets/images/profile/user-uploads/ico_Avatar.svg')}}"style="object-fit: cover;  ">

                          <div class="user-info text-center">
                            @if (Session('user'))
                              <h4>{{ session('user')[0]->nombres.' '.session('user')[0]->apellidos }}</h4>
                            @endif
                            <p class="media-heading"><span class="fw-bolder">{{session('user')[0]->email}}</span></p>
                            {{-- <span class="badge bg-light-secondary">Author</span> --}}
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="list-item align-items-center">
                  <a class="dropdown-item" href="{{route("usuario.editarDatos",['usuario_id' => Auth::user()->id, 'cct_actual' => session('usuario_id')])}}">
                    <i class="me-50" data-feather="user"></i> Mi perfil
                  </a>
                </li>
                <li class="list-item align-items-center">
                  <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="me-50" data-feather="power"></i>{{ __('Logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="GET" class="d-none">
                      @csrf
                  </form>
                </li>
              </div>
            </li>
          </ul>
          <!--fin de desplegable-->
          
         
        </li>
      </ul>
    </div>
  </nav>
</div>

{{-- <ul class="main-search-list-defaultlist d-none">
  <li class="d-flex align-items-center">
      <a href="#"><h6 class="section-label mt-75 mb-0">Files</h6></a>
  </li>
  <li class="auto-suggestion">
      <a class="d-flex align-items-center justify-content-between w-100" href="app-file-manager.html">
          <div class="d-flex">
              <div class="me-75"><img src="../../../app-assets/images/icons/xls.png" alt="png" height="32"></div>
              <div class="search-data">
                  <p class="search-data-title mb-0">Two new item submitted</p><small class="text-muted">Marketing Manager</small>
              </div>
          </div>
          <small class="search-data-size me-50 text-muted">&apos;17kb</small>
      </a>
  </li>
  <li class="auto-suggestion">
      <a class="d-flex align-items-center justify-content-between w-100" href="app-file-manager.html">
          <div class="d-flex">
              <div class="me-75"><img src="../../../app-assets/images/icons/jpg.png" alt="png" height="32"></div>
              <div class="search-data">
                  <p class="search-data-title mb-0">52 JPG file Generated</p><small class="text-muted">FontEnd Developer</small>
              </div>
          </div>
          <small class="search-data-size me-50 text-muted">&apos;11kb</small>
       </a>
  </li>
  <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100" href="app-file-manager.html">
      <div class="d-flex">
        <div class="me-75"><img src="../../../app-assets/images/icons/pdf.png" alt="png" height="32"></div>
        <div class="search-data">
          <p class="search-data-title mb-0">25 PDF File Uploaded</p><small class="text-muted">Digital Marketing Manager</small>
        </div>
      </div><small class="search-data-size me-50 text-muted">&apos;150kb</small></a></li>
  <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100" href="app-file-manager.html">
      <div class="d-flex">
        <div class="me-75"><img src="../../../app-assets/images/icons/doc.png" alt="png" height="32"></div>
        <div class="search-data">
          <p class="search-data-title mb-0">Anna_Strong.doc</p><small class="text-muted">Web Designer</small>
        </div>
      </div><small class="search-data-size me-50 text-muted">&apos;256kb</small></a></li>
  <li class="d-flex align-items-center"><a href="#">
      <h6 class="section-label mt-75 mb-0">Members</h6></a></li>
  <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="app-user-view-account.html">
      <div class="d-flex align-items-center">
        <div class="avatar me-75"><img src="../../../app-assets/images/portrait/small/avatar-s-8.jpg" alt="png" height="32"></div>
        <div class="search-data">
          <p class="search-data-title mb-0">John Doe</p><small class="text-muted">UI designer</small>
        </div>
      </div></a></li>
  <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="app-user-view-account.html">
      <div class="d-flex align-items-center">
        <div class="avatar me-75"><img src="../../../app-assets/images/portrait/small/avatar-s-1.jpg" alt="png" height="32"></div>
        <div class="search-data">
          <p class="search-data-title mb-0">Michal Clark</p><small class="text-muted">FontEnd Developer</small>
        </div>
      </div></a></li>
  <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="app-user-view-account.html">
      <div class="d-flex align-items-center">
        <div class="avatar me-75"><img src="../../../app-assets/images/portrait/small/avatar-s-14.jpg" alt="png" height="32"></div>
        <div class="search-data">
          <p class="search-data-title mb-0">Milena Gibson</p><small class="text-muted">Digital Marketing Manager</small>
        </div>
      </div></a></li>
  <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="app-user-view-account.html">
      <div class="d-flex align-items-center">
        <div class="avatar me-75"><img src="../../../app-assets/images/portrait/small/avatar-s-6.jpg" alt="png" height="32"></div>
        <div class="search-data">
          <p class="search-data-title mb-0">Anna Strong</p><small class="text-muted">Web Designer</small>
        </div>
      </div></a></li>
</ul> --}}
{{-- <ul class="main-search-list-defaultlist-other-list d-none">
  <li class="auto-suggestion justify-content-between"><a class="d-flex align-items-center justify-content-between w-100 py-50">
      <div class="d-flex justify-content-start"><span class="me-75" data-feather="alert-circle"></span><span>No results found.</span></div></a></li>
</ul> --}}