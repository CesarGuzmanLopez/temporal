$(window).on('load',  function(){
    if (feather) {
      feather.replace({ width: 14, height: 14 });
    }
  });
   
  //validamos solo números al campo del teléfono.
  $('#mobile_phone').keypress(function (event) {
    if (event.which < 48 || event.which > 57) {
      return false;
    }
  });

  $("#btn_validaCCT").on('click',function(){
    if($('#texto_cct').val()==''){
      $("#form-paso2").submit();
    }else{
      validaCCT($('#texto_cct').val());
    }   
  });

  $("#btn_validaCCTNuevo").on('click',function(){
    if($('#texto_cct').val()==''){
      $("#form-paso2").submit();
    }else{
      validaCCTNuevo($('#texto_cct').val());
    }   
  });

  $("#btn_validaCCTNuevoCorreo").on('click',function(){
    console.log("==");
    if($('#texto_cct').val()==''){
      $("#form-paso2").submit();
    }else{
      validaCCTNuevoCorreo($('#texto_cct').val(),$('#email_cct').val());
    }   
  });

  $('#texto_cct').on('focus',function(){//limpieza del campo de cct y deshabilitar envio
    $(this).val('');
    $("#envio_paso2").prop( "disabled", true );
    $("#texto_cct").removeClass('is-valid');
    $("#texto_cct").removeClass('is-invalid');
    $("#id_cct,#clave_cct,#nexus_cct").val('');
    $("#texto_cct-error,#clave_cct-error,#nexus_cct-error").remove();
    $("#ficha_cct").css('display', 'none');
  });

  $("#combo_cct").on('keypress change',function(){
    $("#id_cct").val(this.value);
  });
  
  $("#country").change(function(){
    getLada(this.value);
    if(this.value =='138' || $("#country").val() == '138'){//si es México o Colombia
      $(".opt2").css('display','none');
      $(".opt1").css('display','block');
      $("#tooltip_msg").css('display','none');
      $("#text_titulo").text("Clave del Centro de Trabajo");
    }else if(this.value == '45' || $("#country").val() == '45'){
          $(".opt2").css('display','none');
          $(".opt1").css('display','block');
          $("#tooltip_msg").removeAttr( 'style' );
          $("#text_titulo").text("Clave del colegio");
    }else {
          $(".opt1").css('display','none');
          $(".opt2").css('display','block');
    }
  });

  $("#entidad").change(function(){
    getMunicipio(this.value);
  });

  $("#municipio").change(function(){
    getLocalidad($("#entidad").val(),this.value);
  });

  $("#localidad").change(function(){
    getCct($("#entidad").val(),$("#municipio").val(),this.value);
  });

  function getLada(idPais){
    $.ajax({
      type : "GET",
      url: "/get-ladas/"+idPais,
      dataType: "json",
      success: function(response){
        //console.log(response.lista[0].lada);
        if(response.lista[0].lada=='+52'){
          $('#mobile_phone').attr("placeholder", "10 dígitos");
          $('#mobile_phone').keypress(function (event) {
            if (event.which < 48 || event.which > 57 || this.value.length === 10) {
              return false;
            }
          });
        }
        $("#lada_phone").val(response.lista[0].lada);
      }
    });
  }

  function getMunicipio(idEntidad){
    $.ajax({
      type : "GET",
      url: "/get-municipios/"+idEntidad,
      dataType: "json",
      success: function(response){
        //console.log(response.lista[0].ciudad);
        
          // Limpiamos el select
          $("#municipio").find('option[value]').remove();
          $.each(response.lista, function(i, v){ // indice, valor
            //console.log(v.ciudad);
           $("#municipio").append('<option value="' + v.clave_municipio_delegacion + '">' + v.nombre_municipio_delegacion + '</option>');
          });
        }
    });
  }

  function getLocalidad(idEntidad, idMunicipio){
    $.ajax({
      type : "GET",
      url: "/get-localidades/"+idEntidad+'/'+idMunicipio,
      dataType: "json",
      success: function(response){

        $("#localidad").find('option[value]').remove();
          $.each(response.lista, function(i, v){ // indice, valor
            //console.log(v.colonia);
           $("#localidad").append('<option value="' + v.clave_localidad + '">' + v.nombre_localidad + '</option>');
          });
      }
    });
  }

  function getCct(idEntidad, idMunicipio, idLocalidad){
    $.ajax({
      type : "GET",
      url: "/get-cct/"+idEntidad+'/'+idMunicipio+'/'+idLocalidad,
      dataType: "json",
      success: function(response){

        $("#combo_cct").find('option[value]').remove();
          $.each(response.lista, function(i, v){ // indice, valor
            //console.log(v.cct);
           $("#combo_cct").append('<option value="' + v.id + '">' + v.clave_centro_trabajo  +" | " + v.nombre_centro_trabajo+ " | " +v.nivel_educativo + " | " + v.nombre_turno +'</option>');
           $("#clave_cct").val(v.clave_centro_trabajo);
          });
      }
    });
  }

  function validaCCT(cct){
    //console.log(cct);
    $.ajax({
      type : "GET",
      url: "/valida-cct/"+cct,
      dataType: "json",
      beforeSend: function(){
        $("#loader").show();
      },
      success: function(response){
        $("#loader").hide();
        //console.log(response);
        $("#texto_cct").removeClass('is-valid');
        $("#texto_cct").removeClass('is-invalid');
        if(response.success === true){
            $("#id_cct").val(response.lista[0].id);
            $("#clave_cct").val(response.lista[0].clave_centro_trabajo);
            $("#nexus_cct").val(response.lista[0].nexus_cct);
          if(response.lista[0].nexus_cct == null){
            $("#form-paso2").submit();
            $("#texto_cct").addClass('is-invalid');
            $("#envio_paso2").prop( "disabled", true );
          }else{
            $("#texto_cct").addClass('is-valid');

            $("#ficha_cct").css('display', 'block').html(
            '<div class="card-body">'+
            '<h4 class="card-title" id="ficha_nomescuela">Colegio: '+response.lista[0].nombre_centro_trabajo+'</h4>'+
              '<ul>'+
                '<li id="ficha_cct"><strong>Clave del colegio:</strong> '+response.lista[0].clave_centro_trabajo+'</li>'+
                /*'<li id="ficha_turno"><strong>Turno:</strong> '+response.lista[0].nombre_turno+'</li>'+*/
                '<li id="ficha_nivel"><strong>Nivel educativo:</strong> '+response.lista[0].nivel_educativo+'</li>'+
              '</ul>'+
            '</div>'
            );
            $("#envio_paso2").prop( "disabled", false );
          }
          
        }else{
          $("#texto_cct").addClass('is-invalid');
          $("#id_cct").val('');
          $("#clave_cct").val('');
          $("#envio_paso2").prop( "disabled", true );
          $("#form-paso2").submit();
        }
      }
    });
  }

  function validaCCTNuevo(cct){
    //console.log(cct);
    console.log("NUEVO");
    $.ajax({
      type : "GET",
      url: "/valida-cct/"+cct,
      dataType: "json",
      beforeSend: function(){
        $("#loader").show();
      },
      success: function(response){
        $("#loader").hide();
        
        //console.log(response);
        $("#texto_cct").removeClass('is-valid');
        $("#texto_cct").removeClass('is-invalid');
        if(response.success === true){
          
            $("#id_cct").val(response.lista[0].id);
            $("#clave_cct").val(response.lista[0].clave_centro_trabajo);
            $("#nexus_cct").val(response.lista[0].nexus_cct);
          if(response.lista[0].nexus_cct == null){
            
            //$("#form-paso2").submit();
            $("#texto_cct").addClass('is-invalid');
            $("#envio_paso2").prop( "disabled", true );
            $("#cct_existe").val(0);
          }else{
            
            $("#texto_cct").addClass('is-valid');

            $("#ficha_cct").css('display', 'block').html(
            '<div class="card-body">'+
            '<h4 class="card-title" id="ficha_nomescuela">Colegio: '+response.lista[0].nombre_centro_trabajo+'</h4>'+
              '<ul>'+
                '<li id="ficha_cct">Clave del colegio: '+response.lista[0].clave_centro_trabajo+'</li>'+
                // '<li id="ficha_turno">TURNO: '+response.lista[0].nombre_turno+'</li>'+
                '<li id="ficha_nivel">Nivel educativo: '+response.lista[0].nivel_educativo+'</li>'+
              '</ul>'+
            '</div>'
            );

            $("#envio_paso2").prop( "disabled", false );
            $("#cct_existe").val(1);
            a = $("#correo_existe").val();
            b = $("#cct_existe").val();

            if(a == 1 && b == 1){
              
              $("#enviar_nuevo_cct").removeClass( 'disabled' );
            }
          }
          
        }else{
          
          $("#texto_cct").addClass('is-invalid');
          $("#id_cct").val('');
          $("#clave_cct").val('');
          $("#envio_paso2").prop( "disabled", true );
          //$("#form-paso2").submit();
        }
      }
    });
  }

  function validaCCTNuevoCorreo(cct,correo){
    //console.log(cct);
    
    $("#enviar_nuevo_cct").addClass( 'disabled' );
    validaCCTNuevo(cct);

    $.ajax({
      type : "GET",
      url: "/valida-correo/"+correo,
      dataType: "json",
      beforeSend: function(){
        $("#loader").show();
      },
      success: function(response){
        $("#email_cct").removeClass('is-valid');
        $("#email_cct").removeClass('is-invalid');
        if(response.success === true){
          $("#email_cct").addClass('is-valid');
          $("#usuario_id_nuevo_cct").val(response.lista[0].id);
          $("#correo_existe").val(1);
        }else{
          $("#email_cct").addClass('is-invalid');
          $("#correo_existe").val(0);
        }
      }
    });

    
  }

  function mayus(e) {
    e.value = e.value.toUpperCase();
  }


  $('#usuario_completo').on('change', function() {
    if(this.value == 2){
      $("#rol").prop( "disabled", true );
      $("#cct").prop( "disabled", true );
    }else{
      $("#rol").prop( "disabled", false );
      $("#cct").prop( "disabled", false );
    }
  });