const btnguardargranalla = document.getElementById("btnguardargranalla");
const txtgranallo= document.getElementById("txtgranallo");
const txtPkempresa= document.getElementById("txtPkempresa");
const txtPkusuario= document.getElementById("txtPkusuario");
const txtUsario= document.getElementById("txtUsario");



var pk = $.trim(document.getElementById("txtPkempresa").value);

$(document).ready(function () {


    $('#cbmmaquina').select2({
      theme: "bootstrap-5",
      width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
      placeholder: $( this ).data( 'placeholder' ),
      // allowClear: true
    });
  
 
    $('#cbmgranalla').select2({
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        // allowClear: true
      });
    
   

  
    if (pk==""){
      pk = localStorage.getItem('pk');
    
      
    }else{
      pk = $.trim(document.getElementById("txtPkempresa").value);
    }
    
    btnguardargranalla.addEventListener("click", GuardarGranalla);

  
    obtenerMaq(pk);
    obtenerGranalla(pk);
  
    $(".currency-mx").each(function () {
      var monetary_value = $(this).text();
      var i = new Intl.NumberFormat("es-MX", {
        style: "currency",
        currency: "MX",
      }).format(monetary_value);
      $(this).text(i);
    });
  
  

  
    $('#cbmmaquina').change(function(){
      
      var tablaterminado = $("#tablaterminado tr").length - 1;
      
      if (tablaterminado > 1) {
        for (y = tablaterminado; y > 0; y--) {
          document.getElementById("tablaterminado").deleteRow(y);
        }
      }
  
      var tablacabina = $("#tablacabina tr").length - 1;
    
      if (tablacabina > 1) {
        for (y = tablacabina; y > 0; y--) {
          document.getElementById("tablacabina").deleteRow(y);
        }
      }
  
      var tablaespera = $("#tablaespera tr").length - 1;
      if (tablaespera > 1) {
        for (y = tablaespera; y > 0; y--) {
          document.getElementById("tablaespera").deleteRow(y);
        }
      }
      
  
      var Maquina = $('#cbmmaquina').select2('data');
  
      $.ajax({
        url: "modelos/tablasvagones.php",
        type: "POST",
        data: {
          fk_maquina: Maquina[0].id
        },
        dataType: "json",
        beforeSend: function (response) {},
        complete: function (response) {},
        success: function (data) {
          document.getElementById("datoscabina").textContent="";
          document.getElementById("datoscabina").textContent="VAGONES DE CABINA: "  + Maquina[0].text ;
          for (var i = 0; i < data.length; i++) {
            if (data[i].consecutivo_cabina==-1){
              document.getElementById("tablaterminado").insertRow(-1).innerHTML = "<td>" + data[i].alias_produccion + "</td> <td class='text-center'>" + data[i].fecha_granallado + "</td>" + "</td> <td>" + data[i].serie_proyecto + "</td>";
            }
            if (data[i].consecutivo_cabina==0){
              document.getElementById("tablacabina").insertRow(-1).innerHTML = "<td>" + data[i].alias_produccion + "</td> <td>" + data[i].serie_proyecto + "</td>" + "</td> ";
            }
            if (data[i].consecutivo_cabina==1){
              document.getElementById("tablaespera").insertRow(-1).innerHTML = "<td>" + data[i].alias_produccion + "</td> <td>" + data[i].serie_proyecto + "</td>" + "</td> ";
            }
          }
        },
        error: function (response) {
           ocultarLoader();
        },
      });
    });
  
  
  
  
  
  });


  function obtenerMaq(pk) {

    // $('#cbmmaquina').val(null).trigger('change');
    $("#cbmmaquina").select2("val", "");
    $("#cbmmaquina").empty();


    
    $.ajax({
      url: "modelos/obtenermaquinas.php",
      type: "POST",
      data: { pk: pk },
      dataType: "json",
  
      beforeSend: function (response) {
        mostrarLoader();
        // spanElement.innerText = "Buscando Información";
      },
  
      //  Se ejecuta cuando termino la petición
      complete: function (response) {
        // $('#exito').html('Exito...');
      },
  
      // se ejecuta al termino de la petición y está fue correcta
      success: function (data) {
          $('#cbmmaquina').append(
            `<option value="Ninguno"  selected="selected">Seleccione</option>`
        );       
  

        
        for (var i = 0; i < data.length; i++) {
  
          $('#cbmmaquina').append(
            `<option value="${data[i].pk}">${data[i].descripcion}</option>`
        );       
   
        
        }
        ocultarLoader();
        $('#cbmmaquina').select2('focus');
        $('#cbmmaquina').select2('open');   
      },
      error: function (response) {
        // window.location ="salir";
      },
    });
  }

  function obtenerGranalla(pk) {

    // $('#cbmmaquina').val(null).trigger('change');
    $("#cbmgranalla").select2("val", "");
    $("#cbmgranalla").empty();
    $.ajax({
      url: "modelos/obtenergranallado.php",
      type: "POST",
      data: { pk: pk },
      dataType: "json",
  
      beforeSend: function (response) {
        mostrarLoader();
        // spanElement.innerText = "Buscando Información";
      },
  
      //  Se ejecuta cuando termino la petición
      complete: function (response) {
        // $('#exito').html('Exito...');
      },
  
      // se ejecuta al termino de la petición y está fue correcta
      success: function (data) {
          $('#cbmgranalla').append(
            `<option value="Ninguno"  selected="selected">Seleccione</option>`
        );       
  
        for (var i = 0; i < data.length; i++) {
  
          $('#cbmgranalla').append(
            `<option value="${data[i].pk}">${data[i].Descripcion}</option>`
        );       
  
          
        }
        ocultarLoader();
        // $('#cbmgranalla').select2('focus');
        // $('#cbmgranalla').select2('open');   
      },
      error: function (response) {
        // window.location ="salir";
      },
    });
  }

  function GuardarGranalla(){

    var today = new Date();
    

    var Maquina = $('#cbmmaquina').select2('data');
    var Grana = $('#cbmgranalla').select2('data');

    if (Maquina[0].text=="" || Maquina[0].text=="Seleccione"){
        Swal.fire({
          icon: "error",
          title: "Error Seleccione una maquina",
          showConfirmButton: false,
          timer: 1500,
        });
        return false;
      }


    if (Grana[0].text=="" || Grana[0].text=="Seleccione"){
        Swal.fire({
          icon: "error",
          title: "Error seleccione un tipo de granallado",
          showConfirmButton: false,
          timer: 1500,
        });
        return false;
      }

    
     if (document.getElementById('txtgranallo').value==""){
       Swal.fire({
         icon: "error",
         title: "Error favor de ingresar una cantidad",
         showConfirmButton: false,
         timer: 1500,
       });
       return false;
     }

     
     $.ajax({
        url: "modelos/insertargranalla.php",
        type: "POST",
        data: { 
            kg:txtgranallo.value,
            fkEmpresa: txtPkempresa.value, 
            // fecha: ((today.getMonth() + 1)  + "/" + today.getDate() + "/" + today.getFullYear()),
            fkUsuario: txtPkusuario.value,
            fkGranalla: Grana[0].id,
            fkMaquina: Maquina[0].id, 
            usuario: txtUsario.value,
            tipo: "granalla"
            },
        dataType: "json",
        beforeSend: function (response) {
        },
        complete: function (response) {
        },
          success: function (data) {
              if(data[0]["message"]==="OK"){
        
                txtgranallo.value= '';
                $("#cbmgranalla").val("Ninguno").trigger("change")
                $("#cbmmaquina").val("Ninguno").trigger("change")
                $('#cbmmaquina').select2('focus');
                $('#cbmmaquina').select2('open');  
                Swal.fire({
                  icon: "success",
                  title: "Registro Ingresado Correctamente",
                  showConfirmButton: false,
                  timer: 1500,
                });
              };
          },
          error: function (response) {
            console.log(response);
          },
        });

  }





      
     



   