var pk = document.getElementById("txtpk").value;
var pkmaquina = "";
var funo = "";
var fdos = "";
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

  $("#cbmsuperv").select2({
    theme: "bootstrap-5",
    width: $(this).data("width")
      ? $(this).data("width")
      : $(this).hasClass("w-100")
      ? "100%"
      : "style",
    placeholder: $(this).data("placeholder"),
    // allowClear: true
  });

  $("#cbmturno").select2({
    theme: "bootstrap-5",
    width: $(this).data("width")
      ? $(this).data("width")
      : $(this).hasClass("w-100")
      ? "100%"
      : "style",
    placeholder: $(this).data("placeholder"),
    // allowClear: true
  });

  $("#cbmmodo").select2({
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

  $("#daypickerini")
    .datepicker({
      minDate: 0,
      autoclose: true,
      format: "yyyy/mm/dd",
      forceParse: false,
    })
    .on("changeDate", function (e) {
      var date = e.date;
      var fsel = new Date(date);
      let result = compareDates(hoy, date);

      funo =
        date.getMonth() + 1 + "/" + date.getDate() + "/" + date.getFullYear();
      actual =
        hoy.getMonth() + 1 + "/" + hoy.getDate() + "/" + hoy.getFullYear();

      var fechaIngresarInicio = new Date(funo);
      var FechaActualHoy = new Date(actual);

      // console.log("fecha Ingresada", fechaIngresarInicio);
      // console.log("fecha actual", FechaActualHoy);

      // if (fechaIngresarInicio < FechaActualHoy) {
      //   // console.log(`${fechaIngresarInicio} es menos que ${FechaActualHoy}`);
      //   Swal.fire({
      //     position: "center",
      //     icon: "error",
      //     title: "Seleccione Una Fecha Mayor",
      //     showConfirmButton: false,
      //     timer: 2500,
      //   });
      //   document.getElementById("daypickerini").value = "";
      //   funo = "";
      // }
      // if (fechaIngresarInicio > FechaActualHoy) {
      //   // console.log(`${fechaIngresarInicio} es mayor que ${FechaActualHoy}`);
      // }
      // console.log(`${funo} fecha ingresa`);
    });

  $("#daypickerfin")
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
      fechasel = "";

      fdos =
        date.getMonth() + 1 + "/" + date.getDate() + "/" + date.getFullYear();
      actual =
        hoy.getMonth() + 1 + "/" + hoy.getDate() + "/" + hoy.getFullYear();

      var fechaIngresarFin = new Date(fdos);
      var FechaActualHoy = new Date(funo);

      // console.log("fecha fin", fechaIngresarFin);
      // console.log("fecha inicio", funo);
      // console.log("fecha actual", FechaActualHoy);

      if (funo == 0) {
        Swal.fire({
          position: "center",
          icon: "info",
          title: "Seleccione una fecha inicio",
          showConfirmButton: false,
          timer: 2500,
        });

        document.getElementById("daypickerfin").value = "";
        fdos = "";
      }
      
      if (fechaIngresarFin < FechaActualHoy) {
        // console.log(`${FechaActualHoy} es menos que ${fechaIngresarFin}`);
        Swal.fire({
          position: "center",
          icon: "info",
          title: "Seleccione una fecha mayor que fecha inicio",
          showConfirmButton: false,
          timer: 2500,
        });
        document.getElementById("daypickerfin").value = "";
        fdos = "";
      }
      if (fechaIngresarFin > FechaActualHoy) {
        // console.log(`${fechaIngresarFin} es mayor que ${FechaActualHoy}`);
      }
      // console.log(`${fdos} fecha ingresa`);
    });

  $("#cbmaquinas").change(function () {
    var value = $(this).val();
    pkmaquina = value;
    obtenerSup(pk);
  });

  $("#cbmsuperv").change(function () {
    var value = $(this).val();
    obtenerplanta(pkmaquina);
  });

  $("#cbmmodo").change(function () {
    var value = $(this).val();
    obtenerTurno(value);
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

function obtenerSup(pk) {
  $("#cbmsuperv").empty();
  $.ajax({
    url: "modelos/obtenersupervisor.php",
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
      $("#cbmsuperv").append(
        `<option value="Ninguno"  selected="selected">Seleccione</option>`
      );

      for (var i = 0; i < data.length; i++) {
        $("#cbmsuperv").append(
          `<option value="${data[i].pk}">${data[i].descripcion}</option>`
        );
      }
      ocultarLoader();
    },
    error: function (response) {
      // window.location ="salir";
    },
  });
}

function obtenerModo(pk) {
  $("#cbmmodo").empty();
  $.ajax({
    url: "modelos/obtenermodoturno.php",
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
      console.log(data);
      $("#cbmmodo").append(
        `<option value="Ninguno"  selected="selected">Seleccione</option>`
      );

      for (var i = 0; i < data.length; i++) {
        $("#cbmmodo").append(
          `<option value="${data[i].pk}">${data[i].descripcion}</option>`
        );
      }
      ocultarLoader();
    },
    error: function (response) {
      console.log(response);
    },
  });
}

function obtenerTurno(pk) {
  $("#cbmturno").empty();
  $.ajax({
    url: "modelos/obtenerturno.php",
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
      console.log(data);
      $("#cbmturno").append(
        `<option value="Ninguno"  selected="selected">Seleccione</option>`
      );

      for (var i = 0; i < data.length; i++) {
        $("#cbmturno").append(
          `<option value="${data[i].pk}">${data[i].descripcion}</option>`
        );
      }
      ocultarLoader();
    },
    error: function (response) {
      Swal.fire({
        icon: "error",
        title: "Error No Existe Turnos Favor De Seleccionar Otro ",
        showConfirmButton: false,
        timer: 1500,
      });
      ocultarLoader();
      console.log(response);
    },
  });
}

function GuardarTurno(e) {
  e.preventDefault();

  var maquina = $("#cbmaquinas").select2("data");
  var suervisor = $("#cbmsuperv").select2("data");
  var modo = $("#cbmmodo").select2("data");
  var turno = $("#cbmturno").select2("data");

  if (maquina[0].text == "" || maquina[0].text == "Seleccione") {
    Swal.fire({
      icon: "error",
      title: "Error Seleccione Una Maquina",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  }

  if (suervisor[0].text == "" || suervisor[0].text == "Seleccione") {
    Swal.fire({
      icon: "error",
      title: "Error Seleccione Un Supervisor",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  }

  if (modo[0].text == "" || modo[0].text == "Seleccione") {
    Swal.fire({
      icon: "error",
      title: "Error Seleccione Un Modo de Turno",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  }

  if (turno[0].text == "" || turno[0].text == "Seleccione") {
    Swal.fire({
      icon: "error",
      title: "Error Seleccione Un Turno",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  }

  if (funo == "") {
    Swal.fire({
      icon: "error",
      title: "Debe Seleccionar Una Fecha Inicial",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  }

  if (fdos == "") {
    Swal.fire({
      icon: "error",
      title: "Debe Seleccionar Una Fecha Final",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  }

  $.ajax({
    url: "modelos/buscarsupervisor.php",
    type: "POST",
    data: {
      fecha_ini: funo,
      fecha_fin: fdos,
      pk: suervisor[0].id,
    },
    dataType: "json",
    beforeSend: function (response) {},
    complete: function (response) {},
    success: function (data) {
      console.log("respuesta buscador");
      // console.log(data)

      if (data == 0) {
        $.ajax({
          url: "modelos/insertarturno.php",
          type: "POST",
          data: {
            fk_cliente_lersoft: pk,
            fk_maquina: maquina[0].id,
            fk_supervisor: suervisor[0].id,
            fk_modo_turno: modo[0].id,
            fk_turno: turno[0].id,
            fecha_ini: funo,
            fecha_fin: fdos,
          },
          dataType: "json",
          beforeSend: function (response) {},
          complete: function (response) {},
          success: function (data) {
            if (data[0]["message"] === "OK") {
              Swal.fire({
                icon: "success",
                title: "Registro Ingresado Correctamente",
                showConfirmButton: false,
                timer: 1500,
              });

              setInterval(location.reload(), 15000);
            }
          },
          error: function (response) {
            console.log(response);
          },
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "No Se Puede Registrar Turnos Ya Registrados",
          showConfirmButton: false,
          timer: 1500,
        });
      }
    },
    error: function (response) {
      console.log(response);
    },
  });
}

function obtenerplanta(pk) {
  $.ajax({
    url: "modelos/obtenerplanta.php",
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
      obtenerModo(data[0]["fk_planta"]);
    },
    error: function (response) {
      // window.location ="salir";
    },
  });
}
