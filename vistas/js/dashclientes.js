let spanElement = document.getElementById("Txtestado");
let pk = document.getElementById("txtpk").value;
let contador = 0;
let limit = 0;
let offset = 1;
let resta = 0;
let cont = 0;
let sum=0;
let cantidad=0;
let itemsPorPagina = 10;
let paginaActual = 1;
const items = [
  "Elemento 1",
  "Elemento 2",
  "Elemento 3",
  "Elemento 4",
  "Elemento 5",
  "Elemento 6",
  "Elemento 7",
  "Elemento 8",
  "Elemento 9",
  "Elemento 10",
  "Elemento 11",
  "Elemento 12"
];
$(document).ready(function () {


if (pk==""){
  let razon =localStorage.getItem('txtRazonsocial');
  document.getElementById("txtRazonsocial").value=razon;

  let Direccion =localStorage.getItem('txtDireccionfiscal');
  document.getElementById("txtDireccionfiscal").value=Direccion;

  let RFC =localStorage.getItem('Txtrfc');
  document.getElementById("Txtrfc").value=RFC;
}



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
  // document.getElementById('Regresarsuper').style.display = 'none';
  

  document.getElementById('InicioJefe').style.display = 'block';
  document.getElementById('PedidosJefe').style.display = 'block';
  document.getElementById('MaquinasJefe').style.display = 'block';
  document.getElementById('ProduccionJefe').style.display = 'block';
  document.getElementById('EstadoJefe').style.display = 'block';
  document.getElementById('SalirJefe').style.display = 'block';
  // document.getElementById('Regresarsuper').style.display = 'block';

 
  
  

  // obtenerInfo();
// Datos de muestra



  

 

});


// function mostrarElementosPaginados() {

//   const inicio = (paginaActual - 1) * itemsPorPagina;
//   const fin = inicio + itemsPorPagina;
//   const elementosPaginados = items.slice(inicio, fin);

//   const itemsContainer = document.getElementById("items");
//   itemsContainer.innerHTML = "";

//   elementosPaginados.forEach((elemento) => {
//     const li = document.createElement("li");
//     li.classList.add("list-group-item");
//     li.innerText = elemento;
//     itemsContainer.appendChild(li);
//   });
// }

// Función para generar los elementos de paginación
// function generarPaginacion(cantidad) {
//   const totalPaginas = Math.ceil(cantidad/ itemsPorPagina);
//   const paginationContainer = document.getElementById("pagination");
//   paginationContainer.innerHTML = "";

//   for (let i = 1; i <= totalPaginas; i++) {
//     const link = document.createElement("a");
//     link.classList.add("page-link");
//     link.href = "#";
//     link.innerText = i;

//     if (i === paginaActual) {
//       link.classList.add("active");
//     }

//     link.addEventListener("click", () => {
//       paginaActual = i;
//       mostrarElementosPaginados();
//       generarPaginacion(cantidad);
//     });

//     const li = document.createElement("li");
//     li.classList.add("page-item");
//     li.appendChild(link);
//     paginationContainer.appendChild(li);
//   }
// }

// function generatePageNumbers(totalPages, currentPage) {
//   const paginationElement = document.getElementById('pagination');
//   paginationElement.innerHTML = ''; // Limpiar el contenido existente

//   for (let i = 1; i <= totalPages; i++) {
//     const pageNumber = document.createElement('span');
//     pageNumber.textContent = i;

  

//     pageNumber.addEventListener('click', function () {
     
//       // Aquí puedes implementar la lógica para manejar el clic en un número de página
//       // Por ejemplo, puedes cargar contenido correspondiente a la página seleccionada
//       currentPage=i;
//       for (let i = 1; i <= totalPages; i++) {
    
//         if (i === currentPage) {
//           pageNumber.classList.add('active'); // Agregar clase CSS para resaltar la página actual
//         }else{
//           pageNumber.classList.remove('active');
//         }
//       }

     
      
     
     
//       console.log('Haz clic en la página', i);
//     });

//     paginationElement.appendChild(pageNumber);
//   }
// }

$("#btnconsultar").click(function (e) {
  e.preventDefault();
  // 
  if ((contador > 0) & (resta <= contador)) {
    if (contador < 10) {
      resta = 0;
      limit = contador;
      if (cont == 0) {
        cont += 1;
        offset = 1;
      } else {
        offset += 10;
      }
      contador = resta;
    } else {
      resta = contador - 10;
      limit = 10;
      contador = resta;
      if (cont == 0) {
        cont += 1;
        offset = 1;
      } else {
        offset += 10;
      }
    }

    

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
             '<td  style="text-align:right">' +
             accounting.formatMoney(data[i].Total , "$ ", 2, ",", ".") +
             "</td>" +
             '<td  style="text-align:center">' +
             data[i].Moneda +
             "</td>" +
             '<td  style="display:none;">' +
             data[i].pk +
             "</td>" +
             "</tr>"; 
         }
         $("#DataPedidos").html(html);


     



        if (sum === cantidad) {
          contador = 0;
          resta = 0;
          limit = 0;
          offset = 1;
          cont = 0;
          cantidad=0;
          sum=0;
          obtenerInfo();
        } else {
          sum+=10;
          spanElement.innerText = "Consultar " + sum + " De " + cantidad + " Registros";
        }

      },
      error: function (response) {
        // alert(error con la petición);
      },
    });
  }
});

function obtenerInfo() {
  $.ajax({
    url: "modelos/contarpedidos.php",
    type: "POST",
    data: { pk: pk },
    dataType: "json",

    beforeSend: function (response) {
      //         // $('#cargando').css({display:'block'});
      //         // $('#exito').html('Procesando...');
      // spanElement.innerText = "Buscando Información";
    },

    //  Se ejecuta cuando termino la petición
    complete: function (response) {
      // $('#exito').html('Exito...');
    },

    // se ejecuta al termino de la petición y está fue correcta
    success: function (data) {
      let totalPages = 0;
      let currentPage = 1;
      contador = parseInt(data);
      cantidad=parseInt(data);
      if (parseInt(data) > 0) {
        sum+=10;
        // spanElement.innerText = "Consultar " + sum +" De " + data + " Registros";
        cantidad=parseInt(data);
        if (cantidad<10){
          totalPages=1;
        }else{
          totalPages=(cantidad/10);
          totalPages = Math.round(totalPages);

        }

       
        
        // Configuración de paginación
     
        
        // Función para mostrar elementos paginados
        
        
        // Inicializar la paginación
        mostrarElementosPaginados();
        generarPaginacion(cantidad);

        // generatePageNumbers(totalPages, currentPage);

      
      } else {
        // spanElement.innerText = "Sin Información";
      }
    },
    error: function (response) {
      // spanElement.innerText = "Sin Información";
    },
  });
}
