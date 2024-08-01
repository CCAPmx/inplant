$(document).ready(function () {
    $('#tablaVisitas').bootstrapTable();
    $('#tablaVisitas').css("visibility", "visible");
});
/**
 * Event to schedule a new visit
 */
$(document).on("click", "#programar-visita", async function () {
    $(".general-loader").show();
    const pk_cliente = $(this).data('cliente');
    $("#programarVisitaDetailModalBody").html("");
	$("#programarVisitaDetailModalTitle").html('Programar Nueva Visita');
    const clientes = await getClientes();
    $("#programarVisitaDetailModalBody").html(htmlToModal(JSON.parse(clientes)));
    
    $(".modal-header").css("background-color", "#07B5E8");
    $(".modal-header").css("color", "#fff");
    $(".general-loader").hide();
    $("#programarvisitaDetailModal").modal("toggle");
    $('#fk_cliente').select2({
        theme: "bootstrap-5",
        dropdownParent: $('#programarvisitaDetailModal')
    });
    $('#fk_cliente').on('select2:select', async function (e) {
        $(".new-loader").show();
        const pk_cliente = e.params.data.id;
        const nombre_cliente = e.params.data.text;
        const maquinasResponse = await getMaquinas(pk_cliente);
        const maquinas = JSON.parse(maquinasResponse);
        if (maquinas.error) {
            Swal.fire(
                'Sin maquinas para este cliente',
                '',
                'error'
            )
            $("#fk_maquina").html(`<option selected disabled>Seleccione...</option>`);
            $("#fk_visitador").html(`<option selected disabled>Seleccione...</option>`);
            $("#fecha").val(``);
            $("input[name=nombre_cliente]").val(``);
            $(".new-loader").hide();
            formChangeValidation()
            return;
        }
        let maquinasOptions = '';
        maquinas.forEach(maquina => {
            maquinasOptions += `<option value="${maquina.pk_maquina}">${maquina.nombre_maquina}</option>`;
        });
        $("#fk_maquina").html(`<option selected disabled>Seleccione...</option>${maquinasOptions}`);
        $("#fk_visitador").html(`<option selected disabled>Seleccione...</option>`);
        $("#fecha").val(``);
        $("input[name=nombre_cliente]").val(nombre_cliente);
        $(".new-loader").hide();
        formChangeValidation()
    });
})
/**
 * Event to change cliente
 */

$(document).on("change", "#fk_cliente", async function () {
    
})
/**
 * Event to change maquina
 */
$(document).on("change", "#fk_maquina", async function () {
    $(".new-loader").show();
    const pk_maquina = $(this).val();
    const nombre_maquina = $(this).find('option:selected').text();
    const ingenierosResponse = await getIngenieros(pk_maquina);
    const ingenieros = JSON.parse(ingenierosResponse);
    let ingenierosOptions = '';
    ingenieros.forEach(ingeniero => {
        if (ingeniero.fk_ingeniero.length > 0 && ingeniero.nombre_ingeniero.length > 0) {
            ingenierosOptions += `<option value="${ingeniero.fk_ingeniero}">${ingeniero.nombre_ingeniero}</option>`;   
        }
    });
    if (ingenierosOptions.length == 0) {
        Swal.fire(
            'Sin visitadores para esta Maquina',
            '',
            'error'
        )
        $(".new-loader").hide();
        formChangeValidation()
        return;
    }
    $("#fk_visitador").html(`<option selected disabled>Seleccione...</option>${ingenierosOptions}`);
    $("input[name=nombre_maquina]").val(nombre_maquina);
    $(".new-loader").hide();
    formChangeValidation()
})

$(document).on("submit", ".data-programacion", async function (event) {
    $(".new-loader").show();
    event.preventDefault()
    const isValid = formSubmitValidation();
    if (isValid) {
        await createVisitaProgramada();
        $(".new-loader").hide();
        location.href = location.href;
    }
})

$(document).on("change", "#fecha", function (event) {
    formChangeValidation()
})

$(document).on("change", "#fk_visitador", function (event) {
    const nombre_visitador = $(this).find('option:selected').text();
    $("input[name=nombre_visitador]").val(nombre_visitador);
    formChangeValidation()
})

let htmlToModal = function (clientes) {
    let clientesOptions = '';
    clientes.forEach(cliente => {
        clientesOptions += `<option value="${cliente.pk_cliente}">${cliente.nombre_cliente}</option>`;
    });
    const html =    `<div class="text-center new-loader" style="display: none">
                        <strong role="status" class="text-info">Loading...</strong>
                        <div class="spinner-border ms-auto text-info" aria-hidden="true"></div>
                    </div>
                    <form class="data-programacion">
                        <div class="row mb-3">
                            <label for="Cliente" class="col-sm-2 col-form-label">Cliente</label>
                            <div class="col-sm-10 select-cliente">
                                <select class="form-select" id="fk_cliente" name="fk_cliente">
                                    <option selected disabled>Seleccione...</option>
                                    ${clientesOptions}
                                </select>
                                <input type="hidden" name="nombre_cliente">
                            </div>
                        </div>
                        <div class="container mt-4">
                            <div class="row mb-3">
                                <label for="fk_maquina" class="col-sm-2 col-form-label">Máquina</label>
                                <div class="col-sm-10">
                                    <select class="form-select" id="fk_maquina" name="fk_maquina">
                                        <option selected disabled>Seleccione...</option>
                                    </select>
                                    <input type="hidden" name="nombre_maquina">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="visitador" class="col-sm-2 col-form-label">Visitador</label>
                                <div class="col-sm-10">
                                    <select class="form-select" id="fk_visitador" name="fk_visitador">
                                        <option selected disabled>Seleccione...</option>
                                    </select>
                                    <input type="hidden" name="nombre_visitador">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="fecha" class="col-sm-2 col-form-label">Fecha</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="fecha" name="fecha">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="observaciones" class="col-sm-2 col-form-label">Observaciones</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="observaciones" name="observaciones"></textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Enviar</button>
                                </div>
                            </div>
                        </div>
                    </form>`;
    return html;
}
let formSubmitValidation = function (){
    let cliente = $("#fk_cliente");
    let maquina = $("#fk_maquina");
    let visitador = $("#fk_visitador");
    let fecha = $("#fecha");
    let flag = true;

    if (cliente.val() == null) {
        cliente.addClass('is-invalid')
        flag = false;
    }else{
        cliente.removeClass('is-invalid');
    }

    if (maquina.val() == null) {
        maquina.addClass('is-invalid')
        flag = false;
    }else{
        maquina.removeClass('is-invalid');
    }

    if (visitador.val() == null) {
        visitador.addClass('is-invalid')
        flag = false;
    }else{
        visitador.removeClass('is-invalid');
    }

    if (fecha.val() == '') {
        fecha.addClass('is-invalid')
        flag = false;
    }else{
        fecha.removeClass('is-invalid');
    }

    return flag;
}
let formChangeValidation = function (){
    $("#fk_cliente").removeClass('is-invalid');
    $("#fk_maquina").removeClass('is-invalid');
    $("#fk_visitador").removeClass('is-invalid');
    $("#fecha").removeClass('is-invalid');
}
let getMaquinas = async function(pk_cliente){
    return await $.ajax({
      type: "GET",
      url: `controladores/programacionvisitas.controlador.php?action=getMaquinas&pk=${pk_cliente}`,
      success: function(response) {
          result = JSON.parse(response);
          if (response?.ok) {
          return result;
          }else{
          return false;
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {	} 
  });
}
let getIngenieros = async function(pk_maquina){
    return await $.ajax({
      type: "GET",
      url: `controladores/programacionvisitas.controlador.php?action=getIngenieros&pk=${pk_maquina}`,
      success: function(response) {
          result = JSON.parse(response);
          if (response?.ok) {
          return result;
          }else{
          return false;
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {	} 
  });
}
let getClientes = async function(){
    return await $.ajax({
      type: "GET",
      url: `controladores/programacionvisitas.controlador.php?action=getClientes`,
      success: function(response) {
          result = JSON.parse(response);
          if (response?.ok) {
          return result;
          }else{
          return false;
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {	} 
  });
}
let createVisitaProgramada = async function(){
    const formData = new FormData($(".data-programacion")[0]);
    formData.append('action', 'createVisita')
    return await $.ajax({
        type: "POST",
        url: `controladores/programacionvisitas.controlador.php`,
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          result = JSON.parse(response);
          if (response?.ok) {
            return result;
          }else{
            return false;
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {	} 
  });
}