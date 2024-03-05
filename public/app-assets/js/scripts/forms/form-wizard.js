/*=========================================================================================
    File Name: form-wizard.js
    Description: wizard steps page specific js
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(function () {
  'use strict';

  var bsStepper = document.querySelectorAll('.bs-stepper'),
    select = $('.select2'),
    horizontalWizard = document.querySelector('.horizontal-wizard-example'),
    verticalWizard = document.querySelector('.vertical-wizard-example'),
    modernWizard = document.querySelector('.modern-wizard-example'),
    modernVerticalWizard = document.querySelector('.modern-vertical-wizard-example');

  // Adds crossed class
  if (typeof bsStepper !== undefined && bsStepper !== null) {
    for (var el = 0; el < bsStepper.length; ++el) {
      bsStepper[el].addEventListener('show.bs-stepper', function (event) {
        var index = event.detail.indexStep;
        var numberOfSteps = $(event.target).find('.step').length - 1;
        var line = $(event.target).find('.step');

        // The first for loop is for increasing the steps,
        // the second is for turning them off when going back
        // and the third with the if statement because the last line
        // can't seem to turn off when I press the first item. ¯\_(ツ)_/¯

        for (var i = 0; i < index; i++) {
          line[i].classList.add('crossed');

          for (var j = index; j < numberOfSteps; j++) {
            line[j].classList.remove('crossed');
          }
        }
        if (event.detail.to == 0) {
          for (var k = index; k < numberOfSteps; k++) {
            line[k].classList.remove('crossed');
          }
          line[0].classList.remove('crossed');
        }
      });
    }
  }

  // select2
  select.each(function () {
    var $this = $(this);
    $this.wrap('<div class="position-relative"></div>');
    $this.select2({
      placeholder: 'Select value',
      dropdownParent: $this.parent()
    });
  });

  // Horizontal Wizard
  // --------------------------------------------------------------------
  if (typeof horizontalWizard !== undefined && horizontalWizard !== null) {
    var numberedStepper = new Stepper(horizontalWizard),
      $form = $(horizontalWizard).find('form');
    $form.each(function () {
      var $this = $(this);
      $this.validate({
        ignore: "not:hidden",
        rules: {
          username: {
            required: true
          },
          email: {
            required: true
          },
          password: {
            required: true
          },
          'confirm-password': {
            required: true,
            equalTo: '#password'
          },
          rol: {
            required: true
          },
          'first-name': {
            required: true
          },
          'last-name': {
            required: true
          },
          'mobile-phone': {
            required: true,
            minlength: 10,
            maxlength: 10
          },
          'lada-phone':{
            required:true,
          },
          'privacy_policy': {
            required: true,
          },
          'texto_cct': {
            // require_from_group: [1, '#id_cct'],//.validacct es para pintar el icono sobre el input
            required: true,
            minlength: 10,
          },
          'combo_cct': {
            require_from_group: [1, '.valida_cct']//.validacct es para pintar el icono sobre el input
          },
          'clave_cct': {
            required: true,
          },
          'nexus_cct': {
            equalTo: '#clave_cct'
          }
        },
        messages: {
          'first-name': 'Ingresa nombre',
          'last-name': "Ingresa apellidos",
          'lada-phone': "Ingresa lada de teléfono",
          'mobile-phone': "Ingresa un número de télefono",
          'privacy_policy': "Deberá leer y aceptar los Términos del servicio y la Política de Privacidad",
          'texto_cct': "Ingrese un CCT válido",
          'combo_cct': "Elija una opción" ,
          'clave_cct': "No hemos encontrado un colegio relacionado con el CCT ingresado, favor de contactar a su representante.",
          'nexus_cct': "No hemos encontrado un proyecto para su colegio, favor de contactar a su representante.",
        }
      });
    });

    $(horizontalWizard)
      .find('.btn-next')
      .each(function () {
        $(this).on('click', function (e) {
          var isValid = $(this).parent().siblings('form').valid();
          if (isValid) {
            var datos  = $("#form-paso1").serialize();
            var result = editPostUser(datos);
            if($("#country").val() == '138'){
              $(".opt2").css('display','none');
              $(".opt1").css('display','block');
              $("#tooltip_msg").css('display','none');
              $("#text_titulo").text("Clave del Centro de Trabajo");
            }else if($("#country").val() == '45'){
              $(".opt2").css('display','none');
              $(".opt1").css('display','block');
              $("#tooltip_msg").removeAttr( 'style' );
              $("#text_titulo").text("Clave del colegio");
            }
            numberedStepper.next();
          } else {
            e.preventDefault();
          }
        });
      });

    $(horizontalWizard)
      .find('.btn-prev')
      .on('click', function () {
        numberedStepper.previous();
      });

    $(horizontalWizard)
      .find('.btn-submit')
      .on('click', function () {
        var isValid = $(this).parent().siblings('form').valid();
        //console.log("VALIDACION"+isValid);
        if (isValid) {
          $("#form-paso2").submit();
        }
      });
  }

  function editPostUser(data){
    $.ajax({
      type : "GET",
      url: "edit-post-p1",
      data: data,
      dataType: "json",
      success: function(response){
        //console.log(response);
        return true;
      }
    });
  }

  // Vertical Wizard
  // --------------------------------------------------------------------
  if (typeof verticalWizard !== undefined && verticalWizard !== null) {
    var verticalStepper = new Stepper(verticalWizard, {
      linear: false
    });
    $(verticalWizard)
      .find('.btn-next')
      .on('click', function () {
        verticalStepper.next();
      });
    $(verticalWizard)
      .find('.btn-prev')
      .on('click', function () {
        verticalStepper.previous();
      });

    $(verticalWizard)
      .find('.btn-submit')
      .on('click', function () {
        alert('Submitted..!!');
      });
  }

  // Modern Wizard
  // --------------------------------------------------------------------
  if (typeof modernWizard !== undefined && modernWizard !== null) {
    var modernStepper = new Stepper(modernWizard, {
      linear: false
    });
    $(modernWizard)
      .find('.btn-next')
      .on('click', function () {
        modernStepper.next();
      });
    $(modernWizard)
      .find('.btn-prev')
      .on('click', function () {
        modernStepper.previous();
      });

    $(modernWizard)
      .find('.btn-submit')
      .on('click', function () {
        alert('Submitted..!!');
      });
  }

  // Modern Vertical Wizard
  // --------------------------------------------------------------------
  if (typeof modernVerticalWizard !== undefined && modernVerticalWizard !== null) {
    var modernVerticalStepper = new Stepper(modernVerticalWizard, {
      linear: false
    });
    $(modernVerticalWizard)
      .find('.btn-next')
      .on('click', function () {
        modernVerticalStepper.next();
      });
    $(modernVerticalWizard)
      .find('.btn-prev')
      .on('click', function () {
        modernVerticalStepper.previous();
      });

    $(modernVerticalWizard)
      .find('.btn-submit')
      .on('click', function () {
        alert('Submitted..!!');
      });
  }
});
