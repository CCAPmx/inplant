const monthNames = [
  "Enero",
  "Febrero",
  "Marzo",
  "Abril",
  "Mayo",
  "Junio",
  "Julio",
  "Agosto",
  "Septiembre",
  "Octubre",
  "Noviembre",
  "Diciembre",
];

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

var pk = $.trim(document.getElementById("txtpkmaq").value);

const btnhoy = document.getElementById("btndia");
const btndiario = document.getElementById("btndiario");
const btnsemanal = document.getElementById("btnsemana");
const btnmensual = document.getElementById("btnmensual");
let ID_procesador = 0;

const $btnEnviar = document.querySelector("#btnEnviar");

var centesimas = 0;
var segundos = 0;
var minutos = 0;
var horas = 0;




$(document).ready(function () {


 


  if (pk == "") {
    pk = localStorage.getItem("pk");
    let razon = localStorage.getItem("txtRazonsocial");
    document.getElementById("Nombmaq").innerHTML = razon;
  } else {
    pk = $.trim(document.getElementById("txtpkmaq").value);
  }

  window.jsPDF = window.jspdf.jsPDF;

  var startDate, endDate;

  $("#weekpicker")
    .datepicker({
      autoclose: true,
      format: "mm/dd/yyyy",
      forceParse: false,
    })
    .on("changeDate", function (e) {
      var date = e.date;
      startDate = new Date(
        date.getFullYear(),
        date.getMonth(),
        date.getDate() - date.getDay()
      );
      endDate = new Date(
        date.getFullYear(),
        date.getMonth(),
        date.getDate() - date.getDay() + 6
      );
      //$('#weekpicker').datepicker("setDate", startDate);
      $("#weekpicker").datepicker("update", startDate);
      $("#weekpicker").val(
        startDate.getMonth() +
          1 +
          "/" +
          startDate.getDate() +
          "/" +
          startDate.getFullYear() +
          " - " +
          (endDate.getMonth() + 1) +
          "/" +
          endDate.getDate() +
          "/" +
          endDate.getFullYear()
      );
    });

  //new
  $("#prevWeek").click(function (e) {
    var date = $("#weekpicker").datepicker("getDate");
    //dateFormat = "mm/dd/yy"; //$.datepicker._defaults.dateFormat;
    startDate = new Date(
      date.getFullYear(),
      date.getMonth(),
      date.getDate() - date.getDay() - 7
    );
    endDate = new Date(
      date.getFullYear(),
      date.getMonth(),
      date.getDate() - date.getDay() - 1
    );
    $("#weekpicker").datepicker("setDate", new Date(startDate));
    $("#weekpicker").val(
      startDate.getMonth() +
        1 +
        "/" +
        startDate.getDate() +
        "/" +
        startDate.getFullYear() +
        " - " +
        (endDate.getMonth() + 1) +
        "/" +
        endDate.getDate() +
        "/" +
        endDate.getFullYear()
    );

    return false;
  });

  $("#nextWeek").click(function () {
    var date = $("#weekpicker").datepicker("getDate");
    //dateFormat = "mm/dd/yy"; // $.datepicker._defaults.dateFormat;
    startDate = new Date(
      date.getFullYear(),
      date.getMonth(),
      date.getDate() - date.getDay() + 7
    );
    endDate = new Date(
      date.getFullYear(),
      date.getMonth(),
      date.getDate() - date.getDay() + 13
    );
    $("#weekpicker").datepicker("setDate", new Date(startDate));
    $("#weekpicker").val(
      startDate.getMonth() +
        1 +
        "/" +
        startDate.getDate() +
        "/" +
        startDate.getFullYear() +
        " - " +
        (endDate.getMonth() + 1) +
        "/" +
        endDate.getDate() +
        "/" +
        endDate.getFullYear()
    );

    return false;
  });

  $("#CbmtipoOper").select2({
    theme: "bootstrap-5",
    width: $(this).data("width")
      ? $(this).data("width")
      : $(this).hasClass("w-100")
      ? "100%"
      : "style",
    placeholder: $(this).data("placeholder"),
    dropdownParent: $("#ModalRep"),
  });

  ocultarLoader();
  obtenerInfomaq(pk);

  document.getElementById('contentenedores').style.display = 'block';
  // inicio();
 

//   if (x.style.display === "none") {
//     x.style.display = "block";
// } else {
//     x.style.display = "none";
// }

});

function obtenerInfomaq(pk) {
  
  $.ajax({
    url: "modelos/contarmaquinas.php",
    type: "POST",
    data: { pk: pk },
    dataType: "json",

    beforeSend: function (response) {
      // spanElement.innerText = "Buscando Información";
    },

    //  Se ejecuta cuando termino la petición
    complete: function (response) {
      // $('#exito').html('Exito...');
    },

    // se ejecuta al termino de la petición y está fue correcta
    success: function (data) {
      let currentPage = 1;
      contador = parseInt(data);
      cantidad = parseInt(data);
      if (parseInt(data) > 0) {
        sum += 10;
        // spanElement.innerText = "Consultar " + sum +" De " + data + " Registros";
        cantidad = parseInt(data);
        if (cantidad < 10) {
          totalPages = 1;
        } else {
          let residuo = cantidad % 10;
          let parteEnteraResiduo = Math.floor(residuo);

          if (parteEnteraResiduo <= 9) {
            parteEnteraResiduo = 1;
          }

          totalPages = cantidad / 10;
          totalPages = totalPages + parteEnteraResiduo;
          totalPages = Math.round(totalPages);
        }
        ocultarLoader();
        generatePageNumbers(totalPages, currentPage);
      }
    },
    error: function (response) {
      ocultarLoader();
      Swal.fire({
        position: "center",
        icon: "error",
        title: "No Tiene Ningun Registro De Maquinas",
        showConfirmButton: false,
        timer: 2500,
      });

      document.getElementById("Iniciosuper").style.display = "none";
      document.getElementById("Usuariosuper").style.display = "none";
      document.getElementById("Maquinasuper").style.display = "none";
      document.getElementById("Granallasuper").style.display = "none";
      document.getElementById("Clientesuper").style.display = "none";
      document.getElementById("Produccionsuper").style.display = "none";
      document.getElementById("Bodegasuper").style.display = "none";
      document.getElementById("Mantenimientosuper").style.display = "none";
      document.getElementById("Direccionsuper").style.display = "none";
      document.getElementById("Granulometriasuper").style.display = "none";
      document.getElementById("Contactosuper").style.display = "none";
      document.getElementById("Salirsuper").style.display = "none";

      document.getElementById("InicioJefe").style.display = "block";
      document.getElementById("PedidosJefe").style.display = "block";
      document.getElementById("MaquinasJefe").style.display = "block";
      document.getElementById("ProduccionJefe").style.display = "block";
      document.getElementById("EstadoJefe").style.display = "block";
      document.getElementById("SalirJefe").style.display = "block";

      //  window.location = "salir";
    },
  });
}

function generatePageNumbers(totalPages, currentPage) {
  const paginationElement = document.getElementById("pagination");
  paginationElement.innerHTML = ""; // Limpiar el contenido existente

  const pageNumberIni = document.createElement("span");
  pageNumberIni.textContent = "⏮";
  paginationElement.appendChild(pageNumberIni);

  pageNumberIni.addEventListener("click", function (e) {
    e.preventDefault();
    limit = 10;
    offset = 1;

    tabla(pk, limit, offset);
    spanPagina.textContent = "Registro 1 al " + offset * 10 + " De " + cantidad;
  });

  for (let i = 1; i <= totalPages; i++) {
    const pageNumber = document.createElement("span");
    pageNumber.textContent = i;

    if (i === currentPage) {
      limit = 10;
      offset = 1;

      tabla(pk, limit, offset);
      sum += 10;
      // spanPagina.textContent = "Registro " + (offset * 10) + " De " + cantidad ;
      spanPagina.textContent =
        // "Registro 1 al " + offset * 10 + " De " + cantidad;
        "Registro " + offset + " al " + cantidad + " De " + cantidad;
    }

    pageNumber.addEventListener("click", function (e) {
      e.preventDefault();
      // e.target.style.background ="#def7ff";
      limit = 10;
      offset = 0;
      offset = (i - 1) * 10 + 1;
      tabla(pk, limit, offset);
      if (cantidad < offset + 9) {
        spanPagina.textContent =
          "Registro " + offset + " al " + cantidad + " De " + cantidad;
      } else {
        spanPagina.textContent =
          "Registro " + offset + " al " + (offset + 9) + " De " + cantidad;
      }
    });

    paginationElement.appendChild(pageNumber);
  }
  const pageNumberfin = document.createElement("span");
  const img = document.createElement("img");
  img.src = "https://lenguajejs.com/assets/logo.svg";
  img.alt = "Logo Javascript";
  pageNumberfin.textContent = "⏭";
  paginationElement.appendChild(pageNumberfin);

  pageNumberfin.addEventListener("click", function (e) {
    e.preventDefault();
    limit = 10;
    offset = (totalPages - 1) * 10 + 1;

    // offset= (cantidad ) ;

    if (cantidad < offset + 9) {
      spanPagina.textContent =
        "Registro " + offset + " al " + cantidad + " De " + cantidad;
    } else {
      spanPagina.textContent =
        "Registro " + offset + " al " + (offset + 9) + " De " + cantidad;
    }
    tabla(pk, limit, offset);
  });
}

function mostrarLoader() {
  document.getElementById("loader").style.display = "block";
}

function ocultarLoader() {
  document.getElementById("loader").style.display = "none";
}

function tabla(pk, limit, offset) {
  $.ajax({
    url: "modelos/maqclient.php",
    type: "POST",
    data: { pk: pk, limit: limit, offset: offset },
    dataType: "json",

    beforeSend: function (response) {
      // spanElement.innerText = 'Buscando Información';
    },

    //  Se ejecuta cuando termino la petición
    complete: function (response) {
      // $('#exito').html('Exito...');
    },

    success: function (data) {
      $("#tablamaq > tbody").empty();
      var html = "";

      for (var i = 0; i < data.length; i++) {
        html +=
          "<tr>" +
          '<td style="text-align:center">' +
          data[i].nombre +
          "</td>" +
          "<td>" +
          data[i].descripcion +
          "</td>" +
          "<td style='display:none;'>" +
          data[i].fkclientelersoft +
          "</td>" +
          "<td style='display:none;'>" +
          data[i].pk +
          "</td>" +
          "<td style='display:none;'>" +
          data[i].tipo_maquina +
          "</td>" +
          '<td style="text-align:center"> <div class="text-center"><button class="btn btn-outline-info btn-sm" onclick="obtenerReporte(this)"><i class="fa-solid fa-file-pdf"></i></button></div>' +
          "</td>" +
          '<td style="text-align:center"> <div class="text-center"><button class="btn btn-outline-info btn-sm" onclick="obtenerValor(this)"><i class="fa-solid fa-eye"></i></button></div>' +
          "</td>" +
          "</tr>";
      }
      $("#DataPedidosMaq").html(html);
      document.getElementById("Iniciosuper").style.display = "none";
      document.getElementById("Usuariosuper").style.display = "none";
      document.getElementById("Maquinasuper").style.display = "none";
      document.getElementById("Granallasuper").style.display = "none";
      document.getElementById("Clientesuper").style.display = "none";
      document.getElementById("Produccionsuper").style.display = "none";
      document.getElementById("Bodegasuper").style.display = "none";
      document.getElementById("Mantenimientosuper").style.display = "none";
      document.getElementById("Direccionsuper").style.display = "none";
      document.getElementById("Granulometriasuper").style.display = "none";
      document.getElementById("Contactosuper").style.display = "none";
      document.getElementById("Salirsuper").style.display = "none";

      document.getElementById("InicioJefe").style.display = "block";
      document.getElementById("PedidosJefe").style.display = "block";
      document.getElementById("MaquinasJefe").style.display = "block";
      document.getElementById("ProduccionJefe").style.display = "block";
      document.getElementById("EstadoJefe").style.display = "block";
      document.getElementById("SalirJefe").style.display = "block";
    },
    error: function (response) {
      // alert(error con la petición);
    },
  });
}

function obtenerValor(el) {
  var index = $(el).closest("tr").index();

  var table = document.getElementById("tablamaq");

  let pks = "";
  let fk_cliente_lersoft = "";
  nombre = "";
  descripcion = "";

  pks = table.rows[index + 1].cells[3].innerText;
  fk_cliente_lersoft = table.rows[index + 1].cells[2].innerText;
  nombre = table.rows[index + 1].cells[0].innerText;
  descripcion = table.rows[index + 1].cells[1].innerText;
  ID_procesador = nombre;
  contador = 0;
  $.ajax({
    type: "POST",
    url: "modelos/detallemaq.php",
    data: { nombre: nombre },
    dataType: "json",
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
    success: function (data) {
      var html = "";
      html +=
        "<tr>" +
        '<td style="text-align:left; background-color: #def7ff;"><strong> Numero CCAP: </strong>' +
        data[0].nombre +
        "</td>" +
        "</tr>";

      html +=
        "<tr>" +
        '<td style="text-align:left"><strong> Descripción: </strong>' +
        data[0].descripcion +
        "</td>" +
        "</tr>";

      html +=
        "<tr>" +
        '<td style="text-align:left; background-color: #def7ff;"><strong> Macar: </strong>' +
        data[0].Marca_tipo_maquina +
        "</td>" +
        "</tr>";

      html +=
        "<tr>" +
        '<td style="text-align:left"><strong> Tipo Maquina: </strong>' +
        data[0].tipo_maquina +
        "</td>" +
        "</tr>";

      html +=
        "<tr>" +
        '<td style="text-align:left; background-color: #def7ff;"><strong> Amperaje Max: </strong>' +
        data[0].amp_alto +
        "</td>" +
        "</tr>";

      html +=
        "<tr>" +
        '<td style="text-align:left; background-color: #def7ff;"><strong> Amperaje Min: </strong>' +
        data[0].amp_bajo +
        "</td>" +
        "</tr>";

      html +=
        "<tr>" +
        '<td style="text-align:left; background-color: #def7ff;"><strong> Amperaje Vacio: </strong>' +
        data[0].amperaje_vacio +
        "</td>" +
        "</tr>";

      html +=
        "<tr>" +
        '<td style="text-align:left"><strong> Turbinas: </strong>' +
        data[0].no_turbinas_activas +
        "</td>" +
        "</tr>";

      html +=
        "<tr>" +
        '<td style="text-align:left; background-color: #def7ff;"> <strong>Codigo INPLANT: </strong>' +
        data[0].implant +
        "</td>" +
        "</tr>";

      html +=
        "<tr>" +
        '<td style="text-align:left"><strong> Granalla: </strong>' +
        data[0].abrasivo +
        "</td>" +
        "</tr>";

      html +=
        "<tr>" +
        '<td style="text-align:left; background-color: #def7ff;"><strong> Voltaje: </strong>' +
        data[0].voltaje +
        "</td>" +
        "</tr>";

      html +=
        "<tr>" +
        '<td style="text-align:left"> <strong> Cliente: </strong>' +
        data[0].cliente +
        " </td>" +
        "</tr>";

      html +=
        "<tr>" +
        '<td style="text-align:left; background-color: #def7ff;"> <strong> Costo Granalla: </strong>' +
        data[0].costo_granalla +
        "</td>" +
        "</tr>";

      html +=
        "<tr>" +
        '<td style="text-align:left"><strong> Costo Electrico: </strong>' +
        data[0].costo_electrico +
        "</td>" +
        "</tr>";

      html +=
        "<tr>" +
        '<td style="text-align:left; background-color: #def7ff;"><strong> Costo Personal: </strong>' +
        data[0].costo_personal +
        "</td>" +
        "</tr>";

      html +=
        "<tr>" +
        '<td style="text-align:left"><strong> Costo Mantenimiento: </strong>' +
        data[0].costo_mtto_maquina +
        "</td>" +
        "</tr>";

      html +=
        "<tr>" +
        '<td style="text-align:left; background-color: #def7ff;"> <strong>Consumo Granalla * Hora: </strong>' +
        data[0].consumo_granalla_hora +
        "</td>" +
        "</tr>";

      html +=
        "<tr>" +
        '<td style="text-align:left"><strong>Produccion Por Hora: </strong>' +
        data[0].perf_hora +
        "</td>" +
        "</tr>";

      html +=
        "<tr>" +
        '<td style="text-align:left; background-color: #def7ff;"><strong>Tipo Produccion: </strong>' +
        data[0].diasTipo +
        "</td>" +
        "</tr>";

      html +=
        "<tr>" +
        '<td style="text-align:left"><strong>Numero De Operadores: </strong>' +
        data[0].operadores +
        "</td>" +
        "</tr>";

      html +=
        "<tr>" +
        '<td style="text-align:left; background-color: #def7ff;"><strong>Capacidad del silo (Kg): </strong>' +
        data[0].capacidad_silo +
        "</td>" +
        "</tr>";

      html +=
        "<tr>" +
        '<td style="text-align:left"><strong>Tiempo Lectura: </strong>' +
        data[0].tiempolectura +
        "</td>" +
        "</tr>";

      html +=
        "<tr>" +
        '<td style="text-align:left; background-color: #def7ff;"><strong>Horometro: </strong>' +
        data[0].horometro +
        "</td>" +
        "</tr>";

      $("#tablaDatosmaq").html(html);

      ocultarLoader();
      $(".modal-header").css("background-color", "#07B5E8");
      $(".modal-title").text("Maquina: " + nombre + " -- " + descripcion + "");
      $("#ModalMaq").modal("show");
    },
    error: function (response) {
      // alert(error con la petición);

      ocultarLoader();
      alert("Error: " + response);
    },
  });
}

function obtenerReporte(el) {
  var index = $(el).closest("tr").index();

  var table = document.getElementById("tablamaq");

  let nombre = "";

  Tipo = table.rows[index + 1].cells[4].innerText;
  nombre = table.rows[index + 1].cells[0].innerText;
  ID_procesador = nombre;

  if (Tipo == "Presion") {
    $.ajax({
      url: "modelos/ontenergranalla.php",
      type: "POST",
      data: {
        nombre: nombre,
      },
      dataType: "json",
      beforeSend: function (response) {},
      complete: function (response) {},

      success: function (data) {
        granalla = 0;
        granalla = data[0].consumo_granalla_hora;
        alturasilo = data[0].altura_silo;
        granallazonamuerta = data[0].granalla_zona_muerta;
        granalla_pots = data[0].granalla_pots;
        noturbinasactivas = data[0].no_turbinas_activas;
        descripcion = data[0].descripcion;
        cliente = data[0].cliente;
      },
      error: function (response) {
        contador = 0;
        ocultarLoader();
      },
    });

    $(".modal-header").css("background-color", "#07B5E8");
    $(".modal-title").text("REPORTES");
    $("#ModalRep").modal("show");
  } else if (Tipo == "Batch" || Tipo == "Tunel") {
    $.ajax({
      url: "modelos/obtenerdatos.php",
      type: "POST",
      data: {
        nombre: nombre,
      },
      dataType: "json",
      beforeSend: function (response) {},
      complete: function (response) {},
      success: function (data) {
        document.getElementById("tablamaquina").insertRow(-1).innerHTML =
          "<td colspan='6' class='text-center'> Maquina " +
          data[0].maquina +
          "</td>";
        document.getElementById("tablamaquina").insertRow(-1).innerHTML =
          "<td>Codigo Lersan </td> <td>" +
          data[0].nombre +
          "</td> </td> <td>Amp Max:</td> <td>" +
          data[0].ampmax +
          "</td> <td colspan='2'> Amp </td>";
        document.getElementById("tablamaquina").insertRow(-1).innerHTML =
          "<td>Turbinas </td> <td>" +
          data[0].turbinas +
          "</td> </td> <td>Amp Ideal:</td> <td>" +
          data[0].ampideal +
          "</td> <td colspan='2'> Amp </td>";
        document.getElementById("tablamaquina").insertRow(-1).innerHTML =
          "<td>Voltaje </td> <td>" +
          data[0].voltaje +
          "</td> </td> <td>Amp Critico:</td> <td>" +
          data[0].ampcritico +
          "</td> <td colspan='2'> Amp </td>";
        document.getElementById("tablamaquina").insertRow(-1).innerHTML =
          "<td>Producto </td> <td>" +
          data[0].producto +
          "</td> </td> <td>Amp Vacio:</td> <td>" +
          data[0].ampvacio +
          "</td> <td colspan='2'> Amp </td>";
        document.getElementById("tablamaquina").insertRow(-1).innerHTML =
          "<td>Abrasivo </td> <td>" +
          data[0].abrasivo +
          "</td> </td> <td>Potencia Total:</td> <td>" +
          data[0].potenciatot +
          "</td> <td colspan='2'> Kwatt </td>";
        document.getElementById("tablamaquina").insertRow(-1).innerHTML =
          "<td>Producción Teorica </td> <td>" +
          data[0].produccion +
          "</td>  <td> Piezas/hr </td> </td> <td>Consumo Abr:</td> <td>" +
          data[0].consumoabra +
          "</td> <td> Kg/hr </td>";
        document.getElementById("tablamaquina").insertRow(-1).innerHTML =
          "<td colspan='6' class='text-center'> Detalles de costos </td>";
        document.getElementById("tablamaquina").insertRow(-1).innerHTML =
          "<td colspan='3'>Costo Granalla </td> <td>" +
          data[0].costogranalla +
          "</td> <td colspan='2'> USD/Kg</td>";
        document.getElementById("tablamaquina").insertRow(-1).innerHTML =
          "<td colspan='3'>Costo Electrico </td> <td>" +
          data[0].costoelectrico +
          "</td> <td colspan='2'>USD/Kwh</td>";
        document.getElementById("tablamaquina").insertRow(-1).innerHTML =
          "<td colspan='3'>Costo Personal </td> <td>" +
          data[0].costopersonal +
          "</td> <td colspan='2'> USD/Hr-H</td>";
        document.getElementById("tablamaquina").insertRow(-1).innerHTML =
          "<td colspan='3'>Operadores </td> <td>" +
          data[0].operadores +
          "</td> <td colspan='2'> USD/Kg</td>";
        document.getElementById("tablamaquina").insertRow(-1).innerHTML =
          "<td colspan='3'>Costo Mantenimiento Maquina </td> <td>" +
          data[0].costomonto +
          "</td> <td colspan='2'> USD/Hr</td>";
      },
      error: function (response) {
        contador = 0;
        ocultarLoader();
      },
    });

    $(".modal-header").css("background-color", "#07B5E8");
    $(".modal-title").text("REPORTES");
    $("#ModalRep").modal({show:true});
  }

  // reinicio();
}

btnhoy.addEventListener("click", function () {
  var dia = document.getElementById ("daypicker");
  dia.value="";
  dia.placeholder = "Seleccionar Día";

  var semana = document.getElementById ("weekpicker");
  semana.value="";
  semana.placeholder = "En desarrollo";
  // semana.placeholder = "Seleccionar Semana";

  var mes = document.getElementById ("monthpicker");
  mes.value="";
  mes.placeholder = "En desarrollo";
  // mes.placeholder = "Seleccionar Mes";


  var presion = 0;
  if (Tipo == "Presion") {
    presion = 1;
  } else {
    presion = 2;
  }
  let date = new Date();
  ReporteDia(date, 0, presion);
});

$(function () {
  var startDate, endDate;
  var hoy = new Date();

  let date = new Date();
  let dayInMillis = 24 * 3600000;

  $("#daypicker")
    .datepicker({
      autoclose: true,
      format: "yyyy/mm/dd",
      startView: "days",
      minViewMode: "days",
      forceParse: false,
    })

    .on("changeDate", function (e) {
      var date = e.date;
      var fsel = new Date(date);
      let result = compareDates(hoy, fsel);

      if (result == 1) {
        startDate = new Date(
          date.getFullYear(),
          date.getMonth(),
          date.getDate()
        );
        $("#daypicker").datepicker("setDate", startDate);

        $("#daypicker").val(
          startDate.getDate() +
            "/" +
            getLongMonthName(new Date(date)) +
            "/" +
            startDate.getFullYear()
        );

        var semana = document.getElementById ("weekpicker");
        semana.value="";
        semana.placeholder = "En desarrollo";

        var mes = document.getElementById ("monthpicker");
        mes.value="";
        mes.placeholder = "En desarrollo";

        var presion = 0;
        if (Tipo == "Presion") {
          presion = 1;
        } else {
          presion = 2;
        }
        mostrarLoader();
        ReporteDia(date, 1, presion);
      } else if (result == -1) {
        // console.log('Mayor');
        Swal.fire({
          position: "center",
          icon: "error",
          title: "Seleccione Una Fecha Menor",
          showConfirmButton: false,
          timer: 2500,
        });
      } else {
        // console.log('Igual');
        Swal.fire({
          position: "center",
          icon: "error",
          title: "Seleccione Una Fecha Menor",
          showConfirmButton: false,
          timer: 2500,
        });
      }
    });

  $("#weekpicker")
    .datepicker({
      autoclose: true,
      format: "yyyy/mm/dd",
      startView: "week",
      minViewMode: "week",
      forceParse: false,
    })
    .on("changeDate", function (e) {
      var date = e.date;
      startDate = new Date(
        date.getFullYear(),
        date.getMonth(),
        date.getDate() - date.getDay()
      );
      endDate = new Date(
        date.getFullYear(),
        date.getMonth(),
        date.getDate() - date.getDay() + 6
      );
      $("#weekpicker").datepicker("setDate", startDate);
      $("#weekpicker").datepicker("update", startDate);

      //  (startDate.getMonth() + 1)
      $("#weekpicker").val(
        startDate.getDate() +
          "/" +
          getLongMonthName(new Date(date)) +
          "/" +
          startDate.getFullYear() +
          " - " +
          endDate.getDate() +
          "/" +
          getLongMonthName(new Date(date)) +
          "/" +
          endDate.getFullYear()
      );
      

      var semana = document.getElementById ("daypicker");
      semana.value="";
      semana.placeholder = "Seleccionar Día";

      var mes = document.getElementById ("monthpicker");
      mes.value="";
      mes.placeholder = "Seleccionar Mes";


    });

  $("#monthpicker")
    .datepicker({
      autoclose: true,
      format: "yyyy/mm/dd",
      startView: "months",
      minViewMode: "months",
      forceParse: false,
    })
    .on("changeDate", function (e) {
      //alert(e.date);
      var date = e.date;
      startDate = new Date(date.getFullYear(), date.getMonth(), 1);
      endDate = new Date(date.getFullYear(), date.getMonth() + 1, 0);
      $("#monthpicker").datepicker("setDate", startDate);
      $("#monthpicker").datepicker("update", startDate);
      $("#monthpicker").val(
        startDate.getDate() +
          "/" +
          getLongMonthName(new Date(date)) +
          "/" +
          startDate.getFullYear() +
          " - " +
          endDate.getDate() +
          "/" +
          getLongMonthName(new Date(date)) +
          "/" +
          endDate.getFullYear()
      );
      
      var semana = document.getElementById ("daypicker");
      semana.value="";
      semana.placeholder = "Seleccionar Día";

      var mes = document.getElementById ("weekpicker");
      mes.value="";
      mes.placeholder = "Seleccionar Semana";


    });

  //new
  $("#prevWeek").click(function (e) {
    var date = $("#weekpicker").datepicker("getDate");
    //dateFormat = "mm/dd/yy"; //$.datepicker._defaults.dateFormat;
    startDate = new Date(
      date.getFullYear(),
      date.getMonth(),
      date.getDate() - date.getDay() - 7
    );
    endDate = new Date(
      date.getFullYear(),
      date.getMonth(),
      date.getDate() - date.getDay() - 1
    );
    $("#weekpicker").datepicker("setDate", new Date(startDate));
    $("#weekpicker").val(
      startDate.getMonth() +
        1 +
        "/" +
        startDate.getDate() +
        "/" +
        startDate.getFullYear() +
        " - " +
        (endDate.getMonth() + 1) +
        "/" +
        endDate.getDate() +
        "/" +
        endDate.getFullYear()
    );

    return false;
  });

  $("#nextWeek").click(function () {
    var date = $("#weekpicker").datepicker("getDate");
    //dateFormat = "mm/dd/yy"; // $.datepicker._defaults.dateFormat;
    startDate = new Date(
      date.getFullYear(),
      date.getMonth(),
      date.getDate() - date.getDay() + 7
    );
    endDate = new Date(
      date.getFullYear(),
      date.getMonth(),
      date.getDate() - date.getDay() + 13
    );
    $("#weekpicker").datepicker("setDate", new Date(startDate));
    $("#weekpicker").val(
      startDate.getMonth() +
        1 +
        "/" +
        startDate.getDate() +
        "/" +
        startDate.getFullYear() +
        " - " +
        (endDate.getMonth() + 1) +
        "/" +
        endDate.getDate() +
        "/" +
        endDate.getFullYear()
    );

    return false;
  });

  var start = moment();
  $('input[name="txtFehahoy"]').daterangepicker(
    {
      locale: {
        format: "DD/MM/YYYY",
        separator: " - ",
        applyLabel: "Aplicar",
        cancelLabel: "Cancelar",
        fromLabel: "DE",
        toLabel: "HASTA",
        customRangeLabel: "Custom",
        daysOfWeek: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sáb"],
        monthNames: [
          "Enero",
          "Febrero",
          "Marzo",
          "Abril",
          "Mayo",
          "Junio",
          "Julio",
          "Agosto",
          "Septiembre",
          "Octubre",
          "Noviembre",
          "Diciembre",
        ],
        firstDay: 1,
      },
      opens: "center",
      singleDatePicker: true,
      showDropdowns: true,
      startDate: start,
      minYear: 1901,
      maxYear: parseInt(moment().format("YYYY"), 10),
    },
    function (start, end, label) {
      // var years = moment().diff(start, 'years');
      // alert("You are " + years + " years old!");
    }
  );

  // var start = moment().subtract(7, "days");
  // var end = moment();

  // function semana(start, end) {
  //   $("#reportrange span").html(
  //     start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
  //   );
  // }

  $("#reportrange").daterangepicker(
    {
      locale: {
        format: "DD/MM/YYYY",
        separator: " - ",
        applyLabel: "Aplicar",
        cancelLabel: "Cancelar",
        fromLabel: "DE",
        toLabel: "HASTA",
        customRangeLabel: "Custom",
        daysOfWeek: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sáb"],
        monthNames: [
          "Enero",
          "Febrero",
          "Marzo",
          "Abril",
          "Mayo",
          "Junio",
          "Julio",
          "Agosto",
          "Septiembre",
          "Octubre",
          "Noviembre",
          "Diciembre",
        ],
        firstDay: 1,
      },
      opens: "center",
      startDate: start,
      // startDate: start,
      // endDate: end,
    },
    function (start, end, label) {
      alert("Semana");
    }
  );

  // semana(start, end);

  // var start = moment().subtract(29, "days");
  // var end = moment();

  // function mes(start, end) {
  //   $("#reportrangemens span").html(
  //     start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
  //   );
  // }

  $("#reportrangemens").daterangepicker(
    {
      locale: {
        format: "DD/MM/YYYY",
        separator: " - ",
        applyLabel: "Aplicar",
        cancelLabel: "Cancelar",
        fromLabel: "DE",
        toLabel: "HASTA",
        customRangeLabel: "Custom",
        daysOfWeek: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sáb"],
        monthNames: [
          "Enero",
          "Febrero",
          "Marzo",
          "Abril",
          "Mayo",
          "Junio",
          "Julio",
          "Agosto",
          "Septiembre",
          "Octubre",
          "Noviembre",
          "Diciembre",
        ],
        firstDay: 1,
      },
      opens: "center",
      startDate: start,
      // startDate: start,
      // endDate: end,
    },
    function (start, end, label) {
      alert("Mes");
    }
  );

  // mes(start, end);
});

function Semanas() {
  // Obtener el elemento select
  const selectElement = document.getElementById("semanas");

  // Obtener la fecha actual
  const currentDate = new Date();

  // Obtener el año actual
  const currentYear = currentDate.getFullYear();

  // Crear un objeto Date para el primer día del año
  const startDate = new Date(currentYear, 0, 1);

  // Crear un objeto Date para el último día del año
  const endDate = new Date(currentYear, 11, 31);

  // Calcular el número total de semanas en el año
  const totalWeeks = Math.ceil(
    (endDate - startDate) / (24 * 60 * 60 * 1000) / 7
  );

  // Agregar las opciones al elemento select
  for (let i = 1; i <= totalWeeks; i++) {
    const option = document.createElement("option");
    option.value = i;
    option.text = "Semana " + i;
    selectElement.appendChild(option);
  }
}

getLongMonthName = function (date) {
  return monthNames[date.getMonth()];
};

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

function ReporteDia(fecha, Opera, presion) {
  const fechacontulta = new Date(fecha);
  fechareporte = fechacontulta.toLocaleString("en-US").split(",")[0];

  if (presion == 1) {
    debugger;
    var tablapot = $("#tablapot tr").length - 1;
    var tabladiario = $("#tabladiario tr").length - 1;
    var tablaprod = $("#tablaprod tr").length - 1;
    var tablacabina = $("#tablacabina tr").length - 1;
    var tabladatos = $("#tabladatos tr").length - 1;

    if (tablapot > 1) {
      for (x = tablapot; x > 0; x--) {
        document.getElementById("tablapot").deleteRow(x);
      }
    }

   

    if (tablaprod > 1) {
      for (z = tablaprod; z > 0; z--) {
        document.getElementById("tablaprod").deleteRow(z);
      }
    }

    if (tablacabina > 1) {
      for (j = tablacabina; j > 0; j--) {
        document.getElementById("tablacabina").deleteRow(j);
      }
    }

    if (tabladatos > 1) {
      for (j = tabladatos; j > 0; j--) {
        document.getElementById("tabladatos").deleteRow(j);
      }
    }

    debugger;

     if (tabladiario > 1) {
       for (v = tabladiario; v > 0; v--) {
         document.getElementById("tabladiario").deleteRow(0);
       }
     }

    $(".modal-header").css("background-color", "#07B5E8");

    if (Opera == 0) {
      tiporeporte = "Reporte_Actual";
      $(".modal-title").text("Reporte Granallado Del Día");
    } else {
      tiporeporte = "Reporte_Diario";
      $(".modal-title").text("Reporte Granallado Diario");
    }

    $("#ModalReportedia").modal("show");

    $.ajax({
      url: "modelos/contar_reportedia.php",
      type: "POST",
      data: {
        ID_procesador: ID_procesador,
        fecha: fechacontulta.toLocaleString("en-US").split(",")[0],
      },
      dataType: "json",

      beforeSend: function (response) {
        mostrarLoader();
      },

      complete: function (response) {
        ocultarLoader();
      },

      success: function (data) {
        totales = 0;
        totales = data;

        $.ajax({
          url: "modelos/reportdia.php",
          type: "POST",
          data: {
            ID_procesador: ID_procesador,
            contador: totales,
            fecha: fechacontulta.toLocaleString("en-US").split(",")[0],
          },
          dataType: "json",

          beforeSend: function (response) {},

          complete: function (response) {
            ocultarLoader();
          },

          success: function (data) {
            let num = 0;
            let html = "";
            let pot1 = 0;
            let pot2 = 0;
            let pot3 = 0;
            let pot4 = 0;
            let pot5 = 0;
            let pot6 = 0;
            let pot7 = 0;
            let pot8 = 0;
            let pot9 = 0;
            let pot10 = 0;
            let pot11 = 0;
            let pot12 = 0;
            let silo = 0;

            let pottot = 0;

            let presion = 0;
            let mingradia = 0;

            let propot1 = 0;
            let propot2 = 0;
            let propot3 = 0;
            let propot4 = 0;
            let propot5 = 0;
            let propot6 = 0;
            let propot7 = 0;
            let propot8 = 0;
            let propot9 = 0;
            let propot10 = 0;
            let propot11 = 0;
            let propot12 = 0;

            propresion = 0;
            granallomin = 0;
            granallodia = 0;
            prom_silo = 0;

            document.getElementById("tabladatos").insertRow(-1).innerHTML =
              "<td colspan='2' class='text-center'>" + cliente + "</td>";
            document.getElementById("tabladatos").insertRow(-1).innerHTML =
              "<td>Maquina de granallado  " +
              descripcion +
              "</td> <td>Fecha: " +
              fechacontulta.toLocaleString("es-MX").split(",")[0] +
              "</td>";

            etiqueta = "";
            datos = "";
            A1 = "";
            A2 = "";
            A3 = "";
            A4 = "";
            A5 = "";
            A6 = "";
            A7 = "";
            A8 = "";
            A9 = "";
            A10 = "";
            A11 = "";
            A12 = "";
            presionlinea = "";
            nivellinea = "";
            tendencialinea = "";
            tmax = 0;
            for (var i = 0; i < data.length; i++) {
              num += 1;
              pot1 += data[i].t_a1;
              pot2 += data[i].t_a2;
              pot3 += data[i].t_a3;
              pot4 += data[i].t_a4;
              pot5 += data[i].t_a5;
              pot6 += data[i].t_a6;
              pot7 += data[i].t_a7;
              pot8 += data[i].t_a8;
              pot9 += data[i].t_a9;
              pot10 += data[i].t_a10;
              pot11 += data[i].t_a11;
              pot12 += data[i].t_a12;
              presion += data[i].presion;
              mingradia += data[i].sum_t;
              silo += data[i].nivel;
              etiqueta += data[i].label + ",";
              presionlinea += data[i].presion + ",";
              nivellinea += data[i].nivel + ",";

              if (data[i].tendencia != "") {
                tendencialinea += data[i].tendencia + ",";
              }
              tmax += data[i].max_tiempo;
              if (data[i].a1 == 1) {
                A1 += "1,";
              } else {
                A1 += "null,";
              }

              if (data[i].a2 == 2) {
                A2 += "2,";
              } else {
                A2 += "null,";
              }

              if (data[i].a3 == 3) {
                A3 += "3,";
              } else {
                A3 += "null,";
              }

              if (data[i].a4 == 4) {
                A4 += "4,";
              } else {
                A4 += "null,";
              }

              if (data[i].a5 == 5) {
                A5 += "5,";
              } else {
                A5 += "null,";
              }

              if (data[i].a6 == 6) {
                A6 += "6,";
              } else {
                A6 += "null,";
              }

              if (data[i].a7 == 7) {
                A7 += "7,";
              } else {
                A7 += "null,";
              }

              if (data[i].a8 == 8) {
                A8 += "8,";
              } else {
                A8 += "null,";
              }

              if (data[i].a9 == 9) {
                A9 += "9,";
              } else {
                A9 += "null,";
              }

              if (data[i].a10 == 10) {
                A10 += "10,";
              } else {
                A10 += "null,";
              }

              if (data[i].a11 == 11) {
                A11 += "11,";
              } else {
                A11 += "null,";
              }

              if (data[i].a12 == 12) {
                A12 += "12,";
              } else {
                A12 += "null,";
              }
            }

            etiqueta = etiqueta.slice(0, -1);
            A1 = A1.slice(0, -1);
            A2 = A2.slice(0, -1);
            A3 = A3.slice(0, -1);
            A4 = A4.slice(0, -1);
            A5 = A5.slice(0, -1);
            A6 = A6.slice(0, -1);
            A7 = A7.slice(0, -1);
            A8 = A8.slice(0, -1);
            A9 = A9.slice(0, -1);
            A10 = A10.slice(0, -1);
            A11 = A11.slice(0, -1);
            A12 = A12.slice(0, -1);

            $("#Datahoy").html(html);
            propot1 = pot1 / 3600;
            propot2 = pot2 / 3600;
            propot3 = pot3 / 3600;
            propot4 = pot4 / 3600;
            propot5 = pot5 / 3600;
            propot6 = pot6 / 3600;
            propot7 = pot7 / 3600;
            propot8 = pot8 / 3600;

            pottot =
              (propot1 +
                propot2 +
                propot3 +
                propot4 +
                propot5 +
                propot6 +
                propot7 +
                propot8) /
              3600;

            propresion = presion / num;
            prom_silo = silo / num;

            granallomin = mingradia / 60;

            totpropot1 = propot1.toFixed(1);
            totpropot2 = propot2.toFixed(1);
            totpropot3 = propot3.toFixed(1);
            totpropot4 = propot4.toFixed(1);
            totpropot5 = propot5.toFixed(1);
            totpropot6 = propot6.toFixed(1);
            totpropot7 = propot7.toFixed(1);
            totpropot8 = propot8.toFixed(1);

            granallodia = (granallomin / 60) * granalla;
            GranallaMaq = 0;

            if (alturasilo - prom_silo <= 89) {
              GranallaMaq =
                ((3.29 * (alturasilo - prom_silo)) / 100) * (4.5 * 1000);
            } else {
              GranallaMaq =
                (6.05 * (alturasilo / 100) - 0.89) * (4.5 * 1000) +
                3.29 * (4.5 * 1000);
            }
            GranallaMaq += granallazonamuerta + granalla_pots;

            document.getElementById("tablapot").insertRow(-1).innerHTML =
              "<td>Pot 1</td><td>" + totpropot1 + "</td>";
            document.getElementById("tablapot").insertRow(-1).innerHTML =
              "<td>Pot 2</td><td>" + totpropot2 + "</td>";
            document.getElementById("tablapot").insertRow(-1).innerHTML =
              "<td>Pot 3</td><td>" + totpropot3 + "</td>";
            document.getElementById("tablapot").insertRow(-1).innerHTML =
              "<td>Pot 4</td><td>" + totpropot4 + "</td>";
            document.getElementById("tablapot").insertRow(-1).innerHTML =
              "<td>Pot 5</td><td>" + totpropot5 + "</td>";
            document.getElementById("tablapot").insertRow(-1).innerHTML =
              "<td>Pot 6</td><td>" + totpropot6 + "</td>";
            document.getElementById("tablapot").insertRow(-1).innerHTML =
              "<td>Pot 7</td><td>" + totpropot7 + "</td>";
            document.getElementById("tablapot").insertRow(-1).innerHTML =
              "<td>Pot 8</td><td>" + totpropot8 + "</td>";
            document.getElementById("tabladiario").insertRow(-1).innerHTML =
              "<td>Presion Prom</td><td>" + propresion.toFixed(0) + "</td>";
            document.getElementById("tabladiario").insertRow(-1).innerHTML =
              "<td>Min Granallado</td><td>" +
              granallomin
                .toLocaleString("en-US", { maximumFractionDigits: 0 })
                .toLocaleString("en-US", { maximumFractionDigits: 0 }) +
              "</td>";
            document.getElementById("tabladiario").insertRow(-1).innerHTML =
              "<td>Granallado/dia</td><td>" +
              granallodia.toLocaleString("en-US", {
                maximumFractionDigits: 0,
              }) +
              " KG </td>";
            document.getElementById("tabladiario").insertRow(-1).innerHTML =
              "<td>Prom Granalla Maquina</td><td>" +
              GranallaMaq.toLocaleString("en-US", {
                maximumFractionDigits: 0,
              }) +
              " KG </td>";

            let j = 0;
            let k = 0;
            let tiempo = 0;
            let turnonicial = "";
            let contadores = 0;
            vagonest1 = 0;
            vagonest2 = 0;
            vagonest3 = 0;

            horaturnouno = 0;
            vagporhorauno = 0;

            horaturnodos = 0;
            vagporhorados = 0;

            horaturnotres = 0;
            vagporhoratres = 0;

            let cabina = 0;
            let chorreo = 0;
            let finicio = "";
            let ffin = "";

            for (j = 0; j < data.length; j++) {
              if (data[j].sum_t > 0) {
                tiempo = tiempo + data[j].max_tiempo / 60;
                finicio = data[j].Fecha_mex;
                cabina += data[j].max_tiempo;
                chorreo +=
                  data[j].t_a1 +
                  data[j].t_a2 +
                  data[j].t_a3 +
                  data[j].t_a4 +
                  data[j].t_a5 +
                  data[j].t_a6 +
                  data[j].t_a7 +
                  data[j].t_a8 +
                  data[j].t_a9 +
                  data[j].t_a10 +
                  data[j].t_a11 +
                  data[j].t_a12;
                turnonicial = data[j].Turno;
                for (k = j + 1; k < data.length; k++) {
                  if (data[k].sum_t != 0) {
                    tiempo = tiempo + data[k].max_tiempo / 60;
                    cabina += data[k].max_tiempo;
                    chorreo +=
                      data[k].t_a1 +
                      data[k].t_a2 +
                      data[k].t_a3 +
                      data[k].t_a4 +
                      data[k].t_a5 +
                      data[k].t_a6 +
                      data[k].t_a7 +
                      data[k].t_a8 +
                      data[k].t_a9 +
                      data[k].t_a10 +
                      data[k].t_a11 +
                      data[k].t_a12;
                  } else {
                    contadores += 1;

                    if (contadores >= 2 && tiempo >= 20) {
                      if (turnonicial == "Turno 1") {
                        ffin = data[k].Fecha_mex;
                        hi = new Date(finicio);
                        hf = new Date(ffin);
                        var tiempo1 = new Date(hi);
                        var tiempo2 = new Date(hf);
                        var diferencia = tiempo2 - tiempo1;
                        var horas = Math.floor(diferencia / 3600000);
                        var minutos = Math.floor(
                          (diferencia % 3600000) / 60000
                        );
                        var hrs = horas + "." + minutos;
                        var min = hrs * 60;
                        horaturnouno += cabina / 60;
                        vagonest1 += 1;
                        document.getElementById(
                          "tablacabina"
                        ).style.backgroundColor = "#07B5E8";
                        document
                          .getElementById("tablacabina")
                          .insertRow(-1).innerHTML =
                          '<td  style="background-color:#07B5E8;" >' +
                          turnonicial +
                          '</td> <td style="background-color:#07B5E8;" >' +
                          finicio +
                          '</td> <td style="background-color:#07B5E8;" > ' +
                          ffin +
                          '</td> <td style="background-color:#07B5E8;" >' +
                          (cabina / 60).toFixed(0) +
                          ' MIN </td> <td style="background-color:#07B5E8;">' +
                          (chorreo / 60).toFixed(0) +
                          ' MIN</td> <td style="background-color:#07B5E8;" >' +
                          ((cabina / 60).toFixed(0) * noturbinasactivas -
                            (chorreo / 60).toFixed(0)) +
                          ' MIN </td> <td style="background-color:#07B5E8;" >' +
                          (
                            parseFloat(chorreo / 60) +
                            parseFloat(
                              (cabina / 60).toFixed(0) * noturbinasactivas -
                                (chorreo / 60).toFixed(0)
                            )
                          ).toFixed(0) +
                          ' MIN </td> <td style="background-color:#07B5E8;" >' +
                          min.toFixed(0) +
                          " MIN </td>";

                        cabina = 0;
                        chorreo = 0;
                      } else if (turnonicial == "Turno 2") {
                        ffin = data[k].Fecha_mex;
                        hi = new Date(finicio);
                        hf = new Date(ffin);
                        var tiempo1 = new Date(hi);
                        var tiempo2 = new Date(hf);
                        var diferencia = tiempo2 - tiempo1;
                        var horas = Math.floor(diferencia / 3600000);
                        var minutos = Math.floor(
                          (diferencia % 3600000) / 60000
                        );
                        var hrs = horas + "." + minutos;
                        var min = hrs * 60;
                        horaturnodos += cabina / 60;
                        vagonest2 += 1;
                        document
                          .getElementById("tablacabina")
                          .insertRow(-1).innerHTML =
                          '<td  style="background-color:#EC900D;" >' +
                          turnonicial +
                          '</td> <td style="background-color:#EC900D;" >' +
                          finicio +
                          '</td> <td style="background-color:#EC900D;" > ' +
                          ffin +
                          '</td> <td style="background-color:#EC900D;" >' +
                          (cabina / 60).toFixed(0) +
                          ' MIN </td> <td style="background-color:#EC900D;">' +
                          (chorreo / 60).toFixed(0) +
                          ' MIN</td> <td style="background-color:#EC900D;" >' +
                          ((cabina / 60).toFixed(0) * noturbinasactivas -
                            (chorreo / 60).toFixed(0)) +
                          ' MIN </td> <td style="background-color:#EC900D;" >' +
                          (
                            parseFloat(chorreo / 60) +
                            parseFloat(
                              (cabina / 60).toFixed(0) * noturbinasactivas -
                                (chorreo / 60).toFixed(0)
                            )
                          ).toFixed(0) +
                          ' MIN </td> <td style="background-color:#EC900D;" >' +
                          min.toFixed(0) +
                          " MIN </td>";
                        cabina = 0;
                        chorreo = 0;
                      } else if (turnonicial == "Turno 3") {
                        ffin = data[k].Fecha_mex;
                        hi = new Date(finicio);
                        hf = new Date(ffin);
                        var tiempo1 = new Date(hi);
                        var tiempo2 = new Date(hf);
                        var diferencia = tiempo2 - tiempo1;
                        var horas = Math.floor(diferencia / 3600000);
                        var minutos = Math.floor(
                          (diferencia % 3600000) / 60000
                        );
                        var hrs = horas + "." + minutos;
                        var min = hrs * 60;
                        horaturnotres += cabina / 60;
                        vagonest3 += 1;
                        document
                          .getElementById("tablacabina")
                          .insertRow(-1).innerHTML =
                          '<td  style="background-color:#DA90A4;" >' +
                          turnonicial +
                          '</td> <td style="background-color:#DA90A4;" >' +
                          finicio +
                          '</td> <td style="background-color:#DA90A4;" > ' +
                          ffin +
                          '</td> <td style="background-color:#DA90A4;" >' +
                          (cabina / 60).toFixed(0) +
                          ' MIN </td> <td style="background-color:#DA90A4;">' +
                          (chorreo / 60).toFixed(0) +
                          ' MIN</td> <td style="background-color:#DA90A4;" >' +
                          ((cabina / 60).toFixed(0) * noturbinasactivas -
                            (chorreo / 60).toFixed(0)) +
                          ' MIN </td> <td style="background-color:#DA90A4;" >' +
                          (
                            parseFloat(chorreo / 60) +
                            parseFloat(
                              (cabina / 60).toFixed(0) * noturbinasactivas -
                                (chorreo / 60).toFixed(0)
                            )
                          ).toFixed(0) +
                          ' MIN </td> <td style="background-color:#DA90A4;" >' +
                          min.toFixed(0) +
                          "</td>";
                        cabina = 0;
                        chorreo = 0;
                      }
                      contadores = 0;
                      tiempo = 0;
                      cabina = 0;
                      chorreo = 0;
                      j = k + 1;
                      break;
                    } else if (contadores >= 3) {
                      contadores = 0;
                      tiempo = 0;
                      cabina = 0;
                      chorreo = 0;
                      j = k + 1;
                      break;
                    }
                  }
                }
              }
            }

            horaturnouno = horaturnouno / 60;
            vagporhorauno = vagonest1 / horaturnouno.toFixed(2);

            horaturnodos = horaturnodos / 60;
            vagporhorados = vagonest2 / horaturnodos.toFixed(2);

            horaturnotres = horaturnotres / 60;
            vagporhoratres = vagonest3 / horaturnotres.toFixed(2);

            horaturatot = horaturnouno + horaturnodos + horaturnotres;
            vagontotal = vagonest1 + vagonest2 + vagonest3;

            if (isNaN(vagporhorauno)) {
              vagporhorauno = 0;
            }

            if (isNaN(vagporhorados)) {
              vagporhorados = 0;
            }

            if (isNaN(vagporhoratres)) {
              vagporhoratres = 0;
            }

            document.getElementById("tablaprod").insertRow(-1).innerHTML =
              "<td>Turno 1</td><td>" +
              vagonest1 +
              " Vag. </td> <td>" +
              horaturnouno.toFixed(2) +
              " Hrs </td> <td>" +
              vagporhorauno.toFixed(2) +
              " Va/h </td>";

            document.getElementById("tablaprod").insertRow(-1).innerHTML =
              "<td>Turno 2</td><td>" +
              vagonest2 +
              " Vag. </td> <td>" +
              horaturnodos.toFixed(2) +
              " Hrs </td> <td>" +
              vagporhorados.toFixed(2) +
              " Va/h </td>";

            document.getElementById("tablaprod").insertRow(-1).innerHTML =
              "<td>Turno 3</td><td>" +
              vagonest3 +
              " Vag. </td> <td>" +
              horaturnotres.toFixed(2) +
              " Hrs </td> <td>" +
              vagporhoratres.toFixed(2) +
              " Va/h </td>";

            document.getElementById("tablaprod").insertRow(-1).innerHTML =
              "<td>Total</td><td>" +
              (vagonest1 + vagonest2 + vagonest3) +
              " Vag. </td> <td>" +
              (horaturnouno + horaturnodos + horaturnotres).toFixed(2) +
              " Hrs </td> <td>" +
              (vagontotal / horaturatot).toFixed(2) +
              " Va/h </td>";

            presionlinea = presionlinea.substring(0, presionlinea.length - 1);
            tendencialinea = tendencialinea.substring(
              0,
              tendencialinea.length - 1
            );
            nivellinea = nivellinea.substring(0, nivellinea.length - 1);

            etiqueta = etiqueta.replace(/[']/g, "");

            const canvaslinea = document.getElementById("myChart");
            const ctxlineas = canvaslinea.getContext("2d");
            const myChart = new Chart(ctxlineas, {
              type: "line",
              data: {
                labels: etiqueta.split(","),
                datasets: [
                  {
                    label: "Pot 1",
                    yAxisID: "y1",
                    data: A1.split(","),
                    fill: false,
                    pointRadius: 5,
                    borderWidth: 3,
                    borderColor: "blue",
                    pointStyle: "dash",
                    showLine: true,
                  },
                  {
                    label: "Pot 2",
                    yAxisID: "y1",
                    data: A2.split(","),
                    fill: false,
                    pointRadius: 5,
                    borderWidth: 3,
                    borderColor: "red",
                    pointStyle: "dash",
                    showLine: true,
                  },
                  {
                    label: "Pot 3",
                    yAxisID: "y1",
                    data: A3.split(","),
                    fill: false,
                    pointRadius: 5,
                    borderWidth: 3,
                    borderColor: "cyan",
                    pointStyle: "dash",
                    showLine: true,
                  },
                  {
                    label: "Pot 4",
                    yAxisID: "y1",
                    data: A4.split(","),
                    fill: false,
                    pointRadius: 5,
                    borderWidth: 3,
                    borderColor: "olive",
                    pointStyle: "dash",
                    showLine: true,
                  },
                  {
                    label: "Pot 5",
                    yAxisID: "y1",
                    data: A5.split(","),
                    fill: false,
                    pointRadius: 5,
                    borderWidth: 3,
                    borderColor: "gold",
                    pointStyle: "dash",
                    showLine: true,
                  },
                  {
                    label: "Pot 6",
                    yAxisID: "y1",
                    data: A6.split(","),
                    fill: false,
                    pointRadius: 5,
                    borderWidth: 3,
                    borderColor: "purple",
                    pointStyle: "dash",
                    showLine: true,
                  },
                  {
                    label: "Pot 7",
                    yAxisID: "y1",
                    data: A7.split(","),
                    fill: false,
                    pointRadius: 5,
                    borderWidth: 3,
                    borderColor: "orange",
                    pointStyle: "dash",
                    showLine: true,
                  },
                  {
                    label: "Pot 8",
                    yAxisID: "y1",
                    data: A8.split(","),
                    fill: false,
                    pointRadius: 5,
                    borderWidth: 3,
                    borderColor: "pink",
                    pointStyle: "dash",
                    showLine: true,
                  },
                ],
              },
              options: {
                responsive: true,
                title: {
                  display: false,
                  text: "Encendido de mangueras",
                  fontSize: 30,
                  fontColor: "black",
                },
                legend: {
                  display: false,
                  labels: { fontSize: 18 },
                  fontColor: "Black",
                },
                scales: {
                  xAxes: [
                    {
                      ticks: {
                        fontStyle: "bold",
                        fontColor: "black",
                        fontSize: 10,
                      },
                    },
                  ],
                  yAxes: [
                    {
                      id: "y1",
                      display: true,
                      position: "right",
                      ticks: {
                        max: 10,
                        stepSize: 1,
                        min: 0,
                        fontStyle: "bold",
                        fontColor: "black",
                        fontSize: 12,
                        callback: (val) => {
                          return (val > 0) & (val <= 8) ? "POT " + val : null;
                        },
                      },
                    },
                    {
                      id: "y",
                      display: true,
                      position: "left",
                      ticks: {
                        max: 10,
                        stepSize: 1,
                        min: 0,
                        fontStyle: "bold",
                        fontColor: "black",
                        fontSize: 12,
                        callback: (val) => {
                          return (val > 0) & (val <= 8) ? "POT " + val : null;
                        },
                      },
                    },
                  ],
                },
              },
            });

            var ctxlinea = document
              .getElementById("myChartlecturas")
              .getContext("2d");
            var myChartlecturas = new Chart(ctxlinea, {
              type: "line", //Type of chart (e.g., bar, line, pie)
              data: {
                labels: etiqueta.split(","),

                datasets: [
                  {
                    datalabels: { display: true },
                    type: "line",
                    fill: false,
                    pointRadius: 0,
                    backgroundColor: "black",
                    borderWidth: 3,
                    borderColor: "black",
                    showLine: true,
                    label: "Lectura Presion",
                    yAxisID: "y",
                    data: presionlinea.split(","),
                  },
                  {
                    datalabels: { display: true },
                    type: "line",
                    fill: false,
                    pointRadius: 0,
                    backgroundColor: "orange",
                    borderWidth: 3,
                    borderColor: "orange",
                    showLine: true,
                    label: "Tendencia",
                    yAxisID: "y1",
                    data: tendencialinea.split(","),
                  },
                  {
                    datalabels: { display: true },
                    type: "line",
                    fill: true,
                    pointRadius: 0,
                    backgroundColor: "lightblue",
                    borderWidth: 1,
                    borderColor: "blue",
                    label: "Nivel Silo",
                    yAxisID: "y1",
                    data: nivellinea.split(","),
                  },
                ],
              },
              options: {
                responsive: true,
                title: {
                  display: true,
                  text: "",
                  fontSize: 10,
                  fontColor: "black",
                },
                spanGaps: true,
                legend: {
                  display: true,
                  labels: { fontSize: 8 },
                  fontColor: "Black",
                },
                scales: {
                  xAxes: [
                    {
                      ticks: {
                        fontStyle: "bold",
                        fontColor: "black",
                        fontSize: 11,
                      },
                    },
                  ],
                  yAxes: [
                    {
                      id: "y",
                      display: true,
                      position: "left",
                      ticks: {
                        max: 100,
                        min: 0,  //limite inferior grafica presion
                        stepSize: 10,
                        fontStyle: "bold",
                        fontColor: "black",
                        fontSize: 10,
                        callback: (val) => {
                          return val + " PSI";
                        },
                      },
                    },
                    {
                      id: "y1",
                      display: true,
                      position: "right",
                      ticks: {
                        max: 250,
                        min: 20,
                        fontStyle: "bold",
                        fontColor: "black",
                        fontSize: 10,
                        callback: (val) => {
                          return val + "cms";
                        },
                      },
                    },
                  ],
                },
              },
            });

            var ctxdona = document
              .getElementById("myChartdona")
              .getContext("2d");
            var myChartdona = new Chart(ctxdona, {
              type: "doughnut",
              data: {
                datasets: [
                  {
                    data: [
                      (tmax / 3600).toFixed(1),
                      0,
                      24 - (tmax / 3600).toFixed(1),
                    ],
                    backgroundColor: ["lightblue", "gray", "red"],
                    color: "black",
                  },
                ],
                labels: ["Granallado", "Sopleteo", "Tiempo Inactivo"],
              },
              options: {
                responsive: true,
                legend: { labels: { fontSize: 12 } },
                title: {
                  fontColor: "black",
                  display: true,
                  text:
                    "Distribucion del tiempo del dia: " +
                    fechacontulta.toLocaleString("en-US").split(",")[0],
                  fontSize: 12,
                },
                plugins: {
                  doughnutlabel: {
                    labels: [
                      { text: "24", font: { size: 25 } },
                      { text: "Horas del dia", font: { size: 25 } },
                    ],
                  },
                  datalabels: {
                    display: true,
                    formatter: (value) => {
                      return value + "hrs";
                    },
                    color: "black",
                    font: { size: 15 },
                  },
                },
              },
            });

            document.getElementById('contentenedores').style.display = 'none';
          },

          error: function (response) {
            ocultarLoader();
          },
        });
      },
      error: function (response) {
        contador = 0;
        ocultarLoader();
      },
    });
  } else {

    var tabladatosbatch = $("#tabladatosbatch tr").length - 1;

    if (tabladatosbatch > 1) {
      for (j = tabladatosbatch; j > 0; j--) {
        document.getElementById("tabladatosbatch").deleteRow(j);
      }
    }

    document.getElementById("tabladatosbatch").insertRow(-1).innerHTML =
      "<td colspan='2' class='text-center'>" +
      document.getElementById("Nombmaq").innerHTML +
      "</td>";
    document.getElementById("tabladatosbatch").insertRow(-1).innerHTML =
      "<td>Maquina de granallado  " +
      descripcion +
      "</td> <td>Fecha: " +
      fechacontulta.toLocaleString("es-MX").split(",")[0] +
      "</td>";

    $(".modal-header").css("background-color", "#07B5E8");

    if (Opera == 0) {
      tiporeporte = "Reporte_Actual";
      $(".modal-title").text("Reporte Granallado Del Día");
    } else {
      tiporeporte = "Reporte_Diario";
      $(".modal-title").text("Reporte Granallado Diario");
    }

    $("#ModalRepbatch").modal("show");

    totales = 0;

    $.ajax({
      url: "modelos/contar_reportedia.php",
      type: "POST",
      data: {
        ID_procesador: ID_procesador,
        fecha: fechacontulta.toLocaleString("en-US").split(",")[0],
      },
      dataType: "json",

      beforeSend: function (response) {
        mostrarLoader();
      },

      complete: function (response) {
        ocultarLoader();
      },

      success: function (data) {
        totales = 0;
        totales = data;

        document.getElementById("tablaresoper").insertRow(-1).innerHTML =
          "<td colspan='6'>Resumen De Operación</td>";
        document.getElementById("tablaresoper").insertRow(-1).innerHTML =
          "<td>Valores Diarios</td> <td>Valores Mes</td> <td>Valores Historicos</td>";
        document.getElementById("tablaresoper").insertRow(-1).innerHTML =
          "<td>Ciclos/día</td> <td>444</td> <td>Ciclos/Mes</td> <td>8,438</td> <td>Total Ciclos</td> <td>56,936</td>";

        $.ajax({
          url: "modelos/reportdiabatch.php",
          type: "POST",
          data: {
            ID_procesador: ID_procesador,
            contador: totales,
            fecha: fechacontulta.toLocaleString("en-US").split(",")[0],
          },
          dataType: "json",

          beforeSend: function (response) {},

          complete: function (response) {
            ocultarLoader();
          },

          success: function (data) {
            var cont = 0;
            for (var i = 0; i < data.length; i++) {
              if (data[i].prom_Amp != "null") {
                cont += 1;
                amppromedio += data[i].prom_Amp;
                horometro += data[i].prom_D;
              }
            }
            // console.log(amppromedio);
            // console.log(cont);
            // console.log(horometro/3600);

            // document.getElementById("tablaresoper").insertRow(-1).innerHTML =
            //   "<td>Amp. Medio </td> <td> " +
            //   (amppromedio / cont).toFixed(2) +
            //   " </td>";
            // document.getElementById("tablaresoper").insertRow(-1).innerHTML =
            //   "<td>Horometro </td> <td> " +
            //   (horometro / 3600).toFixed(2) +
            //   " </td>";

            $.ajax({
              url: "modelos/granalladia.php",
              type: "POST",
              data: {
                nombre: ID_procesador,
              },
              dataType: "json",

              beforeSend: function (response) {},

              complete: function (response) {
                ocultarLoader();
              },

              success: function (data) {
                for (var i = 0; i < data.length; i++) {
                  if (data[i].horometro != "") {
                    granalladias = data[i].horometro + horometro / 3600;
                  } else {
                    granalladias = horometro / 3600;
                  }
                }
                // document
                //   .getElementById("tablaresoper")
                //   .insertRow(-1).innerHTML =
                //   "<td>Granalla/Dia </td> <td> " +
                //   granalladias.toFixed(2) +
                //   " KG </td>";
              },
            });


              var fmes="";
              fmes=fechacontulta.toLocaleString("en-US").split(",")[0];
              const splitString = fmes.split("/");
              const mesanio= splitString[2] + zfill(splitString[0] , 2);
             $.ajax({
               url: "modelos/contar_reportemes.php",
               type: "POST",
               data: {
                 ID_procesador: ID_procesador,
                 fecha: mesanio,
               },
               dataType: "json",
        
               beforeSend: function (response) {
                 mostrarLoader();
               },
        
               complete: function (response) {
                 ocultarLoader();
               },
        
               success: function (data) {
                 totales = 0;
                 totales = data;
            

                //  x.style.display = "none";


               

            
                 document.getElementById('contentenedores').style.display = 'none';
        
                //  document.getElementById("tablaresoper").insertRow(-1).innerHTML =
                //    "<td colspan='6'>Resumen De Operación</td>";
                //  document.getElementById("tablaresoper").insertRow(-1).innerHTML =
                //    "<td>Valores Diarios</td> <td>Valores Mes</td> <td>Valores Historicos</td>";
                //  document.getElementById("tablaresoper").insertRow(-1).innerHTML =
                //    "<td>Ciclos/día</td> <td>444</td> <td>Ciclos/Mes</td> <td>8,438</td> <td>Total Ciclos</td> <td>56,936</td>";

                // $.ajax({
                //   url: "modelos/reportdiabatchmes.php",
                //   type: "POST",
                //   data: {
                //     ID_procesador: ID_procesador,
                //     contador: totales,
                //     fecha: mesanio,
                //   },
                //   dataType: "json",
    
                //   beforeSend: function (response) {},
    
                //   complete: function (response) {
                //     ocultarLoader();
                //   },
    
                //   success: function (data) {
                //     console.log(data);
               
              
                //   },
                // });





                
               },
               error: function (response) {
                 console.log(response);
                 contador = 0;
                 ocultarLoader();
               },
             });




          },
        });
      },
      error: function (response) {
        console.log(response);
        contador = 0;
        ocultarLoader();
      },
    });



  }


}

function saveBase64ImageToFile(base64Data, fileName) {
  const link = document.createElement("a");
  link.href = base64Data;
  link.download = fileName;
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}

$btnEnviar.onclick = async () => {
  const tabla = document.getElementById("tablacabina");
  const filas = tabla.getElementsByTagName("tr");
  const datos = [];
  for (let i = 1; i < filas.length; i++) {
    const celdas = filas[i].getElementsByTagName("td");
    const turno = celdas[0].innerText;
    const inicio = celdas[1].innerText;
    const fin = celdas[2].innerText;
    const tiempocabina = celdas[3].innerText;
    const tiempochorreo = celdas[4].innerText;
    const tiempoperdido = celdas[5].innerText;
    const tiemporeal = celdas[6].innerText;
    const tiempoincativo = celdas[7].innerText;
    let color = "";
    if (turno == "Turno 1") {
      color = "#07B5E8";
    } else if (turno == "Turno 2") {
      color = "#EC900D";
    } else if (turno == "Turno 3") {
      color = "#DA90A4";
    }
    const filaDatos = {
      turno,
      inicio,
      fin,
      tiempocabina,
      tiempochorreo,
      tiempoperdido,
      tiemporeal,
      tiempoincativo,
      color,
    };
    datos.push(filaDatos);
  }

  const chartline = document.getElementById("myChart");
  const datapots = chartline.toDataURL("image/png", 1);

  const chartlectura = document.getElementById("myChartlecturas");
  const datalectura = chartlectura.toDataURL("image/png", 1);

  const chartdona = document.getElementById("myChartdona");
  const datadona = chartdona.toDataURL("image/png", 1);

  const fd = new FormData();
  fd.append("pots", datapots);
  fd.append("lectura", datalectura);
  fd.append("dona", datadona);
  fd.append("cliente", cliente);
  fd.append("descripcion", descripcion);
  fd.append("vagonuno", vagonest1);
  fd.append("vagondos", vagonest2);
  fd.append("vagontres", vagonest3);
  fd.append("pot1", totpropot1);
  fd.append("pot2", totpropot2);
  fd.append("pot3", totpropot3);
  fd.append("pot4", totpropot4);
  fd.append("pot5", totpropot5);
  fd.append("pot6", totpropot6);
  fd.append("pot7", totpropot7);
  fd.append("pot8", totpropot8);
  fd.append("presioprom", propresion.toFixed(0));
  fd.append(
    "mingranillado",
    granallomin
      .toLocaleString("en-US", { maximumFractionDigits: 0 })
      .toLocaleString("en-US", { maximumFractionDigits: 0 })
  );
  fd.append(
    "granallodia",
    granallodia.toLocaleString("en-US", { maximumFractionDigits: 0 })
  );
  fd.append(
    "maquina",
    GranallaMaq.toLocaleString("en-US", { maximumFractionDigits: 0 })
  );

  fd.append("hruno", horaturnouno.toFixed(2));
  fd.append("hrdos", horaturnodos.toFixed(2));
  fd.append("hrtres", horaturnotres.toFixed(2));
  fd.append("hrtot", (horaturnouno + horaturnodos + horaturnotres).toFixed(2));

  fd.append("vaghruno", vagporhorauno.toFixed(2));
  fd.append("vaghrdos", vagporhorados.toFixed(2));
  fd.append("vaghrtres", vagporhoratres.toFixed(2));
  fd.append("vaghrtot", (vagontotal / horaturatot).toFixed(2));
  fd.append("tiporeporte", tiporeporte);
  fd.append("fechareporte", fechareporte);
  fd.append("tabla", JSON.stringify(datos));

  const respuestaHttp = await fetch("modelos/graficas.php", {
    method: "POST",
    body: fd,
  });

  var options = {
    width: "100%",
    height: "100vh",
  };
  NomPdf = "";
  fecha = convertDateToISOFormat(fechareporte);
  NomPdf = "pdf/" + tiporeporte + "_" + descripcion + "_" + fecha + ".pdf";
  $("#Modalpdf").modal("show");
  var viewpdf = $("#reportepdf");
  PDFObject.embed(NomPdf, viewpdf, options);
  // inicio();
};


function convertDateToISOFormat(dateString) {
  const parts = dateString.split("/");
  if (parts.length !== 3) {
    throw new Error("Invalid date format. Use dd/mm/yyyy.");
  }

  const day = parts[0].padStart(2, "0");
  const month = parts[1].padStart(2, "0");
  const year = parts[2];

  return `${month}-${day}-${year}`;
}

function zfill(number, width) {
  var numberOutput = Math.abs(number); /* Valor absoluto del número */
  var length = number.toString().length; /* Largo del número */ 
  var zero = "0"; /* String de cero */  
  
  if (width <= length) {
      if (number < 0) {
           return ("-" + numberOutput.toString()); 
      } else {
           return numberOutput.toString(); 
      }
  } else {
      if (number < 0) {
          return ("-" + (zero.repeat(width - length)) + numberOutput.toString()); 
      } else {
          return ((zero.repeat(width - length)) + numberOutput.toString()); 
      }
  }
}


$("#ModalReportedia").on("hidden.bs.modal", function () {
  alert("Adios");
});
