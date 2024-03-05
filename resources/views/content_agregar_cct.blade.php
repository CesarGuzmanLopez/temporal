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
                      {{__('Agregar CCT')}}
                        <svg xmlns="http://www.w3.org/2000/svg" id="Capa_1" viewBox="0 0 24 24" width="35px" height="35px">
                          <defs><style>.cls-1{fill:#fff;}.cls-2{fill:#999;}</style></defs>
                          <path xmlns="http://www.w3.org/2000/svg" class="cls-2" d="M11.86,1.44C6.06,1.51,1.42,6.28,1.5,12.08c.08,5.8,4.84,10.43,10.64,10.36,5.8-.08,10.44-4.84,10.36-10.64-.08-5.8-4.84-10.44-10.64-10.36Zm1.16,3.5c1.07,0,1.38,.62,1.38,1.33,0,.88-.71,1.7-1.92,1.7-1.01,0-1.49-.51-1.46-1.35,0-.71,.59-1.68,2-1.68Zm-2.74,13.56c-.73,0-1.26-.44-.75-2.39l.84-3.45c.15-.55,.17-.77,0-.77-.22,0-1.17,.38-1.72,.76l-.36-.6c1.77-1.48,3.81-2.35,4.69-2.35,.73,0,.85,.86,.49,2.19l-.96,3.63c-.17,.64-.1,.86,.07,.86,.22,0,.94-.27,1.64-.82l.41,.55c-1.73,1.73-3.61,2.39-4.34,2.39Z"/>
                        </svg>
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
    
        <section >
        
      
            <div id="account-details" class="content" role="tabpanel" aria-labelledby="account-details-trigger">
        
            <div id="personal-info" class="content" role="tabpanel" aria-labelledby="personal-info-trigger">
              <div class="content-header">
                <h5 class="mb-0">{{ __('School Info') }}</h5>
                <small>{{ __('Enter your School info') }}</small>
              </div>
            <form id="form-paso2" method="POST" action="{{ Route('dashboard.agregarCct') }}" class="opt1">
              @csrf
              <input type="hidden" name="usuario_id" id="usuario_id" value="{{Auth::user()->id }}" >
                <div class="row mb-5">
                  <h5 for="cct">{{ __('Clave del Centro de Trabajo CCT') }}</h5>
                  <div class="mb-1 col-md-6">
                    <input type="text" name="texto_cct" id="texto_cct" class="form-control valida_cct" placeholder=""  onkeyup="mayus(this);"/>
                    <input type="hidden" name="id_cct" id="id_cct">
                    <input type="hidden" name="clave_cct" id="clave_cct">
                    <input type="hidden" name="nexus_cct" id="nexus_cct">
                  </div>
                  <div class="mb-1 col-md-2">
                    <button class="btn btn-primary btn-next" id="btn_validaCCTNuevo" type="button">
                      <span class="spinner-border spinner-border-sm" id="loader" role="status" aria-hidden="true" style="display: none"></span>
                      <span class="ms-25 align-middle">Valida CCT</span></button>
                  </div>
                </div>
                <div class="card mb-4" id="ficha_cct" style="display: none">
                </div>

                <div class="d-flex justify-content-between">
                
                  <button class="btn btn-primary btn-submit" id="envio_paso2" disabled>{{ __('Send') }}</button>
                </div>
              
              </form>
      
           
      
              
            </div>
          </div>
         
          </section>

      

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







