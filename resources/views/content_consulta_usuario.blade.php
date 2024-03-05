<!-- BEGIN: Content consulta usuario-->
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
                      {{__('Consulta de usuarios')}}
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
    



    <section  class="contenedor_button  ml-200 row justify-content-center" >
      <div class="row justify-content-center ">
        <div class="col-md-6" >
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
  
        <div class="row">
            @error('password')
            <div class="alert alert-danger p-1" role="alert">
              {{ $message }}
            </div>
            
        @enderror

        <form method="GET" action="{{ Route('usuario.consulta') }}">
          @csrf


          <div class="row">
            <div class="mb-1 col-md-10">
              <label class="form-label" for="usuario_completo">{{ __('Estatus usuario')}}</label>
              <select class="form-control select2 w-100" name="usuario_completo" id="usuario_completo">
                  <option value="1" selected>Completo</option>
                  <option value="2">Incompleto</option>
              </select>
            </div>
        </div>

          <div class="row">
              <div class="mb-1 col-md-10">
                <label class="form-label" for="rol">{{ __('Rol')}}</label>
                <select class="form-control select2 w-100" name="rol" id="rol">
                  <option label=" "></option>
                  @foreach ($roles as $rol)
                    <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                  @endforeach
                </select>
              </div>
          </div>

          <div class="row">


            <div class="mb-1 col-md-10">
              <label class="form-label" for="nombre">{{ __('Nombre(s)')}}</label>
              <input
                type="text"
                name="nombre"
                id="nombre"
                class="form-control"
                placeholder=""
                aria-label="nombre"
                value=""
              />
            </div>
        </div>
          <div class="row">
              <div class="mb-1 col-md-10">
                <label class="form-label" for="apellidos">{{ __('Apellidos')}}</label>
                <input
                  type="text"
                  name="apellidos"
                  id="apellidos"
                  class="form-control"
                  placeholder=""
                  aria-label="apellidos"
                  value=""
                />
              </div>
          </div>
          <div class="row">
              <div class="mb-1 col-md-10">
                <label class="form-label" for="email">{{ __('Email')}}</label>
                <input
                  type="text"
                  name="email"
                  id="email"
                  class="form-control"
                  placeholder=""
                  aria-label="email"
                  value=""
                />
              </div>
          </div>
          <div class="row">
              <div class="mb-1 col-md-10">
                <label class="form-label" for="cct">{{ __('CCT')}}</label>
                <input
                  type="text"
                  name="cct"
                  id="cct"
                  class="form-control"
                  placeholder=""
                  aria-label="cct"
                  value=""
                />
              </div>
          </div>

          <div class="row ">
            <div class="mb-1 col-md-10 d-inline-flex justify-content-center gap-3" > 
              <button class="btn btn-primary btn-submit ">{{ __('Search') }}</button>

              <a href="#" id="addNewFile" data-bs-toggle="modal" data-bs-target="#modal-AC" aria-haspopup="true" aria-expanded="true" class="btn btn-primary btn-square-m" style="
              z-index: 9;"></i><span class="align-middle"> Agregar CCT</span></a>
            </div>
          </div>
          
          

      </form>


        </div>
      </div>
    </section>

<!-- Horizontal Wizard -->
<div class="app-content content " >

  <!--
  @if ($query2)
            @foreach ($query2  as $post )
                <p>{{$post}}</p>
            
               
            @endforeach
            @endif-->
  
  
           
            @if ($query2)

            <div  class="row">
              <div class="mb-1 col-md-12 d-inline-flex justify-content-center gap-3" > 
                  <form   method="POST" action="{{route('usuario.exportar')}}" style="margin-bottom: 10px;">
                    @csrf
                    
                    <div class="form-group" >
                        
                        <input type="hidden" name="queryTotal" id="queryTotal" class="form-control" value="{{ $queryTotal}}">
                    </div>
                    <div class="form-group" style="margin-left:20px">
                            <button type="submit" id="activarLicencias"  class="btn btn-primary float-right">Exporta a Excel</button>    
                    </div>
                  </form>
                  
              </div>
            </div>
              
              @endif
            @if ($query2)
            <div class="row"> 
              @if($tipo_consulta==1)

                <table class="table-fixed text-center">
                  <thead >
                    <tr >
                      <th >Correo</th>
                      <th >Nombres</th>
                      <th >Apellidos</th>
                      <th >Fecha de registro</th>
                      <th >Rol</th>
                      <th >Numero CCT</th>
                      <th >Editar</th>
                      <th >Cambio de password</th>
                      <th >Eliminar CCT</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if ($query2)
                        
                            @foreach ($query2  as $post )
                            <tr>
                              @if ($post->ent_usuario->registro->correo == null)
                            
                                <td>-</td>
                              @else
                                <td>{{$post->ent_usuario->registro->correo}}</td>
                              @endif
                            
                            <td>{{$post->ent_usuario->registro->nombres}}</td>
                            <td>{{$post->ent_usuario->registro->apellidos}}</td>
                            <td>{{$post->ent_usuario->registro->fechacreacion}}</td>
                            <td>{{$post->ent_usuario->user_rol->rol->nombre}} - {{$post->ent_usuario->user_rol->rol->clave}}</td>
            
                            @if ($post->cct == null)
                            
                            
                            @else
            
                                @if ($post->cct == null)
                                <td> -</td>
            
                                @else
                                  <td>{{$post->cct->clave_centro_trabajo}}</td>
                                @endif
                            
                            @endif
            
                            <td class="editarBtn text-center" >
                              <button class="btn btn-primary me-1 waves-effect waves-float waves-light" id="myModal{{$post->ent_usuario->registro->id}}" value="{{$post->ent_usuario->registro}}"><i class="far fa-edit" ></i></button>
                              
                            </td>
            
                            <td class="editarPassBtn ">
                              <button class="btn btn-primary me-1 waves-effect waves-float waves-light" id="myModalPassword{{$post->ent_usuario->registro->id}}" value="{{$post->ent_usuario->registro}}"><i class="fas fa-key"></i></button>
                              
                            </td>
            
                            <td class="editarPassBtn ">
            
                                  @if ($post->cct  == null)
                                
                                  
                                  @else
            
                                  <form method="POST" action="{{ Route('usuario.borrarCct') }}">
                                    @csrf
                                    <input type="hidden" value="{{$post->id}}" id="id_usuario_cct" name="id_usuario_cct">
                                    <input type="hidden" value="{{$post->ent_usuario->registro->correo}}" id="usuario_correo" name="usuario_correo">
            
                                    <button class="btn btn-primary btn-submit me-1 waves-effect waves-float waves-light delete-cct" ><i class="fas fa-user-minus"></i></button>
                                  </form>
                                  
                                  @endif
                                
                              
                            </td>
                            
                            </tr>
                            @endforeach
                          
                    @endif 
                  </tbody>
                </table> 

              @else

              <table class="table-fixed text-center">
                <thead >
                  <tr >
                    <th >Correo</th>
                    <th >Nombres</th>
                    <th >Apellidos</th>
                    <th >Fecha de registro</th>
                    <th >Validar cuenta</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($query2)
                      
                          @foreach ($query2  as $post )
                          <tr>
                            @if ($post->registro->correo == null)
                           
                              <td>-</td>
                            @else
                              <td>{{$post->registro->correo}}</td>
                            @endif
                          
                          <td>{{$post->registro->nombres}}</td>
                          <td>{{$post->registro->apellidos}}</td>
                          <td>{{$post->registro->fechacreacion}}</td>
                          <td style="margin: 0px 5px !important;">
                            @if($post->email_verified_at == null)
                              <a href= "{{ url('servicios/mesadeayuda/soporte/validacuentamesaayuda/'.$post->id) }}" class="btn btn-success">Validar ahora</a>

                            @else
                            No aplica
                            @endif
                          </td>
                          
                                                    
                          </tr>
                          @endforeach
                         
                  @endif 
                </tbody>
              </table> 

              @endif
               
          
              @if ($query2)
              <div style="margin-top: 50px">
                {{$query2->links('pagination::bootstrap-5')}}
              </div>
              @endif
          
          </div>
          @endif
  


<!-- Create modal-ED Starts-->
<div class="modal fade" id="modal-ED">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar datos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{Route('usuario.editar')}}" method="POST">
      @csrf
      <input type="hidden" value="" id="idUsuarioEdit" name="idUsuarioEdit">
      <div class="modal-body">

        
        <div class="row">
          <div class="mb-1 col-md-12">
            <label class="form-label" for="nombreEdit">{{ __('Nombre(s)')}}</label>
            <input
              type="text"
              name="nombreEdit"
              id="nombreEdit"
              class="form-control"
              placeholder=""
              aria-label="nombreEdit"
              value=""
            />
          </div>
      </div>
        <div class="row">
            <div class="mb-1 col-md-12">
              <label class="form-label" for="apellidosEdit">{{ __('Apellidos')}}</label>
              <input
                type="text"
                name="apellidosEdit"
                id="apellidosEdit"
                class="form-control"
                placeholder=""
                aria-label="apellidosEdit"
                value=""
              />
            </div>
        </div>
        <div class="row justify-content-center">
          <div class="mb-1 col-md-12">
            <label class="form-label" for="paisEdit">{{ __('País')}}</label>
            <input
              type="text"
              name="paisEdit"
              id="paisEdit"
              class="form-control"
              placeholder=""
              aria-label="paisEdit"
              value="México"
              disabled
            />
          </div>
        </div>

        <div class="row justify-content-center">
          <div class="mb-1 col-md-12">
            <label class="form-label" for="telefonoEdit">{{ __('Teléfono')}}</label>
            <input
              type="text"
              name="telefonoEdit"
              id="telefonoEdit"
              class="form-control"
              placeholder=""
              aria-label="telefonoEdit"
              value=""
            />
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light" >Editar</button>
      </form>
        <button type="button" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- /Create modal-ED Ends -->
<!-- Create modal-EP Starts-->


<div class="modal fade" id="modal-EP">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{Route('usuario.editarPassword')}}" method="POST">
      @csrf
      <div class="modal-body">

        <input type="hidden" value="" id="idUsuarioEditPassword" name="idUsuarioEditPassword">
        <input type="hidden" value="" id="correoEditPassword" name="correoEditPassword">
        <div class="row">
          <div class="mb-1 col-md-10">
            <label class="form-label" for="password">{{ __('Password')}}</label>
            <input
              type="password"
              name="password"
              id="password"
              class="form-control @error('password') border-red-500 @enderror"
              placeholder=""
              aria-label="password"
              value=""
            />
          </div>
      </div>

      <div class="row">
        <div class="mb-1 col-md-10">
          <label class="form-label" for="password_confirmation">{{ __('Confirmar password')}}</label>
          <input
            type="password"
            name="password_confirmation"
            id="password_confirmation"
            class="form-control"
            placeholder=""
            aria-label="password_confirmation"
            value=""
          />
        </div>
    </div>
      </div>
        
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light" >Editar</button>
      </form>
        <button type="button" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>



<!--Modal agregar CCT inicio-->

<div class="modal fade" id="modal-AC">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Añadir CCT</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{Route('dashboard.agregarCct')}}" method="POST">
      @csrf
      <div class="modal-body">

        <div class="row">
          <div class="mb-1 col-md-12">
            <label class="form-label" for="Correo">{{ __('Correo')}}</label>
            <input
              type="email"
              name="email_cct"
              id="email_cct"
              class="form-control"
              placeholder=""
              aria-label="email_cct"
              value=""
            />
            <input type="hidden" name="usuario_id" id="usuario_id_nuevo_cct">


            <input type="hidden" name="correo_existe" id="correo_existe" value=0>
            <input type="hidden" name="cct_existe" id="cct_existe" value=0>
          </div>
        </div>

        <div class="row mb-5">
          <h5 for="cct">{{ __('Clave del Centro de Trabajo CCT') }}</h5>
          <div class="mb-1 col-md-12">
            <input type="text" name="texto_cct" id="texto_cct" class="form-control valida_cct" placeholder=""  onkeyup="mayus(this);"/>
            <input type="hidden" name="id_cct" id="id_cct">
            <input type="hidden" name="clave_cct" id="clave_cct">
            <input type="hidden" name="nexus_cct" id="nexus_cct">
          </div>
          <div class="mb-1 col-md-12">
            <button class="btn btn-primary btn-next" id="btn_validaCCTNuevoCorreo" type="button">
              <span class="spinner-border spinner-border-sm" id="loader" role="status" aria-hidden="true" style="display: none"></span>
              <span class="ms-25 align-middle">Valida CCT y Correo</span></button>
          </div>
        </div>
        <div class="card mb-4" id="ficha_cct" style="display: none">
        </div>

     
      </div>
        
      <div class="modal-footer">
        <button type="submit" id="enviar_nuevo_cct" class="btn btn-primary me-1 waves-effect waves-float waves-light disabled" >Agregar</button>
      </form>
        <button type="button" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!--Modal agregar CCT fin-->


</div>

</div>
</div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  console.log("HOLA");

  $(document).ready(function () {

    $('body').on('click', '.editarBtn button', function(){

      var id=$(this).val();
      console.log(id);
      var data= $.parseJSON(id);
      //console.log(data);
      $('#modal-ED').modal("show");
      $('#modal-EP').modal("hide");
      $('#idUsuarioEdit').val(data.id);
      $('#nombreEdit').val(data.nombres);
		  $('#apellidosEdit').val(data.apellidos);
      $('#emailEdit').val(data.correo);
      $('#telefonoEdit').val(data.telefonomovil);
    })

    $('body').on('click', '.editarPassBtn button', function(){

      var id=$(this).val();
      var data= $.parseJSON(id);

      $('#modal-EP').modal("show");
      $('#modal-EP').modal("hide");
      $('#modal-EP').modal("show");
      $('#idUsuarioEditPassword').val(data.id);
      $('#correoEditPassword').val(data.correo);
     
    })

    $('.delete-cct').on('click', function() {
          console.log("borrar");

          setTimeout(() => {
            $(this).prop('disabled', true);
          }, 500);
          
      })
  
    /*
    $('#myModal').click('show.bs.modal', function(e) {    

      
      var id=$(this).val();
      var data= $.parseJSON(id);
      //console.log(id2);
      
    });*/

  }); 
</script>
