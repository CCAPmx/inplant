var pk = document.getElementById("txtpk").value;
var pkmaquina = "";

const btnguardarsup = document.getElementById("btnguardarsup");

$(document).ready(function () {
  if (pk == "") {
    pk = localStorage.getItem("pk");
  } else {
    pk = $.trim(document.getElementById("txtpk").value);
  }

  $("#cbmaquinas").select2({
    theme: "bootstrap-5",
    width: $(this).data("width")
      ? $(this).data("width")
      : $(this).hasClass("w-100")
      ? "100%"
      : "style",
    placeholder: $(this).data("placeholder"),
    // allowClear: true
  });

  obtenerMaq(pk);

  btnguardarsup.addEventListener("click", GuardarTurno);

  var startDate, endDate;
  var hoy = new Date();

  $("#cbmaquinas").change(function () {
    var value = $(this).val();
    pkmaquina = value;

    console.log(pkmaquina);
    // obtenerSup(pk);
  });
});

function obtenerMaq(pk) {
  $("#cbmaquinas").empty();
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
      $("#cbmaquinas").append(
        `<option value="Ninguno"  selected="selected">Seleccione</option>`
      );

      for (var i = 0; i < data.length; i++) {
        $("#cbmaquinas").append(
          `<option value="${data[i].pk}">${data[i].descripcion}</option>`
        );
      }
      ocultarLoader();
      $("#cbmaquinas").select2("focus");
      $("#cbmaquinas").select2("open");
    },
    error: function (response) {
      // window.location ="salir";
    },
  });
}

let btnGuardar = document.getElementById("guardar");
btnGuardar.addEventListener("click", function () {
  // alert('dentro 2');

  let url = "modelos/insertarSupervisor.php";
  let maquina = document.getElementById("cbmaquinas").value;
  let nombreSupervisor = document.getElementById("nombreSupervisor").value;
  let apellidosSupervisor = document.getElementById("apellidoSupervisor").value;
  let pk = document.getElementById("txtpk").value;

  // console.log(maquina.length);
  // console.log(supervisor.length);

  if (maquina.length == 7) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Favor de selecionar una maquina",
      showConfirmButton: false,
      timer: 1500,
    });
  } else if (nombreSupervisor.length == 0) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Favor de llenar el campo supervisor",
      showConfirmButton: false,
      timer: 1500,
    });
  } else if (apellidosSupervisor.length == 0) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Favor de llenar el campo apellido supervisor",
      showConfirmButton: false,
      timer: 1500,
    });
  } else {
    let options = {
      method: "POST",
      headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        fk_maquina: maquina,
        nombre: nombreSupervisor,
        apellidos:apellidosSupervisor,
        fk_cliente_lersoft: pk,
      }),
    };

    ajaxParametos(url, options);
  }
});

ajaxParametos(url, options);
function ajaxParametos(url, options) {
  fetch(url, options)
    .then((response) => response.json())
    .then(dataResponse)
    .catch((errorB) => console.log("error", errorB));
}

function dataResponse(datajson) {
  console.log(datajson);
  fechaActualEvento = [];
  if (datajson.status == 200) {
    Swal.fire({
      position: "center",
      icon: "success",
      title: "usuario registrado con exito",
      showConfirmButton: false,
      timer: 1500,
    });
    document.getElementById("myform").reset();
  }
}

// function GuardarTurno(e) {
//   e.preventDefault();

//   var maquina = $("#cbmaquinas").select2("data");
//   var suervisor = $("#cbmsuperv").select2("data");
//   var modo = $("#cbmmodo").select2("data");
//   var turno = $("#cbmturno").select2("data");

//   if (maquina[0].text == "" || maquina[0].text == "Seleccione") {
//     Swal.fire({
//       icon: "error",
//       title: "Error Seleccione Una Maquina",
//       showConfirmButton: false,
//       timer: 1500,
//     });
//     return false;
//   }

//   if (suervisor[0].text == "" || suervisor[0].text == "Seleccione") {
//     Swal.fire({
//       icon: "error",
//       title: "Error Seleccione Un Supervisor",
//       showConfirmButton: false,
//       timer: 1500,
//     });
//     return false;
//   }

//   if (modo[0].text == "" || modo[0].text == "Seleccione") {
//     Swal.fire({
//       icon: "error",
//       title: "Error Seleccione Un Modo de Turno",
//       showConfirmButton: false,
//       timer: 1500,
//     });
//     return false;
//   }

//   if (turno[0].text == "" || turno[0].text == "Seleccione") {
//     Swal.fire({
//       icon: "error",
//       title: "Error Seleccione Un Turno",
//       showConfirmButton: false,
//       timer: 1500,
//     });
//     return false;
//   }

//   if (funo == "") {
//     Swal.fire({
//       icon: "error",
//       title: "Debe Seleccionar Una Fecha Inicial",
//       showConfirmButton: false,
//       timer: 1500,
//     });
//     return false;
//   }

//   if (fdos == "") {
//     Swal.fire({
//       icon: "error",
//       title: "Debe Seleccionar Una Fecha Final",
//       showConfirmButton: false,
//       timer: 1500,
//     });
//     return false;
//   }

//   $.ajax({
//     url: "modelos/buscarsupervisor.php",
//     type: "POST",
//     data: {
//       fecha_ini: funo,
//       fecha_fin: fdos,
//       pk: suervisor[0].id,
//     },
//     dataType: "json",
//     beforeSend: function (response) {},
//     complete: function (response) {},
//     success: function (data) {
//       console.log("respuesta buscador");
//       // console.log(data)

//       if (data == 0) {
//         $.ajax({
//           url: "modelos/insertarturno.php",
//           type: "POST",
//           data: {
//             fk_cliente_lersoft: pk,
//             fk_maquina: maquina[0].id,
//             fk_supervisor: suervisor[0].id,
//             fk_modo_turno: modo[0].id,
//             fk_turno: turno[0].id,
//             fecha_ini: funo,
//             fecha_fin: fdos,
//           },
//           dataType: "json",
//           beforeSend: function (response) {},
//           complete: function (response) {},
//           success: function (data) {
//             if (data[0]["message"] === "OK") {
//               Swal.fire({
//                 icon: "success",
//                 title: "Registro Ingresado Correctamente",
//                 showConfirmButton: false,
//                 timer: 1500,
//               });

//               setInterval(location.reload(), 15000);
//             }
//           },
//           error: function (response) {
//             console.log(response);
//           },
//         });
//       } else {
//         Swal.fire({
//           icon: "error",
//           title: "No Se Puede Registrar Turnos Ya Registrados",
//           showConfirmButton: false,
//           timer: 1500,
//         });
//       }
//     },
//     error: function (response) {
//       console.log(response);
//     },
//   });
// }
