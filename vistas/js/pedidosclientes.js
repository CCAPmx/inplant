var tbordenpedido = null;
var tbpedidosclien = null;
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
var statustrans=document.getElementById("statustranspor");
var subtotal =0;
var total = 0;
var contar=0;

var Orden = 0;
var ordenpedido = ""
var moneda =""
var transporte =""


var pk = $.trim(document.getElementById("txtpk").value);



$(document).ready(function () {
 
  
 

  if (pk==""){
    pk = localStorage.getItem('pk');
  
    
  }else{
    pk = $.trim(document.getElementById("txtpk").value);
  }
  
  ocultarLoader();
  obtenerInfo(pk);

  $("#Modalpedidos").on("hidden.bs.modal", function (e) {
    tbordenpedido.destroy();
  });

  $(".currency-mx").each(function () {
    var monetary_value = $(this).text();
    var i = new Intl.NumberFormat("es-MX", {
      style: "currency",
      currency: "MX",
    }).format(monetary_value);
    $(this).text(i);
  });

  $("#tablaDatos").tablesorter();
  $("#tablaDatos").tablesorterPager({
    container: $("#paginacion"),
    size: 10, // Número de filas por página
    output: "{startRow} - {endRow} / {filteredRows} ({totalRows})", // Formato de salida para la información de paginación
  });

  



});

function obtenerInfo(pk) {
  $.ajax({
    url: "modelos/contarpedidos.php",
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
        generatePageNumbers(totalPages, currentPage);
      }
      ocultarLoader();
    },
    error: function (response) {
      console.log(response)
      // spanElement.innerText = "Sin Información";
      // ocultarLoader();
      // Swal.fire({
      //   position: 'center',
      //   icon: 'error',
      //   title: 'Se Cierra Sesion',
      //   showConfirmButton: false,
      //   timer: 2500
      // })
      // window.location ="salir";
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
        "Registro 1 al " + offset * 10 + " De " + cantidad;
    }

    pageNumber.addEventListener("click", function (e) {
    
      e.preventDefault();
      // e.target.style.background ="#def7ff";
      limit = 10;
      offset = 0;

      offset = (i - 1) * 10 + 1;

      // if (i===1){
      //   offset=1;
      // }else{
      //   // offset= (i * 10) +1 ;
      //   offset (Numero pagina -1)10 +1
      // }

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

function tabla(pk, limit, offset) {
  $.ajax({
    url: "modelos/pedclient.php",
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
      $("#tablaped > tbody").empty();
      var html = "";

      for (var i = 0; i < data.length; i++) {
        html +=
          "<tr>" +
          '<td style="text-align:center">' +
          data[i].Fecha +
          "</td>" +
          '<td style="text-align:center">' +
          data[i].Orden +
          "</td>" +
          '<td  style="text-align:right;visibility:collapse; display:none">' +
          accounting.formatMoney(data[i].Total, "$ ", 2, ",", ".") +
          "</td>" +
          '<td  style="text-align:center;visibility:collapse; display:none">' +
          data[i].Moneda +
          "</td>" +
          '<td  style="display:none;">' +
          data[i].pk +
          "</td>" +
          '<td style="text-align:center">' +
          data[i].Status +
          "</td>" +
          '<td style="display:none;">' +
          data[i].Transporte +
          "</td>" +
          '<td style="text-align:center"> <div class="text-center"><button class="btn btn-outline-info btn-sm" onclick="obtenerValor(this)"><i class="fa-solid fa-eye"></i></button></div>' +
          "</td>" +
          "</tr>";
      }
      $("#DataPedidos").html(html);
      document.getElementById('Iniciosuper').style.display = 'none';
      document.getElementById('Usuariosuper').style.display = 'none';
      document.getElementById('Maquinasuper').style.display = 'none';
      document.getElementById('Granallasuper').style.display = 'none';
      document.getElementById('Clientesuper').style.display = 'none';
      document.getElementById('Produccionsuper').style.display = 'none';
      document.getElementById('Bodegasuper').style.display = 'none';
      document.getElementById('Mantenimientosuper').style.display = 'none';
      document.getElementById('Direccionsuper').style.display = 'none';
      document.getElementById('Granulometriasuper').style.display = 'none';
      document.getElementById('Contactosuper').style.display = 'none';
      document.getElementById('Salirsuper').style.display = 'none';
    
      document.getElementById('InicioJefe').style.display = 'block';
      document.getElementById('PedidosJefe').style.display = 'block';
      document.getElementById('MaquinasJefe').style.display = 'block';
      document.getElementById('ProduccionJefe').style.display = 'block';
      document.getElementById('EstadoJefe').style.display = 'block';
      document.getElementById('SalirJefe').style.display = 'block';
    },
    error: function (response) {
      // alert(error con la petición);
    },
  });
}

function obtenerValor(el){
  var index = $(el).closest("tr").index()

  var table = document.getElementById('tablaped');
     

  Orden = table.rows[index + 1].cells[1].innerText;
  ordenpedido = table.rows[index + 1].cells[4].innerText;
  moneda = table.rows[index + 1].cells[3].innerText;
  total = table.rows[index + 1].cells[2].innerText;
  transporte= table.rows[index + 1].cells[6].innerText;
  $.ajax({
     url: "modelos/ordenventa.php",
     type: "POST",
     data: { pk: ordenpedido},
     dataType: "json",
     success: function (data) {
       var html = "";
       subtotal=  0;
       total= 0;
       // var i;
       for (var i = 0; i < data.length; i++) {
         contar += 1;
         subtotal += parseFloat(data[i].PU);
         total += parseFloat(data[i].total);
         html +=
           "<tr>" +
           "<td>" +
           data[i].ID_lersan +
           "</td>" +
           "<td>" +
           data[i].descripcion_producto +
           "</td>" +
           '<td  style="text-align:center">' +
           parseFloat(data[i].cantidad) +
           "</td>" 
          //  +'<td  style="text-align:right">' +
          //  accounting.formatMoney(
          //    parseFloat(data[i].PU),
          //    "$ ",
          //    2,
          //    ",",
          //    "."
          //  ) +
          //  "</td>" +
          //  '<td  style="text-align:right">' +
          //  accounting.formatMoney(
          //    parseFloat(data[i].total),
          //    "$ ",
          //    2,
          //    ",",
          //    "."
          //  ) +
          //  "</td>" +
           "</tr>";
       }
      //  if ((contar = 1)) {
      //    html +=
      //      "<tr>" +
      //      '<td colspan="4" style="text-align:right">Sub Total</td>' +
      //      '<td  style="text-align:right">' +
      //      accounting.formatMoney(total, "$ ", 2, ",", ".") +
      //      "</td>" +
      //      "</tr>";

      //    iva = parseFloat(total * 0.16);

      //    html +=
      //      "<tr>" +
      //      '<td colspan="4" style="text-align:right">IVA</td>' +
      //      '<td  style="text-align:right">' +
      //      accounting.formatMoney(iva, "$ ", 2, ",", ".") +
      //      "</td>" +
      //      "</tr>";

      //    html +=
      //      "<tr>" +
      //      '<td colspan="4" style="text-align:right">' +
      //      moneda +
      //      " Total</td>" +
      //      '<td  style="text-align:right">' +
      //      accounting.formatMoney(
      //        parseFloat(total + iva),
      //        "$ ",
      //        2,
      //        ",",
      //        "."
      //      ) +
      //      "</td>" +
      //      "</tr>";
      //    $("#DataResult").html(html);
      //  } else if (contar > 1) {
      //    html +=
      //      "<tr>" +
      //      '<td colspan="4" style="text-align:right">Sub Total</td>' +
      //      '<td  style="text-align:right">' +
      //      accounting.formatMoney(parseFloat(subtotal), "$ ", 2, ",", ".") +
      //      "</td>" +
      //      "</tr>";

      //    iva = parseFloat(subtotal * 0.16);

      //    html +=
      //      "<tr>" +
      //      '<td colspan="4" style="text-align:right">IVA</td>' +
      //      '<td  style="text-align:right">' +
      //      accounting.formatMoney(iva, "$ ", 2, ",", ".") +
      //      "</td>" +
      //      "</tr>";

      //    html +=
      //      "<tr>" +
      //      '<td colspan="4" style="text-align:right">' +
      //      moneda +
      //      " Total</td>" +
      //      '<td  style="text-align:right">' +
      //      accounting.formatMoney(
      //        parseFloat(subtotal + iva),
      //        "$ ",
      //        2,
      //        ",",
      //        "."
      //      ) +
      //      "</td>" +
      //      "</tr>";
      //    $("#DataResult").html(html);
      //  } else {
      //    html +=
      //      "<tr>" +
      //      '<td colspan="5" style="text-align:right">SIN INFORMACION</td>' +
      //      "</tr>";
      //    $("#DataResult").html(html);
      //  }

      $("#DataResult").html(html);
       statustranspor.textContent = "Status del Transporte - " + transporte;
       
       $(".modal-header").css("background-color", "#07B5E8");
       $(".modal-title").text("Lista de Empaque: " + Orden );
       $("#Modalpedidos").modal("show");
     },
   });
  


}