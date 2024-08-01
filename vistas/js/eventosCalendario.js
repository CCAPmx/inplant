let fechaActualEvento = [];
let url = "modelos/eventos_calendario.php";

let options = {
  method: "POST",
  headers: {
    Accept: "application/json",
    "Content-Type": "application/json",
  },
  body: JSON.stringify({
    fecha: "0",
  }),
};

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
  if (datajson.status == 400) {
    Swal.fire({
      position: "center",
      icon: "info",
      title: "No hay eventos en este mes",
      showConfirmButton: false,
      timer: 2500,
    });
  }

  if (datajson.status == 200) {
    let tamArrayEvento = datajson.datosEventos;

    for (i = 0; i < tamArrayEvento.length; i++) {
      let convercionFecha = new Date(tamArrayEvento[i].fieldData.t_ini);
      let convercionFechaFin = new Date(tamArrayEvento[i].fieldData.t_fin);
      console.log(convercionFecha.toISOString());


      let tipoColor = "";
      if (tamArrayEvento[i].fieldData.color_turno == 1) {
        tipoColor = "#07B5E8";
      }

      if (tamArrayEvento[i].fieldData.color_turno == 2) {
        tipoColor = "#EC900D";
      }

      if (tamArrayEvento[i].fieldData.color_turno == 3) {
        tipoColor = "#DA90A4";
      }

      fechaActualEvento.push.apply(fechaActualEvento, [
        {
          title:
            tamArrayEvento[i].fieldData.nombre_supervisor ,
          start: convercionFecha.toISOString(),
          end: convercionFechaFin.toISOString(),
          allDay: false,
          timeFormat: 'h:mm' ,
          extendedProps: {
            data: tamArrayEvento[i].fieldData,
          },
          color: tipoColor,
          
          
        },
      ]);
    }
  }

  // console.log(fechaActualEvento)
}

document.addEventListener("DOMContentLoaded", function () {
  var calendarEl = document.getElementById("calendar");
  var calendar = new FullCalendar.Calendar(calendarEl, {
    headerToolbar: {
      left: "prev,next",
      center: "title",
      right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth",
    },
    locale: "es",
    initialDate: new Date(),
    editable: true,
    selectable: true,
    businessHours: true,
    dayMaxEvents: true, // allow "more" link when too many events
    buttonText: {
      today: "Hoy",
      year: "Año",
      month: "Mes",
      week: "Semana",
      day: "Día",
      list: "Agenda",
    },
    eventClick: function (info) {
      $("#exampleModalLabel").html(info.event.title);
      $("#fecha").html(info.event.extendedProps.data.fecha);
      $("#hora_ini").html(info.event.extendedProps.data.hora_ini);
      $("#hora_fin").html(info.event.extendedProps.data.hora_fin);
      $("#maquina").html(info.event.extendedProps.data.nombre_maquina);
      $("#supervisor").html(info.event.extendedProps.data.nombre_supervisor);
      $("#turno").html(info.event.extendedProps.data.nombre_turno);
      $("#exampleModal").modal("show");
    },
    weekText: "Sm",
    allDayText: "Todo el día",
    moreLinkText: "más",
    noEventsText: "No hay eventos para mostrar",
    events: function (fetchInfo, successCallback, failureCallback) {
      successCallback(fechaActualEvento); // fetchInfo(fechaActualEvento)
      
    },

    eventTimeFormat: { // like '14:30:00'
      hour: '2-digit',
      minute: '2-digit',     
      hour12: false
    },
    customButtons: {
      prev: {
        text: "Prev",
        click: function () {
          calendar.prev();
          let fecha = calendar.getDate();
          console.log(fecha.toISOString());

          options = {
            method: "POST",
            headers: {
              Accept: "application/json",
              "Content-Type": "application/json",
            },
            body: JSON.stringify({
              fecha: calendar.getDate(),
            }),
          };
          ajaxParametos(url, options);
        },
      },
      next: {
        text: "Next",
        click: function () {
          calendar.next();
          let fecha = calendar.getDate();
          console.log(fecha.toISOString());

          options = {
            method: "POST",
            headers: {
              Accept: "application/json",
              "Content-Type": "application/json",
            },
            body: JSON.stringify({
              fecha: calendar.getDate(),
            }),
          };
          ajaxParametos(url, options);
        },
      },
    },
  });

  calendar.render();

  setInterval(() => {
    calendar.refetchEvents();
  }, 1000);
});
