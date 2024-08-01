var tbclientes = null;
let selectedId = 0;
let selectedText = "";


$(document).ready(function () {

  document.getElementById('Iniciosuper').style.display = 'block';
  document.getElementById('Usuariosuper').style.display = 'block';
  document.getElementById('Maquinasuper').style.display = 'block';
  document.getElementById('Granallasuper').style.display = 'block';
  document.getElementById('Clientesuper').style.display = 'block';
  document.getElementById('Produccionsuper').style.display = 'block';
  document.getElementById('Bodegasuper').style.display = 'block';
  document.getElementById('Mantenimientosuper').style.display = 'block';
  document.getElementById('Direccionsuper').style.display = 'block';
  document.getElementById('Granulometriasuper').style.display = 'block';
  document.getElementById('Contactosuper').style.display = 'block';
  document.getElementById('Salirsuper').style.display = 'block';

  document.getElementById('InicioJefe').style.display = 'none';
  document.getElementById('PedidosJefe').style.display = 'none';
  document.getElementById('MaquinasJefe').style.display = 'none';
  document.getElementById('ProduccionJefe').style.display = 'none';
  document.getElementById('EstadoJefe').style.display = 'none';
  document.getElementById('SalirJefe').style.display = 'none';

  ocultarLoader();

  // mostrarLoader();

    obtenerCombocliente();

    let tbclientes = $("#tbclientes").DataTable({
      autoWidth: true,
      responsive: true,
      paging      : true,
      retrieve: true,
      pageLength  : 10,
      lengthChange: false,
      dom: "Bfrtip",
      ordering    : true,
      serverSide	: false,
      fixedHeader : true,
      orderCellsTop: true,
      info		: true,
      search: {
        "escapeRegex": false // Permite caracteres especiales
      },
      select      : false,
      stateSave	: false, 
      order       : [ [ 0, 'asc' ] ],	
      buttons: [

          {
              extend: 'excel',
              text: '<iIng class="fas fa-file-excel"></iIng>',
              title: 'REPORTE DE REFERENCIAS ',
              filename: 'REFERENCIAS',
              titleAttr: 'Excel'
          },
          {
              extend: 'pdf',
              text: '<i class="fas fa-file-pdf"></i>',
              orientation: 'portrait',
              pageSize: 'letter',
              title: 'REPORTE DE REFERENCIAS ',
              filename: 'REFERENCIAS',
              titleAttr: 'PDF'
          },
      //     {
      //         extend: 'print',
      //         text: '<i class="fas fa-print"></i>',
      //         titleAttr: 'Imprimir'
      //       },
      //       'pageLength'
            
      ],
      language : {
          processing:     "Procesando...",
          zeroRecords:    "No se encontraron resultados",
          emptyTable:     "Ningún dato disponible en esta tabla",
          info:           "Mostrando _START_ al _END_ de _TOTAL_ registros",
          infoEmpty:      "No hay registros disponibles",
          infoFiltered:   "(filtrado de un total de _MAX_ registros)",
          infoPostFix:    "",
          search:         "Buscar:",
          url:            "",
          infoThousands:  ",",
          loadingRecords: "Cargando...",
          oPaginate: {
                 sFirst : "Primero",
                 sLast  : "Último",
                 sNext  : "<span class='fa fa-chevron-right fa-w-10'></span>",
                 sPrevious : "<span class='fa fa-chevron-left fa-w-10'></span>"
             },         
          searchBuilder: {
              add: 'Agregar Filtro',
              condition: 'Operador',
              clearAll: 'Limpiar',
              delete: 'Borrar',
              deleteTitle: 'Borrar Titulo',
              data: 'Columna',
              left: 'Izquierda',
              leftTitle: 'Titulo Izquierdo',
              logicAnd: 'And',
              logicOr: 'or',
              right: 'Derecho',
              rightTitle: 'Titulo Derecho',
              title: {
                  0: '',
                  _: 'Filtros (%d)'
              },
              value: 'Opción',
              valueJoiner: 'et',
              conditions :{
                  string: {
                      contains: 'Contiene',
                      empty: 'Vacío',
                      endsWith: 'Termina con',
                      equals: 'Igual a',
                      not: 'Diferente de',
                      notContains: 'No Contiene',
                      notEmpty: 'No Vacío',
                      notEndsWith: 'No Termina con',
                      notStartsWith: 'No Inicia con',
                      startsWith: 'Inicia con'
                  },
                  number: {
                      equals: 'Igual a',
                      not: 'Diferente de',
                      gt: 'Mayor a',
                      gte: 'Mayor o igual a',
                      lt: 'Menor a',
                      lte: 'Menor o igual a',
                      between: 'Entre',
                      notBetween: 'No entre',
                      empty: 'Vacío',
                      notEmpty: 'No vacío'
                  },
                  date: {
                      before: 'Antes',
                      after: 'Después',
                      equals: 'Igual a',
                      not: 'Diferente de',
                      between: 'Entre',
                      notBetween: 'No entre',
                      empty: 'Vacío',
                      notEmpty: 'No vacío'
                  },
                  moment: {
                      before: 'Antes',
                      after: 'Después',
                      equals: 'Igual a',
                      not: 'Diferente de',
                      between: 'Entre',
                      notBetween: 'No entre',
                      empty: 'Vacío',
                      notEmpty: 'No vacío'
                  }
              }
          }
      },




      
      ajax: {
        method: "POST",
        url: "ajax/tableclientes.ajax.php",
      },
      
    
  
  columnDefs: [
    { "width": "10%", "targets": 0 },
    { "width": "10%", "targets": 1},
    { "width": "10%", "targets": 2 },
    { "width": "10%", "targets": 3 },

   {
       targets: -1,
       data: null,
       defaultContent: '<div class="text-center" ><button class="btn btn-outline-info btn-sm BtnCliente" Id style="margin-right:10px;"><i class="fa-solid fa-eye"></i></button></div>'
   },
  //  {
  //     target: 3,
  //     visible: false,
  //  },

  
]
  });
  tbclientes.on('draw.dt', function() {
    // Aquí se ejecuta el código cuando se ha terminado de cargar el DataTable
    ocultarLoader();
  });


  

  $("#btnActualizar").click(function () {

    // alert('sssss');
    mostrarLoader();
    $.ajax({
      type: "POST",
      url: "modelos/envioclientes.php",
      success: function (data) {;
         Conta = parseInt(data);
         if (Conta>0 ) {
           Swal.fire({
             icon: "success",
             title: "Registros Actualizado Correctamente",
             showConfirmButton: false,
             timer: 1500,
           });
           tbclientes.ajax.reload(null, false);
           ocultarLoader();
         } else {
           Swal.fire({
             icon: "success",
             title: "Registros Actualizado Correctamente",
             showConfirmButton: false,
             timer: 1500,
           });
           tbclientes.ajax.reload(null, false);
           ocultarLoader();
         }
      },
    });
  });

  $("#FrmClientes").submit(function (e) {
    e.preventDefault();
    let id = $.trim(document.getElementById("idcliente").value);
    let pk= generateUUID();
    let Nombre = $.trim(document.getElementById("txtNombre").value);
    let email = $.trim(document.getElementById("txtEmail").value);
    let nombrecorto = $.trim(document.getElementById("txtNombrecorto").value);
    let nombre_real_cliente = $.trim(document.getElementById("txtNombrereal").value);
    
  
     var datos = {};
     datos = {
      id: id,
       pk: pk,
       Nombre: Nombre,
       email: email,
       nombrecorto: nombrecorto,
       nombre_real_cliente: nombre_real_cliente,
      
     };

     $.ajax({
       data: {
         Insert: datos,
       },
       type: "POST",
       url: "ajax/clientes.ajax.php",
       success: function (data) {
          data = parseInt(data);
          if (data === 1) {
            Swal.fire({
              icon: "success",
              title: "Registro Actualizado Correctamente",
              showConfirmButton: false,
              timer: 1500,
            });
            tbclientes.ajax.reload(null, false);
            $("#FrmClientes").trigger("reset");
            $("#Modalclientes").modal("hide");
          } else {
            Swal.fire({
              icon: "error",
              title: "Error Al Registrar La Información",
              showConfirmButton: false,
              timer: 1500,
            });
            tbclientes.ajax.reload(null, false);
            $("#FrmClientes").trigger("reset");
            $("#Modalclientes").modal("hide");
          }
       },
     });

 });

 $(document).on("click", ".BtnCliente", function (e) {

  // alert('dentro de usuario');
  let pks="";

  e.preventDefault();

  // if (window.matchMedia("(min-width:992px)").matches) {
    var data = tbclientes.row($(this).parents("tbody tr ul li")).data();
    razon = data[0];
    direccion= data[1];
    rfc= data[2];
    pks =data[3];
    id= data[4];
    tipousr= parseInt($.trim(document.getElementById("tipousuarionivel").value));
   
    // var s = document.getElementById('txtpkmaq');
    // s.value = rfc;

    // document.getElementById("txtpkmaq").value=pks;
  // } else {
    // var data = tbclientes.row($(this).parents("tbody tr ul li")).data();
    // razon = data[0];
    // direccion= data[1];
    // rfc= data[2];
    // // pks =data[3];
    // id= data[4];
    // tipousr= parseInt($.trim(document.getElementById("tipousuarionivel").value));


   
    // document.getElementById("txtpkmaq").value=pks;

    // var s = document.getElementById('txtpkmaq');
    // s.value = rfc;
  // }


  localStorage.setItem('txtRazonsocial',razon);
  localStorage.setItem('txtDireccionfiscal',direccion);
  localStorage.setItem('Txtrfc',rfc);
  localStorage.setItem('idempresa',id);
  localStorage.setItem('tipousr',tipousr);
  localStorage.setItem('pk',pks);
  window.location ="dashclientes";

 





});

$(document).on("click", ".BtnEli", function (e) {
  e.preventDefault();
  if(window.matchMedia("(min-width:992px)").matches){
    var data = tbclientes.row( $(this).parents('tr') ).data();
    id= data[6];
  }else{
    var data = tbclientes.row( $(this).parents('tbody tr ul li') ).data();
    id= data[6];
  }

  
  Swal.fire({
    title: 'Esta Seguro De Borrar Este Cliente?',
    text: "¡Si no lo está puede cancelar la acción!",
    icon: 'error',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, borrar Cliente!'
  }).then((result) => {
    if (result.value) {
        $.ajax({
            type: 'POST',
            url: "ajax/clientes.ajax.php",
            data: {Id: id},
            success: function (respuesta) {
              resp = parseInt(respuesta);
              if (resp === 1) {
                    Swal.fire({
                      position: "center",
                      icon: "success",
                      title: "Eliminado!",
                      text: "Cliente eliminado correctamente",
                      showConfirmButton: false,
                      timer: 2000,
                    });
                    tbclientes.ajax.reload(null, false);
                    $("#FrmClientes").trigger("reset");
                }
                      
            }
        })
    }
  })
  
});


});


$("#btnNuevocliente").click(function () {
  $("#FrmClientes").trigger("reset");
  $(".modal-header").css("background-color", "#07B5E8");
  $(".modal-title").text("Alta De Clientes");
  $("#Modalclientes").modal("show");
});


$("#cbmCliente").on('change', function(){ 
  mostrarLoader();
  var select2 = $('#cbmCliente').data('select2');
  selectedId = select2.data()[0].id;
  selectedText = select2.data()[0].text;
  // var value = $(this).val();
  cambio(selectedId);
});


function cambio(pk){
  $('#tablaMaquinass > tbody').empty();
  $.ajax({
      url: "modelos/maquinas.php",
      type: "POST",
      data: {pk: pk},
       dataType: "json",

       beforeSend:function(response){ 
        // $('#cargando').css({display:'block'});
        // $('#exito').html('Procesando...');
          mostrarLoader();
        },

        //Se ejecuta cuando termino la petición
        complete:function(response){
          // $('#exito').html('Exito...');
          ocultarLoader();
        },

        // se ejecuta al termino de la petición y está fue correcta
        success: function (data) {
          var html = '';
          contar=0;
          // var i;
           for (var i = 0; i < data.length; i++) {
              contar+=1;
             
              html += '<tr>' +
              '<td style="text-align:center">' + contar + '</td>' +
              '<td style="text-align:left">' +  data[i].nombre + '</td>' +
              '<td  style="text-align:left">' +  data[i].descripcion + '</td>' +
              '<td  style="text-align:center"><input type="checkbox"></td>' +
              '</tr>';
             
  
           }
           $('#DataResultmaquina').html(html);

        },
         error: function (response) {
          // alert(error con la petición);
          ocultarLoader();
        }
      

  });
}




function mostrarLoader() {
  document.getElementById("loader").style.display = "block";
}

// Función para ocultar el loader
function ocultarLoader() {
  document.getElementById("loader").style.display = "none";
}


  function obtenerCombocliente() {
    $.ajax({
      url: "ajax/clientes.ajax.php",
      type: "POST",
      data: {
        Combo: 1
      },
      datatype: "json",
      success: function (data) {
       
        $("#cbmCliente").append(
          '<option value=0 selected="selected">Seleccione Cliente</option>'
        );
        var obj = JSON.parse(data);
        obj.forEach(function (data, index) {
          $("#cbmCliente").append(
            "<option value=" + data.id + ">" + data.text + "</option>"
          );
        });
      },
      error: function (data) {
        // alert("Error Centro");
      },
    });
  }



