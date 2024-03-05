<!-- Horizontal Wizard -->
<div class="app-content content" >
  <div class="content-overlay"></div>
  <div class="header-navbar-shadow"></div>
  <div class="content-wrapper container-xxl mt-3">
    <div class="content-header row">
      <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
          <div class="col-12">
            <h2 class="content-header-title float-start mb-0">{{__('Complete your register')}}</h2>  
          </div>
        </div>
      </div>
    </div>
    <div class="content-body"><!-- Horizontal Wizard -->
      <!--si hay un error-->
      @if (session('success'))
      <div class="alert alert-success p-1" role="alert">
          {{ session('success') }}
      </div>
      @endif
      @if (session('fail'))
          <div class="alert alert-danger p-1" role="alert">
              {{ session(__('fail')) }}
          </div>
      @endif
  
    <section class="horizontal-wizard">
    <div class="bs-stepper horizontal-wizard-example">
    <div class="bs-stepper-header" role="tablist">
      <div class="step" data-target="#account-details" role="tab" id="account-details-trigger">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-box">
            <img src="{{ secure_asset('app-assets/images/icons/ico_ipersonal_red.png')}}" alt="docente" class="icon_pasos">
          </span>
          <span class="bs-stepper-label">
            <span class="bs-stepper-title">{{ __('Account Details')}}</span>
            {{-- <span class="bs-stepper-subtitle">{{ __('Personal Info') }}</span> --}}
          </span>
        </button>
      </div>
      <div class="line">
        <i data-feather="chevron-right" class="font-medium-2"></i>
      </div>
      <div class="step" data-target="#personal-info" role="tab" id="personal-info-trigger">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-box">
            <img src="{{ secure_asset('app-assets/images/icons/ico_iescolar_red.png')}}" alt="colegio" class="icon_pasos">
          </span>
          <span class="bs-stepper-label">
            <span class="bs-stepper-title">{{ __('School Info')}}</span>
            {{-- <span class="bs-stepper-subtitle">{{ __('Add School Info')}}</span> --}}
          </span>
        </button>
      </div>
   
    </div>
    <div class="bs-stepper-content">
      <div id="account-details" class="content" role="tabpanel" aria-labelledby="account-details-trigger">
        {{-- <div class="content-header">
          <h5 class="mb-0">{{ __('Account Details')}}</h5>
          <small class="text-muted">{{ __('Enter Your Account Details.') }}</small>
        </div> --}}

        {{-- {{ session()->get('user')->'0'}} --}}
        {{-- {{ $data }} --}}
        <form id="form-paso1">
          @csrf
          <input type="hidden" name="usuario_id" id="usuario_id" value="{{ Auth::user()->id }}" >
          <div class="row">
            <div class="mb-1 col-md-6">
              <div class="mb-1">
                <label class="form-label" for="rol">{{ __('Rol')}}</label>
                <div class="row custom-options-checkable g-1">
                    <div class="col-sm-3 col-md-6">
                        <input class="custom-option-item-check" type="radio" name="rol" id="rol" value="3" checked="">
                        <label class="custom-option-item p-1" for="rol">
                            <span class="d-flex flex-wrap mb-50">
                              <span class="fw-bolder">
                                <img src="{{ secure_asset('app-assets/images/icons/ico_user_red.png')}}" alt="docente" class="icon_user">
                              </span>
                              <span class="fw-bolder">{{__('Teacher')}}</span>
                            </span>
                        </label>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <input disabled class="custom-option-item-check" type="radio" name="rol" id="rol2" value="25" data-bs-toggle="modal" data-bs-target="#new-folder-modal">
                        <label class="custom-option-item p-1" for="rol2">
                            <span class="d-flex flex-wrap mb-50">
                              <span class="fw-bolder">
                                <img src="{{ secure_asset('app-assets/images/icons/ico_iescolar_gray.png')}}" alt="alumno" class="icon_user">
                              </span>
                              <span class="fw-bolder">{{__('Student')}}</span>
                            </span>
                        </label>
                    </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="mb-1 col-md-6">
              <label class="form-label" for="first-name">{{ __('Name')}}</label>
              <input
                type="text"
                name="first-name"
                id="first-name"
                class="form-control"
                placeholder=""
                aria-label="name"
                value=" @if (Session('user')){{ session('user')[0]->nombres }}@endif"
              />
            </div>
            <div class="mb-1 form-password-toggle col-md-6">
              <label class="form-label" for="lastname">{{ __('Lastname')}}</label>
              <input
                type="text"
                name="last-name"
                id="last-name"
                class="form-control"
                placeholder=""
                value=" @if (Session('user')){{ session('user')[0]->apellidos }}@endif"
              />
            </div>
          </div>
          <div class="row">
            <div class="mb-1 col-md-6">
              <label class="form-label" for="country">{{ __('Country')}}</label>
              <select class="select2 w-100" name="country" id="country">
                <option label=" "></option>
                @foreach ($paises as $pais)
                 {{-- @if ($pais->activo==1) --}}
                 @if ($pais->id == 138)
                  <option value="{{ $pais->id }}" @if (Session('user'))@if($pais->id == session('user')[0]->pais_id ) selected @endif @endif>{{ $pais->nombre }}</option>
                 @endif
                @endforeach
              </select>
            </div>
            
            <div class="mb-1 form-password-toggle col-md-2">
              <label class="form-label" for="lada_phone">{{ __('Lada')}}</label>
              <input
              type="text"
              name="lada-phone"
              id="lada_phone"
              class="form-control"
              value="@if(Session('user')){{session('user')[0]->telefonomovillada}}@endif"
              readonly="readonly"
            />
          </div>
          <div class="mb-1 form-password-toggle col-md-4">
            <label class="form-label" for="mobile-phone">{{ __('Mobile Phone')}}</label>
              <input
                type="text"
                name="mobile-phone"
                id="mobile_phone"
                class="form-control"
                value="@if (Session('user')){{session('user')[0]->telefonomovil}}@endif"
              />
            </div>
          </div>
        <div class="row">
          <div class="mb-1">
            <div class="form-check ">
                <input class="form-check-input " id="register-privacy-policy" name="privacy_policy" type="checkbox" tabindex="4" value="1" @if (Session('user'))@if(session('user')[0]->terminos_condiciones==1 ) checked @endif @endif>
                <label class="form-check-label" for="privacy_policy">
                    {{-- Estoy de acuerdo con los --}}
                    He leído y estoy de acuerdo con el 
                    {{-- <a href="https://www.edicionescastillo.com/terminos-y-condiciones" target="_blank">Términos del servicio</a>
                    y la --}}
                    <a href="https://www.edicionescastillo.com/aviso-de-privacidad" target="_blank">Aviso de privacidad</a>
                </label>
            </div>  
          </div>
        </div>
        </form>
        <div class="d-flex justify-content-between">
          <button class="btn btn-outline-secondary btn-prev" disabled>
            <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
            <span class="align-middle d-sm-inline-block d-none">{{ __('Previous')}}</span>
          </button>
          <button class="btn btn-primary btn-next">
            <span class="align-middle d-sm-inline-block d-none">{{ __('Next')}}</span>
            <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
          </button>
        </div>
      </div>
      <div id="personal-info" class="content" role="tabpanel" aria-labelledby="personal-info-trigger">
        <div class="content-header">
          <h5 class="mb-0">{{ __('School Info') }}</h5>
          <small>{{ __('Enter your School info') }}</small>
        </div>
      <form id="form-paso2" method="POST" action="{{ Route('post.edit.paso2') }}" class="opt1">
        @csrf
        <input type="hidden" name="usuario_id" id="usuario_id" value="{{Auth::user()->id }}" >
          <div class="row mb-5">
            <h5 for="cct"><label id="text_titulo"></label>
              <label id="tooltip_msg" data-bs-toggle="tooltip" title="" data-bs-original-title="La clave del colegio será proporcionada por su representante de ventas"><i data-feather='alert-circle'></i>
              </label>
            </h5>
            <div class="mb-1 col-md-6">
              <input type="text" name="texto_cct" id="texto_cct" class="form-control valida_cct" placeholder=""  onkeyup="mayus(this);"/>
              <input type="hidden" name="id_cct" id="id_cct">
              <input type="hidden" name="clave_cct" id="clave_cct">
              <input type="hidden" name="nexus_cct" id="nexus_cct">
            </div>
            <div class="mb-1 col-md-2">
              <button class="btn btn-primary btn-next" id="btn_validaCCT" type="button">
                <span class="spinner-border spinner-border-sm" id="loader" role="status" aria-hidden="true" style="display: none"></span>
                <span class="ms-25 align-middle">Valida CCT</span></button>
            </div>
          </div>
          <div class="card mb-4" id="ficha_cct" style="display: none">
          </div>
          {{-- <div class="row mb-3">
            <h6 class="">{{ __('Esta sección aparece si es pública,  y tiene adopciones')}}</h6>
            <div class="col-4">
              <a class="btn btn-success w-100 waves-effect waves-float waves-light" data-bs-toggle="collapse" href="#collapse1" role="button" aria-expanded="true" aria-controls="collapseExample">
                <h3 class="text-white">1o.</h3>Primer grado
              </a>
              <div class="collapse" id="collapse1" style="">
                <div class="p-1">
                  <div class="form-check form-check-success">
                    <input type="checkbox" class="form-check-input" id="colorCheck1" >
                    <label class="form-check-label" for="colorCheck1">Primary</label>
                  </div>
                  <div class="form-check form-check-success">
                    <input type="checkbox" class="form-check-input" id="colorCheck1" >
                    <label class="form-check-label" for="colorCheck1">Primary</label>
                  </div>
                  <div class="form-check form-check-success">
                    <input type="checkbox" class="form-check-input" id="colorCheck1" >
                    <label class="form-check-label" for="colorCheck1">Primary</label>
                  </div>
                  <div class="form-check form-check-success">
                    <input type="checkbox" class="form-check-input" id="colorCheck1" >
                    <label class="form-check-label" for="colorCheck1">Primary</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-4">
              <a class="btn btn-info w-100 waves-effect waves-float waves-light" data-bs-toggle="collapse" href="#collapse2" role="button" aria-expanded="true" aria-controls="collapseExample">
                <h3 class="text-white">2o.</h3>Segundo grado
              </a>
              <div class="collapse" id="collapse2" style="">
                <div class="p-1">
                  <div class="form-check form-check-info">
                    <input type="checkbox" class="form-check-input" id="colorCheck1" >
                    <label class="form-check-label" for="colorCheck1">Primary</label>
                  </div>
                  <div class="form-check form-check-info">
                    <input type="checkbox" class="form-check-input" id="colorCheck1" >
                    <label class="form-check-label" for="colorCheck1">Primary</label>
                  </div>
                  <div class="form-check form-check-info">
                    <input type="checkbox" class="form-check-input" id="colorCheck1" >
                    <label class="form-check-label" for="colorCheck1">Primary</label>
                  </div>
                  <div class="form-check form-check-info">
                    <input type="checkbox" class="form-check-input" id="colorCheck1" >
                    <label class="form-check-label" for="colorCheck1">Primary</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-4">
              <a class="btn btn-warning w-100 waves-effect waves-float waves-light" data-bs-toggle="collapse" href="#collapse3" role="button" aria-expanded="true" aria-controls="collapseExample">
                <h3 class="text-white">3o.</h3>Tercer grado
              </a>
              <div class="collapse" id="collapse3" style="">
                <div class="p-1">
                  <div class="form-check form-check-warning">
                    <input type="checkbox" class="form-check-input" id="colorCheck1" >
                    <label class="form-check-label" for="colorCheck1">Primary</label>
                  </div>
                  <div class="form-check form-check-warning">
                    <input type="checkbox" class="form-check-input" id="colorCheck1" >
                    <label class="form-check-label" for="colorCheck1">Primary</label>
                  </div>
                  <div class="form-check form-check-warning">
                    <input type="checkbox" class="form-check-input" id="colorCheck1" >
                    <label class="form-check-label" for="colorCheck1">Primary</label>
                  </div>
                  <div class="form-check form-check-warning">
                    <input type="checkbox" class="form-check-input" id="colorCheck1" >
                    <label class="form-check-label" for="colorCheck1">Primary</label>
                  </div>
                </div>
              </div>
            </div>

          <div class="row mb-3">
          </div>
          </div> --}}

          {{-- <div class="row">
            <h6 class="">{{ __('Si no conoces tu cct, completa la siguiente información')}}</h6>
            <div class="mb-1 col-md-6">
              <label class="form-label" for="entidad">{{ __('Entidad') }}</label>
              <select class="form-control select2 w-100" id="entidad" name="entidad">
                <option label=" "></option>

                @foreach ($estados as $estado)
                  <option value="{{$estado->clave_entidad_federativa}}">{{$estado->nombre_entidad}}</option>
                @endforeach
                
              </select>
            </div>
            <div class="mb-1 col-md-6">
              <label class="form-label" for="municipio">{{ __('Delegación o Municipio') }}</label>
              <select class="select2 w-100" name="municipio" id="municipio">
                <option label="{{ __('Select option') }}"></option>
              </select>
            </div>
            
          </div>
          <div class="row">
            <div class="mb-1 col-md-6">
              <label class="form-label" for="localidad">{{ __('Localidad') }}</label>
              <select class="select2 w-100" name="localidad" id="localidad">
                <option label="{{ __('Select option') }}"></option>
              </select>
            </div>
            <div class="mb-1 col-md-6">
              <label class="form-label" for="cct_form">{{ __('Clave del centro de trabajo') }}</label>
              <select class="select2 w-100 valida_cct" name="combo_cct" id="combo_cct">
                <option label="{{ __('Select option') }}"></option>
              </select>
            </div>
          </div> --}}
        </form>

        <!--SI ES OTRO PAÍS-->
        {{-- <form id="form-paso2" method="POST" action="{{ Route('post.edit.paso2') }}" class="opt2">
        @csrf
        <input type="hidden" name="usuario_id" id="usuario_id" value="{{Auth::user()->id }}" >
          <div class="row">
            <div class="mb-1 col-md-6">
              <label class="form-label" for="cct">{{ __('Instutute name') }}</label>
              <input type="text" name="nombre_escuela" id="nombre_escuela" class="form-control" placeholder="" />
            </div>
          </div>
          
        </form> --}}
        <!--FIN SI ES OTRO PAÍS-->

        <div class="d-flex justify-content-between">
          <button class="btn btn-primary btn-prev">
            <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
            <span class="align-middle d-sm-inline-block d-none">{{ __('Previous') }}</span>
          </button>
          <button class="btn btn-primary btn-submit" id="envio_paso2" disabled>{{ __('Send') }}</button>
        </div>
      </div>
    </div>
    </div>
    </section>
    <!-- Create New Folder Modal Starts-->
    <div class="modal fade" id="new-folder-modal">
      <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <div class="modal-header">
          <h5 class="modal-title">Registro de Alumno</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
          <h6 class="files-section-title mt-2 mb-75">
              Al aceptar la Política de privacidad declaras
              ser mayor de edad. Si aún no cumples los 18
              años, deberá registrarse tu padre o tutor.</h6>
          </div>
          <div class="modal-footer">
          </div>
      </div>
      </div>
  </div>
  <!-- /Create New Folder Modal Ends -->

    </div>
  </div>
</div>