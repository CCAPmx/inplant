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

function crearSelector(data) {
  const select = document.getElementById("cbmClienteGranulometria");

  // Limpiar opciones previas
  select.innerHTML = '<option value="">Seleccione una opción</option>';

  // Usar `Set` para almacenar clientes únicos
  const clientesUnicos = new Set();

  data.forEach((cliente) => {
    if (!clientesUnicos.has(cliente.cliente)) {
      // Verifica si ya está agregado
      clientesUnicos.add(cliente.cliente); // Agregar al Set para evitar duplicados

      let option = document.createElement("option");
      option.value = cliente.procesador_maq; // Suponiendo que cada cliente tiene un 'id'
      option.textContent = cliente.cliente; // Suponiendo que cada cliente tiene un 'nombre'
      select.appendChild(option);
    }
  });
}

// 🔹 Función para poblar el <select> de clientes
function crearSelectorClientes(data) {
  const selectClientes = document.getElementById("cbmClienteGranulometria");
  selectClientes.innerHTML = '<option value="">Seleccione un Cliente</option>';

  const clientesUnicos = new Set();

  data.forEach((cliente) => {
    if (!clientesUnicos.has(cliente.cliente)) {
      clientesUnicos.add(cliente.cliente);
      let option = document.createElement("option");
      option.value = cliente.cliente; // Se usa `procesador_maq` como value
      option.textContent = cliente.cliente;
      selectClientes.appendChild(option);
    }
  });

  // 🔹 Evento cuando se selecciona un cliente
  selectClientes.addEventListener("change", function () {
    const procesadorMaqSeleccionado = this.value;
    // console.log("🔍 Procesador seleccionado:", procesadorMaqSeleccionado);
    actualizarSelectorMaquinas(procesadorMaqSeleccionado);
  });
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

  // console.log("🔍 Máquinas filtradas:", maquinasFiltradas);

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
    $(".modal-title").text("informacion de granulometria");

    $("#fecha_nueva_granulometria").text(fecha);
    $("#cliente_nueva_granulometria").text(nombreCliente);
    $("#maquina_nueva_granulometria").text(maquinaCliente);

    


    





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
});

// 🔹 Evento para el botón "Guardar"

let btnGuardarGranulometria = document.getElementById(
  "btnGuardarGranulometria"
);

btnGuardarGranulometria.addEventListener("click", function () {
  // FrmVisitas

  // Obtener el formulario de edición
  let form = document.getElementById("FrmVisitas");
  let inputs = form.querySelectorAll("input[type='number']");
  let valido = true;

  // Recorrer cada input y validar
  inputs.forEach((input) => {
    if (!input.value.trim()) {
      // Si está vacío
      input.classList.add("input-invalido"); // Agregar la clase de error
      valido = false; // Indicar que hay campos vacíos
    } else {
      input.classList.remove("input-invalido"); // Quitar la clase si ya tiene valor
    }
  });

  if (!valido) {
    var mensaje = document.getElementById("mensaje_granulometria");
    mensaje.style.display = "block";
    document.getElementById("mensaje_granulometria").innerHTML =
      "Por favor, complete todos los campos obligatorios.";
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

  let arrayDatos = {
    clienteNombre: $("#cbmClienteGranulometria").val(),
    maquinaNombre: $("#maquina_nueva_granulometria").val(),
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
    polvo: $("#polvo").val(),
    usuario: datosSesion,
  };

  // console.log(arrayDatos);
  let clienteFK = clientesData.find(
    (cliente) =>
      cliente.procesador_maq === parseInt(arrayDatos.procesador_maq, 10)
  );

  arrayDatos.fkCliente = clienteFK.id_cliente;
  arrayDatos.fkMaquina = clienteFK.fkMaquina;
  arrayDatos.maquinaNombre = clienteFK.nombre;
  // console.log(arrayDatos);
  // console.log(clientesData);
  // console.log(clienteFK);

  let url = "controladores/granulometria.controlador.php?action=insertar";
  let options = {
    method: "POST",
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ arrayDatos: arrayDatos }),
  };
  var urlGranulometria =
    "controladores/granulometria.controlador.php?action=insertar";

  mensaje = "Granulometria guardada con exito";

  parametresGetFetch(url, options, mensaje);
});

let btnEditarGranulometria = document.getElementById("btnGranulometriaEdicion");

btnEditarGranulometria.addEventListener("click", function () {
  let $form = $("#FrmGranulometriaEdicion");

  // Obtener el formulario de edición
  let form = document.getElementById("FrmGranulometriaEdicion");
  let inputs = form.querySelectorAll("input[type='number']");
  let valido = true;

  // Recorrer cada input y validar
  inputs.forEach((input) => {
    if (!input.value.trim()) {
      // Si está vacío
      input.classList.add("input-invalido"); // Agregar la clase de error
      valido = false; // Indicar que hay campos vacíos
    } else {
      input.classList.remove("input-invalido"); // Quitar la clase si ya tiene valor
    }
  });

  if (!valido) {
    var mensaje = document.getElementById("mensaje_granulometria_editar");
    mensaje.style.display = "block";
    document.getElementById("mensaje_granulometria_editar").innerHTML =
      "Por favor, complete todos los campos obligatorios.";
    // alert("Por favor, complete todos los campos obligatorios.");
    return;
  } else {
    var mensaje = document.getElementById("mensaje_granulometria");
    mensaje.style.display = "none";
  }

  let arrayDatos = {
    c_05: $form.find("#c_05").val(),
    c_09: $form.find("#c_09").val(),
    c_150: $form.find("#c_150").val(),
    c_212: $form.find("#c_212").val(),
    c_300: $form.find("#c_300").val(),
    c_425: $form.find("#c_425").val(),
    c_600: $form.find("#c_600").val(),
    c_850: $form.find("#c_850").val(),
    c_1180: $form.find("#c_1180").val(),
    c_1400: $form.find("#c_1400").val(),
    c_1700: $form.find("#c_1700").val(),
    c_2200: $form.find("#c_2200").val(),
    polvo: $form.find("#polvo").val(),
    procesador_maq: $form.find("#procesador").val(),
    idGranulometria: $form.find("#idGranulometria").val(),
  };

  // Busca en clientesData el registro que coincida según procesador_maq
  let clienteFK = clientesData.find(
    (cliente) =>
      cliente.procesador_maq === parseInt(arrayDatos.procesador_maq, 10)
  );

   console.log(clienteFK);

  arrayDatos.fkCliente = clienteFK.id_cliente;
  arrayDatos.fkMaquina = clienteFK.fkMaquina;
  arrayDatos.maquinaNombre = clienteFK.nombre;

  arrayDatos.fkCliente = clienteFK.id_cliente;
  arrayDatos.fkMaquina = clienteFK.fkMaquina;
  arrayDatos.maquinaNombre = clienteFK.nombre;
  // console.log(arrayDatos);
  // console.log(clientesData);
  // console.log(clienteFK);

  let url = "controladores/granulometria.controlador.php?action=editar";
  let options = {
    method: "POST",
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ arrayDatos: arrayDatos }),
  };

  mensaje = "Granulometria guardada con exito";

  parametresGetFetch(url, options, mensaje);
});

// 🔹 Función para obtener los datos y almacenarlos en clientesData
async function cargarClientes() {
  const urlGranulometria =
    "controladores/granulometria.controlador.php?action=1";
  clientesData = await getFetch(urlGranulometria);
  // console.log("✅ Datos cargados:", clientesData);
  crearSelectorClientes(clientesData);
}

// 🔹 Iniciar la carga de datos
cargarClientes();
