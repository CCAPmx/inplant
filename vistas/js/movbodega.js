const pk = document.getElementById("txtpk").value;
const parrafo = document.getElementById("parrafoinfo");
const btnsemact = document.getElementById("btnsemact");
const btnsempas = document.getElementById("btnsempas");
const btnmesact = document.getElementById("btnmesact");
const btnmespas = document.getElementById("btnmespas");
let fecha="";


$(document).ready(function () {
    parrafo.classList.add("mostrar");
   
    window.jsPDF = window.jspdf.jsPDF;
    
  
    $('#cbmgranallamov').select2({
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        // allowClear: true
      });

      obtenerGranalla(pk);


     btnsemact.addEventListener("click", Semanaactual);
     btnsempas.addEventListener("click", Semanapasado);
     btnmesact.addEventListener("click", Mesactual);
     btnmespas.addEventListener("click", Mespasado);
    exportexcel.addEventListener("click", exportexc);
    exportpdf.addEventListener("click", exportpdfs);
    exportexceldetalle.addEventListener("click", exportexcdetalle);
    exportpdfdetalle.addEventListener("click", exportpdfsdetalle);

     
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
              var granalla = $('#cbmgranallamov').select2('data');
              fechasel = (date.getMonth() + 1) + "/" + date.getDate() + "/" + date.getFullYear() + "..." + (date.getMonth() + 1) + "/" + date.getDate() + "/" + date.getFullYear();
              fecha=fechasel;
              
              titulo = "LISTADO DE MOVIMIENTO DE BODEGA - FECHA " + fechaEnLetra(date);
              tituloexcel = "REPORTE DE MOVIMIENTO DE BODEGA_" + date.getDate() + (date.getMonth() + 1) + date.getFullYear();
              tabla(fechasel, granalla[0].id);
            } else if (result == -1) {
              Swal.fire({
                position: "center",
                icon: "error",
                title: "Seleccione Una Fecha Menor",
                showConfirmButton: false,
                timer: 2500,
              });
            } else {
            var granalla = $('#cbmgranallamov').select2('data');
              fechasel = (date.getMonth() + 1) + "/" + date.getDate() + "/" + date.getFullYear() + "..." + (date.getMonth() + 1) + "/" + date.getDate() + "/" + date.getFullYear();
              fecha=fechasel;
              titulo = "LISTADO DE MOVIMIENTO DE BODEGA - FECHA " + fechaEnLetra(date);
              tituloexcel = "RREPORTE DE MOVIMIENTO DE BODEGA_" + date.getDate() + (date.getMonth() + 1) + date.getFullYear();
              tabla(fechasel, granalla[0].id);
      
            }
      
      
          });
      
      
      });


    function sindatos() {
        debugger;
        $('#tablebodega').bootstrapTable('destroy');
     
        $('#tablegranalla').bootstrapTable({
          url: 'vistas/recursos/json/sinvagones.json',
          columns: [
            {
                field: 'id'
              },
            {
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

    function obtenerGranalla(pk) {

        $("#cbmgranallamov").select2("val", "");
        $("#cbmgranallamov").empty();
    
    
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
              $('#cbmgranallamov').append(
                `<option value="Ninguno"  selected="selected">Seleccione</option>`
            );       
    
    
            for (var i = 0; i < data.length; i++) {
      
              $('#cbmgranallamov').append(
                `<option value="${data[i].pk}">${data[i].Descripcion}</option>`
            );       
    
           
              
            }
            ocultarLoader();
           
          },
          error: function (response) {
            // window.location ="salir";
          },
        });
    }
    
    function Semanaactual() {
        var granalla = $('#cbmgranallamov').select2('data');
    
        var fecha = new Date();
        var inicio = new Date(fecha.getFullYear(), fecha.getMonth(), fecha.getDate() - fecha.getDay() + 1);
        var fin = new Date(fecha.getFullYear(), fecha.getMonth(), fecha.getDate() + 7 - fecha.getDay());
        fechasel = "";
        fechasel = (inicio.getMonth() + 1) + "/" + inicio.getDate() + "/" + inicio.getFullYear() + "..." + (fin.getMonth() + 1) + "/" + fin.getDate() + "/" + fin.getFullYear();
        fecha=fechasel;
        titulo =
          "REPORTE DE MOVIMIENTO DE BODEGA - PERIODO DE  " +
          fechaEnLetra(inicio) +
          " AL " +
          fechaEnLetra(fin);
        tituloexcel = "REPORTE_MOV_BODEGA_" + (inicio.getDate()) + "/" + (inicio.getMonth() + 1) + "/" + inicio.getFullYear() + " - " + fin.getDate() + "/" + (fin.getMonth() + 1) + "/" + fin.getFullYear();
        tabla(fechasel, granalla[0].id);
    }

    function Semanapasado() {
        var granalla = $('#cbmgranallamov').select2('data');

        var fecha = new Date();
        var inicio = new Date(fecha.getFullYear(), fecha.getMonth(), fecha.getDate() - 7 - fecha.getDay() + 1);
        var fin = new Date(fecha.getFullYear(), fecha.getMonth(), fecha.getDate() - fecha.getDay());
        fechasel = "";
        fechasel = (inicio.getMonth() + 1) + "/" + inicio.getDate() + "/" + inicio.getFullYear() + "..." + (fin.getMonth() + 1) + "/" + fin.getDate() + "/" + fin.getFullYear();
        fecha=fechasel;
        titulo =
          "REPORTE DE MOVIMIENTO DE BODEGA - PERIODO DE  " +
          fechaEnLetra(inicio) +
          " AL " +
          fechaEnLetra(fin);
        tituloexcel = "REPORTE_MOV_BODEGA_" + (inicio.getDate()) + "/" + (inicio.getMonth() + 1) + "/" + inicio.getFullYear() + " - " + fin.getDate() + "/" + (fin.getMonth() + 1) + "/" + fin.getFullYear();
        tabla(fechasel, granalla[0].id);
    }

    function Mesactual() {
        var granalla = $('#cbmgranallamov').select2('data');

        var date = new Date();
        var primerDia = new Date(date.getFullYear(), date.getMonth(), 1);
        var ultimoDia = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        fechasel = "";
        fechasel = (primerDia.getMonth() + 1) + "/" + primerDia.getDate() + "/" + primerDia.getFullYear() + "..." + (ultimoDia.getMonth() + 1) + "/" + ultimoDia.getDate() + "/" + ultimoDia.getFullYear();
        fecha=fechasel;
        titulo =
          "REPORTE DE MOVIMIENTO DE BODEGA - PERIODO DE  " +
          fechaEnLetra(primerDia) +
          " AL " +
          fechaEnLetra(ultimoDia);
        tituloexcel = "REPORTE_MOV_BODEGA_" + (primerDia.getDate()) + "/" + (primerDia.getMonth() + 1) + "/" + primerDia.getFullYear() + " - " + ultimoDia.getDate() + "/" + (ultimoDia.getMonth() + 1) + "/" + ultimoDia.getFullYear();
        tabla(fechasel, granalla[0].id);
    }
      
      function Mespasado() {
        var granalla = $('#cbmgranallamov').select2('data');

        var date = new Date();
        var primerDia = new Date(date.getFullYear(), date.getMonth() - 1, 1);
        var ultimoDia = new Date(date.getFullYear(), date.getMonth(), 0);
        fechasel = "";
        fechasel = (primerDia.getMonth() + 1) + "/" + primerDia.getDate() + "/" + primerDia.getFullYear() + "..." + (ultimoDia.getMonth() + 1) + "/" + ultimoDia.getDate() + "/" + ultimoDia.getFullYear();
        fecha=fechasel;
        titulo =
          "REPORTE DE MOVIMIENTO DE BODEGA - PERIODO DE   " +
          fechaEnLetra(primerDia) +
          " AL " +
          fechaEnLetra(ultimoDia);
        tituloexcel = "REPORTE_MOV_BODEGA_" + (inicio.getDate()) + "/" + (inicio.getMonth() + 1) + "/" + inicio.getFullYear() + " - " + fin.getDate() + "/" + (fin.getMonth() + 1) + "/" + fin.getFullYear();
        tabla(fechasel, granalla[0].id);
      }

      function tabla(fecha, cliente) {
        $.ajax({
          url: "modelos/consultarbodega.php",
          type: "POST",
          data: { fecha: fecha, fkgranalla: cliente },
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


      function obtenertabla() {  
        $('#tablebodega').bootstrapTable('destroy');
    
        $('#tablebodega').bootstrapTable({
          url: 'vistas/recursos/json/bodega.json',
          columns: [
            {
                field: 'id'
              },
            {
              field: "tipo",
            },
            {
              field: 'descripcion'
            },
            {
              field: 'kilos'
            }]
        })
    
    
       
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

          var granalla = $('#cbmgranallamov').select2('data');
        $.ajax({
          url: "modelos/consultarbodegadetallada.php",
          type: "POST",
          data: {
            fecha:  fecha,
            tipo: row["tipo"],
            fkgranalla:  granalla[0].id,
            descripcion:row["descripcion"]
          },
          dataType: "json",
          beforeSend: function (response) { },
          complete: function (response) { },
          success: function (data) {
            console.log(data)
            
            const p = document.getElementById("granalla");
            p.innerText = "Granalla " + granalla[0].text;

            $('#tabledeallebodega').bootstrapTable('destroy');
    
            $('#tabledeallebodega').bootstrapTable({
              url: 'vistas/recursos/json/bodegadetalle.json',
              columns: [
                {
                    field: 'Hcreo'
                  },
                {
                  field: "cantidad",
                },
                {
                    field: "tipo",
                  },
                {
                  field: 'descripcion'
                },
                {
                    field: 'usuario'
                  }]
            })


            $(".modal-header").css("background-color", "#07B5E8");
            $(".modal-title").text("Movimientos de Bodega");
            $("#Modaldecripcion").modal("show");
      
        
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


      function exportpdfs(e) {
        var today = new Date();
        e.preventDefault();
      
      
        var tabla = document.getElementById("tablebodega");
        var datosArray = [];
      
        for (var i = 1; i < tabla.rows.length; i++) {
          var fila = tabla.rows[i];
          var filaArray = [];
      
          for (var j = 1; j < fila.cells.length; j++) {
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
          head: [["Operación",  "Cabina", "Kilos"]],
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
        const tabla = document.getElementById("tablebodega");
        const filas = tabla.rows;
      
        for (let i = 1; i < filas.length; i++) {
      
          const celdas = filas[i].cells;
          for (let j = 1; j < celdas.length; j++) {
            const celda = celdas[j];
            const contenido = celda.innerHTML;
            if (j == 1) {
              tb.Operacion = contenido;
            } else if (j == 2) {
              tb.Cabina = contenido;
            } else if (j == 3) {
              tb.Kilos = contenido;
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


      function exportpdfsdetalle(e) {
        var today = new Date();
        e.preventDefault();
      
      
        var tabla = document.getElementById("tabledeallebodega");
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
          head: [["Fecha",  "Cantidad", "Operacion", "Maquina", "Usuario"]],
          body: datosArray,
          margin: { top: 40 },
          styles: {overflow: 'linebreak',
                      fontSize: 6}
        };
      
        doc.autoTable(options);
        doc.save(tituloexcel + ".pdf");
      }
    
    
      function exportexcdetalle(e) {
    
        e.preventDefault();
      
      
        var tb = new Object();
        var myObject = [];
        const tabla = document.getElementById("tabledeallebodega");
        const filas = tabla.rows;
      
        for (let i = 1; i < filas.length; i++) {
      
          const celdas = filas[i].cells;
          for (let j = 0; j < celdas.length; j++) {
            const celda = celdas[j];
            const contenido = celda.innerHTML;
            if (j == 0) {
              tb.Fecha = contenido;
            } else if (j == 1) {
              tb.Cantidad = contenido;
            } else if (j == 2) {
              tb.Operacion = contenido;
             } else if (j == 3) {
                tb.Maquina = contenido;
              } else if (j == 4) {
                tb.Usuario = contenido;
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