const pk = document.getElementById("txtpk").value;
const parrafo = document.getElementById("parrafoinfo");
const btnsemact = document.getElementById("btnsemact");
const btnsempas = document.getElementById("btnsempas");
const btnmesact = document.getElementById("btnmesact");
const btnmespas = document.getElementById("btnmespas");


$(document).ready(function () {

    parrafo.classList.add("mostrar");
  
    window.jsPDF = window.jspdf.jsPDF;
    
  
     btnsemact.addEventListener("click", Semanaactual);
     btnsempas.addEventListener("click", Semanapasado);
     btnmesact.addEventListener("click", Mesactual);
     btnmespas.addEventListener("click", Mespasado);
    exportexcel.addEventListener("click", exportexc);
     exportpdf.addEventListener("click", exportpdfs);
    // btnpdf.addEventListener("click", pdfexport);
  
 
  
  });


$(function () {

    var startDate, endDate;
    var hoy = new Date();
  
    let date = new Date();
    let dayInMillis = 24 * 3600000;
  
    $("#daypickerhoygra")
      .datepicker({
        autoclose: true,
        format: "yyyy/mm/dd",
        startView: "days",
        minViewMode: "days",
        forceParse: false,
      })
  
      .on("changeDate", function (e) {
        debugger;
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
  
          $("#daypickerhoygra").datepicker("setDate", startDate);
  
          fechasel = (date.getMonth() + 1) + "/" + date.getDate() + "/" + date.getFullYear() + "..." + (date.getMonth() + 1) + "/" + date.getDate() + "/" + date.getFullYear();
          titulo = "LISTADO DE CARGA DE GRANALLAS - FECHA " + fechaEnLetra(date);
          tituloexcel = "REPORTE_CARGA_GRANALLA_" + date.getDate() + (date.getMonth() + 1) + date.getFullYear();
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
          fechasel = (date.getMonth() + 1) + "/" + date.getDate() + "/" + date.getFullYear() + "..." + (date.getMonth() + 1) + "/" + date.getDate() + "/" + date.getFullYear();
          titulo = "LISTADO DE CARGA DE GRANALLAS - FECHA " + fechaEnLetra(date);
          tituloexcel = "REPORTE_CARGA_GRANALLA_" + date.getDate() + (date.getMonth() + 1) + date.getFullYear();
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

  function fechaEnLetra(fecha) {
    debugger;
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

  function tabla(fecha, cliente) {
    debugger;
    $.ajax({
      url: "modelos/consultargranalla.php",
      type: "POST",
      data: { fecha: fecha, fk_cliente_lersoft: cliente },
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
        //   sindatos();
        }
  
      },
      error: function (response) {
  
        alert("Sin Datos");
        parrafo.classList.remove("oculto");
        parrafo.classList.add("mostrar");
        // sindatos();
  
      },
    });
  
  
  
  }


   function obtenertabla() {  
      $('#tablegranalla').bootstrapTable('destroy');
  
      $('#tablegranalla').bootstrapTable({
        url: 'vistas/recursos/json/granalla.json',
        columns: [
          {
            field: "granalla",
          },
          {
            field: 'cargas'
          },
          {
            field: 'cabina'
          },
           {
            field: 'cantidad'
          }]
      })
  
  
     
   }
  
   function sindatos() {
     debugger;
     $('#tablegranalla').bootstrapTable('destroy');
  
     $('#tablegranalla').bootstrapTable({
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



function Semanaactual() {
    var fecha = new Date();
    var inicio = new Date(fecha.getFullYear(), fecha.getMonth(), fecha.getDate() - fecha.getDay() + 1);
    var fin = new Date(fecha.getFullYear(), fecha.getMonth(), fecha.getDate() + 7 - fecha.getDay());
    fechasel = "";
    fechasel = (inicio.getMonth() + 1) + "/" + inicio.getDate() + "/" + inicio.getFullYear() + "..." + (fin.getMonth() + 1) + "/" + fin.getDate() + "/" + fin.getFullYear();
    titulo =
      "Reporte vagones - PERIODO DE  " +
      fechaEnLetra(inicio) +
      " AL " +
      fechaEnLetra(fin);
    tituloexcel = "REPORTE_CARGA_GRANALLA_" + (inicio.getDate()) + "/" + (inicio.getMonth() + 1) + "/" + inicio.getFullYear() + " - " + fin.getDate() + "/" + (fin.getMonth() + 1) + "/" + fin.getFullYear();
    tabla(fechasel, pk);
  }
  
  function Semanapasado() {
    var fecha = new Date();
    var inicio = new Date(fecha.getFullYear(), fecha.getMonth(), fecha.getDate() - 7 - fecha.getDay() + 1);
    var fin = new Date(fecha.getFullYear(), fecha.getMonth(), fecha.getDate() - fecha.getDay());
    fechasel = "";
    fechasel = (inicio.getMonth() + 1) + "/" + inicio.getDate() + "/" + inicio.getFullYear() + "..." + (fin.getMonth() + 1) + "/" + fin.getDate() + "/" + fin.getFullYear();
    titulo =
      "LISTADO DE CARGA DE GRANALLAS - PERIODO DE  " +
      fechaEnLetra(inicio) +
      " AL " +
      fechaEnLetra(fin);
    tituloexcel = "REPORTE_CARGA_GRANALLA_" + (inicio.getDate()) + "/" + (inicio.getMonth() + 1) + "/" + inicio.getFullYear() + " - " + fin.getDate() + "/" + (fin.getMonth() + 1) + "/" + fin.getFullYear();
    tabla(fechasel, pk);
  }
  
  function Mesactual() {
    var date = new Date();
    var primerDia = new Date(date.getFullYear(), date.getMonth(), 1);
    var ultimoDia = new Date(date.getFullYear(), date.getMonth() + 1, 0);
    fechasel = "";
    fechasel = (primerDia.getMonth() + 1) + "/" + primerDia.getDate() + "/" + primerDia.getFullYear() + "..." + (ultimoDia.getMonth() + 1) + "/" + ultimoDia.getDate() + "/" + ultimoDia.getFullYear();
    titulo =
      "LISTADO DE CARGA DE GRANALLAS - PERIODO DE  " +
      fechaEnLetra(primerDia) +
      " AL " +
      fechaEnLetra(ultimoDia);
    tituloexcel = "REPORTE_CARGA_GRANALLA_" + (primerDia.getDate()) + "/" + (primerDia.getMonth() + 1) + "/" + primerDia.getFullYear() + " - " + ultimoDia.getDate() + "/" + (ultimoDia.getMonth() + 1) + "/" + ultimoDia.getFullYear();
    tabla(fechasel, pk);
  }
  
  function Mespasado() {
    var date = new Date();
    var primerDia = new Date(date.getFullYear(), date.getMonth() - 1, 1);
    var ultimoDia = new Date(date.getFullYear(), date.getMonth(), 0);
    fechasel = "";
    fechasel = (primerDia.getMonth() + 1) + "/" + primerDia.getDate() + "/" + primerDia.getFullYear() + "..." + (ultimoDia.getMonth() + 1) + "/" + ultimoDia.getDate() + "/" + ultimoDia.getFullYear();
    titulo =
      "LISTADO DE CARGA DE GRANALLAS - PERIODO DE   " +
      fechaEnLetra(primerDia) +
      " AL " +
      fechaEnLetra(ultimoDia);
    tituloexcel = "REPORTE_CARGA_GRANALLA_" + (inicio.getDate()) + "/" + (inicio.getMonth() + 1) + "/" + inicio.getFullYear() + " - " + fin.getDate() + "/" + (fin.getMonth() + 1) + "/" + fin.getFullYear();
    tabla(fechasel, pk);
  }

  function exportpdfs(e) {
    var today = new Date();
    e.preventDefault();
  
  
    var tabla = document.getElementById("tablegranalla");
    var datosArray = [];
  
    for (var i = 1; i < tabla.rows.length; i++) {
      var fila = tabla.rows[i];
      var filaArray = [];
  
      for (var j = 0; j < fila.cells.length; j++) {
        var celda = fila.cells[j];
        filaArray.push(celda.textContent);
      }
  
      datosArray.push(filaArray);
    }
  
    var doc = new jsPDF();
  
  
    const imgData = "vistas/recursos/img/avatars/lersan.png";
    doc.addImage(imgData, "PNG", 10, 10, 50, 20);
    let pageWidth = doc.internal.pageSize.getWidth();
    doc.setFontSize(10);
    doc.text(titulo, pageWidth / 2, 35, "center");
  
    var textColor = [144, 142, 141];
    doc.setTextColor(textColor[0], textColor[1], textColor[2]);
    doc.setFontSize(8);
  
  
    doc.text('GENERADO POR ' + document.getElementById("txtnombre").value.toUpperCase(), 190, 20, { align: 'right', });
    doc.text('FECHA ' + today.getDate() + "/" + (today.getMonth() + 1) + "/" + today.getFullYear(), 190, 25, { align: 'right', });
  
    textColor = [6, 6, 6];
    doc.setTextColor(textColor[0], textColor[1], textColor[2]);
    doc.setFontSize(8);
  
    const options = {
      head: [["Granalla", "Cargas",  "Cabina", "Cantidad"]],
      body: datosArray,
      margin: { top: 40 },
      styles: {overflow: 'linebreak',
                  fontSize: 6}
    };
  
    doc.autoTable(options);
    doc.save(tituloexcel + ".pdf");
  }


  function exportexc(e) {

    e.preventDefault();
  
  
    var tb = new Object();
    var myObject = [];
    const tabla = document.getElementById("tablegranalla");
    const filas = tabla.rows;
  
    for (let i = 1; i < filas.length; i++) {
  
      const celdas = filas[i].cells;
      for (let j = 0; j < celdas.length; j++) {
        const celda = celdas[j];
        const contenido = celda.innerHTML;
        if (j == 0) {
          tb.Granalla = contenido;
        } else if (j == 1) {
          tb.Cargas = contenido;
        } else if (j == 2) {
          tb.Cabina = contenido;
        } else if (j == 3) {
          tb.Cantidad = contenido;
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