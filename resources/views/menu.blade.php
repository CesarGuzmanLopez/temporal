 <!--main menu-->
 <div class="main-menu menu-light menu-accordion menu-shadow" data-scroll-to-active="true" style="touch-action: none; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
  <div class="main-menu-content ps ps--active-y" >
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">  
        @if (session('rol_id')  != 26 && session('rol_id')  != 1)
        <li class="nav-item">
          <a class="d-flex align-items-center" href="@if(session('usuario_cct_id')){{route('assemble',session('usuario_cct_id'))}}@endif">
            <img src="{{asset('app-assets/images/icons/dashboard_icons/ico_Menu_plataformas.svg')}}"  height="25" width="25" class="img_dashboard">
            <span class="menu-title text-truncate">Mis plataformas</span>
          </a>
        </li>
        <li class="nav-item has-sub">
          <a class="d-flex align-items-center" href="#">
            <img src="{{asset('app-assets/images/icons/dashboard_icons/ico_Menu_CCT.svg')}}"  height="25" width="25" class="img_dashboard">
            <span class="menu-title text-truncate">Mi CCT</span>
          </a>
          <ul class="menu-content">
              @if (session('cctUsuario'))
                @foreach (session('cctUsuario')  as $post )
                <li @if($post->clave_cct == session('clave_cct')) class="active" @endif>
                    <a href="{{url('get-libros/'.Auth::user()->id.'/'.$post->clave_cct)}}" class="align-items-center">CCT: {{$post->clave_cct}} </a> 
                </li>
                @endforeach
              @endif
          </ul>
        </li>
        @endif
          <li>
            
          </li>

          {{-- <li class="nav-item has-sub ">
            <a class="d-flex align-items-center pl-2" href="#">
              <img src="{{asset('app-assets/images/icons/dashboard_icons/ico_Menu_notificaciones.svg')}}"  height="25" width="25" class="img_dashboard">
              <span class="menu-title text-truncate">Notificaciones</span>
            </a>
          </li> --}}
          {{-- <li class="nav-item has-sub ">
            <a class="d-flex align-items-center" href="#">
              <img src="{{asset('app-assets/images/icons/dashboard_icons/ico_Menu_tutoriales.svg')}}"  height="25" width="25" class="img_dashboard">
              <span class="menu-title text-truncate">Tutoriales</span>
            </a>
          </li>   --}}
          <li class=" nav-item">
            <a class="d-flex align-items-center" href="{{route("usuario.editarDatos",['usuario_id' => Auth::user()->id, 'cct_actual' => session('usuario_id')])}}">
              <img src="{{asset('app-assets/images/icons/dashboard_icons/ico_Usuario.svg')}}"  height="25" width="25" class="img_dashboard">
            <span class="menu-title text-truncate" data-i18n="Todo">Mi perfil</a>
          </li>
          @if (session('rol_id') == 26 || session('rol_id')  == 1)
          <li class=" nav-item"><a class="d-flex align-items-center" href="{{Route('usuario.form')}}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 36" width="35px" height="35px"><defs><style>.cls-1{fill:#fff;}.cls-2{fill:#999;}</style></defs><rect class="cls-2" x="2.76" y="2.76" width="30.48" height="30.48" rx="5.33" ry="5.33"/><g><g><rect class="cls-1" x="8.87" y="8.87" width="5.25" height="5.25"/><rect class="cls-1" x="21.87" y="8.87" width="5.25" height="5.25"/><rect class="cls-1" x="15.37" y="8.87" width="5.25" height="5.25"/></g><g><rect class="cls-1" x="8.87" y="15.37" width="5.25" height="5.25"/><rect class="cls-1" x="21.87" y="15.37" width="5.25" height="5.25"/><rect class="cls-1" x="15.37" y="15.37" width="5.25" height="5.25"/></g><g><rect class="cls-1" x="8.87" y="21.87" width="5.25" height="5.25"/><rect class="cls-1" x="21.87" y="21.87" width="5.25" height="5.25"/><rect class="cls-1" x="15.37" y="21.87" width="5.25" height="5.25"/></g></g></svg><span class="menu-title text-truncate" data-i18n="Todo"></span>Consulta de usuarios</a>
          </li>
          @endif
         
          {{-- <li class=" nav-item"><a class="d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modal-EP" href="">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 36"><defs><style>.cls-1{fill:#fff;}.cls-2{fill:#999;}</style></defs><rect class="cls-2" x="2.76" y="2.76" width="30.48" height="30.48" rx="5.33" ry="5.33"/><path class="cls-1" d="M24.01,17.4c.05-.44,.08-.89,.08-1.36,0-4.65-2.67-8.3-6.08-8.3s-6.08,3.64-6.08,8.3c0,.46,.03,.92,.08,1.36h-1.49v10.86h15v-10.86h-1.49Zm-5,5.14h0v3.7h-2.01v-3.7h0c-.44-.31-.72-.82-.72-1.4,0-.95,.77-1.73,1.73-1.73s1.73,.77,1.73,1.73c0,.58-.29,1.09-.72,1.4Zm-4.67-5.14c-.07-.44-.11-.89-.11-1.36,0-3.24,1.73-5.98,3.77-5.98s3.77,2.74,3.77,5.98c0,.47-.04,.92-.11,1.36h-7.33Z"/></svg><span class="menu-title text-truncate" data-i18n="Todo">Cambiar contraseña</span></a>
          </li>
          <li class=" nav-item"><a class="d-flex align-items-center" href="{{Route('usuario.form')}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg><span class="menu-title text-truncate" data-i18n="Todo">Consulta de usuarios</span></a>
          </li> --}}
          <li class="nav-item">
              @isset($castillo_id)
              @if($castillo_id!='')
              <a class="d-flex align-items-center" href="{{Route('moduloEscuelas',array('cct'=>$cct,'castillo_id'=>$castillo_id))}}" target="_blank">
              <img src="{{asset('app-assets/images/icons/dashboard_icons/ico_Menu_escuela.svg')}}"  height="25" width="25" class="img_dashboard">
              <span class="menu-title text-truncate">Mi escuela</a>
              @endif
              @endisset
          </li>
    
      </ul>  
</div>
</div>
<!--fiin main menu-->