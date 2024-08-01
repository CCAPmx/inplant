const pk = document.getElementById("txtpk").value;
const entradas= document.getElementById("txtEntradas");
const devoluciones= document.getElementById("txtdevolucion");
const cliente= document.getElementById("txtpk");
const btnguardarEntradasSoli = document.getElementById("btnguardarEntradasSoli");
const nuevo = document.getElementById('nuevo');


$(document).ready(function () {

  if (pk==""){
    pk = localStorage.getItem('pk');
  
    
  }

    devoluciones.disabled = true;
    $('#cbmtipo').select2({
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        // allowClear: true
      });

      $('#cbmgranallaje').select2({
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        // allowClear: true
      });


    window.jsPDF = window.jspdf.jsPDF;
    tabla(pk);
    obtenerGranalla(pk);

    exportexcel.addEventListener("click", exportexc);
    exportpdf.addEventListener("click", exportpdfs);
    nuevo.addEventListener("click", nuevoreg);
    btnguardarEntradasSoli.addEventListener("click", GuardarEntradasol);

    $('#cbmtipo').change(function(){
        var value = $(this).val();
        if (value=="Devolucion"){
            devoluciones.disabled = false;
            devoluciones.value="";
            devoluciones.focus();
            devoluciones.select();
        }else{
            devoluciones.value="";
            devoluciones.disabled = true;
            $('#cbmgranallaje').select2('focus');
            $('#cbmgranallaje').select2('open');   
        }
    
    });


  });


  function tabla(cliente) {
    $.ajax({
      url: "modelos/consultarsolicitudes.php",
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
      $('#tablesolicitud').bootstrapTable('destroy');
  
      $('#tablesolicitud').bootstrapTable({
        url: 'vistas/recursos/json/solicitudes.json',
        columns: [
          {
            field: 'solicitud'
          },
          {
            field: 'granalla'
          },
           {
            field: 'cantidad'
          },
          {
            field: 'fecha'
          },
          {
            field: 'usuario'
          },
          {
            field: 'cliente'
          },
          {
            field: 'status'
          },
          {
            field: 'more-info',
            title: 'Más Información',
            formatter: function(value, row, index) {
              return `<a class="status-details" data-index="${row.pk}"><i class="fas fa-info-circle fa-3x" style="color: #07b5e8;" width="30"></i></a>`;
            }
          },
          {
            field: 'change-status',
            title: 'Cambiar Estatus',
            formatter: function(value, row, index) {
              switch (row.status) {
                case "Solicitada":
                  nextStatus = "Recibida";
                  break;
                case "Recibida":
                  nextStatus = "Despachada";
                break;
                case "Despachada":
                  nextStatus = "Entregada";
                break;
                case "Entregada":
                  nextStatus = "Firmar de Conformidad";
                break;
                case "Firmada de conformidad":
                  nextStatus = "";
                break;
              }
              if (row.status == 'Firmada de Conformidad') {
                return ``;
              }else if (nextStatus == 'Firmar de Conformidad') {
                if ($("#tipouser").val() != 'Cliente operador') {
                  return ``; 
                }else{
                  return `<button class="btn btn-warning btn-sm change-status" data-index="${row.pk}" data-status="${row.status}">${nextStatus}</button>`;
                }
              }else{
                if ($("#tipouser").val() == 'Cliente operador') {
                  return ``; 
                }else{
                  return `<button class="btn btn-warning btn-sm change-status" data-index="${row.pk}" data-status="${row.status}">${nextStatus}</button>`;
                }
              }
              
            }
          },
        ]
      })
  
  $('#tablesolicitud').on('click', '.change-status', function() {
    const pk = $(this).data('index');
    const currentStatus = $(this).data('status');
    let newStatus = "";
    switch (currentStatus) {
      case "Solicitada":
        newStatus = "Recibida";
        break;
      case "Recibida":
        newStatus = "Despachada";
      break;
      case "Despachada":
        newStatus = "Entregada";
      break;
      case "Entregada":
        newStatus = "Firmar de Conformidad";
      break;
      case "Firmada de conformidad":
        newStatus = "";
      break;
    }
    Swal.fire({
      title: '¿Continuar?',
      html: `El estatus cambiara a <strong>${newStatus}<strong>`,
      footer: 'Este cambio no podrá revertirse.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, continuar!',
      cancelButtonText: 'Cancelar',
      preConfirm: async () => {
        return result = await changeStatus(pk, currentStatus);
      }
    }).then( (result) => {
      if (result.isConfirmed) {
        Swal.fire(
          'Completado!',
          'Estatus actualizado correctamente.',
          'success'
        ).then( (result) => {
          location.reload();
        })
      }
    })
});
$('#tablesolicitud').on('click', '.status-details', async function() {
  mostrarLoader();
  const pk = $(this).data('index');
  const response = await getStatusDetails(pk);
  const responseParsed = JSON.parse(response);
  const fielData = responseParsed.response.data[0].fieldData;
  const dateCreated = fielData.fecha;
  const dateSigned = fielData.fecha_conformidad;
  const dateDistpached = fielData.fecha_despacho;
  const dateDelivered = fielData.fecha_entrega;
  const dateReceived = fielData.fecha_recibida;
  const title = `${fielData["T14_sol_CLIENTES::Nombre"]} | ${fielData["T14_sol_GRANALLA::Descripcion"]} | ${fielData.cantidad}`;
  const html =  `<table class="table table-striped table-hover">
                  <thead>
                    <tr>
                      <th scope="col">Estatus de Solictud</th>
                      <th scope="col">Fecha</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row">Solicitada</th>
                      <td>${dateCreated}</td>
                    </tr>
                    <tr>
                      <th scope="row">Despachada</th>
                      <td>${dateDistpached}</td>
                    </tr>
                    <tr>
                      <th scope="row">Entregada</th>
                      <td>${dateDelivered}</td>
                    </tr>
                    <tr>
                      <th scope="row">Recibida</th>
                      <td>${dateReceived}</td>
                    </tr>
                    <tr>
                      <th scope="row">Firmada</th>
                      <td>${dateSigned}</td>
                    </tr>
                  </tbody>
                </table>`;
  $("#statusDetailModalTitle").html(title);
  $("#statusDetailModalBody").html(html);
  $("#statusDetailModal").modal("toggle");
  ocultarLoader();
})
     
     
}
  

function exportpdfs(e) {
    var today = new Date();
    e.preventDefault();
  
  
    var tabla = document.getElementById("tablesolicitud");
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
    doc.text("REPORTE DE SOLICITUDES DE GRANALLA ", pageWidth / 2, 35, "center");
  
    var textColor = [144, 142, 141];
    doc.setTextColor(textColor[0], textColor[1], textColor[2]);
    doc.setFontSize(8);
  
  
    doc.text('GENERADO POR ' + document.getElementById("txtnombre").value.toUpperCase(), 190, 20, { align: 'right', });
    doc.text('FECHA ' + today.getDate() + "/" + (today.getMonth() + 1) + "/" + today.getFullYear(), 190, 25, { align: 'right', });
  
    textColor = [6, 6, 6];
    doc.setTextColor(textColor[0], textColor[1], textColor[2]);
    doc.setFontSize(8);
  
    const options = {
      head: [["N°_Solicitud",  "Granalla", "Cantidad", "Fecha", "Usuario", "Cliente", "Status"]],
      body: datosArray,
      margin: { top: 40 },
      styles: {overflow: 'linebreak',
                  fontSize: 6}
    };
  
    doc.autoTable(options);
    doc.save("REPORTE_SOLICITUD_GRANALLA" + ".pdf");
}


function exportexc(e) {

    e.preventDefault();
  
  
    var tb = new Object();
    var myObject = [];
    const tabla = document.getElementById("tablesolicitud");
    const filas = tabla.rows;
  
    for (let i = 1; i < filas.length; i++) {
  
      const celdas = filas[i].cells;
      for (let j = 0; j < celdas.length; j++) {
        const celda = celdas[j];
        const contenido = celda.innerHTML;
        if (j == 0) {
          tb.Solicitud = contenido;
        } else if (j == 1) {
          tb.Granalla = contenido;
        } else if (j == 2) {
          tb.Cantidad = contenido;
        } else if (j == 3) {
            tb.Fecha = contenido;
        } else if (j == 4) {
            tb.Usuario = contenido;
        } else if (j == 5) {
            tb.Cliente = contenido;
        } else if (j == 6) {
            tb.Status = contenido;
        } 
      }
      myObject.push(tb);
      tb = [];
    }
  
    var myFile = "REPORTE_SOLICITUD_GRANALLA.xlsx";
    var myWorkSheet = XLSX.utils.json_to_sheet(myObject);
    var myWorkBook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(myWorkBook, myWorkSheet, "lista");
    XLSX.writeFile(myWorkBook, myFile);
}

function nuevoreg(e) {

    e.preventDefault();

    $(".modal-header").css("background-color", "#07B5E8");
    $(".modal-title").text("Solicitudes");

    $("#ModalEntradanew").modal("show");

    

}

function validarNumero(value) {
    var valor = $(value).val();
     if (!isNaN(valor) && valor >= 0){
       $(value).val(valor);
     }else{
       $(value).val(0);
     }
}

 function obtenerGranalla(pk) {
    $("#cbmgranallaje").empty();

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
          $('#cbmgranallaje').append(
            `<option value="Ninguno"  selected="selected">Seleccione</option>`
        );       


        for (var i = 0; i < data.length; i++) {
  
          $('#cbmgranallaje').append(
            `<option value="${data[i].pk}">${data[i].Descripcion}</option>`
        );       

          
        }
        ocultarLoader();
       
      },
      error: function (response) {
        console.log(response)
        // window.location ="salir";
      },
    });
}




function GuardarEntradasol(e) {
    e.preventDefault();
    debugger;
   var tipo = $('#cbmtipo').select2('data');
   var granalla = $('#cbmgranallaje').select2('data');

 

   if (tipo[0].text=="" || tipo[0].text=="Seleccione"){
     Swal.fire({
       icon: "error",
       title: "Error Seleccione Un Tipo De Movimiento",
       showConfirmButton: false,
       timer: 1500,
     });
     return false;
   }

   if  (entradas.value=="" || entradas.value==0 ){
    Swal.fire({
      icon: "error",
      title: "Debe ingresar una Cantidad",
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

   if ( tipo[0].text=="Devolucion" && devoluciones.value==""){
    Swal.fire({
        icon: "error",
        title: "Error Debe Ingresar Un Motivo De Devolución",
        showConfirmButton: false,
        timer: 1500,
      });
      return false;
   }


   
   
    $.ajax({
      url: "modelos/insertarsolicitud.php",
      type: "POST",
      data: { 
          fkgranalla: granalla[0].id, 
          cantidad: entradas.value,
          fkCliente: cliente.value, 
          tipo: tipo[0].id,
          razon: devoluciones.value
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
  
async function changeStatus(pkSolicitud, currentStatus) {
  return await $.ajax({
    type: "POST",
    url: "controladores/solicitudes.controlador.php",
    data: {
        action: "preChange",
        pk: pkSolicitud,
        currentStatus: currentStatus
    },
    success: function(response) {
      result = JSON.parse(response);
      if (response?.ok) {
        return true;
      }else{
        return false;
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
        
    } 
  });
}
async function getStatusDetails(pkSolicitud) {
  return await $.ajax({
    type: "POST",
    url: "controladores/solicitudes.controlador.php",
    data: {
        action: "getStatusDetails",
        pk: pkSolicitud
    },
    success: function(response) {
      result = JSON.parse(response);
      if (response?.ok) {
        return result;
      }else{
        return false;
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
        
    } 
  });
}