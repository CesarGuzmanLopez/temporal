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
                      {{__('Mis contenidos')}}
                      <img src="{{asset('app-assets/images/icons/dashboard_icons/ico_Info.svg')}}"  height="25" width="25" class="img_dashboard">
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

          <!-- Adopciones -->
            <section id="Adopciones" class="ml-200 contenedor_button d-block pt-2 mb-4 col-md-11 mx-auto">
              <!--si hay un error-->
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
              <div class="alert alert-danger ml-1" role="alert">
                <h4 class="alert-heading p-1">Ups! Existió un problema con la conexión, intenta más tarde.</h4>
              </div>
              @endif

              <div class="alert alert-warning ml-1 mb-3" role="alert">
                <h4 class="alert-heading p-1">
                  <i data-feather='alert-circle'></i> Elija el contenido por cada grado, puede agregar hasta {{$libros_max_elegir}} libros. 
                </h4>
              </div>
              <form action="{{route('insertaLibros')}}" method="POST">
                @csrf
              <div class="row mb-3">              
                @foreach ($grados as $grado)
                    <div class="col-md-4 mx-auto mb-2">
                      <a class="btn btn-outline-danger mx-auto d-block waves-effect" data-bs-toggle="collapse" href="#collapse{{$grado->id}}" role="button" aria-expanded="true" aria-controls="collapseExample">
                        <h3 class="text-danger">{{$grado->texto}}</h3>{{$grado->nombre.' '.$grado->grado_semestre_anio}}
                      </a>
                      @isset($libros)
                        @foreach ($libros as $libro)
                          @if($grado->id==$libro->grado_id)
                            <div class="collapse show" id="collapse{{$grado->id}}">
                              <div class="p-1">
                                <div class="form-check form-check-success">
                                  <input type="checkbox" class="form-check-input" id="colorCheck1" name="adopcion[]" value="{{$libro->adopcion_id}}" @if($libro->AdopTomada > 0) checked disabled @endif>
                                  <label class="form-check-label" for="colorCheck1">{{$libro->alias_360}}</label>
                                </div>
                              </div>
                            </div>
                          @endif
                        @endforeach
                      @endisset
                    </div>
                  @endforeach
              </div>

              
              <input type="hidden" name="cct" value="{{$cct}}">
              <div class="d-flex justify-content-center">
                <button class="btn btn-primary btn-submit" type="submit">{{ __('Send') }}</button>
              </div>
              
              </form>
            </section>
            <!-- Fin Adopciones -->
      </div>
  </div>
</div>
<!-- END: Content-->