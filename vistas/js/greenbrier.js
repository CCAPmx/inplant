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
      title: mensaje,
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

function obtenerDatosRecargas() {
  const datos = []; // Array donde se guardarán los resultados finales

  // Recorremos todos los inputs con clase 'input-carga'
  document.querySelectorAll(".input-carga").forEach((input) => {
    const id = input.dataset.id; // Obtenemos el ID desde el atributo data-id
    const valor = input.value.trim(); // Obtenemos el valor actual del input (sin espacios)
    const name = input.name; // Obtenemos el atributo name del input

    // Validamos que el campo no esté vacío antes de guardar
    if (valor !== "") {
      datos.push({
        id: parseInt(id), // Convertimos el ID a número entero
        carga_granallado: parseFloat(valor), // Convertimos el valor a número decimal
        name: name, // Guardamos el name tal como está
      });
    }
  });

  console.log("📦 Datos de recargas:", datos); // Mostramos el array por consola para depuración
  return datos; // Devolvemos el array con los datos capturados
}

let btnGuardarCambiosGranulometriaReporte = document.getElementById(
  "btnGuardarCambiosGranulometriaReporte"
);

btnGuardarCambiosGranulometriaReporte.addEventListener("click", function () {
  // FrmVisitas

  console.log("🔍 Botón Guardar Cambios Granulometría Reporte presionado");

  // Obtener el formulario de edición
  let form = document.getElementById("FrmReporteGreenbrierGranulometriaEditar");
  let inputs = form.querySelectorAll("input[type='number']");
  let valido = true;

  // let maquina_nombre =  document.getElementById("maquina_nueva_granulometria").value;

  let maquina_nombre = $("#btnGuardarCambiosGranulometriaReporte").val();
  // let cliente = $("#cbmClienteGranulometria").val();

  // console.log("cliente", cliente);
  console.log("maquina_nombre desde js", maquina_nombre);



  let arrayRecargasEditar = obtenerDatosRecargas();

  console.log("📦 Datos de recargas para editar:", arrayRecargasEditar);

  let dataFk = JSON.parse(maquina_nombre);


  let cliente = dataFk.cliente; // Obtener el cliente desde dataFk

  console.log("🔍 Cliente desde dataFk:", cliente);

  let url = "";

  let arrayDatos = {
    clienteNombre: cliente,
    maquinaNombre: dataFk.maquinaNombre,
    procesador_maq: dataFk.procesador_maq,
    fecha: dataFk.fecha,
    c_05: $("#c_05").val(),
    c_09: $("#c_09").val(),
    c_150: $("#c_150").val(),
    c_212: $("#c_212").val(),
    c_300: $("#c_300").val(),
    c_425: $("#c_425").val(),
    c_600: $("#c_600").val(),
    c_850: $("#c_850").val(),
    c_1180: $("#c_1180").val(),
    c_1400: $("#c_1400").val(),
    c_1700: $("#c_1700").val(),
    c_2200: $("#c_2200").val(),
    basura: $("#basura").val(),
    polvo: $("#polvo").val(),
    usuario: datosSesion,
  };

  // Si es GREENBRIER, agregamos los rugXX y basura_*
  if (cliente === "GREENBRIER") {
    for (let i = 1; i <= 20; i++) {
      let key = `rug${i.toString().padStart(2, "0")}`; // rug01, rug02, ...
      let selector = `#rig_${i.toString().padStart(2, "0")}`;
      arrayDatos[key] = $(selector).val();
    }

    const maxSize = 500 * 1024; // 500 KB

    // 🔹 Agregar las imágenes
    let img1 = document.getElementById("basura_img01").files[0];
    let img2 = document.getElementById("basura_img02").files[0];

    if (img1 && img1.size > maxSize) {
      Swal.fire({
        position: "center",
        icon: "error",
        title: "La imagen 01 no puede superar los 500KB",
        showConfirmButton: false,
        timer: 1500,
      });
      return;
    } else if (img2 && img2.size > maxSize) {
      Swal.fire({
        position: "center",
        icon: "error",
        title: "La imagen 02 no puede superar los 500KB",
        showConfirmButton: false,
        timer: 1500,
      });
      return;
    }

    // Agregar basura específica
    arrayDatos.basura_N_der = $('input[name="norte_der"]:checked').val();
    arrayDatos.basura_N_izq = $('input[name="norte_izq"]:checked').val();
    arrayDatos.basura_F_n = $('input[name="norte_afuera"]:checked').val();
    arrayDatos.basura_C_der = $('input[name="centro_der"]:checked').val();
    arrayDatos.basura_C_izq = $('input[name="centro_izq"]:checked').val();
    arrayDatos.basura_S_der = $('input[name="sur_der"]:checked').val();
    arrayDatos.basura_S_izq = $('input[name="sur_izq"]:checked').val();
    arrayDatos.basura_F_s = $('input[name="sur_afuera"]:checked').val();
    arrayDatos.vacio_silo_01 = $("#vacio_silo_1").val();
    arrayDatos.vacio_silo_02 = $("#vacio_silo_2").val();

    arrayDatos.basura_img01 = img1 ? img1 : ""; // Guardar el nombre del archivo
    arrayDatos.basura_img02 = img2 ? img2 : ""; // Guardar
    arrayDatos.fkCliente = dataFk.fkCliente;
    arrayDatos.fkMaquina = dataFk.fkMaquina;
    arrayDatos.id = dataFk.id;

    arrayDatos.recargas_granallados = JSON.stringify(arrayRecargasEditar);

    url =
      "controladores/granulometria.controlador.php?action=editar_reporte_greenbrier";
  }

  let formData = new FormData();

  // 🔹 Agregar todos los campos de arrayDatos
  for (const [key, value] of Object.entries(arrayDatos)) {
    formData.append(key, value);
  }

  // console.log("maquina_nombre", maquina_nombre);

  // console.log("arrayDatos", arrayDatos);

  inputs.forEach((input) => {
    // Si la máquina NO es GREENBRIER y el input es uno de los especiales, saltar validación
    if (
      maquina_nombre !== "GREENBRIER" &&
      ["vacio_silo_1", "vacio_silo_2"].includes(input.id)
    ) {
      return; // Saltar este input
    }

    // Validación normal
    if (!input.value.trim()) {
      input.classList.add("input-invalido");

      valido = false;
    } else {
      input.classList.remove("input-invalido");
    }
  });

  if (!valido) {
    var mensaje = document.getElementById("mensaje_granulometria_reporte");
    mensaje.style.display = "block";
    document.getElementById("mensaje_granulometria_reporte").innerHTML =
      "Por favor, complete todos los campos obligatorios, Si no hay datos debe de poner 0.";
    // alert("Por favor, complete todos los campos obligatorios.");
    return;
  } else {
    var mensaje = document.getElementById("mensaje_granulometria_reporte");
    mensaje.style.display = "none";
  }

  // let clienteFK = clientesData.find(
  //   (cliente) =>
  //     cliente.procesador_maq === parseInt(arrayDatos.procesador_maq, 10)
  // );

  let options = {
    method: "POST",

    body: formData,
  };
  var urlGranulometria =
    "controladores/granulometria.controlador.php?action=editar_reporte_greenbrier";

  mensaje = "Granulometria editada con exito";


  console.log("📦 FormData enviado:", arrayDatos);

  for (let [key, value] of formData.entries()) {
    console.log(`${key}:`, value);
  }

  parametresGetFetch(url, options, mensaje);
});
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
