const pk_cliente = document.getElementById("txtpk").value;

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

  $("#cbmaquinas").change(function () {
    var value = $(this).val();
    pkmaquina = value;

    // console.log(pkmaquina);

    let url = "modelos/partesMaquina.php";

    let options = {
      method: "POST",
      headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        fk_maquina: pkmaquina,
      }),
    };
    document.getElementById("spinner").style.display = "block";
    document.getElementById("error").style.display = "none";
    ajaxParametos(url, options);
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

function ajaxParametos(url, options) {
  fetch(url, options)
    .then((response) => response.json())
    .then(dataResponse)
    .catch((errorB) => console.log("error", errorB));
}

function dataResponse(datajson) {
  document.getElementById("spinner").style.display = "none";
  console.log(datajson);

  if (datajson == 0) {
    document.getElementById("error").style.display = "block";
    document.getElementById("tabla").style.display = "none";
  } else {
    document.getElementById("error").style.display = "none";
    document.getElementById("tabla").style.display = "block";

    $(document).ready(function () {
      var table = $("#table_partes_maquina").DataTable({
        destroy: true,
        empty: true,
        orderCellsTop: true,
        fixedHeader: true,
        paging: true,
        searching: true,
        language: {
          url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
        },
        ajax: {
          url: "vistas/recursos/json/partesMaquinas.json",
          dataSrc: "",
        },

        // dom: "Plfrtip",
        columns: [
          { data: "tipo" },
          { data: "Descripcion" },
          { data: "vida_util_real" },
          { data: "horometro" },
          { data: "porcentaje_cambio" },
          { data: "acciones" },
        ],

        // initComplete: function () {
        //   this.api()
        //     .columns([0])
        //     .every(function () {
        //       var column = this;
        //       var select = $('<select><option value=""></option></select>')
        //         .appendTo($(column.header()).empty())
        //         .on("change", function () {
        //           var val = $.fn.dataTable.util.escapeRegex($(this).val());

        //           column.search(val ? "^" + val + "$" : "", true, false).draw();
        //         });

        //       column
        //         .data()
        //         .unique()
        //         .sort()
        //         .each(function (d, j) {
        //           select.append('<option value="' + d + '">' + d + "</option>");
        //         });
        //     });
        // },
      });
    });
  }
}

/* paso de parametros  mediando  modal vida util con boostraps  */
const exampleModal = document.getElementById("exampleModal");
if (exampleModal) {
  exampleModal.addEventListener("show.bs.modal", (event) => {
    // Button that triggered the modal
    const button = event.relatedTarget;
    // Extract info from data-bs-* attributes
    const recipient = button.getAttribute("data-bs-whatever");
    const maquina = button.getAttribute("data-bs-maquina");
    // If necessary, you could initiate an Ajax request here
    // and then do the updating in a callback.

    // Update the modal's content.
    const modalTitle = exampleModal.querySelector(".modal-title");
    const modalBodyInput = exampleModal.querySelector(".modal-body input");
    const maquinaInput = document.getElementById("pk_maquina");

    modalBodyInput.value = recipient;
    maquinaInput.value = maquina;
  });
}

/* paso de parametros  mediando  modal editar partidad con boostraps  */
const editar = document.getElementById("Editar");
if (editar) {
  editar.addEventListener("show.bs.modal", (event) => {
    const button = event.relatedTarget;
    const recordId = button.getAttribute("data-bs-recordId");
    const no_parte = button.getAttribute("data-bs-noparte");
    const nombremaquina = button.getAttribute("data-bs-nombremaquina");
    const fkmaquina = button.getAttribute("data-bs-fkmaquina");
    const modalTitle = editar.querySelector(".modal-title");

    const recordId_input = document.getElementById("recordId");
    const no_parte_input = document.getElementById("noparte");
    const fkmaquina_input = document.getElementById("fkmaquina");
    const nombremaquina_input = document.getElementById("nombremaquina");

    recordId_input.value = recordId;
    no_parte_input.value = no_parte;
    nombremaquina_input.value = nombremaquina;
    fkmaquina_input.value = fkmaquina;

    document.getElementById("div_materiales_boquillas").style.display = "none";
    document.getElementById("div_material_granalla").style.display = "none";
    ApiProveedores();
    ApiTipos();
  });
}

/* Se intrega  metodo de guardado  */
const btnGuardarVidaUtil = document.getElementById("btn_guardar");
btnGuardarVidaUtil.addEventListener("click", function () {
  let pk = document.getElementById("pk").value;
  let hrs_vida_util = document.getElementById("vida_hrs").value;
  let url = "modelos/insertar_hrs_vida_util.php";
  let options = {
    method: "POST",
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      pk: pk,
      hrs_vida_util: hrs_vida_util,
    }),
  };

  ajaxParametosInsert(url, options);
  console.log("pk", pk);
  console.log("vida", hrs_vida_util);
});

function ajaxParametosInsert(url, options) {
  fetch(url, options)
    .then((response) => response.json())
    .then(dataResponseInsert)
    .catch((errorB) => console.log("error", errorB));
}

function dataResponseInsert(datajson) {
  // console.log(datajson);
  // fechaActualEvento = [];
  if (datajson.status == 200) {
    Swal.fire({
      position: "center",
      icon: "success",
      title: "Horas de vida util agregadas con exito",
      showConfirmButton: false,
      timer: 1500,
    });
    document.getElementById("form_hrs_util").reset();
    setInterval(function () {
      window.location.reload();
    }, 1500);
  }
}

function ApiProveedores() {
  fetch("modelos/provedores.php")
    .then((data) => {
      return data.json();
    })
    .then((post) => {
      console.log(post);
      let proveedores = post.data;

      let select = document.getElementById("proveedor");
      console.log(select.options.length);

      if (select.options.length > 0) {
        for (let i = select.options.length - 1; i >= 0; i--) {
          select.options[i].remove();
        }
      }
      proveedores.forEach(function (valor, indice, array) {
        var aficiones = document.getElementById("proveedor");
        var option = document.createElement("option");
        option.text = valor.fieldData.nombre;
        option.value = valor.fieldData.pk;
        aficiones.add(option);
      });
    });
}

function ApiTipos() {
  fetch("modelos/tipos.php")
    .then((data) => {
      return data.json();
    })
    .then((post) => {
      console.log(post);
      let proveedores = post.data;

      let select = document.getElementById("tipo");
      // console.log(select.options.length);

      if (select.options.length > 0) {
        for (let i = select.options.length - 1; i >= 0; i--) {
          select.options[i].remove();
        }
      }

      proveedores.forEach(function (valor, indice, array) {
        var aficiones = document.getElementById("tipo");
        var option = document.createElement("option");
        option.text = valor.fieldData.nombre;
        option.value = valor.fieldData.pk;
        aficiones.add(option);
      });
    });
}

/*  Se agrega accion de guardar parte */

const btnGuardarParte = document.getElementById("btn_guardar_parte");
btnGuardarParte.addEventListener("click", function () {
  // console.log("dentro de guardar parte");

  const form = document.querySelector("#formPartes");

  var datos = new FormData(form);
  // datos.append('muestra',0);

  fetch("modelos/insertar_maquina_nueva.php", {
    method: "POST",
    body: datos,
  })
    .then((res) => res.json())
    .then((data) => {
      console.log(data);
      if (data.status == 200) {
        Swal.fire({
          position: "center",
          icon: "success",
          title: "Parte Editada",
          showConfirmButton: false,
          timer: 1500,
        });

        setInterval(function () {
          window.location.reload();
        }, 1500);

        // window.location.reload()
        // document.getElementById("formPartes").reset();
      }
    });
});

document.getElementById("tipo").addEventListener("change", function () {
  console.log("dentro de tipo ");

  let tipo = document.getElementById("tipo").value;
  document.getElementById("div_materiales_boquillas").style.display = "none";
  document.getElementById("div_material_granalla").style.display = "none";
  console.log(tipo);
  if (tipo === "A30170EB-E32F-4F73-B7CC-53A703AC0262") {
    materiales_boquilla();
    material_granalla();
    document.getElementById("div_materiales_boquillas").style.display = "block";
    document.getElementById("div_material_granalla").style.display = "block";
  }

  if (tipo === "E29AF8AA-67D3-8C4F-906C-29EF3AD50EED") {
    document.getElementById("div_reversible").style.display = "block";
  }
});

function materiales_boquilla() {
  fetch("modelos/materiales_boquilla.php")
    .then((data) => {
      return data.json();
    })
    .then((post) => {
      console.log(post);
      let proveedores = post.data;

      let select = document.getElementById("tipo_boquilla");
      // console.log(select.options.length);
      if (select.options.length > 0) {
        for (let i = select.options.length - 1; i >= 0; i--) {
          select.options[i].remove();
        }
      }
      proveedores.forEach(function (valor, indice, array) {
        var aficiones = document.getElementById("tipo_boquilla");
        var option = document.createElement("option");
        option.text = valor.fieldData.nombre;
        option.value = valor.fieldData.pk;
        aficiones.add(option);
      });
    });
}

function material_granalla() {
  fetch("modelos/materiales_granalla.php")
    .then((data) => {
      return data.json();
    })
    .then((post) => {
      console.log(post);
      let proveedores = post.data;

      let select = document.getElementById("material_granalla");
      // console.log(select.options.length);
      if (select.options.length > 0) {
        for (let i = select.options.length - 1; i >= 0; i--) {
          select.options[i].remove();
        }
      }
      proveedores.forEach(function (valor, indice, array) {
        var aficiones = document.getElementById("material_granalla");
        var option = document.createElement("option");
        option.text = valor.fieldData.nombre;
        option.value = valor.fieldData.pk;
        aficiones.add(option);
      });
    });
}
