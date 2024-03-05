<!-- BEGIN: Content editar usuario-->
<div class="app-content content ">
  <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
      <div class="content-wrapper container-xxl mt-3">
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
                          {{__('Mi Perfil')}}
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
      </div>

    <section  class="contenedor_button border d-block pt-4 mb-4 mx-4" >

      <div class="row col-md-8" >
        <div class="col-md-8 ">
          <h1 class="float-start mb-10 px-5 ">¡Hola, {{$nombres}}!</h1>  
        </div>
      </div>
      

      <div class="row justify-content-center ">
        <div class="col-md-6" >
          <form action="{{Route('usuario.editar')}}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="row " >
              <div class="d-inline-flex justify-content-center col-md-12 " >
                <div class="rounded-circle" style="border: 1px solid blue; position: relative; width:200px; height:200px; overflow:hidden ">


              

                  <a href="#" id="modal-imagen"  data-bs-toggle="modal" data-bs-target="#modal-EI" aria-haspopup="true" aria-expanded="true">
                    <img  id="imagen-perfil"class="rounded-circle" width="200px" height="200px" src="{{$path_photo ? asset('app-assets/images/profile/user-uploads') . '/'.$path_photo : asset('app-assets/images/profile/user-uploads/ico_Avatar.svg')}}" alt="imagen usuario" style="object-fit: cover; width: 100%; ">
                  </a>

             
                  <!--<input type="file" id="imagen" name="imagen"  class="" accept=".jpg, .jpeg, .png" style="position: absolute; width: 200px; height: 100px;bottom:0; opacity:0">-->
                </div>

               
              </div>

            </div>
           
            

            <input type="hidden" value="{{$id}}"  id="idUsuarioEdit" name="idUsuarioEdit">
            <input type="hidden" value="{{$matricula}}"  id="matriculaEdit" name="matriculaEdit">

            <div class="row justify-content-center" >
              <div class="mb-1 col-md-10">
                <label class="form-label" for="nombreEdit">{{ __('Nombre(s)')}}</label>
                <input
                  type="text"
                  name="nombreEdit"
                  id="nombreEdit"
                  class="form-control"
                  placeholder=""
                  aria-label="nombreEdit"
                  value="{{ $nombres}}"
                />
              </div>
            </div>
    
            <div class="row justify-content-center">
              <div class="mb-1 col-md-10">
                <label class="form-label" for="apellidosEdit">{{ __('Apellidos')}}</label>
                <input
                  type="text"
                  name="apellidosEdit"
                  id="apellidosEdit"
                  class="form-control"
                  placeholder=""
                  aria-label="apellidosEdit"
                  value="{{ $apellidos}}"
                />
              </div>
            </div>
    
            <div class="row justify-content-center">
              <div class="mb-1 col-md-10">
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
              <div class="mb-1 col-md-10">
                <label class="form-label" for="telefonoEdit">{{ __('Teléfono')}}</label>
                <input
                  type="text"
                  name="telefonoEdit"
                  id="telefonoEdit"
                  class="form-control"
                  placeholder=""
                  aria-label="telefonoEdit"
                  value="{{ $telefono}}"
                />
              </div>
            </div>
            
            <div class="row ">
              <div class="mb-1 col-md-12 d-inline-flex justify-content-center gap-3" > 
                <button type="button" class="btn btn-primary  waves-effect waves-float waves-light"  style=" background-color:transparent !important; color:#da2131 !important"><a href="{{route("assemble",$cct_actual)}}">Regresar</a></button>
                
                <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light " >Actualizar</button>
               
              </div>
            </div>

            <div class="row ">
              <div class="mb-1 col-md-12 d-inline-flex justify-content-center gap-3" > 
                <a href="#" id="addNewFile" data-bs-toggle="modal" data-bs-target="#modal-EP" aria-haspopup="true" aria-expanded="true" class="btn btn-primary btn-square-m "><span class="align-middle"> Cambiar contraseña</span></a>
            </div>
            </div>

            
          </form>
        </div>
        
  
      </div>


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


              <input type="hidden" value="{{$id}}" id="idUsuarioEditPassword" name="idUsuarioEditPassword">
              <input type="hidden" value="{{Auth::user()->email}}" id="correoEditPassword" name="correoEditPassword">
                <div class="modal-body">
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
      <!-- /Create modal-EP Ends -->

       <!-- Create modal-Editar Imagen Starts-->
       <div class="modal fade" id="modal-EI">
        <div class="modal-dialog 	modal-lg modal-dialog-centered">
          <div class="modal-content ">
            <div class="modal-header">
              <h5 class="modal-title">Editar Imagen</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="row ">
              <div class=" mb-1 col-md-12 img-cont ">

                  <div class="image-container">

                    <div class="image-workspace">
                        <img id="imagen-principal" src="" alt="">
                    </div>

                    <div class="image-workspace-2">
                      <img " src="" alt="">
                    </div>

                </div>
              </div>

            </div>

            <div class="row">
              <div class="mb-1 col-md-3">

                <div class="action-button">
                  <button class="upload btn btn-primary me-1 waves-effect waves-float waves-light">Seleccionar</button>
                  <input type="file" class="hidden-upload" style="display:none;" accept="image/*">
                  
                </div>
              </div>

              <div class="mb-1 col-md-3">
                <div class="side-control-page-1" >
                  <div class="zoom">
                      <span>Zoom</span>
                      <div class="btn-edit">
                        <li><svg xmlns="http://www.w3.org/2000/svg" height="24" width="24"><path d="M19.55 20.575 13.25 14.3Q12.5 14.925 11.525 15.275Q10.55 15.625 9.525 15.625Q6.95 15.625 5.175 13.85Q3.4 12.075 3.4 9.5Q3.4 6.95 5.175 5.162Q6.95 3.375 9.525 3.375Q12.075 3.375 13.85 5.15Q15.625 6.925 15.625 9.5Q15.625 10.575 15.275 11.55Q14.925 12.525 14.325 13.25L20.6 19.525ZM9.525 14.125Q11.45 14.125 12.788 12.775Q14.125 11.425 14.125 9.5Q14.125 7.575 12.788 6.225Q11.45 4.875 9.525 4.875Q7.575 4.875 6.238 6.225Q4.9 7.575 4.9 9.5Q4.9 11.425 6.238 12.775Q7.575 14.125 9.525 14.125ZM10.275 12.2H8.775V10.25H6.825V8.75H8.775V6.8H10.275V8.75H12.2V10.25H10.275Z"/></svg></li>
                      <li><svg xmlns="http://www.w3.org/2000/svg" height="24" width="24"><path d="M19.55 20.575 13.25 14.3Q12.5 14.925 11.525 15.275Q10.55 15.625 9.525 15.625Q6.95 15.625 5.175 13.85Q3.4 12.075 3.4 9.5Q3.4 6.95 5.175 5.162Q6.95 3.375 9.525 3.375Q12.075 3.375 13.85 5.15Q15.625 6.925 15.625 9.5Q15.625 10.575 15.275 11.55Q14.925 12.525 14.325 13.25L20.6 19.525ZM9.525 14.125Q11.45 14.125 12.788 12.775Q14.125 11.425 14.125 9.5Q14.125 7.575 12.788 6.225Q11.45 4.875 9.525 4.875Q7.575 4.875 6.238 6.225Q4.9 7.575 4.9 9.5Q4.9 11.425 6.238 12.775Q7.575 14.125 9.525 14.125ZM7.125 10.25V8.75H11.9V10.25Z"/></svg></li>
                      </div>
                      
                  </div>
                </div>
              </div>


              <div class="mb-1 col-md-3">
                <div class="side-control-page-1" >
                    <div class="rotate">
                      <span>Rotar</span>
                      <div class="btn-edit">
                        <li><svg xmlns="http://www.w3.org/2000/svg" height="24" width="24"><path d="M20.5 12.05H18.975Q18.825 11.2 18.5 10.387Q18.175 9.575 17.65 8.85L18.725 7.8Q19.45 8.675 19.9 9.762Q20.35 10.85 20.5 12.05ZM13.05 21.5V19.95Q13.9 19.825 14.713 19.5Q15.525 19.175 16.25 18.65L17.3 19.725Q16.35 20.45 15.288 20.9Q14.225 21.35 13.05 21.5ZM18.725 18.3 17.65 17.25Q18.175 16.525 18.5 15.712Q18.825 14.9 18.975 14.05H20.5Q20.375 15.2 19.925 16.275Q19.475 17.35 18.725 18.3ZM11.05 21.5Q7.825 21.075 5.688 18.675Q3.55 16.275 3.55 13.05Q3.55 9.5 6.025 7.025Q8.5 4.55 12.05 4.55H12.5L10.7 2.725L11.75 1.65L15.4 5.3L11.75 8.95L10.7 7.9L12.55 6.05H12.05Q9.125 6.05 7.088 8.088Q5.05 10.125 5.05 13.05Q5.05 15.65 6.75 17.613Q8.45 19.575 11.05 19.975Z"/></svg></li>
                        <li><svg xmlns="http://www.w3.org/2000/svg" height="24" width="24"><path d="M3.55 12.05Q3.7 10.85 4.15 9.762Q4.6 8.675 5.325 7.8L6.4 8.85Q5.875 9.575 5.55 10.387Q5.225 11.2 5.075 12.05ZM11 21.5Q9.825 21.35 8.763 20.9Q7.7 20.45 6.75 19.725L7.8 18.65Q8.525 19.175 9.338 19.5Q10.15 19.825 11 19.95ZM5.325 18.3Q4.575 17.35 4.125 16.275Q3.675 15.2 3.55 14.05H5.075Q5.225 14.9 5.55 15.712Q5.875 16.525 6.4 17.25ZM13 21.5V19.975Q15.6 19.575 17.3 17.613Q19 15.65 19 13.05Q19 10.125 16.962 8.088Q14.925 6.05 12 6.05H11.5L13.35 7.9L12.3 8.95L8.65 5.3L12.3 1.65L13.35 2.725L11.55 4.55H12Q15.55 4.55 18.025 7.025Q20.5 9.5 20.5 13.05Q20.5 16.275 18.363 18.675Q16.225 21.075 13 21.5Z"/></svg></li>
                      </div> 
                    </div>

                </div>
              </div>

              <div class="mb-1 col-md-3">
                <div class="side-control-page-1" >
                  <div class="flip">
                    <span>Voltear</span>
                    <div class="btn-edit">
                      <li><svg xmlns="http://www.w3.org/2000/svg" height="24" width="24"><path d="M17 13.65 15.95 12.575 18.775 9.75H11.25V8.25H18.775L15.95 5.425L17 4.35L21.65 9ZM7 19.65 2.35 15 7 10.35 8.05 11.425 5.225 14.25H12.75V15.75H5.225L8.05 18.575Z"/></svg></li>
                      <li><svg xmlns="http://www.w3.org/2000/svg" height="24" width="24"><path d="M15 21.65 10.35 17 11.425 15.95 14.25 18.775V11.25H15.75V18.775L18.575 15.95L19.65 17ZM8.25 12.75V5.225L5.425 8.05L4.35 7L9 2.35L13.65 7L12.575 8.05L9.75 5.225V12.75Z"/></svg></li>
                    </div> 
                </div>
                </div>
              </div>


              
            
            
            </div>

            <div class="row justify-content-center">
              <div class="mb-1 col-md-3">
                
              </div>

            </div>
           
            <form  action="{{Route('usuario.editarFoto')}}" enctype="multipart/form-data" method="POST">
              @csrf
              <input type="hidden" name="bl" id="bl"">


            <input type="hidden" value="{{$id}}"  id="idUsuarioEdit" name="idUsuarioEdit">
            <input type="hidden" value="{{$matricula}}"  id="matriculaEdit" name="matriculaEdit">

            <div class="modal-footer">

              <button type="button" id="descargar" class="btn btn-primary me-1 waves-effect waves-float waves-light" >Aplicar cambios</button>
              
              <button  id="guardar-submit" class="btn btn-primary me-1 waves-effect waves-float waves-light" >Guardar</button>

              <button type="submit" id="imagen-submit" class="btn btn-primary me-1 waves-effect waves-float waves-light" ></button>
            </form>
              <button type="button" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal">Cancel</button>
              
            </div>
          </div>
        </div>
      </div>
  <!-- /Create modal-Editar Imagen Ends -->

    </section>



  </div>

  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>


  $(document).ready(function () {


    
    $('#guardar-submit').prop( "disabled", true );


    $('body').on('click', '#modal-imagen', function(){

      $('#imagen-submit').hide();
      

      var imgsrc = $('#imagen-perfil').attr('src');
      console.log(imgsrc);
      image_workspace.src = imgsrc;

      
      var url = window.URL.createObjectURL(new Blob([image_workspace], { type : 'image/png'}))
      image_workspace.src = imgsrc;

      $('#imagen-principal').attr('src',imgsrc);
      var options = {
        dragMode: 'move',
        //preview: '.img-preview',
        viewMode: 1,
        modal: false,
        background: false,
        ready: function(){
             //zoom
             zoom[0].onclick = () => crooper.zoom(0.1);
             zoom[1].onclick = () => crooper.zoom(-0.1);
            
             rotate[0].onclick = () => crooper.rotate(45);
             rotate[1].onclick = () => crooper.rotate(-45);


              //flip
              var flipX = -1;
              var flipY = -1;
              flip[0].onclick = () => {
               crooper.scale(flipX, 1)
               flipX = -flipX;
              }; 

              flip[1].onclick = () => {
               crooper.scale(1, flipY)
               flipY = -flipY;
              }; 

              document.querySelector('#descargar').onclick = () => {
                document.querySelector('#descargar').onclick.innerText = '...'
                crooper.getCroppedCanvas().toBlob((blob) => {
                    var downloadURL = window.URL.createObjectURL(blob);
                    console.log(downloadURL);
                    //document.querySelector("#edit").filename  = downloadURL;

                    /*
                    var a = document.createElement('a');
                    a.href =  downloadURL;
                    a.download = 'cropped-image.jpg';
                    a.click();
                    actionButton[1].innerText = 'Download';*/

                    var reader = new FileReader();
                    reader.readAsDataURL(blob); 
                    reader.onloadend = function() {
                    var base64data = reader.result;                
                    console.log(base64data);
                    document.querySelector("#bl").value= base64data;
                    $('#guardar-submit').prop( "disabled", false );

                    }
                })
               }
             
            }
    }

    var crooper = new Cropper(image_workspace, options);
      //$('#modal-EI').modal("show");
      
      /*
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
      $('#telefonoEdit').val(data.telefonomovil);*/
    })


  }); 

  function back(){
    
   
      window.history.back();
      console.log("back");
 

  }
</script>