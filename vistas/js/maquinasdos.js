$(document).ready(function () {

    let tbpermisos = $("#tbpermisos").DataTable({
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
        select      : false,
        stateSave	: false, 
        order       : [ [ 0, 'asc' ] ],	
        buttons: [

            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i>',
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
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i>',
                titleAttr: 'Imprimir'
              },
              'pageLength'
              
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
            select: {
                rows: "" 
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
       "ajax": {
           "method": "POST",
           "url": "ajax/tablemaquinas.ajax.php"
       
       },
       
       columnDefs: [

        { "width": "10%", "targets": 0 },
        { "width": "40%", "targets": 1},
        { "width": "40%", "targets": 2 },
        { "width": "0%", "targets": 3 },
        { "width": "10%", "targets": 4 },
        {
          target: 3,
          visible: false,
      },
      {
        orderable: false,
        targets: 4,
        render: function(data, type, row, meta) {
          // Utiliza la función render para personalizar el contenido de la columna
          return '<input type="checkbox">';
        }
      },
 
    ]
    });

    $("#btnActualizarmaq").click(function () {
        mostrarLoader();
        $.ajax({
          type: "POST",
          url: "modelos/enviomaquina.php",
          success: function (data) {
             Conta = parseInt(data);
             if (Conta>0 ) {
               Swal.fire({
                 icon: "success",
                 title: "Registros Actualizado Correctamente " + Conta,
                 showConfirmButton: false,
                 timer: 1000,
               });
               tbpermisos.ajax.reload(null, false);
               ocultarLoader();
             } else {
               Swal.fire({
                 icon: "success",
                 title: "Registros Actualizado Correctamente " + Conta,
                 showConfirmButton: false,
                 timer: 1000,
               });
               tbpermisos.ajax.reload(null, false);
               ocultarLoader();
             }
          },
        });
      });
    
});

$("#btnNuevousuario").click(function () {
      $("#Frmusuarios").trigger("reset");
      $(".modal-header").css("background-color", "#07B5E8");
      $(".modal-title").text("Alta De Usuario");
      $("#myModal").modal("show");
  });

  $("#formConctato").submit(function (e) {
    e.preventDefault();
    idtipouser = parseInt($("#cbmTipouser").val());
    idcliente = parseInt($("#cbmCliente").val());
    idnotificacion = parseInt($("#cbmNotificacion").val());
    nombre = $.trim($("#txtNombre").val());
    usuario = $.trim($("#txtPuesto").val());
    contrasena = $.trim($("#txtContrasena").val());
    movil = $.trim($("#txtMovil").val());

    if (document.getElementById('CheckProd').checked){
        areaprod=1
     }else{
        areaprod=0
     }

     if (document.getElementById('CheckManto').checked){
        areamanto=1
     }else{
        areamanto=0
     }

     if (document.getElementById('CheckDir').checked){
        areadir=1
     }else{
        areadir=0
     }


    


    if ($('#CheckDir').is(":checked")) {
        areadir=1;
    }
    else {
        areadir=0;
    }

    if ($('#CheckBodega').is(":checked")) {
        areabodega=1;
    }
    else {
        areabodega=0;
    }

    if ($('#CheckProy').is(":checked")) {
        areaproyecto=1;
    }
    else {
        areaproyecto=0;
    }

    if ($('#CheckGranalla').is(":checked")) {
        permisogranalla=1;
    }
    else {
        permisogranalla=0;
    }

    if ($('#CheckPiezas').is(":checked")) {
        permisopieza=1;
    }
    else {
        permisopieza=0;
    }

    if ($('#CheckPartes').is(":checked")) {
        permisoaltapartes=1;
    }
    else {
        permisoaltapartes=0;
    }

    if ($('#CheckExtender').is(":checked")) {
        permisovidautil=1;
    }
    else {
        permisovidautil=0;
    }

    if ($('#CheckEntradas').is(":checked")) {
        permisoentrada=1;
    }
    else {
        permisoentrada=0;
    }

    if ($('#CheckSalidas').is(":checked")) {
        permisosalida=1;
    }
    else {
        permisosalida=0;
    }

    $.ajax({
      url: "modelos/crudcontactos.php",
      type: "POST",
      datatype: "json",
      data: {
        idcontacto:idcontacto,
        idusuario: idusuario,
        nombre: nombre,
        puesto: puesto,
        domoficina: domoficina,
        teloficina: teloficina,
        fax: fax,
        domparticular: domparticular,
        telparticular: telparticular,
        celular: celular,
        email: email,
        fecha: fecha,
        opcion: opcion,
      },
      success: function (data) {
        Swal.fire({
          icon: 'success',
          title: 'Registro Actualizado Correctamente',
          showConfirmButton: false,
          timer: 1000
        })
        $("#ModalContactos").modal("hide");
        tbcontactos.ajax.reload(null, false);
      },
    });
   
   
  });

  function obtenerTipousario() {
    $.ajax({
      url: "ajax/usuarios.ajax.php",
      type: "POST",
      data: {
        Combo: 1
      },
      datatype: "json",
      success: function (data) {
       
        $("#cbmTipouser").append(
          '<option value=0 selected="selected">Seleccione Tipo De Usuario</option>'
        );
        var obj = JSON.parse(data);
        obj.forEach(function (data, index) {
          $("#cbmTipouser").append(
            "<option value=" + data.id + ">" + data.text + "</option>"
          );
        });
      },
      error: function (data) {
        // alert("Error Centro");
      },
    });
  }

  
function mostrarLoader() {
    document.getElementById("loader").style.display = "block";
  }
  
  // Función para ocultar el loader
  function ocultarLoader() {
    document.getElementById("loader").style.display = "none";
  }
  