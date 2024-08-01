var tbusuarios = null;
// const btnsel = document.createElement("button");
$(document).ready(function () {
  ocultarLoader();
  // const razon = localStorage.getItem('txtRazonsocial');
  // const direccion = localStorage.getItem('txtDireccionfiscal');
  // const rfc = localStorage.getItem('Txtrfc');
  // const idempresa = localStorage.getItem('idempresa');

  // Set the button text
  // button.innerHTML = "Click me";

  // // Add a click event listener to the button
  // button.addEventListener("click", function() {
  //   // Code to execute when the button is clicked
  //   console.log("Button clicked!");
  // });

  $("#txtMovil").focus(function () {
    $("#txtMovil").val("+52");
    $("#txtMovil").unbind();
  });

  $("#cbmTipouser").select2({
    theme: "bootstrap-5",
    width: $(this).data("width")
      ? $(this).data("width")
      : $(this).hasClass("w-100")
      ? "100%"
      : "style",
    placeholder: $(this).data("placeholder"),
    dropdownParent: $("#myModal"),
  });

  $("#cbmCliente").select2({
    theme: "bootstrap-5",
    width: $(this).data("width")
      ? $(this).data("width")
      : $(this).hasClass("w-100")
      ? "100%"
      : "style",
    placeholder: $(this).data("placeholder"),
    dropdownParent: $("#myModal"),
  });

  sessionStorage.clear();
  obtenerTipousario();
  tbusuarios = $("#tbusuarios").DataTable({
    responsive: true,
    paging: true,
    retrieve: true,
    pageLength: 10,
    lengthChange: false,
    dom: "Bfrtip",
    ordering: true,
    serverSide: false,
    fixedHeader: true,
    orderCellsTop: true,
    info: true,
    select: false,
    stateSave: false,
    order: [[0, "asc"]],
    buttons: [
      {
        extend: "excel",
        text: '<i class="fas fa-file-excel"></i>',
        title: "REPORTE DE REFERENCIAS ",
        filename: "REFERENCIAS",
        titleAttr: "Excel",
      },
      {
        extend: "pdf",
        text: '<i class="fas fa-file-pdf"></i>',
        orientation: "portrait",
        pageSize: "letter",
        title: "REPORTE DE REFERENCIAS ",
        filename: "REFERENCIAS",
        titleAttr: "PDF",
      },
      // {
      //   extend: "print",
      //   text: '<i class="fas fa-print"></i>',
      //   titleAttr: "Imprimir",
      // },
      "pageLength",
    ],
    language: {
      processing: "Procesando...",
      zeroRecords: "No se encontraron resultados",
      emptyTable: "Ningún dato disponible en esta tabla",
      info: "Mostrando _START_ al _END_ de _TOTAL_ registros",
      infoEmpty: "No hay registros disponibles",
      infoFiltered: "(filtrado de un total de _MAX_ registros)",
      infoPostFix: "",
      search: "Buscar:",
      url: "",
      infoThousands: ",",
      loadingRecords: "Cargando...",
      oPaginate: {
        sFirst: "Primero",
        sLast: "Último",
        sNext: "<span class='fa fa-chevron-right fa-w-10'></span>",
        sPrevious: "<span class='fa fa-chevron-left fa-w-10'></span>",
      },
      select: {
        rows: "",
      },
      searchBuilder: {
        add: "Agregar Filtro",
        condition: "Operador",
        clearAll: "Limpiar",
        delete: "Borrar",
        deleteTitle: "Borrar Titulo",
        data: "Columna",
        left: "Izquierda",
        leftTitle: "Titulo Izquierdo",
        logicAnd: "And",
        logicOr: "or",
        right: "Derecho",
        rightTitle: "Titulo Derecho",
        title: {
          0: "",
          _: "Filtros (%d)",
        },
        value: "Opción",
        valueJoiner: "et",
        conditions: {
          string: {
            contains: "Contiene",
            empty: "Vacío",
            endsWith: "Termina con",
            equals: "Igual a",
            not: "Diferente de",
            notContains: "No Contiene",
            notEmpty: "No Vacío",
            notEndsWith: "No Termina con",
            notStartsWith: "No Inicia con",
            startsWith: "Inicia con",
          },
          number: {
            equals: "Igual a",
            not: "Diferente de",
            gt: "Mayor a",
            gte: "Mayor o igual a",
            lt: "Menor a",
            lte: "Menor o igual a",
            between: "Entre",
            notBetween: "No entre",
            empty: "Vacío",
            notEmpty: "No vacío",
          },
          date: {
            before: "Antes",
            after: "Después",
            equals: "Igual a",
            not: "Diferente de",
            between: "Entre",
            notBetween: "No entre",
            empty: "Vacío",
            notEmpty: "No vacío",
          },
          moment: {
            before: "Antes",
            after: "Después",
            equals: "Igual a",
            not: "Diferente de",
            between: "Entre",
            notBetween: "No entre",
            empty: "Vacío",
            notEmpty: "No vacío",
          },
        },
      },
    },
    ajax: {
      method: "POST",
      url: "ajax/tableusuarios.ajax.php",
    },

    columnDefs: [
      { width: "30%", targets: 0 },
      { width: "30%", targets: 1 },
      { width: "30%", targets: 2 },
      { width: "10%", targets: 3 },
      {
        targets: -1,
        data: null,
        defaultContent:
          '<div class="text-center" ><button class="btn btn-outline-info btn-sm BtnModclient" Id style="margin-right:10px;"><i class="fas fa-pen"></i></button></div>',
      },
      {
        targets: [3],
        visible: false,
      },

      // {

      //     targets: 7,
      //     searchable: false,
      //     orderable: false,
      //     className: 'dt-body-center',
      //     render: function (data, type, row) {
      //         if (row[7]== 1) {
      //             return '<i class="fa-solid fa-check fa-2x" style="color:#07B5E8"></i>';
      //         } else  {
      //             return '<i class="fa-solid fa-xmark fa-2x" style="color:red"></i>';
      //         }

      //     }
      //   },
      //   {
      //     targets: 8,
      //     searchable: false,
      //     orderable: false,
      //     className: 'dt-body-center',
      //     render: function (data, type, row) {
      //         if (row[8]== 1) {
      //             return '<i class="fa-solid fa-check fa-2x" style="color:#07B5E8"></i>';
      //         } else  {
      //             return '<i class="fa-solid fa-xmark fa-2x" style="color:red"></i>';
      //         }
      //     }
      //   },
      //   {
      //     targets: 9,
      //     searchable: false,
      //     orderable: false,
      //     className: 'dt-body-center',
      //     render: function (data, type, row) {
      //         if (row[9]== 1) {
      //             return '<i class="fa-solid fa-check fa-2x" style="color:#07B5E8"></i>';
      //         } else  {
      //             return '<i class="fa-solid fa-xmark fa-2x" style="color:red"></i>';
      //         }
      //     }
      //   },
      //   {
      //     targets: 10,
      //     searchable: false,
      //     orderable: false,
      //     className: 'dt-body-center',
      //     render: function (data, type, row) {
      //         if (row[10]== 1) {
      //             return '<i class="fa-solid fa-check fa-2x" style="color:#07B5E8"></i>';
      //         } else  {
      //             return '<i class="fa-solid fa-xmark fa-2x" style="color:red"></i>';
      //         }
      //     }
      //   },
      //   {
      //     targets: 11,
      //     searchable: false,
      //     orderable: false,
      //     className: 'dt-body-center',
      //     render: function (data, type, row) {
      //         if (row[11]== 1) {
      //             return '<i class="fa-solid fa-check fa-2x" style="color:#07B5E8"></i>';
      //         } else  {
      //             return '<i class="fa-solid fa-xmark fa-2x" style="color:red"></i>';
      //         }
      //     }
      //   },
      //   {
      //     targets: 12,
      //     searchable: false,
      //     orderable: false,
      //     className: 'dt-body-center',
      //     render: function (data, type, row) {
      //         if (row[12]== 1) {
      //             return '<i class="fa-solid fa-check fa-2x" style="color:#07B5E8"></i>';
      //         } else  {
      //             return '<i class="fa-solid fa-xmark fa-2x" style="color:red"></i>';
      //         }
      //     }
      //   },
      //   {
      //     targets: 13,
      //     searchable: false,
      //     orderable: false,
      //     className: 'dt-body-center',
      //     render: function (data, type, row) {
      //         if (row[13]== 1) {
      //             return '<i class="fa-solid fa-check fa-2x" style="color:#07B5E8"></i>';
      //         } else  {
      //             return '<i class="fa-solid fa-xmark fa-2x" style="color:red"></i>';
      //         }
      //     }
      //   },
      //   {
      //     targets: 14,
      //     searchable: false,
      //     orderable: false,
      //     className: 'dt-body-center',
      //     render: function (data, type, row) {
      //         if (row[14]== 1) {
      //             return '<i class="fa-solid fa-check fa-2x" style="color:#07B5E8"></i>';
      //         } else  {
      //             return '<i class="fa-solid fa-xmark fa-2x" style="color:red"></i>';
      //         }
      //     }
      //   },
      //   {
      //     targets: 15,
      //     searchable: false,
      //     orderable: false,
      //     className: 'dt-body-center',
      //     render: function (data, type, row) {
      //         if (row[15]== 1) {
      //             return '<i class="fa-solid fa-check fa-2x" style="color:#07B5E8"></i>';
      //         } else  {
      //             return '<i class="fa-solid fa-xmark fa-2x" style="color:red"></i>';
      //         }
      //     }
      //   },
      //   {
      //     targets: 16,
      //     searchable: false,
      //     orderable: false,
      //     className: 'dt-body-center',
      //     render: function (data, type, row) {
      //         if (row[16]== 1) {
      //             return '<i class="fa-solid fa-check fa-2x" style="color:#07B5E8"></i>';
      //         } else  {
      //             return '<i class="fa-solid fa-xmark fa-2x" style="color:red"></i>';
      //         }
      //     }
      //   },
      //   {
      //     targets: 17,
      //     searchable: false,
      //     orderable: false,
      //     className: 'dt-body-center',
      //     render: function (data, type, row) {
      //         if (row[17]== 1) {
      //             return '<i class="fa-solid fa-check fa-2x" style="color:#07B5E8"></i>';
      //         } else  {
      //             return '<i class="fa-solid fa-xmark fa-2x" style="color:red"></i>';
      //         }
      //     }
      //   },
      //   {
      //     "targets": [18,19,20],
      //     "visible": false,
      // }
    ],
  });

  // let tbpermisos = $("#tbpermisos").DataTable({
  //   responsive: true,
  //   paging      : true,
  //   retrieve: true,
  //   pageLength  : 5,
  //   lengthChange: false,
  //   dom: "Bfrtip",
  //   ordering    : true,
  //   serverSide	: false,
  //   fixedHeader : true,
  //   orderCellsTop: true,
  //   info		: true,
  //   select      : false,
  //   stateSave	: false,
  //   order       : [ [ 0, 'asc' ] ],
  //   buttons: [

  //       {
  //           extend: 'excel',
  //           text: '<i class="fas fa-file-excel"></i>',
  //           title: 'REPORTE DE REFERENCIAS ',
  //           filename: 'REFERENCIAS',
  //           titleAttr: 'Excel'
  //       },
  //       {
  //           extend: 'pdf',
  //           text: '<i class="fas fa-file-pdf"></i>',
  //           orientation: 'portrait',
  //           pageSize: 'letter',
  //           title: 'REPORTE DE REFERENCIAS ',
  //           filename: 'REFERENCIAS',
  //           titleAttr: 'PDF'
  //       },
  //       {
  //           extend: 'print',
  //           text: '<i class="fas fa-print"></i>',
  //           titleAttr: 'Imprimir'
  //         },
  //         'pageLength'

  //   ],
  //   language : {
  //       processing:     "Procesando...",
  //       zeroRecords:    "No se encontraron resultados",
  //       emptyTable:     "Ningún dato disponible en esta tabla",
  //       info:           "Mostrando _START_ al _END_ de _TOTAL_ registros",
  //       infoEmpty:      "No hay registros disponibles",
  //       infoFiltered:   "(filtrado de un total de _MAX_ registros)",
  //       infoPostFix:    "",
  //       search:         "Buscar:",
  //       url:            "",
  //       infoThousands:  ",",
  //       loadingRecords: "Cargando...",
  //       oPaginate: {
  //              sFirst : "Primero",
  //              sLast  : "Último",
  //              sNext  : "<span class='fa fa-chevron-right fa-w-10'></span>",
  //              sPrevious : "<span class='fa fa-chevron-left fa-w-10'></span>"
  //          },
  //       select: {
  //           rows: ""
  //       },
  //       searchBuilder: {
  //           add: 'Agregar Filtro',
  //           condition: 'Operador',
  //           clearAll: 'Limpiar',
  //           delete: 'Borrar',
  //           deleteTitle: 'Borrar Titulo',
  //           data: 'Columna',
  //           left: 'Izquierda',
  //           leftTitle: 'Titulo Izquierdo',
  //           logicAnd: 'And',
  //           logicOr: 'or',
  //           right: 'Derecho',
  //           rightTitle: 'Titulo Derecho',
  //           title: {
  //               0: '',
  //               _: 'Filtros (%d)'
  //           },
  //           value: 'Opción',
  //           valueJoiner: 'et',
  //           conditions :{
  //               string: {
  //                   contains: 'Contiene',
  //                   empty: 'Vacío',
  //                   endsWith: 'Termina con',
  //                   equals: 'Igual a',
  //                   not: 'Diferente de',
  //                   notContains: 'No Contiene',
  //                   notEmpty: 'No Vacío',
  //                   notEndsWith: 'No Termina con',
  //                   notStartsWith: 'No Inicia con',
  //                   startsWith: 'Inicia con'
  //               },
  //               number: {
  //                   equals: 'Igual a',
  //                   not: 'Diferente de',
  //                   gt: 'Mayor a',
  //                   gte: 'Mayor o igual a',
  //                   lt: 'Menor a',
  //                   lte: 'Menor o igual a',
  //                   between: 'Entre',
  //                   notBetween: 'No entre',
  //                   empty: 'Vacío',
  //                   notEmpty: 'No vacío'
  //               },
  //               date: {
  //                   before: 'Antes',
  //                   after: 'Después',
  //                   equals: 'Igual a',
  //                   not: 'Diferente de',
  //                   between: 'Entre',
  //                   notBetween: 'No entre',
  //                   empty: 'Vacío',
  //                   notEmpty: 'No vacío'
  //               },
  //               moment: {
  //                   before: 'Antes',
  //                   after: 'Después',
  //                   equals: 'Igual a',
  //                   not: 'Diferente de',
  //                   between: 'Entre',
  //                   notBetween: 'No entre',
  //                   empty: 'Vacío',
  //                   notEmpty: 'No vacío'
  //               }
  //           }
  //       }
  //   },
  //   "ajax": {
  //     "method": "POST",
  //     "url": "ajax/tablemaquinas.ajax.php"

  // },

  // columnDefs: [

  //  { "width": "10%", "targets": 0 },
  //  { "width": "40%", "targets": 1},
  //  { "width": "40%", "targets": 2 },
  //  { "width": "0%", "targets": 3 },
  //  { "width": "10%", "targets": 4 },

  //  {
  //     orderable: false,
  //     className: 'select-checkbox',
  //     targets:   4
  // } ],
  // select: {
  //     style:    'os',
  //     selector: 'td:first-child'
  // }

  //   });

  // $("#btnActualizarusuario").click(function () {
  //     mostrarLoader();
  //     $.ajax({
  //       type: "POST",
  //       url: "modelos/usuarios.ajax.php",
  //       success: function (data) {
  //         console.log(data);
  //          Conta = parseInt(data);
  //          if (Conta>0 ) {
  //            Swal.fire({
  //              icon: "success",
  //              title: "Registros Actualizado Correctamente " + Conta,
  //              showConfirmButton: false,
  //              timer: 1000,
  //            });
  //            tbusuarios.ajax.reload(null, false);
  //            ocultarLoader();
  //          } else {
  //            Swal.fire({
  //              icon: "success",
  //              title: "Registros Actualizado Correctamente " + Conta,
  //              showConfirmButton: false,
  //              timer: 1000,
  //            });
  //            tbusuarios.ajax.reload(null, false);
  //            ocultarLoader();
  //          }
  //       },
  //     });
  //   });


  $(document).on("click", ".BtnModclient", function (e) {

    e.preventDefault();

    var data = tbusuarios.row($(this).parents("tr")).data();
    var id=0;
    if (data == undefined) {
      var selected_row = $(this).parents("tr");
      if (selected_row.hasClass("child")) {
        selected_row = selected_row.prev();
      }

      var rowData = $("#tbusuarios").DataTable().row(selected_row).data();
      id = rowData[3];
    } else {
      id = data[3];
    }


    $.ajax({
      url: "ajax/usuarios.ajax.php",
      type: "POST",
      data: { Id: id },
      dataType: "json",
  
      beforeSend: function (response) {
        mostrarLoader();
      },
  
      //  Se ejecuta cuando termino la petición
      complete: function (response) {
        ocultarLoader();
        // $('#exito').html('Exito...');
      },
  
      // se ejecuta al termino de la petición y está fue correcta
      success: function (data) {
        $("#Frmusuarios").trigger("reset");
        $(".modal-header").css("background-color", "#07B5E8");
        $(".modal-title").text("Edición De Usuario");
        $("#myModal").modal("show");
        document.getElementById("id").value=data.id;
        document.getElementById("txtNombre").value=data.nombre;
        document.getElementById("txtUsuario").value=data.usuario;

        $("#cbmTipouser").val(data.tipousuario);
        $("#cbmTipouser").trigger("change.select2");

        $("#cbmCliente").val(data.idempresa);
        $("#cbmCliente").trigger("change.select2");

        $("#cbmNotificacion").val(data.nivel_alarmas);
        $("#cbmNotificacion").trigger("change.select2");

        document.getElementById("txtMovil").value=data.telefono_app;
       
        if (data.produccion===1){
          document.getElementById("CheckProd").checked = true;
        }else{
          document.getElementById("CheckProd").checked = true;
        }

        if (data.mantenimiento===1){
          document.getElementById("CheckManto").checked = true;
        }else{
          document.getElementById("CheckManto").checked = true;
        }

        if (data.direccion===1){
          document.getElementById("CheckDir").checked = true;
        }else{
          document.getElementById("CheckDir").checked = true;
        }


        if (data.bodega===1){
          document.getElementById("CheckBode").checked = true;
        }else{
          document.getElementById("CheckBode").checked = true;
        }

        if (data.proyectos===1){
          document.getElementById("CheckProy").checked = true;
        }else{
          document.getElementById("CheckProy").checked = true;
        }

        if (data.ext_cargarGranalla===1){
          document.getElementById("CheckGranalla").checked = true;
        }else{
          document.getElementById("CheckGranalla").checked = true;
        }

        if (data.ext_cargarpiezas===1){
          document.getElementById("CheckPiezas").checked = true;
        }else{
          document.getElementById("CheckPiezas").checked = true;
        }

        if (data.ext_altapartes===1){
          document.getElementById("CheckPartes").checked = true;
        }else{
          document.getElementById("CheckPartes").checked = true;
        }

        if (data.ext_vidautil===1){
          document.getElementById("CheckExtender").checked = true;
        }else{
          document.getElementById("CheckExtender").checked = true;
        }


        if (data.ext_entradas===1){
          document.getElementById("CheckEntradas").checked = true;
        }else{
          document.getElementById("CheckEntradas").checked = true;
        }


        if (data.ext_salidas===1){
          document.getElementById("CheckSalidas").checked = true;
        }else{
          document.getElementById("CheckSalidas").checked = true;
        }



      },
      error: function (response) {
        // spanElement.innerText = "Sin Información";
        ocultarLoader();
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Sin Información',
          showConfirmButton: false,
          timer: 2500
        })
       
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

$("#Frmusuarios").submit(function (e) {
  e.preventDefault();

  let pk = generateUUID();
  let usuario = $.trim(document.getElementById("txtUsuario").value);
  let nombre = $.trim(document.getElementById("txtNombre").value);
  let fkEmpresa = $.trim(document.getElementById("fkEmpresa").value);
  let activo = 1;
  let fkTipo = "";
  let produccion = 0;
  let mantenimiento = 0;
  let direccion = 0;
  let bodega = 0;
  let proyecto = 0;
  let ext_cargarGranalla = 0;
  let ext_cargarpiezas = 0;
  let ext_altapartes = 0;
  let ext_vidautil = 0;
  let ext_entradas = 0;
  let ext_salidas = 0;
  let maquinas = 0;

  if (document.getElementById("CheckProd").checked) {
    produccion = 1;
  } else {
    produccion = 0;
  }

  if (document.getElementById("CheckManto").checked) {
    mantenimiento = 1;
  } else {
    mantenimiento = 0;
  }

  if (document.getElementById("CheckBode").checked) {
    bodega = 1;
  } else {
    bodega = 0;
  }
  let password = $.trim(document.getElementById("txtContrasena").value);

  let device = "";
  let cambiodispositivo = 0;
  let cambiopassword = 0;

  var Tipouser = $("#cbmTipouser").data("select2");
  let tipousuarionombre = Tipouser.data()[0].text;
  let tipousuarionivel = Tipouser.data()[0].id;

  if (tipousuarionivel == null || tipousuarionivel == 0) {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "¡Seleccione Un Tipo De Usuario!",
    });
    return false;
  }

  let token = "";

  const numtel = $.trim(document.getElementById("txtMovil").value);
  let telefono = numtel.slice(3, 14);
  let lada = numtel.slice(0, 3);
  let tefenoapp = numtel;

  var Nivelalarmar = $("#cbmNotificacion").data("select2");
  let NivelalarmarText = Nivelalarmar.data()[0].text;
  let nivel_alarmas = Nivelalarmar.data()[0].id;
  if (nivel_alarmas == null || nivel_alarmas == 0) {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "¡Seleccione Un Tipo De Notificación!",
    });
    return false;
  }

  if ($("#CheckGranalla").is(":checked")) {
    ext_cargarGranalla = 1;
  } else {
    ext_cargarGranalla = 0;
  }

  if ($("#CheckPiezas").is(":checked")) {
    ext_cargarpiezas = 1;
  } else {
    ext_cargarpiezas = 0;
  }

  if ($("#CheckPartes").is(":checked")) {
    ext_altapartes = 1;
  } else {
    ext_altapartes = 0;
  }

  if ($("#CheckExtender").is(":checked")) {
    ext_vidautil = 1;
  } else {
    ext_vidautil = 0;
  }

  if ($("#CheckEntradas").is(":checked")) {
    ext_entradas = 1;
  } else {
    ext_entradas = 0;
  }

  if ($("#CheckSalidas").is(":checked")) {
    ext_salidas = 1;
  } else {
    ext_salidas = 0;
  }

  let fotos = 0;

  var clientes = $("#cbmCliente").data("select2");
  let u_clientes = clientes.data()[0].text;
  let UclientesId = clientes.data()[0].id;

  if (UclientesId == null || UclientesId == 0) {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "¡Seleccione Un Cliente!",
    });
    return false;
  }

  let ext_preparacion = 0;
  let ext_granallado = 0;
  let ext_calidad = 0;
  let vagones = 0;

  //fkEmpresa': UclientesId,'
  // 'fkEmpresa': fkEmpresa,
  let datos = {};
  datos = {
    pk: pk,
    usuario: usuario,
    nombre: nombre,
    fkEmpresa: UclientesId,
    activo: activo,
    fkTipo: tipousuarionivel,
    produccion: produccion,
    mantenimiento: mantenimiento,
    bodega: bodega,
    maquinas: maquinas,
    password: password,
    device: device,
    cambiodispositivo: cambiodispositivo,
    cambiopassword: cambiopassword,
    tipousuarionombre: tipousuarionombre,
    tipousuarionivel: tipousuarionivel,
    token: token,
    telefono: telefono,
    lada: lada,
    telefono_app: tefenoapp,
    nivel_alarmas: nivel_alarmas,
    ext_cargarGranalla: ext_cargarGranalla,
    ext_cargarpiezas: ext_cargarpiezas,
    ext_altapartes: ext_altapartes,
    ext_vidautil: ext_vidautil,
    ext_entradas: ext_entradas,
    ext_salidas: ext_salidas,
    fotos: fotos,
    u_clientes: u_clientes,
    ext_preparacion: ext_preparacion,
    ext_granallado: ext_granallado,
    ext_calidad: ext_calidad,
    vagones: vagones,
  };

  $.ajax({
    datatype: "json",
    data: {
      Insert: datos,
    },
    type: "POST",
    url: "ajax/usuarios.ajax.php",
    beforeSend: function (response) {
      // $('#cargando').css({display:'block'});
      // $('#exito').html('Procesando...');
      mostrarLoader();
    },
    //Se ejecuta cuando termino la petición
    complete: function (response) {
      // $('#exito').html('Exito...');
      ocultarLoader();
    },

    // se ejecuta al termino de la petición y está fue correcta
    success: function (respuesta) {

      if ((respuesta = "1")) {
        Swal.fire({
          icon: "success",
          title: "Registros Actualizado Correctamente ",
          showConfirmButton: true,
          timer: 1500,
        });
        $("#cbmTipouser").val(0);
        $("#cbmTipouser").trigger("change.select2");
        $("#cbmCliente").val(0);
        $("#cbmCliente").trigger("change.select2");
        $("#cbmNotificacion").val(0);
        $("#cbmNotificacion").trigger("change.select2");
        document.getElementById("Frmusuarios").reset();
        $("#myModal").modal("hide");
        tbusuarios.ajax.reload(null, false);
      } else {
        Swal.fire({
          icon: "erro",
          title: "Error Al Ingresar El Registro ",
          showConfirmButton: true,
          timer: 1000,
        });
        $("#cbmTipouser").val(0);
        $("#cbmTipouser").trigger("change.select2");
        $("#cbmCliente").val(0);
        $("#cbmCliente").trigger("change.select2");
        $("#cbmNotificacion").val(0);
        $("#cbmNotificacion").trigger("change.select2");
        document.getElementById("Frmusuarios").reset();
        $("#myModal").modal("hide");
        tbusuarios.ajax.reload(null, false);
      }
    },
    error: function (response) {
      // alert(error con la petición);
      ocultarLoader();
    },
  });
});

function obtenerTipousario() {
  $.ajax({
    url: "ajax/usuarios.ajax.php",
    type: "POST",
    data: {
      Combo: 1,
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

function ocultarLoader() {
  document.getElementById("loader").style.display = "none";
}

function generateUUID() {
  var d = new Date().getTime(); //Timestamp
  var d2 =
    (typeof performance !== "undefined" &&
      performance.now &&
      performance.now() * 1000) ||
    0; //Time in microseconds since page-load or 0 if unsupported
  return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g, function (c) {
    var r = Math.random() * 16; //random number between 0 and 16
    if (d > 0) {
      //Use timestamp until depleted
      r = (d + r) % 16 | 0;
      d = Math.floor(d / 16);
    } else {
      //Use microseconds since page-load if supported
      r = (d2 + r) % 16 | 0;
      d2 = Math.floor(d2 / 16);
    }
    return (c === "x" ? r : (r & 0x3) | 0x8).toString(16);
  });
}
