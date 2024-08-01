
const pk = document.getElementById("txtpk").value;


const btnsemact = document.getElementById("btnsemact");
const btnsempas = document.getElementById("btnsempas");
const btnmesact = document.getElementById("btnmesact");
const btnmespas = document.getElementById("btnmespas");

const exportexcel = document.getElementById("exportexcel");
const exportpdf = document.getElementById("exportpdf");
const btnpdf = document.getElementById("btnpdf");

var contador = 0;
var limit = 0;
var offset = 1;
var resta = 0;
var cont = 0;
var sum = 0;
var cantidad = 0;
var itemsPorPagina = 10;
var paginaActual = 1;
var totalPages = 0;
var spanPagina = document.getElementById("txtPag");
// var statustrans=document.getElementById("statustranspor");
var subtotal = 0;
var total = 0;
var contar = 0;
var totales = 0;

var granalla = 0;
var granallazonamuerta = 0;
var granalla_pots = 0;
var alturasilo = 0;
var noturbinasactivas = 0;

var etiqueta = "";
var A1 = "";
var A2 = "";
var A3 = "";
var A4 = "";
var A5 = "";
var A6 = "";
var A7 = "";
var A8 = "";
var A9 = "";
var A10 = "";
var A11 = "";
var A12 = "";

var datos = "";
var presionlinea = "";
var nivellinea = "";
var tendencialinea = "";
var tmax = 0;

let nombre = "";
let descripcion = "";

let vagonest1 = 0;
let vagonest2 = 0;
let vagonest3 = 0;

let totpropot1 = 0;
let totpropot2 = 0;
let totpropot3 = 0;
let totpropot4 = 0;
let totpropot5 = 0;
let totpropot6 = 0;
let totpropot7 = 0;
let totpropot8 = 0;

let propresion = 0;
let granallomin = 0;
let granallodia = 0;
let prom_silo = 0;
let GranallaMaq = 0;

let horaturnouno = 0;
let horaturnodos = 0;
let horaturnotres = 0;

let vagporhorauno = 0;
let vagporhorados = 0;
let vagporhoratres = 0;

let horaturatot = 0;
let vagontotal = 0;
let tiporeporte = "";
let fechareporte = "";

let amppromedio = 0;
let horometro = 0;
let granalladias = 0;

let Tipo = "";
let fechasel = "";
let titulo = "";
let tituloexcel = "";
let titulodos = "";
var parrafo = document.getElementById("parrafoinfo");
var miTabla=null;


let fechaFormatoInicio = ''
let fechaFormatoFin = ''

let Actual = new Date();
let nombreSession = document.getElementById("txtnombre").value.toUpperCase();



$(document).ready(function () {

  $('#miTabla thead tr')
        .clone(true)
        .addClass('filters')
        .appendTo('#miTabla thead');

  parrafo.classList.add("mostrar");

  window.jsPDF = window.jspdf.jsPDF;

  $('#cbmmaquinarpt').select2({
    theme: "bootstrap-5",
    width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
    placeholder: $(this).data('placeholder'),
  });

  $('#cbmproyrpt').select2({
    theme: "bootstrap-5",
    width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
    placeholder: $(this).data('placeholder'),
  });


  btnsemact.addEventListener("click", Semanaactual);
  btnsempas.addEventListener("click", Semanapasado);
  btnmesact.addEventListener("click", Mesactual);
  btnmespas.addEventListener("click", Mespasado);
  exportexcel.addEventListener("click", exportexc);
  exportpdf.addEventListener("click", exportpdfs);
  btnpdf.addEventListener("click", pdfexport);

  $('#cbmproyrpt').change(function () {
    var getID = $(this).select2('data');

    $.ajax({
      url: "modelos/obtenerproyectosinfo.php",
      type: "POST",
      data: {
        pk: getID[0]['id'],
      },
      dataType: "json",
      beforeSend: function (response) {
      },
      complete: function (response) { },
      success: function (data) {

        obtenerCombo(data[0].fkCliente);

      },
      error: function (response) {
        contador = 0;
        ocultarLoader();
      },
    });
    // obtenerCombo(getID);
  });

});





function tabla(fecha, cliente) {
  // debugger;
  $.ajax({
    url: "modelos/reporteTurno.php",
    type: "POST",
    data: { fecha: fecha, fk_cliente_lersoft: cliente, limit: limit, offset: offset },
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

        parrafo.classList.remove("mostrar");
        parrafo.classList.add("oculto");


      } else {
        alert("Sin Datos");
        parrafo.classList.remove("oculto");
        parrafo.classList.add("mostrar");
        sindatos();
      }

    },
    error: function (response) {

      alert("Sin Datos");
      parrafo.classList.remove("oculto");
      parrafo.classList.add("mostrar");
      sindatos();

    },
  });



}


$(function () {

  var startDate, endDate;
  var hoy = new Date();

  let date = new Date();
  let dayInMillis = 24 * 3600000;

  $("#daypickerhoy")
    .datepicker({
      autoclose: true,
      format: "yyyy/mm/dd",
      startView: "days",
      minViewMode: "days",
      forceParse: false,
    })

    .on("changeDate", function (e) {
      // debugger;
      var date = e.date;
      var fsel = new Date(date);
      let result = compareDates(hoy, fsel);
      fechasel = "";
      if (result == 1) {
        startDate = new Date(
          date.getFullYear(),
          date.getMonth(),
          date.getDate()
        );

        $("#daypickerhoy").datepicker("setDate", startDate);

        fechasel = (date.getMonth() + 1) + "/" + date.getDate() + "/" + date.getFullYear() + ".." + (date.getMonth() + 1) + "/" + date.getDate() + "/" + date.getFullYear();
        titulo = "REPORTE DE VAGONES - FECHA " + fechaEnLetra(date);
        tituloexcel = "REPORTE_VAGONES_" + date.getDate() + (date.getMonth() + 1) + date.getFullYear();
        tabla(fechasel, pk);
      } else if (result == -1) {
        Swal.fire({
          position: "center",
          icon: "error",
          title: "Seleccione Una Fecha Menor",
          showConfirmButton: false,
          timer: 2500,
        });
      } else {
        // Swal.fire({
        //   position: "center",
        //   icon: "error",
        //   title: "Seleccione Una Fecha Menor",
        //   showConfirmButton: false,
        //   timer: 2500,
        // });

        fechasel = (date.getMonth() + 1) + "/" + date.getDate() + "/" + date.getFullYear() + ".." + (date.getMonth() + 1) + "/" + date.getDate() + "/" + date.getFullYear();
        titulo = "REPORTE DE VAGONES - FECHA " + fechaEnLetra(date);
        tituloexcel = "REPORTE_VAGONES_" + date.getDate() + (date.getMonth() + 1) + date.getFullYear();
        tabla(fechasel, pk);

      }


    });


});


function compareDates(date1, date2) {
  let dayInMillis = 24 * 3600000;
  let days1 = Math.floor(date1.getTime() / dayInMillis);
  let days2 = Math.floor(date2.getTime() / dayInMillis);
  // comparamos los días
  if (days1 > days2) {
    return 1;
  } else if (days1 < days2) {
    return -1;
  }
  return 0;
}

getLongMonthName = function (date) {
  return monthNames[date.getMonth()];
};


function Semanaactual() {
  var fecha = new Date();
  var inicio = new Date(fecha.getFullYear(), fecha.getMonth(), fecha.getDate() - fecha.getDay() + 1);
  var fin = new Date(fecha.getFullYear(), fecha.getMonth(), fecha.getDate() + 7 - fecha.getDay());

  fechaFormatoInicio= inicio;
  fechaFormatoFin = fin;
  fechasel = "";
  fechasel = (inicio.getMonth() + 1) + "/" + inicio.getDate() + "/" + inicio.getFullYear() + ".." + (fin.getMonth() + 1) + "/" + fin.getDate() + "/" + fin.getFullYear();
  titulo =
    "Reporte vagones - PERIODO DE  " +
    fechaEnLetra(inicio) +
    " AL " +
    fechaEnLetra(fin);
  tituloexcel = "REPORTE_VAGONES_" + (inicio.getDate()) + "/" + (inicio.getMonth() + 1) + "/" + inicio.getFullYear() + " - " + fin.getDate() + "/" + (fin.getMonth() + 1) + "/" + fin.getFullYear();
  tabla(fechasel, pk);
}

function Semanapasado() {
  var fecha = new Date();
  var inicio = new Date(fecha.getFullYear(), fecha.getMonth(), fecha.getDate() - 7 - fecha.getDay() + 1);
  var fin = new Date(fecha.getFullYear(), fecha.getMonth(), fecha.getDate() - fecha.getDay());
  
  fechaFormatoInicio= inicio;
  fechaFormatoFin = fin;
  
  fechasel = "";
  fechasel = (inicio.getMonth() + 1) + "/" + inicio.getDate() + "/" + inicio.getFullYear() + ".." + (fin.getMonth() + 1) + "/" + fin.getDate() + "/" + fin.getFullYear();
  titulo =
    "REPORTE DE VAGONES - PERIODO DE  " +
    fechaEnLetra(inicio) +
    " AL " +
    fechaEnLetra(fin);
  tituloexcel = "REPORTE_VAGONES_" + (inicio.getDate()) + "/" + (inicio.getMonth() + 1) + "/" + inicio.getFullYear() + " - " + fin.getDate() + "/" + (fin.getMonth() + 1) + "/" + fin.getFullYear();
  tabla(fechasel, pk);
}

function Mesactual() {
  var date = new Date();
  var primerDia = new Date(date.getFullYear(), date.getMonth(), 1);
  var ultimoDia = new Date(date.getFullYear(), date.getMonth() + 1, 0);

  fechaFormatoInicio= primerDia;
  fechaFormatoFin = ultimoDia;

  fechasel = "";
  fechasel = (primerDia.getMonth() + 1) + "/" + primerDia.getDate() + "/" + primerDia.getFullYear() + ".." + (ultimoDia.getMonth() + 1) + "/" + ultimoDia.getDate() + "/" + ultimoDia.getFullYear();
  titulo =
    "REPORTE DE VAGONES - PERIODO DE  " +
    fechaEnLetra(primerDia) +
    " AL " +
    fechaEnLetra(ultimoDia);
  tituloexcel = "REPORTE_VAGONES_" + (primerDia.getDate()) + "/" + (primerDia.getMonth() + 1) + "/" + primerDia.getFullYear() + " - " + ultimoDia.getDate() + "/" + (ultimoDia.getMonth() + 1) + "/" + ultimoDia.getFullYear();
  tabla(fechasel, pk);
}

function Mespasado() {
  var date = new Date();
  var primerDia = new Date(date.getFullYear(), date.getMonth() - 1, 1);
  var ultimoDia = new Date(date.getFullYear(), date.getMonth(), 0);

  fechaFormatoInicio= primerDia;
  fechaFormatoFin = ultimoDia;

  var fecha = new Date();
  var inicio = new Date(fecha.getFullYear(), fecha.getMonth(), fecha.getDate() - 7 - fecha.getDay() + 1);
  var fin = new Date(fecha.getFullYear(), fecha.getMonth(), fecha.getDate() - fecha.getDay());
  
  fechasel = "";
  fechasel = (primerDia.getMonth() + 1) + "/" + primerDia.getDate() + "/" + primerDia.getFullYear() + ".." + (ultimoDia.getMonth() + 1) + "/" + ultimoDia.getDate() + "/" + ultimoDia.getFullYear();
  titulo =
    "REPORTE DE VAGONES - PERIODO DE   " +
    fechaEnLetra(primerDia) +
    " AL " +
    fechaEnLetra(ultimoDia);
  tituloexcel = "REPORTE_VAGONES_" + (inicio.getDate()) + "/" + (inicio.getMonth() + 1) + "/" + inicio.getFullYear() + " - " + fin.getDate() + "/" + (fin.getMonth() + 1) + "/" + fin.getFullYear();
  tabla(fechasel, pk);
}

function exportexc(e) {

  e.preventDefault();


  var tb = new Object();
  var myObject = [];
  const tabla = document.getElementById("table");
  const filas = tabla.rows;

  for (let i = 1; i < filas.length; i++) {

    const celdas = filas[i].cells;
    for (let j = 1; j < celdas.length; j++) {
      const celda = celdas[j];
      const contenido = celda.innerHTML;
      if (j == 1) {
        tb.Serie_Vagon = contenido;
      } else if (j == 2) {
        tb.Serie_Proyecto = contenido;
      } else if (j == 3) {
        tb.Cabina = contenido;
      } else if (j == 4) {
        tb.Fecha_Granallado = contenido;
      } else if (j == 5) {
        tb.Estatus = contenido;
      }
    }
    myObject.push(tb);
    tb = [];
  }

  var myFile = tituloexcel + ".xlsx";
  var myWorkSheet = XLSX.utils.json_to_sheet(myObject);
  var myWorkBook = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(myWorkBook, myWorkSheet, "lista");
  XLSX.writeFile(myWorkBook, myFile);
}

function exportpdfs(e) {
  var today = new Date();
  e.preventDefault();


  // debugger;
   $('#table').DataTable().rows().iterator('row', function(context, index){
    //  debugger;
     var node = $(this.row(index).node()); 
     console.log(node);
     //node.context is element of tr generated by jQuery DataTables.
 });




  // var tabla = document.getElementById("table");
  // var datosArray = [];

  // for (var i = 1; i < tabla.rows.length; i++) {
  //   var fila = tabla.rows[i];
  //   var filaArray = [];

  //   for (var j = 1; j < fila.cells.length; j++) {
  //     var celda = fila.cells[j];
  //     filaArray.push(celda.textContent);
  //   }

  //   datosArray.push(filaArray);
  // }

  // var doc = new jsPDF();



  // const imgData = "vistas/recursos/img/avatars/lersan.png";
  // doc.addImage(imgData, "PNG", 10, 10, 50, 20);
  // let pageWidth = doc.internal.pageSize.getWidth();
  // doc.setFontSize(10);
  // doc.text(titulo, pageWidth / 2, 35, "center");

  // var textColor = [144, 142, 141];
  // doc.setTextColor(textColor[0], textColor[1], textColor[2]);
  // doc.setFontSize(8);


  // doc.text('GENERADO POR ' + document.getElementById("txtnombre").value.toUpperCase(), 190, 20, { align: 'right', });
  // doc.text('FECHA ' + today.getDate() + "/" + (today.getMonth() + 1) + "/" + today.getFullYear(), 190, 25, { align: 'right', });

  // textColor = [6, 6, 6];
  // doc.setTextColor(textColor[0], textColor[1], textColor[2]);
  // doc.setFontSize(8);

  // const options = {
  //   head: [["Serie Vagon", "Serie Proyecto", "Regranallado", "Cabina", "Fecha Granallado", "Estatus"]],
  //   body: datosArray,
  //   margin: { top: 40 },
  //   styles: {overflow: 'linebreak',
  //               fontSize: 6}
  // };

  // doc.autoTable(options);
  // doc.save(tituloexcel + ".pdf");
}


function mostrarLoader() {
  document.getElementById("loader").style.display = "block";
}

function ocultarLoader() {
  document.getElementById("loader").style.display = "none";
}


function obtenerproyectos(pk) {

  $.ajax({
    url: "modelos/obtenerproyectos.php",
    type: "POST",
    data: { pk: pk },
    dataType: "json",

    beforeSend: function (response) {
      mostrarLoader();
    },
    complete: function (response) {
    },
    success: function (data) {
      $('#cbmproyrpt').append(
        `<option value="Ninguno"  selected="selected">Seleccione</option>`
      );

      for (var i = 0; i < data.length; i++) {

        $('#cbmproyrpt').append(
          `<option value="${data[i].pk}">${data[i].Proyecto}</option>`
        );

      }
      $('#cbmproyrpt').select2('focus');
      $('#cbmproyrpt').select2('open');
      ocultarLoader();
    },
    error: function (response) {
      // window.location ="salir";
    },
  });
}

function obtenerCombo(pk) {
  $("#cbmmaquinarpt").select2("val", "");
  $("#cbmmaquinarpt").empty();
  $.ajax({
    url: "modelos/obtenermaquinas.php",
    type: "POST",
    data: { pk: pk },
    dataType: "json",

    beforeSend: function (response) {
      mostrarLoader();
    },
    complete: function (response) {
    },
    success: function (data) {
      $('#cbmmaquinarpt').append(
        `<option value="Ninguno"  selected="selected">Seleccione</option>`
      );

      for (var i = 0; i < data.length; i++) {

        $('#cbmmaquinarpt').append(
          `<option value="${data[i].pk}">${data[i].descripcion}</option>`
        );


      }
      ocultarLoader();
      $('#cbmmaquinarpt').select2('focus');
      $('#cbmmaquinarpt').select2('open');
    },
    error: function (response) {
      // window.location ="salir";
    },
  });
}

function obtenertabla() {

 




  //  $('#table').bootstrapTable('destroy');

  //  $('#table').bootstrapTable({
  //    url: 'vistas/recursos/json/vagones.json',
  //    columns: [
  //      {
  //        field: "pk",
  //      },
  //      {
  //        field: 'alias_produccion'
  //      },
  //      {
  //        field: 'serie_proyecto'
  //      },
  //      {
  //        field: 'veces_regranallado'
  //      },
  //      {
  //        field: 'nombre_cabina'
  //      }, {
  //        field: 'fecha_granallado'
  //      }, {
  //        field: 'status'
  //      }]
  //  })



    miTabla = $('#miTabla').DataTable();

   // Limpia y destruye el DataTable existente
   miTabla.clear().destroy();


   miTabla = $('#miTabla').DataTable({


    orderCellsTop: true,
    fixedHeader: true,
    initComplete: function () {
        var api = this.api();

        // For each column
        api
            .columns()
            .eq(0)
            .each(function (colIdx) {
                // Set the header cell to contain the input element
                var cell = $('.filters th').eq(
                    $(api.column(colIdx).header()).index()
                );
                var title = $(cell).text();
                $(cell).html('<input type="text" placeholder="' + title + '" />');

                // On every keypress in this input
                $(
                    'input',
                    $('.filters th').eq($(api.column(colIdx).header()).index())
                )
                    .off('keyup change')
                    .on('change', function (e) {
                        // Get the search value
                        $(this).attr('title', $(this).val());
                        var regexr = '({search})'; //$(this).parents('th').find('select').val();

                        var cursorPosition = this.selectionStart;
                        // Search the column for that value
                        api
                            .column(colIdx)
                            .search(
                                this.value != ''
                                    ? regexr.replace('{search}', '(((' + this.value + ')))')
                                    : '',
                                this.value != '',
                                this.value == ''
                            )
                            .draw();
                    })
                    .on('keyup', function (e) {
                        e.stopPropagation();

                        $(this).trigger('change');
                        $(this)
                            .focus()[0]
                            .setSelectionRange(cursorPosition, cursorPosition);
                    });
            });
    },


    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
  },
  dom: 'Bfrtip',
        buttons: [

         
        {
          extend: 'excelHtml5',
          text: '<button class="btn btn-info btn-sm" ><i class="fas fa-file-excel"></i></button>',
          titleAttr: 'Reporte De Vagones',
            title:     'Turno-',
          exportOptions: {
            columns: [0,1,2,3,4,5,6],
          }
      },
      

    {
      extend: 'pdfHtml5',
      text: '<button class="btn btn-info btn-sm"><i class="fas fa-file-pdf"></i></button>',
      titleAttr: 'Reporte De Vagones',      
      title:     'Turno-'+fechaFormatoInicio.toLocaleDateString('en-US')+'-'+fechaFormatoFin.toLocaleDateString('en-US'),
      customize: function ( doc ) {      
       doc.content.splice( 1, 0, {
        margin: [ 400,-40,20,20 ],
        alignment: '',        
        text:  'Generado por:'+nombreSession,
        
      }),
      doc.content.splice( 1, 0, {
        margin: [ 400,-20,20,20 ],
        alignment: '',       
       
        text:'Fecha:'+ Actual.toLocaleString('en-US')
      }),
      
       
       
        doc.defaultStyle.fontSize = 6
      },   
      exportOptions: {
          columns: [0,1,2,3,4,5,6],
      },
      
  }
        ],
    ajax: {
      url: 'vistas/recursos/json/reporteTurnos.json', // Cambia la URL a tu archivo JSON
      dataSrc: ''
  },


  columns: [
    
    { data: 'fecha' },
    { data: 'nombre_turno' },
    { data: 'nombre_supervisor' },
    { data: 'nombre_maquina' },
    { data: 'vagones' },
    { data: 'hr_granallado' },
    { data: 'kpi' }
    
    
],
// columnDefs: [
				   
//   {
//       targets: 0,
//   render: function (data, type, row) {
//     rowElement = '<div class="text-left"><div class="btn-group"><button class="btn btn-primary btn-sm btnverinfo" style="color: #07b5e8;"><i class="fas fa-info-circle"></i></button></div></div>';
//       return rowElement;
//     }
//     }
// ],

  });

  $('#miTabla thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    if (i == 0){
    } else {
      $(this).html( '<input type="text" class="form-control form-control-sm" placeholder="'+title+'" style="width: 100%;" />' );	 
    }
 });


  $(document).on("click", ".btnverinfo", function () {
    // debugger;
    if (window.matchMedia("(min-width:992px)").matches) {
      var row = miTabla.row($(this).parents("tr")).data();

      id = (row["pk"]);

    } else {
      var row = miTabla.row($(this).parents("tbody tr ul li")).data();

   
      id = (row["pk"]);

    }
    if (row["status"] == "En Cabina" || row["status"] == "En Espera") {
      Swal.fire({
        position: "center",
        icon: "warning",
        title: "Proceso " + row["status"],
        showConfirmButton: false,
        timer: 2500,
      });
      return
    }
  
    $.ajax({
      url: "modelos/resumenpresion.php",
      type: "POST",
      data: {
        pk: row["fk_proyecto"],
        alias: row["alias_produccion"]
      },
      dataType: "json",
      beforeSend: function (response) { },
      complete: function (response) { },
      success: function (data) {

        if (data[0] === undefined) {
          Swal.fire({
            position: "center",
            icon: "error",
            title: "No Existen Granallados",
            showConfirmButton: false,
            timer: 2500,
          });
          return
        }

        titulo = "";
        titulo = row["serie_proyecto"];
        titulodos = "";
        titulodos = row["alias_produccion"] + "-" + row["serie_proyecto"]
        let horas = "";
        let nuevaFecha = "";
        $(".modal-header").css("background-color", "#07B5E8");
        $(".modal-title").text("Información");

        var html = "";
        if (data[0] !== undefined) {

          html +=
            "<tr>" +
            '<td style="text-align:center; " colspan="2"><strong style="background-color: transparent;">Vagon: ' + row["alias_produccion"] + ' Proyecto: ' + row["serie_proyecto"] + ' -  Estatus: ' + row["status"] + '  </strong>' +
            "</td>" +
            "</tr>";

            html +=
            "<tr>" +
            '<td style="text-align:center; " colspan="2"><strong style="background-color: transparent;">Supervisor: ' + row["supervisor"]  +' </strong>' +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:center; " colspan="2"><strong style="background-color: transparent;">Granallado</strong>' +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"><strong style="background-color: transparent;"> Turno: </strong>' +
            data[0]["turnouno"] +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"><strong style="background-color: transparent;"> Cabina: </strong>' +
            row["nombre_cabina"] +
            "</td>" +
            "</tr>";

          var fechaini = data[0]["fecha_iniciouno"].split("/");
          nuevaFecha = fechaini[1] + "/" + fechaini[0] + "/" + fechaini[2];

          html +=
            "<tr>" +
            '<td style="text-align:left;"><strong style="background-color: transparent;"> Inicio Granallado: </strong>' +
            nuevaFecha +
            " " +
            "</td>" +
            "</tr>";

          var fechafin = data[0]["fecha_finuno"].split("/");
          nuevaFecha = fechafin[1] + "/" + fechafin[0] + "/" + fechafin[2];

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"><strong style="background-color: transparent;"> Fin Granallado: </strong>' +
            nuevaFecha +
            " " +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left;"><strong style="background-color: transparent;"> Tiempo de uso de Cabina: </strong>' +
            data[0]["tiempo_realuno"].toFixed(0) +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"><strong style="background-color: transparent;"> Tiempo de Chorreo: </strong>' +
            data[0]["tiempo_granalladouno"].toFixed(0) +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left; "><strong style="background-color: transparent;"> Tiempo Perdido: </strong>' +
            data[0]["eficiencia_totaluno"].toFixed(0) +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left;  background-color: #def7ff;"> <strong style="background-color: transparent;">Tiempo Total: </strong>' +
            data[0]["tiempo_totaluno"].toFixed(0) +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left;"><strong style="background-color: transparent;"> Tiempo Inactivo: </strong>' +
            data[0]["tiempo_inactivouno"].toFixed(0) +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left;  background-color: #def7ff;"> <strong style="background-color: transparent;">KPI: </strong>' +
            (60 / data[0]["tiempo_totaluno"].toFixed(2)).toFixed(2) +
            " vagones/h" +
            "</td>" +
            "</tr>";

        }

        if (data[1] !== undefined) {

          html +=
            "<tr>" +
            '<td style="text-align:center; " colspan="2"><strong style="background-color: transparent;">Regranallado 1</strong>' +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"><strong style="background-color: transparent;"> Turno: </strong>' +
            data[1]["turnodos"] +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"><strong style="background-color: transparent;"> Cabina: </strong>' +
            row["nombre_cabina"] +
            "</td>" +
            "</tr>";

          var fechaini = data[1]["fecha_iniciodos"].split("/");
          nuevaFecha = fechaini[1] + "/" + fechaini[0] + "/" + fechaini[2];

          html +=
            "<tr>" +
            '<td style="text-align:left;"><strong style="background-color: transparent;"> Inicio Granallado: </strong>' +
            nuevaFecha +
            " " +
            "</td>" +
            "</tr>";

          var fechafin = data[1]["fecha_findos"].split("/");
          nuevaFecha = fechafin[1] + "/" + fechafin[0] + "/" + fechafin[2];

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"><strong style="background-color: transparent;"> Fin Granallado: </strong>' +
            nuevaFecha +
            " " +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left;"><strong style="background-color: transparent;"> Tiempo de uso de Cabina: </strong>' +
            data[1]["tiempo_realdos"].toFixed(0) +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"><strong style="background-color: transparent;"> Tiempo de Chorreo: </strong>' +
            data[1]["tiempo_granalladodos"].toFixed(0) +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left;"><strong style="background-color: transparent;"> Tiempo Perdido: </strong>' +
            data[1]["eficiencia_totaldos"].toFixed(0) +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"> <strong style="background-color: transparent;">Tiempo Total: </strong>' +
            data[1]["tiempo_totaldos"].toFixed(0) +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left;"><strong style="background-color: transparent;"> Tiempo Inactivo: </strong>' +
            data[1]["tiempo_inactivodos"].toFixed(0) +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"> <strong style="background-color: transparent;">KPI: </strong>' +
            (60 / data[1]["tiempo_totaldos"].toFixed(2)).toFixed(2) +
            " vagones/h" +
            "</td>" +
            "</tr>";

        }


        if (data[2] !== undefined) {

          html +=
            "<tr>" +
            '<td style="text-align:center; background-color: transparent;" colspan="2"><strong style="background-color: transparent;">Regranallado 2</strong>' +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"><strong style="background-color: transparent;"> Turno: </strong>' +
            data[2]["turnotres"] +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"><strong style="background-color: transparent;"> Cabina: </strong>' +
            row["nombre_cabina"] +
            "</td>" +
            "</tr>";

          var fechaini = data[2]["fecha_iniciotres"].split("/");
          nuevaFecha = fechaini[1] + "/" + fechaini[0] + "/" + fechaini[2];

          html +=
            "<tr>" +
            '<td style="text-align:left;"><strong style="background-color: transparent;"> Inicio Granallado: </strong>' +
            nuevaFecha +
            " " +
            "</td>" +
            "</tr>";

          var fechafin = data[2]["fecha_fintres"].split("/");
          nuevaFecha = fechafin[1] + "/" + fechafin[0] + "/" + fechafin[2];

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"><strong style="background-color: transparent;"> Fin Granallado: </strong>' +
            nuevaFecha +
            " " +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left;"><strong style="background-color: transparent;"> Tiempo de uso de Cabina: </strong>' +
            data[2]["tiempo_realtres"].toFixed(0) +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"><strong style="background-color: transparent;"> Tiempo de Chorreo: </strong>' +
            data[2]["tiempo_granalladotres"].toFixed(0) +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left;"><strong style="background-color: transparent;"> Tiempo Perdido: </strong>' +
            data[2]["eficiencia_totaltres"].toFixed(0) +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"> <strong style="background-color: transparent;">Tiempo Total: </strong>' +
            data[2]["tiempo_totaltres"].toFixed(0) +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left;"><strong style="background-color: transparent;"> Tiempo Inactivo: </strong>' +
            data[2]["tiempo_inactivotres"].toFixed(0) +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"> <strong style="background-color: transparent;">KPI: </strong>' +
            (60 / data[2]["tiempo_totaltres"].toFixed(2)).toFixed(2) +
            " vagones/h" +
            "</td>" +
            "</tr>";

        }

        $("#tablaVagon").html(html);
        $("#ModalVagon").modal("show");
      },
      error: function (response) {
        Swal.fire({
          position: "center",
          icon: "error",
          title: "No Existen Granallados",
          showConfirmButton: false,
          timer: 2500,
        });
        contador = 0;
      },
    });

    
  });

   
}

function sindatos() {
  // debugger;
  $('#table').bootstrapTable('destroy');

  $('#table').bootstrapTable({
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

function nameFormatter(value, row) {
  var icon = row.id % 2 === 0 ? "fas-info" : "fas-info-and-crescent";
  return (
    value +
    " " +
    '<i class="fas fa-info-circle fa-3x" style="color: #07b5e8;"></i> '
  );
}

function operateFormatter(value, row, index) {
  return [
    '<a class="like" href="javascript:void(0)" title="Inf">',
    '<i class="fas fa-info-circle fa-2x" style="color: #07b5e8;"></i>',
    "</a>",
  ].join("");
}

window.operateEvents = {
  "click .like": function (e, value, row, index) {
    
    console.log(row);
    if (row["status"] == "En Cabina" || row["status"] == "En Espera") {
      Swal.fire({
        position: "center",
        icon: "warning",
        title: "Proceso " + row["status"],
        showConfirmButton: false,
        timer: 2500,
      });
      return
    }
    const jsonObject = row;
    $.ajax({
      url: "modelos/resumenpresion.php",
      type: "POST",
      data: {
        pk: row["fk_proyecto"],
        alias: row["alias_produccion"]
      },
      dataType: "json",
      beforeSend: function (response) { },
      complete: function (response) { },
      success: function (data) {

        if (data[0] === undefined) {
          Swal.fire({
            position: "center",
            icon: "error",
            title: "No Existen Granallados",
            showConfirmButton: false,
            timer: 2500,
          });
          return
        }

        titulo = "";
        titulo = row["serie_proyecto"];
        titulodos = "";
        titulodos = row["alias_produccion"] + "-" + row["serie_proyecto"]
        let horas = "";
        let nuevaFecha = "";
        $(".modal-header").css("background-color", "#07B5E8");
        $(".modal-title").text("Información");

        var html = "";
        if (data[0] !== undefined) {

          html +=
            "<tr>" +
            '<td style="text-align:center; " colspan="2"><strong style="background-color: transparent;">Vagon: ' + row["alias_produccion"] + ' Proyecto: ' + row["serie_proyecto"] + ' -  Estatus: ' + row["status"] + '  </strong>' +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:center; " colspan="2"><strong style="background-color: transparent;">Granallado</strong>' +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"><strong style="background-color: transparent;"> Turno: </strong>' +
            data[0]["turnouno"] +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"><strong style="background-color: transparent;"> Cabina: </strong>' +
            row["nombre_cabina"] +
            "</td>" +
            "</tr>";

          var fechaini = data[0]["fecha_iniciouno"].split("/");
          nuevaFecha = fechaini[1] + "/" + fechaini[0] + "/" + fechaini[2];

          html +=
            "<tr>" +
            '<td style="text-align:left;"><strong style="background-color: transparent;"> Inicio Granallado: </strong>' +
            nuevaFecha +
            " " +
            "</td>" +
            "</tr>";

          var fechafin = data[0]["fecha_finuno"].split("/");
          nuevaFecha = fechafin[1] + "/" + fechafin[0] + "/" + fechafin[2];

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"><strong style="background-color: transparent;"> Fin Granallado: </strong>' +
            nuevaFecha +
            " " +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left;"><strong style="background-color: transparent;"> Tiempo de uso de Cabina: </strong>' +
            data[0]["tiempo_realuno"].toFixed(0) +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"><strong style="background-color: transparent;"> Tiempo de Chorreo: </strong>' +
            data[0]["tiempo_granalladouno"].toFixed(0) +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left; "><strong style="background-color: transparent;"> Tiempo Perdido: </strong>' +
            data[0]["eficiencia_totaluno"].toFixed(0) +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left;  background-color: #def7ff;"> <strong style="background-color: transparent;">Tiempo Total: </strong>' +
            data[0]["tiempo_totaluno"].toFixed(0) +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left;"><strong style="background-color: transparent;"> Tiempo Inactivo: </strong>' +
            data[0]["tiempo_inactivouno"].toFixed(0) +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left;  background-color: #def7ff;"> <strong style="background-color: transparent;">KPI: </strong>' +
            (60 / data[0]["tiempo_totaluno"].toFixed(2)).toFixed(2) +
            " vagones/h" +
            "</td>" +
            "</tr>";

        }

        if (data[1] !== undefined) {

          html +=
            "<tr>" +
            '<td style="text-align:center; " colspan="2"><strong style="background-color: transparent;">Regranallado 1</strong>' +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"><strong style="background-color: transparent;"> Turno: </strong>' +
            data[1]["turnodos"] +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"><strong style="background-color: transparent;"> Cabina: </strong>' +
            row["nombre_cabina"] +
            "</td>" +
            "</tr>";

          var fechaini = data[1]["fecha_iniciodos"].split("/");
          nuevaFecha = fechaini[1] + "/" + fechaini[0] + "/" + fechaini[2];

          html +=
            "<tr>" +
            '<td style="text-align:left;"><strong style="background-color: transparent;"> Inicio Granallado: </strong>' +
            nuevaFecha +
            " " +
            "</td>" +
            "</tr>";

          var fechafin = data[1]["fecha_findos"].split("/");
          nuevaFecha = fechafin[1] + "/" + fechafin[0] + "/" + fechafin[2];

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"><strong style="background-color: transparent;"> Fin Granallado: </strong>' +
            nuevaFecha +
            " " +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left;"><strong style="background-color: transparent;"> Tiempo de uso de Cabina: </strong>' +
            data[1]["tiempo_realdos"].toFixed(0) +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"><strong style="background-color: transparent;"> Tiempo de Chorreo: </strong>' +
            data[1]["tiempo_granalladodos"].toFixed(0) +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left;"><strong style="background-color: transparent;"> Tiempo Perdido: </strong>' +
            data[1]["eficiencia_totaldos"].toFixed(0) +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"> <strong style="background-color: transparent;">Tiempo Total: </strong>' +
            data[1]["tiempo_totaldos"].toFixed(0) +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left;"><strong style="background-color: transparent;"> Tiempo Inactivo: </strong>' +
            data[1]["tiempo_inactivodos"].toFixed(0) +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"> <strong style="background-color: transparent;">KPI: </strong>' +
            (60 / data[1]["tiempo_totaldos"].toFixed(2)).toFixed(2) +
            " vagones/h" +
            "</td>" +
            "</tr>";

        }


        if (data[2] !== undefined) {

          html +=
            "<tr>" +
            '<td style="text-align:center; background-color: transparent;" colspan="2"><strong style="background-color: transparent;">Regranallado 2</strong>' +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"><strong style="background-color: transparent;"> Turno: </strong>' +
            data[2]["turnotres"] +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"><strong style="background-color: transparent;"> Cabina: </strong>' +
            row["nombre_cabina"] +
            "</td>" +
            "</tr>";

          var fechaini = data[2]["fecha_iniciotres"].split("/");
          nuevaFecha = fechaini[1] + "/" + fechaini[0] + "/" + fechaini[2];

          html +=
            "<tr>" +
            '<td style="text-align:left;"><strong style="background-color: transparent;"> Inicio Granallado: </strong>' +
            nuevaFecha +
            " " +
            "</td>" +
            "</tr>";

          var fechafin = data[2]["fecha_fintres"].split("/");
          nuevaFecha = fechafin[1] + "/" + fechafin[0] + "/" + fechafin[2];

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"><strong style="background-color: transparent;"> Fin Granallado: </strong>' +
            nuevaFecha +
            " " +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left;"><strong style="background-color: transparent;"> Tiempo de uso de Cabina: </strong>' +
            data[2]["tiempo_realtres"].toFixed(0) +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"><strong style="background-color: transparent;"> Tiempo de Chorreo: </strong>' +
            data[2]["tiempo_granalladotres"].toFixed(0) +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left;"><strong style="background-color: transparent;"> Tiempo Perdido: </strong>' +
            data[2]["eficiencia_totaltres"].toFixed(0) +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"> <strong style="background-color: transparent;">Tiempo Total: </strong>' +
            data[2]["tiempo_totaltres"].toFixed(0) +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left;"><strong style="background-color: transparent;"> Tiempo Inactivo: </strong>' +
            data[2]["tiempo_inactivotres"].toFixed(0) +
            "</td>" +
            "</tr>";

          html +=
            "<tr>" +
            '<td style="text-align:left; background-color: #def7ff;"> <strong style="background-color: transparent;">KPI: </strong>' +
            (60 / data[2]["tiempo_totaltres"].toFixed(2)).toFixed(2) +
            " vagones/h" +
            "</td>" +
            "</tr>";

        }

        $("#tablaVagon").html(html);
        $("#ModalVagon").modal("show");
      },
      error: function (response) {
        Swal.fire({
          position: "center",
          icon: "error",
          title: "No Existen Granallados",
          showConfirmButton: false,
          timer: 2500,
        });
        contador = 0;
      },
    });
  },
};

function fechaEnLetra(fecha) {
  // debugger;
  const meses = [
    "ENERO",
    "FEBRERO",
    "MARZO",
    "ABRIL",
    "MAYO",
    "JUNIO",
    "JULIO",
    "AGOSTO",
    "SEPTIEMBRE",
    "OCTUBRE",
    "NOVIEMBRE",
    "DICIEMBRE",
  ];

  const dia = fecha.getDate();
  const mes = meses[fecha.getMonth()];
  const año = fecha.getFullYear();

  return `${dia} DE ${mes} DE ${año}`;
}

function pdfexport(e) {
  e.preventDefault();
  var today = new Date();

  var doc = new jsPDF();

  const imgData = "vistas/recursos/img/avatars/lersan.png";
  doc.addImage(imgData, "PNG", 10, 10, 50, 20);
  let pageWidth = doc.internal.pageSize.getWidth();

  var textColor = [144, 142, 141];
  doc.setTextColor(textColor[0], textColor[1], textColor[2]);
  doc.setFontSize(8);


  doc.text('GENERADO POR ' + document.getElementById("txtnombre").value.toUpperCase(), 190, 20, { align: 'right', });
  doc.text('FECHA ' + today.getDate() + "/" + (today.getMonth() + 1) + "/" + today.getFullYear(), 190, 25, { align: 'right', });

  textColor = [6, 6, 6];
  doc.setTextColor(textColor[0], textColor[1], textColor[2]);
  doc.setFontSize(10);


  //  doc.text('Hello, this is a sample PDF created using jsPDF!', 10, 40);
  // debugger;

  var nFilas = $("#tablaVagon tr").length;

  if (nFilas > 0 && nFilas <= 12) {
    doc.setFontSize(11);
    doc.setFont(undefined, 'bold')
    doc.text(document.getElementById("tablaVagon").rows[0].cells[0].innerText, pageWidth / 2, 35, "center");


    doc.setFontSize(10);
    doc.setFont(undefined, 'bold')
    doc.text(document.getElementById("tablaVagon").rows[1].cells[0].innerText, pageWidth / 2, 50, "center");

    doc.setFontSize(10);
    doc.setFont(undefined, 'normal')
    doc.text(document.getElementById("tablaVagon").rows[2].cells[0].innerText, 10, 60);
    doc.text(document.getElementById("tablaVagon").rows[3].cells[0].innerText, 10, 65);
    doc.text(document.getElementById("tablaVagon").rows[4].cells[0].innerText, 10, 70);
    doc.text(document.getElementById("tablaVagon").rows[5].cells[0].innerText, 10, 75);
    doc.text(document.getElementById("tablaVagon").rows[6].cells[0].innerText, 10, 80);
    doc.text(document.getElementById("tablaVagon").rows[7].cells[0].innerText, 10, 85);
    doc.text(document.getElementById("tablaVagon").rows[8].cells[0].innerText, 10, 90);
    doc.text(document.getElementById("tablaVagon").rows[9].cells[0].innerText, 10, 95);
    doc.text(document.getElementById("tablaVagon").rows[10].cells[0].innerText, 10, 100);
    doc.text(document.getElementById("tablaVagon").rows[11].cells[0].innerText, 10, 105);

  }


  if (nFilas > 13 && nFilas <= 23) {

    doc.setFontSize(11);
    doc.setFont(undefined, 'bold')
    doc.text(document.getElementById("tablaVagon").rows[0].cells[0].innerText, pageWidth / 2, 35, "center");


    doc.setFontSize(10);
    doc.setFont(undefined, 'bold')
    doc.text(document.getElementById("tablaVagon").rows[1].cells[0].innerText, pageWidth / 2, 50, "center");

    doc.setFontSize(10);
    doc.setFont(undefined, 'normal')
    doc.text(document.getElementById("tablaVagon").rows[2].cells[0].innerText, 10, 60);
    doc.text(document.getElementById("tablaVagon").rows[3].cells[0].innerText, 10, 65);
    doc.text(document.getElementById("tablaVagon").rows[4].cells[0].innerText, 10, 70);
    doc.text(document.getElementById("tablaVagon").rows[5].cells[0].innerText, 10, 75);
    doc.text(document.getElementById("tablaVagon").rows[6].cells[0].innerText, 10, 80);
    doc.text(document.getElementById("tablaVagon").rows[7].cells[0].innerText, 10, 85);
    doc.text(document.getElementById("tablaVagon").rows[8].cells[0].innerText, 10, 90);
    doc.text(document.getElementById("tablaVagon").rows[9].cells[0].innerText, 10, 95);
    doc.text(document.getElementById("tablaVagon").rows[10].cells[0].innerText, 10, 100);
    doc.text(document.getElementById("tablaVagon").rows[11].cells[0].innerText, 10, 105);

    doc.setFontSize(10);
    doc.setFont(undefined, 'bold')
    doc.text(document.getElementById("tablaVagon").rows[12].cells[0].innerText, pageWidth / 2, 115, "center");


    doc.setFontSize(10);
    doc.setFont(undefined, 'normal')
    doc.text(document.getElementById("tablaVagon").rows[13].cells[0].innerText, 10, 125);
    doc.text(document.getElementById("tablaVagon").rows[14].cells[0].innerText, 10, 130);
    doc.text(document.getElementById("tablaVagon").rows[15].cells[0].innerText, 10, 135);
    doc.text(document.getElementById("tablaVagon").rows[16].cells[0].innerText, 10, 140);
    doc.text(document.getElementById("tablaVagon").rows[17].cells[0].innerText, 10, 145);
    doc.text(document.getElementById("tablaVagon").rows[18].cells[0].innerText, 10, 150);
    doc.text(document.getElementById("tablaVagon").rows[19].cells[0].innerText, 10, 155);
    doc.text(document.getElementById("tablaVagon").rows[20].cells[0].innerText, 10, 160);
    doc.text(document.getElementById("tablaVagon").rows[21].cells[0].innerText, 10, 165);
    doc.text(document.getElementById("tablaVagon").rows[22].cells[0].innerText, 10, 170);

  }


  if (nFilas > 23 && nFilas <= 34) {

    doc.setFontSize(11);
    doc.setFont(undefined, 'bold')
    doc.text(document.getElementById("tablaVagon").rows[0].cells[0].innerText, pageWidth / 2, 35, "center");


    doc.setFontSize(10);
    doc.setFont(undefined, 'bold')
    doc.text(document.getElementById("tablaVagon").rows[1].cells[0].innerText, pageWidth / 2, 50, "center");

    doc.setFontSize(10);
    doc.setFont(undefined, 'normal')
    doc.text(document.getElementById("tablaVagon").rows[2].cells[0].innerText, 10, 60);
    doc.text(document.getElementById("tablaVagon").rows[3].cells[0].innerText, 10, 65);
    doc.text(document.getElementById("tablaVagon").rows[4].cells[0].innerText, 10, 70);
    doc.text(document.getElementById("tablaVagon").rows[5].cells[0].innerText, 10, 75);
    doc.text(document.getElementById("tablaVagon").rows[6].cells[0].innerText, 10, 80);
    doc.text(document.getElementById("tablaVagon").rows[7].cells[0].innerText, 10, 85);
    doc.text(document.getElementById("tablaVagon").rows[8].cells[0].innerText, 10, 90);
    doc.text(document.getElementById("tablaVagon").rows[9].cells[0].innerText, 10, 95);
    doc.text(document.getElementById("tablaVagon").rows[10].cells[0].innerText, 10, 100);
    doc.text(document.getElementById("tablaVagon").rows[11].cells[0].innerText, 10, 105);

    doc.setFontSize(10);
    doc.setFont(undefined, 'bold')
    doc.text(document.getElementById("tablaVagon").rows[12].cells[0].innerText, pageWidth / 2, 115, "center");


    doc.setFontSize(10);
    doc.setFont(undefined, 'normal')
    doc.text(document.getElementById("tablaVagon").rows[13].cells[0].innerText, 10, 125);
    doc.text(document.getElementById("tablaVagon").rows[14].cells[0].innerText, 10, 130);
    doc.text(document.getElementById("tablaVagon").rows[15].cells[0].innerText, 10, 135);
    doc.text(document.getElementById("tablaVagon").rows[16].cells[0].innerText, 10, 140);
    doc.text(document.getElementById("tablaVagon").rows[17].cells[0].innerText, 10, 145);
    doc.text(document.getElementById("tablaVagon").rows[18].cells[0].innerText, 10, 150);
    doc.text(document.getElementById("tablaVagon").rows[19].cells[0].innerText, 10, 155);
    doc.text(document.getElementById("tablaVagon").rows[20].cells[0].innerText, 10, 160);
    doc.text(document.getElementById("tablaVagon").rows[21].cells[0].innerText, 10, 165);
    doc.text(document.getElementById("tablaVagon").rows[22].cells[0].innerText, 10, 170);

    doc.setFontSize(10);
    doc.setFont(undefined, 'bold')
    doc.text(document.getElementById("tablaVagon").rows[23].cells[0].innerText, pageWidth / 2, 180, "center");


    doc.setFontSize(10);
    doc.setFont(undefined, 'normal')
    doc.text(document.getElementById("tablaVagon").rows[24].cells[0].innerText, 10, 190);
    doc.text(document.getElementById("tablaVagon").rows[25].cells[0].innerText, 10, 195);
    doc.text(document.getElementById("tablaVagon").rows[26].cells[0].innerText, 10, 200);
    doc.text(document.getElementById("tablaVagon").rows[27].cells[0].innerText, 10, 205);
    doc.text(document.getElementById("tablaVagon").rows[28].cells[0].innerText, 10, 210);
    doc.text(document.getElementById("tablaVagon").rows[29].cells[0].innerText, 10, 215);
    doc.text(document.getElementById("tablaVagon").rows[30].cells[0].innerText, 10, 220);
    doc.text(document.getElementById("tablaVagon").rows[31].cells[0].innerText, 10, 225);
    doc.text(document.getElementById("tablaVagon").rows[32].cells[0].innerText, 10, 230);
    doc.text(document.getElementById("tablaVagon").rows[33].cells[0].innerText, 10, 235);


  }

  doc.save(titulodos + ".pdf");
}
