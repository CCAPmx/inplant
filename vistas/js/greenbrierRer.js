let clientesData = []; // 🔹 Variable para almacenar la data

// 🔹 Función para obtener datos y almacenarlos en `clientesData`
function getFetch(url) {
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

// function crearSelector(data) {
//   const select = document.getElementById("cbmClienteGranulometria");

//   // Limpiar opciones previas
//   select.innerHTML = '<option value="">Seleccione una opción</option>';

//   // Usar `Set` para almacenar clientes únicos
//   const clientesUnicos = new Set();

//   data.forEach((cliente) => {
//     if (!clientesUnicos.has(cliente.cliente)) {
//       // Verifica si ya está agregado
//       clientesUnicos.add(cliente.cliente); // Agregar al Set para evitar duplicados

//       let option = document.createElement("option");
//       option.value = cliente.procesador_maq; // Suponiendo que cada cliente tiene un 'id'
//       option.textContent = cliente.cliente; // Suponiendo que cada cliente tiene un 'nombre'

//       // Marcar como seleccionado si es GREENBRIER
//       if (cliente.cliente === "GREENBRIER") {
//         option.selected = true;
//       }
//       select.appendChild(option);
//     }
//   });
// }

// 🔹 Función para poblar el <select> de clientes
// function crearSelectorClientes(data) {
//   const selectClientes = document.getElementById("cbmClienteGranulometria");
//   selectClientes.innerHTML = '<option value="">Seleccione un Cliente</option>';

//   const clientesUnicos = new Set();

//   data.forEach((cliente) => {
//     if (!clientesUnicos.has(cliente.cliente)) {
//       clientesUnicos.add(cliente.cliente);
//       let option = document.createElement("option");
//       option.value = cliente.cliente; // Se usa `procesador_maq` como value
//       option.textContent = cliente.cliente;

//       // Marcar como seleccionado si es GREENBRIER
//       if (cliente.cliente === "GREENBRIER") {
//         option.selected = true;
//       }
//       selectClientes.appendChild(option);
//     }
//   });

//   // 🔹 Evento cuando se selecciona un cliente
//   selectClientes.addEventListener("change", function () {
//     const procesadorMaqSeleccionado = this.value;
//     // console.log("🔍 Procesador seleccionado:", procesadorMaqSeleccionado);
//     actualizarSelectorMaquinas(procesadorMaqSeleccionado);
//   });

//   // 🔹 Disparar el cambio si GREENBRIER fue seleccionado automáticamente
//   if (selectClientes.value === clientePreseleccionado) {
//     selectClientes.dispatchEvent(new Event("change"));
//   }
// }

// 🔹 Función para poblar el <select> de clientes
function crearSelectorClientesGreenbrier(data) {
  const selectClientes = document.getElementById("cbmClienteGranulometria");
  selectClientes.innerHTML = '<option value="GREENBRIER">GREENBRIER</option>';

  const clientesUnicos = new Set();
  const clientePreseleccionado = "GREENBRIER";

  data.forEach((cliente) => {
    const nombreCliente = cliente.cliente.trim().toUpperCase();

    if (!clientesUnicos.has(nombreCliente)) {
      clientesUnicos.add(nombreCliente);

      let option = document.createElement("option");
      option.value = nombreCliente;
      option.textContent = cliente.cliente;

      if (cliente.cliente === clientePreseleccionado) {
        option.selected = true; // Marcar como seleccionado si es GREENBRIER
      }

      selectClientes.appendChild(option);
    }
  });

  // 🔹 Evento cuando se selecciona un cliente
  selectClientes.addEventListener("change", function () {
    const procesadorMaqSeleccionado = this.value;
    actualizarSelectorMaquinas(procesadorMaqSeleccionado);
  });

  // ✅ Forzar selección después de poblar opciones
  selectClientes.value = clientePreseleccionado;
  selectClientes.disabled = false;

  // 🔹 Disparar evento si se seleccionó
  if (selectClientes.value === clientePreseleccionado) {
    selectClientes.dispatchEvent(new Event("change"));
  }

  // 🧪 DEBUG
  // console.log("Valor final del selector:", selectClientes.value);
}

// 🔹 Función para filtrar y poblar el select de máquinas con clientes repetidos
function actualizarSelectorMaquinas(cliente) {
  const selectMaquinas = document.getElementById("cbmmaquinaGranulometria");
  selectMaquinas.innerHTML = '<option value="">Seleccione una Máquina</option>';
  // console.log("🔍 Cliente seleccionado:", cliente);

  // Filtrar clientes repetidos con el mismo nombre
  const maquinasFiltradas = clientesData.filter(
    (item) => item.cliente === cliente
  );

  console.log("🔍 Máquinas filtradas:", maquinasFiltradas);

  // Agregar opciones al select de máquinas
  maquinasFiltradas.forEach((item) => {
    let option = document.createElement("option");
    option.value = item.procesador_maq; // Suponiendo que cada máquina tiene un ID
    option.textContent = item.nombre; // Suponiendo que cada máquina tiene un nombre
    selectMaquinas.appendChild(option);
  });
}

function formatoFecha() {
  var input = document.getElementById("txtFechaGranulometria").value;
  var fecha = new Date(input);
  var dia = ("0" + fecha.getDate()).slice(-2);
  var mes = ("0" + (fecha.getMonth() + 1)).slice(-2);
  var año = fecha.getFullYear();
  var fechaFormateada = mes + "/" + dia + "/" + año;
  document.getElementById("fechaFormateada").textContent = fechaFormateada;
}

document.addEventListener("DOMContentLoaded", function () {
  const fechaInput = document.getElementById("txtFechaGranulometria");
  const hoy = new Date();
  const unDia = 24 * 60 * 60 * 1000; // Milisegundos en un día

  // Formatear fecha como YYYY-MM-DD
  function formatearFecha(date) {
    let mes = "" + (date.getMonth() + 1),
      dia = "" + date.getDate(),
      año = date.getFullYear();

    if (mes.length < 2) mes = "0" + mes;
    if (dia.length < 2) dia = "0" + dia;

    return [año, mes, dia].join("-");
  }

  // // Establecer la fecha máxima (hoy) y mínima (3 días antes)
  // fechaInput.max = formatearFecha(hoy);
  // fechaInput.min = formatearFecha(new Date(hoy - 6 * unDia));
  fechaInput.value = fechaInput.max; // Establece la fecha por defecto a hoy
});

const modalGranulometria = document.getElementById("modalGranulometria");
const formulario = document.getElementById("FrmVisitas");

if (modalGranulometria && formulario) {
  // Cuando el modal se abre
  modalGranulometria.addEventListener("show.bs.modal", function () {
    formulario.reset();
    resetiarModal();
  });

  // Cuando el modal se cierra
  modalGranulometria.addEventListener("hidden.bs.modal", function () {
    formulario.reset();
    resetiarModal(); // Llamar a la función para resetear el modal
  });
}

// let btnGuardarCambiosGranulometria = document.getElementById("btnGuardarCambiosGranulometria");

// 🔹 Evento para el botón "Siguiente"
let btnSiguienteGranulometria = document.getElementById(
  "btnSiguienteGranulometria"
);

btnSiguienteGranulometria.addEventListener("click", function () {
  let cliente = document.getElementById("cbmClienteGranulometria").value;
  let maquina = document.getElementById("cbmmaquinaGranulometria").value;
  let fecha = document.getElementById("txtFechaGranulometria").value;
  let nombreCliente = $("#cbmClienteGranulometria option:selected").text();
  let maquinaCliente = $("#cbmmaquinaGranulometria option:selected").text();
  $(".modal-title").show();
  $(".info_granulometria_header").hide();

  resetiarModal();

  if (cliente == 0) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "se requiere seleccionar un cliente",
      showConfirmButton: false,
      timer: 1500,
    });
  } else if (maquina.length == 0 || maquina === "Ninguno") {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "se requiere seleccionar una maquina",
      showConfirmButton: false,
      timer: 1500,
    });
  } else if (fecha.length == 0) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "se requiere seleccionar una fecha",
      showConfirmButton: false,
      timer: 1500,
    });
  } else {
    $(".btnSiguienteGranulometria").hide();
    $(".contenedor_form_granulometria_nueva").hide();
    $(".btnSiguienteGranulometria").hide();
    $(".btnRegresarGranulometria").show();
    $(".contenedor_form_granulometria").show();
    $(".btnGuardarGranulometria").show();

    // $(".rugosidad_greenbrier").hide();
    // $(".modal-title").text("Nuevo Reporte de Granulometría");

    $(".modal-title").hide();
    $(".info_granulometria_header").show();

    $("#fecha_nueva_granulometria").text(fecha);
    $("#cliente_nueva_granulometria").text(nombreCliente);
    $("#maquina_nueva_granulometria").text(maquinaCliente);

    if (nombreCliente === "GREENBRIER") {
      $(".conteneror_rugosidad").show();
      $(".contener_silo").show();
      $(".contenedor_basura").show();
      // console.log("Cliente Greenbrier seleccionado");
    }
  }

  //   let idGranulometria = document.getElementById("txtIdGranulometria").value;
});

// 🔹 Opción de regresar o cambiar los valores de nuevo (puedes añadir un botón si es necesario)
$("#btnRegresarGranulometria").on("click", function () {
  $(".contenedor_form_granulometria").hide();
  $(".btnSiguienteGranulometria").show();
  $(".btnRegresarGranulometria").hide();
  $(".btnGuardarGranulometria").hide();
  $(".contenedor_form_granulometria_nueva").show();
  $(".modal-title").show();
  $(".info_granulometria_header").hide();
});

// 🔹 Evento para el botón "Guardar"

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

let btnGuardarGranulometria = document.getElementById(
  "btnGuardarGranulometria"
);

btnGuardarGranulometria.addEventListener("click", function () {
  // FrmVisitas

  // Obtener el formulario de edición
  let form = document.getElementById("FrmVisitas");
  let inputs = form.querySelectorAll("input[type='number']");
  let valido = true;

  let arrayRecargas = obtenerDatosRecargas();
  // console.log("📦 Datos de recargas:", arrayRecargas);

  // let maquina_nombre =  document.getElementById("maquina_nueva_granulometria").value;

  let maquina_nombre = $("#cbmmaquinaGranulometria option:selected").text();
  let cliente = $("#cbmClienteGranulometria").val();

  let url = "";

  let arrayDatos = {
    clienteNombre: $("#cbmClienteGranulometria").val(),
    maquinaNombre: maquina_nombre,
    procesador_maq: $("#cbmmaquinaGranulometria").val(),
    fecha: $("#txtFechaGranulometria").val(),
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

  // console.log("cliente", cliente);

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
    arrayDatos.recargas_granallados = JSON.stringify(arrayRecargas);

    arrayDatos.basura_img01 = img1 ? img1 : ""; // Guardar el nombre del archivo
    arrayDatos.basura_img02 = img2 ? img2 : ""; // Guardar

    let clienteFK = clientesData.find(
      (cliente) =>
        cliente.procesador_maq === parseInt(arrayDatos.procesador_maq, 10)
    );

    arrayDatos.fkCliente = clienteFK.id_cliente;
    arrayDatos.fkMaquina = clienteFK.fkMaquina;
    arrayDatos.maquinaNombre = clienteFK.nombre;
    console.log("arrayDatos", arrayDatos);
    // console.log(clientesData);
    // console.log('clienteFK',clienteFK);

    url =
      "controladores/granulometria.controlador.php?action=insertar_reporte_greenbrier";
  } else {
    url = "controladores/granulometria.controlador.php?action=insertar"; // puedes ajustar esto
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
    var mensaje = document.getElementById("mensaje_granulometria");
    mensaje.style.display = "block";
    document.getElementById("mensaje_granulometria").innerHTML =
      "Por favor, complete todos los campos obligatorios, Si no hay datos debe de poner 0.";
    // alert("Por favor, complete todos los campos obligatorios.");
    return;
  } else {
    var mensaje = document.getElementById("mensaje_granulometria");
    mensaje.style.display = "none";
  }

  // // Verificar si el formulario es válido (esto mostrará mensajes de error nativos en el navegador)
  // if (!form.checkValidity()) {
  //   // Si el formulario no es válido, evita continuar y dispara la validación
  //   form.reportValidity();
  //   return;
  // }

  let options = {
    method: "POST",
    // headers: {
    //   Accept: "application/json",
    //   "Content-Type": "application/json",
    // },
    body: formData,
  };
  var urlGranulometria =
    "controladores/granulometria.controlador.php?action=insertar_reporte_greenbrier";

  mensaje = "Granulometria guardada con exito";

  parametresGetFetch(url, options, mensaje);
});

let btnGuardarCambiosGranulometria = document.getElementById(
  "btnGuardarCambiosGranulometria"
);

btnGuardarCambiosGranulometria.addEventListener("click", function () {
  // FrmVisitas

  // Obtener el formulario de edición
  let form = document.getElementById("FrmVisitas");
  let inputs = form.querySelectorAll("input[type='number']");
  let valido = true;

  // let maquina_nombre =  document.getElementById("maquina_nueva_granulometria").value;

  let maquina_nombre = $("#btnGuardarCambiosGranulometria").val();
  let cliente = $("#cbmClienteGranulometria").val();

  // console.log("cliente", cliente);
  console.log("maquina_nombre desde js", maquina_nombre);

  let arrayRecargasEditar = obtenerDatosRecargas();

  console.log("📦 Datos de recargas para editar:", arrayRecargasEditar);
  // const dataEdicion = data; // Guardar los datos para la edición

  // console.log("dataEcicion", dataEdicion);

  let dataFk = JSON.parse(maquina_nombre);

  // console.log("dataFk.fkCliente", dataFk.fkCliente);
  // console.log("dataFk.fkMaquina", dataFk.fkMaquina);
  // console.log("dataFk", dataFk);

  let url = "";

  let arrayDatos = {
    clienteNombre: $("#cbmClienteGranulometria").val(),
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
    var mensaje = document.getElementById("mensaje_granulometria");
    mensaje.style.display = "block";
    document.getElementById("mensaje_granulometria").innerHTML =
      "Por favor, complete todos los campos obligatorios, Si no hay datos debe de poner 0.";
    // alert("Por favor, complete todos los campos obligatorios.");
    return;
  } else {
    var mensaje = document.getElementById("mensaje_granulometria");
    mensaje.style.display = "none";
  }

  // // Verificar si el formulario es válido (esto mostrará mensajes de error nativos en el navegador)
  // if (!form.checkValidity()) {
  //   // Si el formulario no es válido, evita continuar y dispara la validación
  //   form.reportValidity();
  //   return;
  // }

  let clienteFK = clientesData.find(
    (cliente) =>
      cliente.procesador_maq === parseInt(arrayDatos.procesador_maq, 10)
  );

  // arrayDatos.fkCliente = clienteFK.id_cliente;
  // arrayDatos.fkMaquina = clienteFK.fkMaquina;
  // arrayDatos.maquinaNombre = clienteFK.nombre;
  // console.log(arrayDatos);
  // console.log(clientesData);
  // console.log(clienteFK);

  let options = {
    method: "POST",
    // headers: {
    //   Accept: "application/json",
    //   "Content-Type": "application/json",
    // },
    body: formData,
  };
  var urlGranulometria =
    "controladores/granulometria.controlador.php?action=editar_reporte_greenbrier";

  mensaje = "Granulometria editada con exito";

  parametresGetFetch(url, options, mensaje);
});

function resetiarModal() {
  // Restaurar título
  $(".contenedor_form_granulometria_nueva").show();
  $(".conteneror_rugosidad").hide();
  $(".contener_silo").hide();
  $(".contenedor_basura").hide();
  $(".modal-title").show();
  $(".info_granulometria_header").hide();
  $(".contenedor_form_granulometria").hide();
  $(".btnSiguienteGranulometria").hide();
  $(".btnSiguienteGranulometria").show();
  $(".btnRegresarGranulometria").hide();
}

let btnNuevaGranulometria = document.getElementById("btnNuevaGranulometria");
btnNuevaGranulometria.addEventListener("click", function () {
  // console.log("🔄 Botón Nueva Granulometría clickeado");

  formulario.reset();

  // contenedor_form_granulometria_nueva
  $(".contenedor_form_granulometria_nueva").show();
  $(".contenedor_form_granulometria").hide();

  $(".btnGuardarCambiosGranulometria").hide();
  $(".btnRegresarGranulometria").hide();
  $(".btnSiguienteGranulometria").show();
  $(".btnGuardarGranulometria").hide();

  // Limpiar inputs file
  document.getElementById("basura_img01").value = "";
  document.getElementById("basura_img02").value = "";

  // Restaurar imágenes por defecto
  document.getElementById("imgPreview01").src =
    "vistas/recursos/img/avatars/image-not-found.jpg";
  document.getElementById("imgPreview02").src =
    "vistas/recursos/img/avatars/image-not-found.jpg";
});

// 🔹 Función para obtener los datos y almacenarlos en clientesData
async function cargarClientesGreenbrier() {
  const urlGranulometria =
    "controladores/granulometria.controlador.php?action=1";
  clientesData = await getFetch(urlGranulometria);
  // console.log("✅ Datos cargados:", clientesData);
  crearSelectorClientesGreenbrier(clientesData);
  // console.log("✅ Selector de clientes creado con éxito greenbrier");
}

// 🔹 Iniciar la carga de datos
cargarClientesGreenbrier();

let btnSiguienteGranulometriaTabla = document.getElementById(
  "btnSiguienteGranulometria"
);

btnSiguienteGranulometriaTabla.addEventListener("click", function () {
  const maquina = document.querySelector("#cbmmaquinaGranulometria").value;
  console.log("🔄 Botón Siguiente Granulometría clickeado", maquina);
  datatableRecargasGranalla(maquina, "nuevo");
});

function datatableRecargasGranalla(maquina,tipo) {

  console.log("🔄 Cargando datos de recargas para la máquina:", maquina);
  console.log("🔄 Tipo de carga:", tipo);
  // console.log("🔄 Cargando datos de recargas para la máquina:", maquina);
  // Destruir si ya están inicializadas
  if ($.fn.DataTable.isDataTable("#tablaHoy")) {
    $("#tablaHoy").DataTable().clear().destroy();
  }
  if ($.fn.DataTable.isDataTable("#tablaAnteriores")) {
    $("#tablaAnteriores").DataTable().clear().destroy();
  }

  $.ajax({
    url: "controladores/granulometria.controlador.php?action=dataGranulometriaGreenbrierRecargasGranalla",
    type: "POST",
    contentType: "application/json",
    data: JSON.stringify({ arrayDatos: { maquina } }),
    success: function (responseRaw) {
      let response;
      try {
        response =
          typeof responseRaw === "string"
            ? JSON.parse(responseRaw)
            : responseRaw;
      } catch (e) {
        console.error("❌ Error al parsear JSON:", e);
        return;
      }

      if (!response || !Array.isArray(response.data)) {
        console.warn("⚠️ No hay datos válidos:", response);
        return;
      }

      const hoy = new Date().toLocaleDateString("en-CA", {
        timeZone: "America/Mexico_City",
      });

      const registrosHoy = [];
      const registrosAnteriores = [];
      const tablaNuevoReporte = {
        id: 0,
        fecha: hoy,
        carga_granalla: 0,        
        cliente: "GREENBRIER",
        unidad: "KG",
      };

      console.log("🔄 Registros hoy:", hoy);
      console.log("🔄 Registros hoy:", tablaNuevoReporte);

      response.data.forEach((item) => {
        if (item.fecha === hoy) {
          registrosHoy.push(item);
        } else {
          registrosAnteriores.push(item);
        }
      });

      console.log("🔄 Registros de hoy:", registrosHoy);
      console.log("🔄 Registros anteriores:", registrosAnteriores);

      // Init tabla de hoy
      $("#tablaHoy").DataTable({
        data: tipo === "nuevo" ? [tablaNuevoReporte] : registrosHoy,
        columns: getColumnDefs(),
        paging: false,
        searching: false,
        info: false,
        ordering: false,
        language: {
          sEmptyTable: "Sin registros para hoy.",
        },
      });

      // Init tabla de anteriores
      $("#tablaAnteriores").DataTable({
        data: registrosAnteriores,
        columns: getColumnDefs(),
        paging: false,
        searching: false,
        info: false,
        ordering: false,
        language: {
          sEmptyTable: "Sin registros anteriores.",
        },
      });
    },
    error: function (xhr, status, error) {
      console.error("❌ Error AJAX:", status, error);
    },
  });
}

// Destruir si ya están inicializada

// Función común de columnas
function getColumnDefs() {
  return [
    { data: "id", className: "text-center" },
    {
      data: "fecha",
      className: "text-center",
      render: function (data) {
        if (!data) return "";

        const [y, m, d] = data.split("-");
        const fechaFormateada = `${d}/${m}/${y}`;

        const hoy = new Date();
        const fechaHoy = hoy.toISOString().split("T")[0]; // yyyy-mm-dd

        if (data === fechaHoy) {
          return `<strong class="text-success">Hoy</strong>`;
        }
        return `<strong>${fechaFormateada}</strong>`;
      },
    },
    {
      data: "carga_granalla",
      className: "text-center",
      render: function (data, type, row) {
        return `
          <input 
            type="number" 
            class="form-control text-center input-carga" 
            data-id="${row.id}" 
            name="recarga_granallado_${row.id}"
            id="recarga_granallado_${row.id}"
            value="${data ?? ""}" 
            style="max-width: 120px; margin: 0 auto; width: 120px;"
            inputmode="decimal" 
            pattern="^\\d+(\\.\\d{1,2})?$" 
            title="Solo números con hasta 2 decimales"
          />
        `;
      },
    },
    {
      data: "unidad",
      className: "text-center",
      defaultContent: "KG", // 👉 fallback si falta
    },
  ];
}
