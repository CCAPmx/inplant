const btnprov = document.getElementById("btnnewproyect");
const btnguardar = document.getElementById("btnguardar");

const txtFk = document.getElementById('txtFk');
const txtpks = document.getElementById('txtpks');
const txtproyecto = document.getElementById('txtproyecto');
const txtfechahoy = document.getElementById('txtfechahoy');
const txtcantidad = document.getElementById('txtcantidad');
const txtproducidos = document.getElementById('txtproducidos');
const txttipovagon = document.getElementById('txttipovagon');
const txtproducto = document.getElementById('txtproducto');

const tiempoTranscurrido = Date.now();
const hoy = new Date(tiempoTranscurrido);
var contador = 0;
var limit = 0;
var offset = 1;
var sum = 0;
var cantidad = 0;
var totalPages = 0;
var spanPagina = document.getElementById("txtPag");




var pk = $.trim(document.getElementById("txtpk").value);



$(document).ready(function () {

  $('#cbmtipo').select2({
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
    dropdownParent: $('#ModalProyecto')
});

    document.getElementById('txtfechahoy').value=hoy.toLocaleDateString();
    
 
btnprov.addEventListener("click", handleClick);

btnguardar.addEventListener("click", Guardar);

  if (pk==""){
    pk = localStorage.getItem('pk');
  
    
  }else{
    pk = $.trim(document.getElementById("txtpk").value);
  }
  
  ocultarLoader();
  obtenerInfo(pk);

 

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
    url: "modelos/contarproyectos.php",
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




        $.ajax({
            url: "modelos/obtenerfkcliente.php",
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
                debugger;
                // console.log(data[0]["pk"]);
                document.getElementById('txtpks').value=data[0]["pk"];
        
        
            },
            error: function (response) {
              // window.location ="salir";
            },
          });




        

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


function obtenerCombo(pk) {
  $.ajax({
    url: "modelos/obtenervagones.php",
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
        $('#cbmtipo').append(
          `<option value="Ninguno"  selected="selected">Seleccione</option>`
      );       

      for (var i = 0; i < data.length; i++) {

        $('#cbmtipo').append(
          `<option value="${data[i].pk}">${data[i].descripcion}</option>`
      );       

        
      }
      // console.log(data);


    },
    error: function (response) {
      // window.location ="salir";
    },
  });
}




function generatePageNumbers(totalPages, currentPage) {
  const paginationElement = document.getElementById("paginationproy");
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
    url: "modelos/proyectos.php",
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
      $("#tablaproyectos > tbody").empty();
      var html = "";

      for (var i = 0; i < data.length; i++) {
        html +=
          "<tr>" +

          '<td style="text-align:center">' +
          data[i].fecha +
          "</td>" +

          '<td style="text-align:center">' +
          data[i].producto +
          "</td>" +

          '<td style="text-align:center">' +
          data[i].Proyecto +
          "</td>" +
         
          '<td style="text-align:center;display:none;">' +
          data[i].fkCliente +
          "</td>" +

          '<td  style="text-align:center">' +
          accounting.formatMoney(data[i].cantidad, "", 0, ",", ".") +
          "</td>" +

          '<td  style="text-align:center">' +
          data[i].producidos +
          "</td>" +

          '<td style="text-align:center;display:none;">' +
          data[i].fk_cliente_lersoft +
          "</td>" +

          '<td style="text-align:center;display:none;">' +
          data[i].fk_tipo_vagon +
          "</td>" +
          
         

          "</tr>";
      }
      $("#DataProyectos").html(html);

    //   document.getElementById('Iniciosuper').style.display = 'none';
    //   document.getElementById('Usuariosuper').style.display = 'none';
    //   document.getElementById('Maquinasuper').style.display = 'none';
    //   document.getElementById('Granallasuper').style.display = 'none';
    //   document.getElementById('Clientesuper').style.display = 'none';
    //   document.getElementById('Produccionsuper').style.display = 'none';
    //   document.getElementById('Bodegasuper').style.display = 'none';
    //   document.getElementById('Mantenimientosuper').style.display = 'none';
    //   document.getElementById('Direccionsuper').style.display = 'none';
    //   document.getElementById('Granulometriasuper').style.display = 'none';
    //   document.getElementById('Contactosuper').style.display = 'none';
    //   document.getElementById('Salirsuper').style.display = 'none';
    
    //   document.getElementById('InicioJefe').style.display = 'block';
    //   document.getElementById('PedidosJefe').style.display = 'block';
    //   document.getElementById('MaquinasJefe').style.display = 'block';
    //   document.getElementById('ProduccionJefe').style.display = 'block';
    //   document.getElementById('EstadoJefe').style.display = 'block';
    //   document.getElementById('SalirJefe').style.display = 'block';
    },
    error: function (response) {
      // alert(error con la petición);
    },
  });
}


 function handleClick() {
  obtenerCombo(pk)
  $(".modal-header").css("background-color", "#07B5E8");
  $(".modal-title").text("Nuevo Proyecto");
  document.getElementById('txtcantidad').value="0";
  document.getElementById('txtcantidad').focus();
  document.getElementById('txtcantidad').select();
    $("#ModalProyecto").modal("show");
 
 }

 function Guardar() {
    debugger;
    var Tipo = $('#cbmtipo').select2('data');
  
    
    if (document.getElementById('txtcantidad').value==0 || document.getElementById('txtcantidad').value==""){
      Swal.fire({
        icon: "error",
        title: "Error La Cantidad Debe Ser Mayor A Cero",
        showConfirmButton: false,
        timer: 1500,
      });
      return false;
    }
    if (Tipo[0].text=="" || Tipo[0].text=="Seleccione"){
      Swal.fire({
        icon: "error",
        title: "Error Seleccione Un Producto",
        showConfirmButton: false,
        timer: 1500,
      });
      return false;
    }
    if (document.getElementById('txtproyecto').value==""){
      Swal.fire({
        icon: "error",
        title: "Error Favor De Ingresar un Proyecto",
        showConfirmButton: false,
        timer: 1500,
      });
      return false;
    }

   
   $.ajax({
     url: "modelos/insertarproyecto.php",
     type: "POST",
     data: { Proyecto: txtproyecto.value,
           fecha: txtfechahoy.value, 
           fkCliente: txtpks.value, 
           cantidad: parseFloat(txtcantidad.value),
           producidos: parseFloat(0),
           fk_cliente_lersoft: txtFk.value,
           fk_tipo_vagon: Tipo[0].id,
           producto: Tipo[0].text},
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
      
         // console.log(data[0]["pk"]);
         if(data[0]["message"]==="OK"){

           $("#ModalProyecto").find("input,textarea,select").val("");
           $("#ModalProyecto").modal("hide");
           Swal.fire({
             icon: "success",
             title: "Registro Ingresado Correctamente",
             showConfirmButton: false,
             timer: 1500,
           });
           location.reload(true);
         };


     },
     error: function (response) {
       console.log(response);
       // window.location ="salir";
     },
   });



   
  }


  //  $('#cbmtipo').on('select2:select', function (e) {
  //   debugger;
  //   var data = e.params.data;
  //   console.log(data);
  // }); 




