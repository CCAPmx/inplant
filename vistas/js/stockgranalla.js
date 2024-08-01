const pk = document.getElementById("txtpk").value;
const btnguardarEntradas = document.getElementById("btnguardarEntradas");
const usaurio= document.getElementById("txtUsario");
const stock = document.getElementById("txtStock");
const entradas= document.getElementById("txtEntradas");
const final= document.getElementById("txtFinal");




const btnguardarSalidas = document.getElementById("btnguardarSalidas");
const usauriosal= document.getElementById("txtUsariosal");
const stockfinal = document.getElementById("txtStocksal");
const salida= document.getElementById("txtSalidas");
const finalsal= document.getElementById("txtFinalsal");


$(document).ready(function () {

  btnguardarEntradas.addEventListener("click", GuardarEntrada);
  btnguardarSalidas.addEventListener("click", GuardarSalir);

  $('#cbmmaquinaent').select2({
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
    // allowClear: true
  });

  $('#cbmmaquinasal').select2({
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
    // allowClear: true
  });


  $('#cbmgranallaent').select2({
      theme: "bootstrap-5",
      width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
      placeholder: $( this ).data( 'placeholder' ),
      // allowClear: true
    });

    $('#cbmgranallasal').select2({
      theme: "bootstrap-5",
      width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
      placeholder: $( this ).data( 'placeholder' ),
      // allowClear: true
    });

    window.jsPDF = window.jspdf.jsPDF;
    tabla(pk);
    obtenerMaq(pk)
    obtenerGranalla(pk);
  });



  function tabla(cliente) {
    debugger;
    $.ajax({
      url: "modelos/stockgranalla.php",
      type: "POST",
      data: {fkCliente: cliente },
      dataType: "json",
  
      beforeSend: function (response) {
        // spanElement.innerText = 'Buscando Información';
      },
  
      //  Se ejecuta cuando termino la petición
      complete: function (response) {
  
  
      },
  
      success: function (data) {
  
        var num = parseInt(data);
        if (num > 0) {
  
            obtenertabla();
  
  
        } else {
          alert("Sin Datos");
          
        //   sindatos();
        }
  
      },
      error: function (response) {
  
        alert("Sin Datos");
       
        // sindatos();
  
      },
    });
  
  
  
  }


   function obtenertabla() {  
      $('#tablestock').bootstrapTable('destroy');
  
      $('#tablestock').bootstrapTable({
        url: 'vistas/recursos/json/stock.json',
        columns: [
          {
            field: 'Descripcion'
          },
          {
            field: 'entradas'
          },
           {
            field: 'salidas'
          },
          {
            field: 'stock'
          }]
      })
  
     
     
     
   }
  
   function sindatos() {
     debugger;
     $('#tablestock').bootstrapTable('destroy');
  
     $('#tablestock').bootstrapTable({
       url: 'vistas/recursos/json/sinvagones.json',
       columns: [{
         field: 'alias_produccion'
       }, {
         field: 'serie_proyecto'
       }, {
         field: 'nombre_cabina'
       }, {
         field: 'status'
       }]
     })
   }

   function operateFormatter(value, row, index) {
    return [
      '<a class="like" href="javascript:void(0)" title="Entradas">',
      '<i class="fa-solid fa-arrow-up-from-bracket fa-2x me-4" style="color: #07b5e8;"></i>',
      '</a>  ',

      '<a class="remove" href="javascript:void(0)" title="Salida">',
      '<i class="fa-solid fa-arrow-right-to-bracket fa-2x" style="color: #07b5e8;"></i>',
      '</a>'
    ].join('')
  }

 


   window.operateEvents = {
    'click .like': function (e, value, row, index) {
     

      document.getElementById("txtStock").value=row["stock"];
      

      $(".modal-header").css("background-color", "#07B5E8");
      $(".modal-title").text("Entradas");
        entradas.value==""
        final.value==""
        $("#cbmmaquinaent").val("Ninguno").trigger("change")
        $("#cbmgranallaent").val("Ninguno").trigger("change")

      $("#ModalEntrada").modal("show");
    },
    'click .remove': function (e, value, row, index) {

       document.getElementById("txtStocksal").value=row["stock"];

       finalsal.value==""
       salida.value==""
     
       $("#cbmmaquinasal").val("Ninguno").trigger("change")
       $("#cbmgranallasal").val("Ninguno").trigger("change")
      

       $(".modal-header").css("background-color", "#07B5E8");
       $(".modal-title").text("Salidas");
       $("#ModalSalida").modal("show");
    }
  }


  function obtenerMaq(pk) {

    $("#cbmmaquinaent").select2("val", "");
    $("#cbmmaquinaent").empty();

    $("#cbmmaquinasal").select2("val", "");
    $("#cbmmaquinasal").empty();

    
    
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
          $('#cbmmaquinaent').append(
            `<option value="Ninguno"  selected="selected">Seleccione</option>`
        );       

        $('#cbmmaquinasal').append(
          `<option value="Ninguno"  selected="selected">Seleccione</option>`
      );       
  

        
        for (var i = 0; i < data.length; i++) {
  
          $('#cbmmaquinaent').append(
            `<option value="${data[i].pk}">${data[i].descripcion}</option>`
        );       

        $('#cbmmaquinasal').append(
          `<option value="${data[i].pk}">${data[i].descripcion}</option>`
      );       
   
        
        }
        ocultarLoader();
        $('#cbmmaquinaent').select2('focus');
        $('#cbmmaquinaent').select2('open');   

        $('#cbmmaquinasal').select2('focus');
        $('#cbmmaquinasal').select2('open');   
      },
      error: function (response) {
        // window.location ="salir";
      },
    });
  }

  function obtenerGranalla(pk) {

    $("#cbmgranallaent").select2("val", "");
    $("#cbmgranallaent").empty();

    $("#cbmgranallasal").select2("val", "");
    $("#cbmgranallasal").empty();

    

    $.ajax({
      url: "modelos/obtenergranallado.php",
      type: "POST",
      data: { pk: pk },
      dataType: "json",
  
      beforeSend: function (response) {
        mostrarLoader();
      },
  
      complete: function (response) {
      },
  
      success: function (data) {
          $('#cbmgranallaent').append(
            `<option value="Ninguno"  selected="selected">Seleccione</option>`
        );       

        $('#cbmgranallasal').append(
          `<option value="Ninguno"  selected="selected">Seleccione</option>`
      );       
  

        


        for (var i = 0; i < data.length; i++) {
  
          $('#cbmgranallaent').append(
            `<option value="${data[i].pk}">${data[i].Descripcion}</option>`
        );       

        $('#cbmgranallasal').append(
          `<option value="${data[i].pk}">${data[i].Descripcion}</option>`
      );       
  
          
        }
        ocultarLoader();
       
      },
      error: function (response) {
        // window.location ="salir";
      },
    });
  }

function GuardarEntrada(e) {
    e.preventDefault();
    
   var Maquina = $('#cbmmaquinaent').select2('data');
   var granalla = $('#cbmgranallaent').select2('data');

 

   if (Maquina[0].text=="" || Maquina[0].text=="Seleccione"){
     Swal.fire({
       icon: "error",
       title: "Error Seleccione Una Maquina",
       showConfirmButton: false,
       timer: 1500,
     });
     return false;
   }

   if (granalla[0].text=="" || granalla[0].text=="Seleccione"){
     Swal.fire({
       icon: "error",
       title: "Error Seleccione Un Tipo De Granalla",
       showConfirmButton: false,
       timer: 1500,
     });
     return false;
   }


   if  (entradas.value=="" || entradas.value==0 ){
     Swal.fire({
       icon: "error",
       title: "Debe ingresar una entrada",
       showConfirmButton: false,
       timer: 1500,
     });
     return false;
   }

   $.ajax({
     url: "modelos/insertarentrada.php",
     type: "POST",
     data: { 
         tipo:"entrada",
         fkgranalla: granalla[0].id, 
         cantidad: entradas.value,
         usuario: usaurio.value,
         fkMaquina: Maquina[0].id, 
         stock_inicial: stock.value,
         stock_final: final.value
         },
     dataType: "json",
     beforeSend: function (response) {
     },
     complete: function (response) {
     },
       success: function (data) {
           if(data[0]["message"]==="OK"){

              
             Swal.fire({
               icon: "success",
               title: "Registro Ingresado Correctamente",
               showConfirmButton: false,
               timer: 1500,
             });
             $('#ModalEntrada').modal('hide')

             tabla(pk);
             location.reload();

           };
       },
       error: function (response) {
         console.log(response);
       },
     });

}


  function GuardarSalir(e) {
    e.preventDefault();


    const final= parseInt(stockfinal.value);

      const sal= parseInt(salida.value);

      if (sal>final){
        Swal.fire({
          icon: "error",
          title: "Favor de corregir la cantidad de salida",
          showConfirmButton: false,
          timer: 1500,
        });
        return false;
      }else{
        var Maquina = $('#cbmmaquinasal').select2('data');
        var granalla = $('#cbmgranallasal').select2('data');
    
        if  (usauriosal.value=""){
          Swal.fire({
            icon: "error",
            title: "Debe ingresar un usuario",
            showConfirmButton: false,
            timer: 1500,
          });
          return false;
        }
    
        if (Maquina[0].text=="" || Maquina[0].text=="Seleccione"){
          Swal.fire({
            icon: "error",
            title: "Error Seleccione Una Maquina",
            showConfirmButton: false,
            timer: 1500,
          });
          return false;
        }
    
        if (granalla[0].text=="" || granalla[0].text=="Seleccione"){
          Swal.fire({
            icon: "error",
            title: "Error Seleccione Un Tipo De Granalla",
            showConfirmButton: false,
            timer: 1500,
          });
          return false;
        }
    
        if  (salida.value=="" || salida.value==0 ){
          Swal.fire({
            icon: "error",
            title: "Debe ingresar una salida",
            showConfirmButton: false,
            timer: 1500,
          });
          return false;
        }
    
        if (parseInt(stockfinal.value)> parseInt(finalsal.value)){
          $.ajax({
            url: "modelos/insertarsalida.php",
            type: "POST",
            data: { 
                tipo:"salida",
                fkgranalla: granalla[0].id, 
                cantidad: salida.value,
                usuario: usauriosal.value,
                fkMaquina: Maquina[0].id, 
                stock_inicial: stockfinal.value,
                stock_final: finalsal.value
                },
            dataType: "json",
            beforeSend: function (response) {
            },
            complete: function (response) {
            },
              success: function (data) {
                  if(data[0]["message"]==="OK"){
                    Swal.fire({
                      icon: "success",
                      title: "Registro Ingresado Correctamente",
                      showConfirmButton: false,
                      timer: 1500,
                    });
                    $('#ModalSalida').modal('hide')
                    tabla(pk);
                    location.reload();
                  };
              },
              error: function (response) {
                console.log(response);
              },
            });   
        }else{
          Swal.fire({
            icon: "error",
            title: "La cantidad de salida debe ser menor al stock",
            showConfirmButton: false,
            timer: 1500,
          });
          return false;
        }

        
      }

    
  

    
  }

  document.getElementById('txtEntradas').addEventListener('keypress', function(event) {
    if (event.key === 'Enter' )   {
      const inicial= parseInt(stock.value);
    const ent= parseInt(entradas.value);
    const total = (parseInt(inicial) + parseInt(ent));
    final.value=total
    }
  });

  document.getElementById('txtSalidas').addEventListener('keypress', function(event) {
    if (event.key === 'Enter' )   {
      const final= parseInt(stockfinal.value);

      const sal= parseInt(salida.value);

      if (sal>final){
        Swal.fire({
          icon: "error",
          title: "Favor de corregir la cantidad de salida",
          showConfirmButton: false,
          timer: 1500,
        });
        return false;
      }else{
        const total = (parseInt(final) - parseInt(sal));
        finalsal.value=total
      }
    
    }
  });


  document.getElementById("txtEntradas").onblur=entr;

  function entr() {
    const inicial= parseInt(stock.value);
    const ent= parseInt(entradas.value);
    const total = (parseInt(inicial) + parseInt(ent));
    final.value=total
   
  }

  document.getElementById("txtSalidas").onblur=salid;

  function salid() {
    const final= parseInt(stockfinal.value);

      const sal= parseInt(salida.value);

      if (sal>final){
        Swal.fire({
          icon: "error",
          title: "Favor de corregir la cantidad de salida",
          showConfirmButton: false,
          timer: 1500,
        });
        return false;
      }else{
        const total = (parseInt(final) - parseInt(sal));
        finalsal.value=total
      }
   
  }