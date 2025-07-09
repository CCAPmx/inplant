let clientesData = []; // 🔹 Variable para almacenar la data
let selectorDataAlertas = [];

// 🔹 Función para obtener datos y almacenarlos en `clientesData`
function getFetch(url, data) {
  return fetch(url, {
    method: "GET",
    headers: { "Content-Type": "application/json" },
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error(`Error HTTP: ${response.status}`);
      }
      return response.json();
    })
    .then((data) => {
      clientesData = data; // Guardar los datos en la variable global
      // console.log("✅ Datos almacenados en clientesData:", clientesData);
      return data;
    })
    .catch((error) => {
      console.error("❌ Error en la solicitud:", error);
      return []; // Devolver un array vacío en caso de error
    });
}

function getFetchSelectorAlertas(url, data) {
  return fetch(url, {
    method: "GET",
    headers: { "Content-Type": "application/json" },
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error(`Error HTTP: ${response.status}`);
      }
      return response.json();
    })
    .then((data) => {
      selectorDataAlertas = data; // Guardar los datos en la variable global
      // console.log("✅ Datos almacenados en clientesData:", clientesData);
      return data;
    })
    .catch((error) => {
      console.error("❌ Error en la solicitud:", error);
      return []; // Devolver un array vacío en caso de error
    });
}

function parametresGetFetch(url, options, mensaje) {
  fetch(url, options)
    .then((response) => response.json())
    .then((data) => dataResponse(data, mensaje))
    .catch((errorB) => console.log("error", errorB));
}

async function dataResponse(datajson, mensaje) {
  // console.log(datajson);
  fechaActualEvento = [];

  if (datajson.status == 200) {
    Swal.fire({
      position: "center",
      icon: "success",
      title: datajson.message,
      showConfirmButton: false,
      timer: 2000,
    }).then(() => {
      // table.ajax.reload(null, false);
      // $('#infoModal').modal('hide');
      // Resetear el formulario y cerrar el modal después del mensaje de éxito
      window.location.reload();
    });
  } else {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Ocurrió un error al guardar la visita",
      text: datajson.message || "Intente nuevamente más tarde",
      showConfirmButton: true,
    });
  }
}

// 🔹 Función para poblar el <select> de clientes
function crearSelectorClientes(data) {
  // console.log("🔍 Datos recibidos:", data);

  const selectClientes = document.getElementById(
    "selectorGranulometriaGreenbrier"
  );
  if (!selectClientes) return;

  selectClientes.innerHTML = '<option value="">Seleccione una opción</option>';

  data.forEach((item) => {
    const option = document.createElement("option");

    // El value puede ser el ID o lo que tú necesites
    option.value = JSON.stringify(item);

    const [año, mes, dia] = item.fecha.split("-");
    const fechaFormateada = `${dia}/${mes}/${año}`;

    // Mostramos cliente + nombre de máquina + fecha
    option.textContent = `${fechaFormateada} - ${item.cliente} - ${item.nombre_maquina} - ${item.usuario}`;

    if (item.usada == 1) {
      option.disabled = true;
      option.style.color = "gray";
      option.style.fontStyle = "italic";
      option.textContent = `🔒 ${option.textContent} (usada)`;
    }

    selectClientes.appendChild(option);
  });
}

async function cargarSelectorAlertas(dataAlertas, selectId, inputMensajeId) {
  const select = document.getElementById(selectId);
  const inputMensaje = document.getElementById(inputMensajeId);

  if (!select || !inputMensaje) return;

  // Limpiar y agregar opción por defecto
  select.innerHTML = '<option value="">Seleccione</option>';

  dataAlertas.forEach((alerta) => {
    const option = document.createElement("option");
    option.value = alerta.id;
    option.textContent = alerta.titulo;
    option.setAttribute("data-texto", alerta.texto);
    option.setAttribute("data-urgencia", alerta.urgencia); // si deseas usarlo
    select.appendChild(option);
  });

  // Evento: al seleccionar título → llenar mensaje automáticamente
  select.addEventListener("change", function () {
    const selectedOption = this.options[this.selectedIndex];
    const texto = selectedOption.getAttribute("data-texto");
    inputMensaje.value = texto || "";
  });
}

let btnGuardarGranulometriaReporte = document.getElementById(
  "btnGuardarGranulometriaReporte"
);

btnGuardarGranulometriaReporte.addEventListener("click", () => {
  const form = document.getElementById("FrmReporteGreenbrier");

  // 🔹 Obtener y parsear el objeto de granulometría seleccionado
  const selectValue = document.getElementById(
    "selectorGranulometriaGreenbrier"
  ).value;
  let granulometriaSeleccionada = null;

  // console.log("🔍 Valor seleccionado:", selectValue);

  if (!selectValue) {
    Swal.fire({
      position: "center",
      icon: "warning",
      title: "No se ha seleccionado ninguna granulometría Greenbrier",
      showConfirmButton: true,
      timer: 2000,
    });
    return;
  }

  if (selectValue) {
    try {
      granulometriaSeleccionada = JSON.parse(selectValue);
    } catch (error) {
      console.error("❌ Error al parsear el valor seleccionado:", error);
    }
  }

  // 🔹 Obtener los comentarios
  const comentario1 = document.getElementById("cometario_1").value;
  const comentario2 = document.getElementById("cometario_2").value;
  const comentario3 = document.getElementById("cometario_3").value;
  const comentario4 = document.getElementById("cometario_4").value;

  const formData = new FormData(form);
  formData.append("granulometria", JSON.stringify(granulometriaSeleccionada));

  formData.append("comment_01", comentario1);
  formData.append("comment_02", comentario2);
  formData.append("comment_03", comentario3);
  formData.append("comment_04", comentario4);

  // console.log("granulometriaSeleccionada", granulometriaSeleccionada);
  // console.log("formData", formData);

  let url =
    "controladores/granulometria.controlador.php?action=crear_reporte_greenbrier";

  let options = {
    method: "POST",
    body: formData,
  };
  mensaje = "reporte guardado con exito";

  parametresGetFetch(url, options, mensaje);

  console.log("📦 Contenido de FormData:");
  for (let [key, value] of formData.entries()) {
    console.log(`${key}:`, value);
  }
});

let btnGuardarGranulometriaReporteEditar = document.getElementById(
  "btnGuardarGranulometriaReporteEditar"
);

btnGuardarGranulometriaReporteEditar.addEventListener("click", () => {
  const form = document.getElementById("FrmReporteGreenbrierEditar");

  // 🔹 Obtener los comentarios
  const comentario1 = document.getElementById("cometario_1").value;
  const comentario2 = document.getElementById("cometario_2").value;
  const comentario3 = document.getElementById("cometario_3").value;
  const comentario4 = document.getElementById("cometario_4").value;

  const formData = new FormData(form);
  // formData.append("granulometria", JSON.stringify(granulometriaSeleccionada));

  formData.append("comment_01", comentario1);
  formData.append("comment_02", comentario2);
  formData.append("comment_03", comentario3);
  formData.append("comment_04", comentario4);

  // console.log("granulometriaSeleccionada", granulometriaSeleccionada);
  // console.log("formData", formData);

  let url =
    "controladores/granulometria.controlador.php?action=editar_reporte_greenbrier_autorizacion";

  let options = {
    method: "POST",
    body: formData,
  };
  mensaje = "reporte editado con exito";

  parametresGetFetch(url, options, mensaje);

  console.log("📦 Contenido de FormData:");
  for (let [key, value] of formData.entries()) {
    console.log(`${key}:`, value);
  }
});

let btnAutorizarGranulometriaReporte = document.getElementById(
  "btnAutorizarGranulometriaReporte"
);

btnAutorizarGranulometriaReporte.addEventListener("click", () => {
  const form = document.getElementById("FrmReporteGreenbrierEditar");

  // 🔹 Obtener los comentarios
  const comentario1 = document.getElementById("cometario_1").value;
  const comentario2 = document.getElementById("cometario_2").value;
  const comentario3 = document.getElementById("cometario_3").value;
  const comentario4 = document.getElementById("cometario_4").value;

  const formData = new FormData(form);
  // formData.append("granulometria", JSON.stringify(granulometriaSeleccionada));

  formData.append("comment_01", comentario1);
  formData.append("comment_02", comentario2);
  formData.append("comment_03", comentario3);
  formData.append("comment_04", comentario4);

  // console.log("granulometriaSeleccionada", granulometriaSeleccionada);
  // console.log("formData", formData);

  let url =
    "controladores/granulometria.controlador.php?action=autorizarReporteGreenbrier";

  let options = {
    method: "POST",
    body: formData,
  };
  mensaje = "Reporte actualizado correctamente";

  parametresGetFetch(url, options, mensaje);

  // console.log("📦 Contenido de FormData:");
  // for (let [key, value] of formData.entries()) {
  //   console.log(`${key}:`, value);
  // }
});

// 🔹 Función para filtrar y poblar el select de máquinas con clientes repetidos

function formatoFecha() {
  var input = document.getElementById("txtFechaGranulometria").value;
  var fecha = new Date(input);
  var dia = ("0" + fecha.getDate()).slice(-2);
  var mes = ("0" + (fecha.getMonth() + 1)).slice(-2);
  var año = fecha.getFullYear();
  var fechaFormateada = mes + "/" + dia + "/" + año;
  document.getElementById("fechaFormateada").textContent = fechaFormateada;
}

async function getFetchOptimizado(url) {
  try {
    const response = await fetch(url, {
      method: "GET",
      headers: { "Content-Type": "application/json" },
    });

    if (!response.ok) {
      throw new Error(`Error HTTP: ${response.status}`);
    }

    return await response.json(); // ⬅️ retornas los datos directamente
  } catch (error) {
    console.error("❌ Error en la solicitud:", error);
    return { data: [] }; // siempre devuelve objeto con `data`
  }
}
// granulometriaGreenbrierInfoReporte

// 🔹 Función para obtener los datos y almacenarlos en clientesData
async function cargarGranulometriaGreenbrier() {
  const urlSelectoAlertas =
    "controladores/granulometria.controlador.php?action=dataSelectorAlertasGreenbrier";
  // clientesDataAlertas = await getFetch(urlSelectoAlertas);

  const selectorDataAlertas = await getFetchOptimizado(urlSelectoAlertas);

  console.log("🔍 Datos de alertas:", selectorDataAlertas);
  cargarSelectorAlertas(
    selectorDataAlertas,
    "tituloAlerta1",
    "txtMensajeAlerta"
  );
  cargarSelectorAlertas(
    selectorDataAlertas,
    "tituloAlerta2",
    "txtMensajeAlerta2"
  );
  cargarSelectorAlertas(
    selectorDataAlertas,
    "tituloAlerta3",
    "txtMensajeAlerta3"
  );


  cargarSelectorAlertas(
    selectorDataAlertas,
    "tituloAlerta1Edicion",
    "txtMensajeAlertaEdicion"
  );
  cargarSelectorAlertas(
    selectorDataAlertas,
    "tituloAlerta2Edicion",
    "txtMensajeAlerta2Edicion"
  );
  cargarSelectorAlertas(
    selectorDataAlertas,
    "tituloAlerta3Edicion",
    "txtMensajeAlerta3Edicion"
  );
  

  const urlGranulometria =
    "controladores/granulometria.controlador.php?action=dataGranulometriaGreenbrierSelector";
  clientesData = await getFetch(urlGranulometria);

  crearSelectorClientes(clientesData.data);
}

// 🔹 Iniciar la carga de datos
cargarGranulometriaGreenbrier();
