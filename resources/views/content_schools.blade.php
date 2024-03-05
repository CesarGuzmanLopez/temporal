<div class="app-content content ">
  <div class="content-overlay"></div>
  <div class="header-navbar-shadow"></div>
  <div class="content-wrapper container-xxl p-0">
    <div class="content-header row">
      <div class="content-header-left col-md-9 col-12 mb-2">
        <!-- <h2 class="mb-0">{{__('Mis aplicaciones')}}</h2>
        @isset($cct)
          @if($pais_id == 45)
            <span>Clave del colegio: {{$cct}} </span>
          @else
            <span>CCT: {{$cct}} </span>
          @endif
        @endisset  -->
      </div>
    </div>
    <div class="content-body">

      <iframe id="manager" style="width:100%; height: 70vh;" src="https://360.edicionescastillo.com/manager-si/castillo?u={{$castillo_id}}&h=1&s=m#" ></iframe>
    
    </div>
  </div>
</div>
