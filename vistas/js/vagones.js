
const btnguardarvag = document.getElementById("btnguardarvag");
const btngranallado = document.getElementById("btngranallado");
const btncorregir = document.getElementById("btncorregir");

const txtSerie= document.getElementById("txtSerie");
const txtCliente= document.getElementById("txtCliente");
const txtTipovag = document.getElementById("txtTipovag");
const txtpkproy = document.getElementById("txtpkproy");
const txtProyectos = document.getElementById("txtProyectos");
const txtFkvag = document.getElementById("txtFkvag");
// const txtProyectos = document.getElementById("txtProyectos");

var contador = 0;
var limit = 0;
var offset = 1;
var sum = 0;
var cantidad = 0;
var totalPages = 0;
var spanPagina = document.getElementById("txtPag");




var pk = $.trim(document.getElementById("txtpk").value);



$(document).ready(function () {


  $('#cbmmaquinavag').select2({
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
    // allowClear: true
  });

  $('#cbmproy').select2({
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
    // allowClear: true
  });


  btnguardarvag.addEventListener("click", GuardarVag);
  btngranallado.addEventListener("click", GuardarGranlla);
  btncorregir.addEventListener("click", Corregir);

  if (pk==""){
    pk = localStorage.getItem('pk');
  
    
  }else{
    pk = $.trim(document.getElementById("txtpk").value);
  }
  

  obtenerCombo(pk);
  obtenerproy(pk);

  $(".currency-mx").each(function () {
    var monetary_value = $(this).text();
    var i = new Intl.NumberFormat("es-MX", {
      style: "currency",
      currency: "MX",
    }).format(monetary_value);
    $(this).text(i);
  });


  $('#cbmproy').change(function(){
   
    var getID = $(this).select2('data');
    txtpkproy.value=getID[0]['id'];
   
       $.ajax({
         url: "modelos/obtenerproyectosinfo.php",
         type: "POST",
         data: {
          pk: getID[0]['id'],
         },
         dataType: "json",
         beforeSend: function (response) {},
         complete: function (response) {},
         success: function (data) {
          // obtenerCombo(data[0].fkCliente);
          txtCliente.value=data[0].fkCliente;
          txtTipovag.value=data[0].fk_tipo_vagon;
          txtProyectos.value=data[0].Proyecto;
         },
         error: function (response) {
           contador = 0;
           ocultarLoader();
         },
       });


    document.getElementById('txtSerie').focus();
    document.getElementById('txtSerie').value = '';

  });

  $('#cbmmaquinavag').change(function(){
    
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
    

    var Maquina = $('#cbmmaquinavag').select2('data');

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
        console.log(data);
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
        console.log(response);
         ocultarLoader();
      },
    });
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
    },
    complete: function (response) {
    },

    success: function (data) {
      $("#tablaproyec > tbody").empty();
      var html = "";

      for (var i = 0; i < data.length; i++) {
        html +=
          "<tr>" +

          '<td style="text-align:center">' +
          data[i].fecha +
          "</td>" +

          '<td style="text-align:center">' +
          data[i].Proyecto +
          "</td>" +
         
          '<td style="text-align:center">' +
          data[i].fkCliente +
          "</td>" +

          '<td  style="text-align:center">' +
          accounting.formatMoney(data[i].cantidad, "", 2, ",", ".") +
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
          
          '<td style="text-align:center">' +
          data[i].producto +
          "</td>" +

          '<td style="text-align:center;display:none;">' +
          data[i].pk +
          "</td>" +

          "</td>" +
          '<td style="text-align:center"> <div class="text-center"><button class="btn btn-outline-info btn-sm" onclick="obtenerVagones(this)"><i class="fab fa-vine"></i></button></div>' +
          "</td>" +

          "</tr>";

          
      }
      $("#DataProyec").html(html);
      ocultarLoader();
    },
    error: function (response) {
      alert("error con la petición");
    },
  });
}

function obtenerVagones (el) {
    
    var index = $(el).closest("tr").index();
  
    var table = document.getElementById("tablaproyec");


    var fecha="";
    var proyecto ="";
    var fkCliente="";
    var cantidad=0;
    var producidos =0;
    var fk_cliente_lersoft=0;
    var fk_tipo_vagon="";
    var producto="";
    var pk="";
    fecha = table.rows[index + 1].cells[0].innerText;
    proyecto = table.rows[index + 1].cells[1].innerText;
    fkCliente = table.rows[index + 1].cells[2].innerText;
    cantidad = table.rows[index + 1].cells[3].innerText;
    producidos = table.rows[index + 1].cells[4].innerText;
    fk_cliente_lersoft = table.rows[index + 1].cells[5].innerText;
    fk_tipo_vagon = table.rows[index + 1].cells[6].innerText;
    producto = table.rows[index + 1].cells[7].innerText;
    pk= table.rows[index + 1].cells[8].innerText;
    // if (Maquina == "Presion") {
    //   $.ajax({
    //     url: "modelos/ontenergranalla.php",
    //     type: "POST",
    //     data: {
    //       nombre: nombre,
    //     },
    //     dataType: "json",
    //     beforeSend: function (response) {},
    //     complete: function (response) {},
  
    //     success: function (data) {
    //       granalla = 0;
    //       granalla = data[0].consumo_granalla_hora;
    //       alturasilo = data[0].altura_silo;
    //       granallazonamuerta = data[0].granalla_zona_muerta;
    //       granalla_pots = data[0].granalla_pots;
    //       noturbinasactivas = data[0].no_turbinas_activas;
    //       descripcion = data[0].descripcion;
    //       cliente = data[0].cliente;
    //     },
    //     error: function (response) {
    //       contador = 0;
    //       ocultarLoader();
    //     },
    //   });
  
        // document.getElementById("txtCliente").value=fkCliente;
        // document.getElementById("txtTipovag").value=fk_tipo_vagon;
        // document.getElementById("txtProyectos").value=proyecto;
        // document.getElementById("txtpkproy").value=pk;
        

        obtenerCombo(fkCliente);
        
    
       
    // } else if (Maquina == "Batch" || Maquina == "Tunel") {
    //   $.ajax({
    //     url: "modelos/obtenerdatos.php",
    //     type: "POST",
    //     data: {
    //       nombre: nombre,
    //     },
    //     dataType: "json",
    //     beforeSend: function (response) {},
    //     complete: function (response) {},
    //     success: function (data) {
    //       document.getElementById("tablamaquina").insertRow(-1).innerHTML =
    //         "<td colspan='6' class='text-center'> Maquina " +
    //         data[0].maquina +
    //         "</td>";
    //       document.getElementById("tablamaquina").insertRow(-1).innerHTML =
    //         "<td>Codigo Lersan </td> <td>" +
    //         data[0].nombre +
    //         "</td> </td> <td>Amp Max:</td> <td>" +
    //         data[0].ampmax +
    //         "</td> <td colspan='2'> Amp </td>";
    //       document.getElementById("tablamaquina").insertRow(-1).innerHTML =
    //         "<td>Turbinas </td> <td>" +
    //         data[0].turbinas +
    //         "</td> </td> <td>Amp Ideal:</td> <td>" +
    //         data[0].ampideal +
    //         "</td> <td colspan='2'> Amp </td>";
    //       document.getElementById("tablamaquina").insertRow(-1).innerHTML =
    //         "<td>Voltaje </td> <td>" +
    //         data[0].voltaje +
    //         "</td> </td> <td>Amp Critico:</td> <td>" +
    //         data[0].ampcritico +
    //         "</td> <td colspan='2'> Amp </td>";
    //       document.getElementById("tablamaquina").insertRow(-1).innerHTML =
    //         "<td>Producto </td> <td>" +
    //         data[0].producto +
    //         "</td> </td> <td>Amp Vacio:</td> <td>" +
    //         data[0].ampvacio +
    //         "</td> <td colspan='2'> Amp </td>";
    //       document.getElementById("tablamaquina").insertRow(-1).innerHTML =
    //         "<td>Abrasivo </td> <td>" +
    //         data[0].abrasivo +
    //         "</td> </td> <td>Potencia Total:</td> <td>" +
    //         data[0].potenciatot +
    //         "</td> <td colspan='2'> Kwatt </td>";
    //       document.getElementById("tablamaquina").insertRow(-1).innerHTML =
    //         "<td>Producción Teorica </td> <td>" +
    //         data[0].produccion +
    //         "</td>  <td> Piezas/hr </td> </td> <td>Consumo Abr:</td> <td>" +
    //         data[0].consumoabra +
    //         "</td> <td> Kg/hr </td>";
    //       document.getElementById("tablamaquina").insertRow(-1).innerHTML =
    //         "<td colspan='6' class='text-center'> Detalles de costos </td>";
    //       document.getElementById("tablamaquina").insertRow(-1).innerHTML =
    //         "<td colspan='3'>Costo Granalla </td> <td>" +
    //         data[0].costogranalla +
    //         "</td> <td colspan='2'> USD/Kg</td>";
    //       document.getElementById("tablamaquina").insertRow(-1).innerHTML =
    //         "<td colspan='3'>Costo Electrico </td> <td>" +
    //         data[0].costoelectrico +
    //         "</td> <td colspan='2'>USD/Kwh</td>";
    //       document.getElementById("tablamaquina").insertRow(-1).innerHTML =
    //         "<td colspan='3'>Costo Personal </td> <td>" +
    //         data[0].costopersonal +
    //         "</td> <td colspan='2'> USD/Hr-H</td>";
    //       document.getElementById("tablamaquina").insertRow(-1).innerHTML =
    //         "<td colspan='3'>Operadores </td> <td>" +
    //         data[0].operadores +
    //         "</td> <td colspan='2'> USD/Kg</td>";
    //       document.getElementById("tablamaquina").insertRow(-1).innerHTML =
    //         "<td colspan='3'>Costo Mantenimiento Maquina </td> <td>" +
    //         data[0].costomonto +
    //         "</td> <td colspan='2'> USD/Hr</td>";
    //     },
    //     error: function (response) {
    //       contador = 0;
    //       ocultarLoader();
    //     },
    //   });
  
    //   $(".modal-header").css("background-color", "#07B5E8");
    //   $(".modal-title").text("REPORTES");
    //   $("#ModalRep").modal({show:true});
    // }
  
   
}

function GuardarVag() {
  debugger;
  var Numesp =0;
  var Numrcabina =0;
  var total =0;
  Numesp =  parseInt($("#tablaespera tr").length - 1);
  Numrcabina =  parseInt($("#tablacabina tr").length - 1);
  total=(Numesp + Numrcabina);
  if (total<2){
    var Maquina = $('#cbmmaquinavag').select2('data');
    var Proye = $('#cbmproy').select2('data');
  
    if (Proye[0].text=="" || Proye[0].text=="Seleccione"){
      Swal.fire({
        icon: "error",
        title: "Error Seleccione Un Proyecto",
        showConfirmButton: false,
        timer: 1500,
      });
      return false;
    }
  
    if (Maquina[0].text=="" || Maquina[0].text=="Seleccione"){
      Swal.fire({
        icon: "error",
        title: "Error Seleccione Una Cabina",
        showConfirmButton: false,
        timer: 1500,
      });
      return false;
    }
  
  
   if (document.getElementById('txtSerie').value==""){
     Swal.fire({
       icon: "error",
       title: "Error Favor De Ingresar una Serie De vagón",
       showConfirmButton: false,
       timer: 1500,
     });
     return false;
   }

    $.ajax({
      url: "modelos/buscarserie.php",
      type: "POST",
      data: {
        serie: txtSerie.value,
      },
      dataType: "json",
      beforeSend: function (response) {},
      complete: function (response) {},
      success: function (data) {
        console.log(data);
         var numeros=parseInt(data);
         if (numeros==0){
          $.ajax({
            url: "modelos/insertarvagon.php",
            type: "POST",
            data: { 
                fk_proyecto:txtpkproy.value,
                alias_produccion: txtSerie.value, 
                maquina: Maquina[0].id, 
                fkProducto: txtTipovag.value,
                serie_proyecto: txtProyectos.value,
                fkCliente: txtCliente.value,
                fk_cliente_lersoft: txtFkvag.value
                },
            dataType: "json",
            beforeSend: function (response) {
            },
            complete: function (response) {
            },
              success: function (data) {
                  if(data[0]["message"]==="OK"){
                    var tablaterminado = $("#tablaterminado tr").length - 1;
                    if (tablaterminado >= 1) {
                      for (y = tablaterminado; y > 0; y--) {
                        document.getElementById("tablaterminado").deleteRow(y);
                      }
                    }
  
                    var tablacabina = $("#tablacabina tr").length - 1;
                  
                    if (tablacabina >= 1) {
                      for (y = tablacabina; y > 0; y--) {
                        document.getElementById("tablacabina").deleteRow(y);
                      }
                    }
  
                    var tablaespera = $("#tablaespera tr").length - 1;
                    if (tablaespera >= 1) {
                      for (y = tablaespera; y > 0; y--) {
                        document.getElementById("tablaespera").deleteRow(y);
                      }
                    }


                    document.getElementById('txtSerie').value = '';
                    $("#cbmproy").val("Ninguno").trigger("change")
                    $("#cbmmaquinavag").val("Ninguno").trigger("change")
                    $('#cbmmaquinavag').select2('focus');
                    $('#cbmmaquinavag').select2('open');  
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
         }else{
           $(".modal-header").css("background-color", "#07B5E8");
           $(".modal-title").text("Vagones");
           $("#ModalVagon").modal("show");
         }
      },
      error: function (response) {
         ocultarLoader();
         $.ajax({
          url: "modelos/insertarvagon.php",
          type: "POST",
          data: { 
              fk_proyecto:txtpkproy.value,
              alias_produccion: txtSerie.value, 
              maquina: Maquina[0].id, 
              fkProducto: txtTipovag.value,
              serie_proyecto: txtProyectos.value,
              fkCliente: txtCliente.value,
              fk_cliente_lersoft: txtFkvag.value
              },
          dataType: "json",
          beforeSend: function (response) {
          },
          complete: function (response) {
          },
            success: function (data) {
                if(data[0]["message"]==="OK"){

                  var tablaterminado = $("#tablaterminado tr").length - 1;
    
                  if (tablaterminado >= 1) {
                    for (y = tablaterminado; y > 0; y--) {
                      document.getElementById("tablaterminado").deleteRow(y);
                    }
                  }

                  var tablacabina = $("#tablacabina tr").length - 1;
                
                  if (tablacabina >= 1) {
                    for (y = tablacabina; y > 0; y--) {
                      document.getElementById("tablacabina").deleteRow(y);
                    }
                  }

                  var tablaespera = $("#tablaespera tr").length - 1;
                  if (tablaespera >= 1) {
                    for (y = tablaespera; y > 0; y--) {
                      document.getElementById("tablaespera").deleteRow(y);
                    }
                  }

                  document.getElementById('txtSerie').value = '';
                  $("#cbmproy").val("Ninguno").trigger("change")
                  $("#cbmmaquinavag").val("Ninguno").trigger("change")
                  $('#cbmmaquinavag').select2('focus');
                  $('#cbmmaquinavag').select2('open');  
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
      },
    });


  }else{
    Swal.fire({
      position: 'center',
      icon: 'warning',
      title: 'La fila de espera de esta cabina está llena. Debes esperar a que se acabe el vagón actualmente en cabina',
      showConfirmButton: false,
      timer: 4000
    })
  }


 




  




 
 



 
}

function GuardarGranlla() {
  debugger;
  var Maquina = $('#cbmmaquinavag').select2('data');
  var Proye = $('#cbmproy').select2('data');

  if (Proye[0].text=="" || Proye[0].text=="Seleccione"){
    Swal.fire({
      icon: "error",
      title: "Error Seleccione Un Proyecto",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  }

  if (Maquina[0].text=="" || Maquina[0].text=="Seleccione"){
    Swal.fire({
      icon: "error",
      title: "Error Seleccione Una Cabina",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  }


 if (document.getElementById('txtSerie').value==""){
   Swal.fire({
     icon: "error",
     title: "Error Favor De Ingresar una Serie De vagón",
     showConfirmButton: false,
     timer: 1500,
   });
   return false;
 }
 
 $.ajax({
   url: "modelos/updatevagon.php",
   type: "POST",
   data: { 
       alias_produccion: txtSerie.value, 
       maquina: Maquina[0].id, 
       fk_proyecto:txtpkproy.value,
       flag_regranallado: 1,
       fkProducto: txtTipovag.value,
       serie_proyecto: txtProyectos.value,
       fkCliente: txtCliente.value,
       fk_cliente_lersoft: txtFkvag.value
       },
   dataType: "json",

   beforeSend: function (response) {
   
   },

   complete: function (response) {

   },
     success: function (data) {
         if(data[0]["message"]==="OK"){
          
           document.getElementById('txtSerie').value = '';
           $("#cbmproy").val("Ninguno").trigger("change")
            $("#cbmmaquinavag").val("Ninguno").trigger("change")

           $('#cbmproy').select2('focus');
           $('#cbmproy').select2('open');  

        Swal.fire({
          icon: "success",
          title: "Registro Ingresado Correctamente",
          showConfirmButton: false,
          timer: 1500,
        });

        $("#ModalVagon").modal("hide");
        
         };


     },
     error: function (response) {
       console.log(response);
     },
   });



 
}

function Corregir(){
  $("#ModalVagon").modal("hide");

  document.getElementById('txtSerie').focus();
    document.getElementById('txtSerie').select();
}

function obtenerCombo(pk) {

  // $('#cbmmaquinavag').val(null).trigger('change');
  $("#cbmmaquinavag").select2("val", "");
  $("#cbmmaquinavag").empty();
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
        $('#cbmmaquinavag').append(
          `<option value="Ninguno"  selected="selected">Seleccione</option>`
      );       

      for (var i = 0; i < data.length; i++) {

        $('#cbmmaquinavag').append(
          `<option value="${data[i].pk}">${data[i].descripcion}</option>`
      );       

        
      }
      ocultarLoader();
      $('#cbmmaquinavag').select2('focus');
      $('#cbmmaquinavag').select2('open');   
    },
    error: function (response) {
      // window.location ="salir";
    },
  });
}

function obtenerproy(pk) {
  $.ajax({
    url: "modelos/obtenerproyectos.php",
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
        $('#cbmproy').append(
          `<option value="Ninguno"  selected="selected">Seleccione</option>`
      );       

      for (var i = 0; i < data.length; i++) {

        $('#cbmproy').append(
          `<option value="${data[i].pk}">${data[i].Proyecto}</option>`
      );       

      }
      
    },
    error: function (response) {
      // window.location ="salir";
    },
  });
}







