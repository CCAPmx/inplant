<link rel="stylesheet" href="vistas/recursos/css/visitastecnicas.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>


<style>
    /* Ocultar flechas en inputs de tipo number */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

    .input-invalido {
        background-color: rgba(255, 165, 0, 0.3) !important;
        /* Naranja pálido */
        border: 1px solid #ffa500;
    }
</style>

<div class="container-fluid">

    <div class="d-flex bd-highlight p-0 text-white" style="background-color: #07B5E8;">
        <div class="my-2 mx-2 flex-grow-1 bd-highlight">Reporte Greenbrier</div>
        <!-- <?php
                // echo $_SESSION["ccap"], $_SESSION["usuario"];
                // echo $_SESSION["lersant"];

                var_dump($_SESSION["auth_reporte"]);
                var_dump($_SESSION["usuario"]);

                ?> -->
        <ol class="my-2 mx-2 breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashclientes">Inicio</a></li>
            <li class="breadcrumb-item active">Reporte Greenbrier</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="d-flex justify-content-end">
                    <div class="btn-group  my-3 mx-2" role="group" aria-label="Basic example">
                    </div>
                </div>
                <div id="loader" class="loader"></div>



                <div class="card-body">
                    <!-- <button id="btnValidarSecion" class="btn btn-outline-info btn-sm mx-3" onclick="validarSesion()"> validar sesion</button> -->
                    <div class="d-flex justify-content-end">
                        <div class="btn-group  my-3 mx-2" role="group" aria-label="Basic example">


                            <?php if ($_SESSION["auth_reporte"] == 1): ?>
                                <button id="btnNuevoReporteGreenbrier" class="btn btn-outline-info btn-sm mx-3" data-bs-toggle="modal" data-bs-target="#modalReporteGreenbrier"> <i class="fas fa-plus-circle"></i> Nuevo Reporte </button>
                            <?php endif; ?>

                            <!-- <button id="btnNuevoReporteGreenbrier" class="btn btn-outline-info btn-sm mx-3" data-bs-toggle="modal" data-bs-target="#modalReporteGreenbrier"> <i class="fas fa-plus-circle"></i> Nuevo Reporte </button> -->
                        </div>
                    </div>



                    <div class=" container" id="contenedor_granulometria">
                        <div class="col table-responsive">
                            <table id="granulometriaTable" class="table table-striped table-bordered text-center" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Detalles</th>
                                        <th>Fecha</th>
                                        <th>Maquina</th>
                                        <th>comentario 1</th>
                                        <th>comentario 2</th>
                                        <th>comentario 3</th>
                                        <th>comentario 4</th>
                                        <th>Autorizado</th>
                                        <th>Nombre</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="modalReporteGreenbrier" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" data-bs-target="#modalReporteGreenbrier" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header" style="color:black;">
                <h4 class="modal-title">Reporte Greenbrier</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Modal body -->

            <div class="modal-body">
                <form id="FrmReporteGreenbrier" class="row g-2" role="form" method="post" autocomplete="off">

                    <div class="row contenedor-granulometria-greenbrier">
                        <div class="col-md-6">
                            <label for="selectorGranulometriaGreenbrier" class="form-label">Granulometria Greenbrier</label>
                            <select class="form-control select2 select2-purple" data-dropdown-css-class="select2-purple" style="width: 100%;" id="selectorGranulometriaGreenbrier" name="selectorGranulometriaGreenbrier">
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="cbmmaquina" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="txtFechaGranulometriaGreenbrier" name="txtFechaGranulometriaGreenbrier" onchange="formatoFecha()" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>

                    <div class="row contenedor-granulometria-greenbrier-comentario">

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <hr>
                        </div>


                        <div class="col-md-6">
                            <label for="cometario_1" class="form-label">comentario 1</label>
                            <textarea name="" class="form-control" id="cometario_1" id="cometario_1" cols="30"></textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="cometario_2" class="form-label">comentario 2</label>
                            <textarea name="" class="form-control" id="cometario_2" id="cometario_2" cols="30"></textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="cometario_3" class="form-label">comentario 3</label>
                            <textarea name="" class="form-control" id="cometario_3" id="cometario_3" cols="30"></textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="cometario_4" class="form-label">comentario 4</label>
                            <textarea name="" class="form-control" id="cometario_4" id="cometario_4" cols="30"></textarea>
                        </div>
                    </div>

                    <div class=" row contenedor_alerta">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <hr>
                        </div>

                        <div class="col-5">
                            <div class="d-flex align-items-center gap-2">
                                <label for="toggleAlertaBtn" class="form-label mb-0">
                                    <strong>Status alerta 1 <small>click para cambiar status</small> </strong>
                                </label>

                                <button type="button" id="toggleAlertaBtn" class="btn btn-danger">
                                    INACTIVO
                                </button>

                                <input type="hidden" name="alerta" id="alerta" value="1"> <!-- coincide con JS -->
                            </div>
                        </div>




                        <div class="row contenedor_alerta_form_1 mt-2">



                            <div>
                                <label>Título:</label>
                                <select id="tituloAlerta1" name="tituloAlerta1" class="form-select">
                                    <option value="">Seleccione</option>
                                </select>
                            </div>

                            <div>
                                <label>Mensaje:</label>
                                <input type="text" id="txtMensajeAlerta" name="txtMensajeAlerta" class="form-control" readonly>
                            </div>
                        </div>






                        <div class="row contenedor_alerta_form_2 mt-2">

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <hr>
                            </div>

                            <div class="col-5">
                                <div class="d-flex align-items-center gap-2">
                                    <label for="toggleAlertaBtn" class="form-label mb-0">
                                        <strong>Status alerta 2 <small>click para cambiar status</small> </strong>
                                    </label>

                                    <button type="button" id="toggleAlertaBtn2" class="btn btn-danger">
                                        INACTIVO
                                    </button>

                                    <input type="hidden" name="alerta2" id="alerta2" value="1"> <!-- coincide con JS -->
                                </div>
                            </div>

                            <div>
                                <label>Título:</label>
                                <select id="tituloAlerta2" name="tituloAlerta2" class="form-select">
                                    <option value="">Seleccione</option>
                                </select>
                            </div>

                            <div>
                                <label>Mensaje:</label>
                                <input type="text" id="txtMensajeAlerta2" name="txtMensajeAlerta2" class="form-control" readonly>
                            </div>



                        </div>


                        <div class="row contenedor_alerta_form_3 mt-2">


                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <hr>
                            </div>

                            <div class="col-5">
                                <div class="d-flex align-items-center gap-2">
                                    <label for="toggleAlertaBtn3" class="form-label mb-0">
                                        <strong>Status alerta 3 <small>click para cambiar status</small> </strong>
                                    </label>

                                    <button type="button" id="toggleAlertaBtn3" class="btn btn-danger">
                                        INACTIVO
                                    </button>

                                    <input type="hidden" name="alerta3" id="alerta3" value="1"> <!-- coincide con JS -->
                                </div>
                            </div>

                            <div>
                                <label>Título:</label>
                                <select id="tituloAlerta3" name="tituloAlerta3" class="form-select">
                                    <option value="">Seleccione</option>
                                </select>
                            </div>

                            <div>
                                <label>Mensaje:</label>
                                <input type="text" id="txtMensajeAlerta3" name="txtMensajeAlerta3" class="form-control" readonly>
                            </div>
                        </div>


                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const selectTitulo = document.getElementById("tituloAlerta1");
                                const inputMensaje = document.getElementById("txtMensajeAlerta");

                                if (selectTitulo && inputMensaje) {
                                    selectTitulo.addEventListener("change", function() {
                                        const selectedOption = selectTitulo.options[selectTitulo.selectedIndex];
                                        const texto = selectedOption.getAttribute("data-texto") || "";
                                        inputMensaje.value = texto;
                                    });
                                }
                            });
                        </script>






                        <!-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <hr>
                        </div> -->

                        <!-- <div class="col-4">
                            <div class="d-flex align-items-center gap-2">
                                <label for="toggleAlertaBtn" class="form-label mb-0">
                                    <strong>Status alerta 2 <small>click para cambiar status</small> </strong>
                                </label>

                                <button type="button" id="toggleAlertaBtn2" class="btn btn-danger">
                                    INACTIVO
                                </button>

                                <input type="hidden" name="alerta2" id="alerta2" value="1"> 
                            </div>
                        </div> -->

                        <!-- <div class="row contenedor_alerta_form_2 mt-2">
                            
                            <div class="col-md-6 d-flex align-items-center mb-3">
                                <label for="txtMensajeAlerta" class="form-label me-2 mb-0" style="width: 100px;"><strong>Mensaje 2:</strong></label>
                                <input type="text" class="form-control" id="txtMensajeAlerta2" name="txtMensajeAlerta2" required>
                            </div>

                            
                            <div class="col-md-6 d-flex align-items-center mb-3">
                                <label for="tipo_alerta" class="form-label me-2 mb-0" style="width: 100px;"><strong>Urgencia:</strong></label>
                                <select name="tipo_alerta2" id="tipo_alerta2" class="form-control" required>
                                    <option value="">seleccione una opcion</option>
                                    <option value="BAJA">BAJA</option>
                                    <option value="MEDIA">MEDIA</option>
                                    <option value="ALTA">ALTA</option>
                                </select>
                            </div>
                        </div> -->
                    </div>
                </form>



            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" id="btnGuardarGranulometriaReporte" class="btn btn-success btnGuardarGranulometriaReporte">Guardar</button>
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">CANCELAR</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalReporteGreenbrierAutorizarEditar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" data-bs-target="#modalReporteGreenbrierAutorizarEditar" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header" style="color:black;">
                <h4 class="modal-title Autorizado_greenbrier" id="Autorizado_greenbrier"></h4> <small></small>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Modal body -->

            <div class="modal-body">

                <form id="FrmReporteGreenbrierEditar" class="row g-2" role="form" method="post" autocomplete="off">

                    <div class="row contenedor-granulometria-greenbrier">
                        <!-- <div class="col-md-6">
                            <label for="selectorGranulometriaGreenbrier" class="form-label">Granulometria Greenbrier</label>
                            <select class="form-control select2 select2-purple" data-dropdown-css-class="select2-purple" style="width: 100%;" id="selectorGranulometriaGreenbrier" name="selectorGranulometriaGreenbrier">
                            </select>
                        </div> -->

                        <!-- <div class="col-md-6">
                            <label for="cbmmaquina" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="txtFechaGranulometriaGreenbrier" name="txtFechaGranulometriaGreenbrier" onchange="formatoFecha()" value="<?php echo date('Y-m-d'); ?>">
                        </div> -->
                    </div>

                    <div class="row contenedor-granulometria-greenbrier-comentario">

                        <!-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <hr>
                        </div> -->


                        <input type="text" name="id_alerta_edicion" id="id_alerta_edicion" hidden>
                        <input type="text" name="id_alerta_edicion2" id="id_alerta_edicion2" hidden>
                        <input type="text" name="id_alerta_edicion3" id="id_alerta_edicion3" hidden>
                        <input type="text" name="idReporteGreenbrier" id="idReporteGreenbrier" hidden>



                        <!-- <input type="text"> -->



                        <div class="col-md-6">
                            <label for="cometario_1" class="form-label">comentario 1</label>
                            <textarea class="form-control" name="cometario_1" id="cometario_1" cols="30"></textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="cometario_2" class="form-label">comentario 2</label>
                            <textarea class="form-control" name="cometario_2" id="cometario_2" cols="30"></textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="cometario_3" class="form-label">comentario 3</label>
                            <textarea class="form-control" name="cometario_3" id="cometario_3" cols="30"></textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="cometario_4" class="form-label">comentario 4</label>
                            <textarea class="form-control" name="cometario_4" id="cometario_4" cols="30"></textarea>
                        </div>
                    </div>



                    <div class=" row contenedor_alerta">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <hr>
                        </div>

                        <div class="col-5">
                            <div class="d-flex align-items-center gap-2">
                                <label for="toggleAlertaBtnEdicion" class="form-label mb-0">
                                    <strong>Status alerta 1 <small>click para cambiar status</small> </strong>
                                </label>

                                <button type="button" id="toggleAlertaBtnEdicion" class="btn btn-danger">
                                    INACTIVO
                                </button>

                                <input type="hidden" name="alertaEdicion" id="alertaEdicion" value="1"> <!-- coincide con JS -->
                            </div>
                        </div>




                        <div class="row contenedor_alerta_form_1 mt-2">



                            <div>
                                <label>Título:</label>
                                <select id="tituloAlerta1Edicion" name="tituloAlerta1Edicion" class="form-select">
                                    <option value="">Seleccione</option>
                                </select>
                            </div>

                            <div>
                                <label>Mensaje:</label>
                                <input type="text" id="txtMensajeAlertaEdicion" name="txtMensajeAlertaEdicion" class="form-control" readonly>
                            </div>
                        </div>






                        <div class="row contenedor_alerta_form_2 mt-2">

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <hr>
                            </div>

                            <div class="col-5">
                                <div class="d-flex align-items-center gap-2">
                                    <label for="toggleAlertaBtn2Edicion" class="form-label mb-0">
                                        <strong>Status alerta 2 <small>click para cambiar status</small> </strong>
                                    </label>

                                    <button type="button" id="toggleAlertaBtn2Edicion" class="btn btn-danger">
                                        INACTIVO
                                    </button>

                                    <input type="hidden" name="alerta2Edicion" id="alerta2Edicion" value="1"> <!-- coincide con JS -->
                                </div>
                            </div>

                            <div>
                                <label>Título:</label>
                                <select id="tituloAlerta2Edicion" name="tituloAlerta2Edicion" class="form-select">
                                    <option value="">Seleccione</option>
                                </select>
                            </div>

                            <div>
                                <label>Mensaje:</label>
                                <input type="text" id="txtMensajeAlerta2Edicion" name="txtMensajeAlerta2Edicion" class="form-control" readonly>
                            </div>



                        </div>


                        <div class="row contenedor_alerta_form_3 mt-2">


                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <hr>
                            </div>

                            <div class="col-5">
                                <div class="d-flex align-items-center gap-2">
                                    <label for="toggleAlertaBtn3Edicion" class="form-label mb-0">
                                        <strong>Status alerta 3 <small>click para cambiar status</small> </strong>
                                    </label>

                                    <button type="button" id="toggleAlertaBtn3Edicion" class="btn btn-danger">
                                        INACTIVO
                                    </button>

                                    <input type="hidden" name="alerta3Edicion" id="alerta3Edicion" value="1"> <!-- coincide con JS -->
                                </div>
                            </div>

                            <div>
                                <label>Título:</label>
                                <select id="tituloAlerta3Edicion" name="tituloAlerta3Edicion" class="form-select">
                                    <option value="">Seleccione</option>
                                </select>
                            </div>

                            <div>
                                <label>Mensaje:</label>
                                <input type="text" id="txtMensajeAlerta3Edicion" name="txtMensajeAlerta3Edicion" class="form-control" readonly>
                            </div>
                        </div>


                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const selectTitulo = document.getElementById("tituloAlerta1Edicion");
                                const inputMensaje = document.getElementById("txtMensajeAlertaEdicion");

                                if (selectTitulo && inputMensaje) {
                                    selectTitulo.addEventListener("change", function() {
                                        const selectedOption = selectTitulo.options[selectTitulo.selectedIndex];
                                        const texto = selectedOption.getAttribute("data-texto") || "";
                                        inputMensaje.value = texto;
                                    });
                                }
                            });
                        </script>






                        <!-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <hr>
                        </div> -->

                        <!-- <div class="col-4">
                            <div class="d-flex align-items-center gap-2">
                                <label for="toggleAlertaBtn" class="form-label mb-0">
                                    <strong>Status alerta 2 <small>click para cambiar status</small> </strong>
                                </label>

                                <button type="button" id="toggleAlertaBtn2" class="btn btn-danger">
                                    INACTIVO
                                </button>

                                <input type="hidden" name="alerta2" id="alerta2" value="1"> 
                            </div>
                        </div> -->

                        <!-- <div class="row contenedor_alerta_form_2 mt-2">
                            
                            <div class="col-md-6 d-flex align-items-center mb-3">
                                <label for="txtMensajeAlerta" class="form-label me-2 mb-0" style="width: 100px;"><strong>Mensaje 2:</strong></label>
                                <input type="text" class="form-control" id="txtMensajeAlerta2" name="txtMensajeAlerta2" required>
                            </div>

                            
                            <div class="col-md-6 d-flex align-items-center mb-3">
                                <label for="tipo_alerta" class="form-label me-2 mb-0" style="width: 100px;"><strong>Urgencia:</strong></label>
                                <select name="tipo_alerta2" id="tipo_alerta2" class="form-control" required>
                                    <option value="">seleccione una opcion</option>
                                    <option value="BAJA">BAJA</option>
                                    <option value="MEDIA">MEDIA</option>
                                    <option value="ALTA">ALTA</option>
                                </select>
                            </div>
                        </div> -->
                    </div>






                </form>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" id="btnGuardarGranulometriaReporteEditar" class="btn btn-success btnGuardarGranulometriaReporteEditar">Guardar</button>

                <?php if ($_SESSION["auth_reporte"] == 1): ?>
                    <button type="button" id="btnAutorizarGranulometriaReporte" class="btn btn-info btnAutorizarGranulometriaReporte">Autorizar</button>
                <?php endif; ?>



                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">CANCELAR</button>
            </div>
        </div>
    </div>
</div>










<script src="vistas/js/greenbrier.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.4.1/purify.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
<script src="vistas/recursos/compressor/compressor.min.js"></script>

<script>
    // mostrar las alertas





    // document.addEventListener("DOMContentLoaded", function() {
    //     const siRadio = document.getElementById("alerta_si");
    //     const noRadio = document.getElementById("alerta_no");
    //     const contenedorOpciones = document.getElementById("contenedor_alerta_form_1");
    //     const contenedorOpciones2 = document.getElementById("contenedor_alerta_form_2");


    //     function toggleAlerta() {

    //         console.log(siRadio.checked);

    //         if (siRadio.checked) {

    //             $('.contenedor_alerta_form_1').show();
    //             $('.contenedor_alerta_form_2').show();
    //             // contenedorOpciones.style.display = "block";
    //             // contenedorOpciones2.style.display = "block";
    //         } else {
    //             $('.contenedor_alerta_form_1').hide();
    //             $('.contenedor_alerta_form_2').hide();
    //         }
    //     }

    //     siRadio.addEventListener("change", toggleAlerta);
    //     noRadio.addEventListener("change", toggleAlerta);

    //     // Ejecutar al cargar por si ya está seleccionado
    //     toggleAlerta();
    // });


    document.querySelectorAll(".basura-input").forEach(input => {
        input.setAttribute("min", "0");
        input.setAttribute("max", "1");
        input.setAttribute("step", "1");

        input.addEventListener("input", function() {
            const value = this.value;
            // Si no es 0 o 1, borra el contenido
            if (value !== "0" && value !== "1") {
                this.value = "";
            }
        });
    });


    document.querySelectorAll(".rugosidad-input").forEach(input => {

        input.setAttribute('step', '0.1');
        // input.setAttribute('min', '1.0');
        input.setAttribute('max', '3.0');
        input.addEventListener("input", function() {


            let value = this.value;

            // Permite solo números con un decimal
            if (!/^\d+(\.\d{0,1})?$/.test(value)) {
                this.value = value.slice(0, -1); // borra último caracter inválido
            }

            // Elimina el valor si está fuera del rango permitido
            const num = parseFloat(this.value);
            if (num < 1.0 || num > 3.0) {
                this.value = '';
            }
        });
    });
    var datosSesion = <?php echo json_encode($_SESSION['nombre']); ?>;
    $(document).ready(function() {
        table = $('#granulometriaTable').DataTable({
            "ajax": "controladores/granulometria.controlador.php?action=dataGranulometriaReporteGreenbrier", // URL del script PHP que retorna el JSON
            "columns": [

                {
                    "data": null,
                    "orderable": false,
                    "className": "text-center",
                    "render": function(data, type, row) {
                        const jsonStr = encodeURIComponent(JSON.stringify(data));

                        return `
        <button 
            class="btn btn-outline-info btn-sm mx-3"
            data-bs-toggle="modal"
            data-bs-target="#modalReporteGreenbrierAutorizarEditar"
            onclick="granulometriaGreenbrierInfoReporte(decodeURIComponent('${jsonStr}'))"
        >
            <i class="fas fa-edit"></i>
        </button>
    `;
                    }
                },
                {
                    data: "fecha",
                    width: "100px",
                    render: function(data, type, row) {
                        if (!data) return "";

                        const fecha = new Date(data);
                        const dia = String(fecha.getDate()).padStart(2, '0');
                        const mes = String(fecha.getMonth() + 1).padStart(2, '0');
                        const año = fecha.getFullYear();

                        return `${dia}/${mes}/${año}`;
                    }
                },
                {
                    "data": "nombre",
                    "width": "100px"
                },

                {
                    "data": "comment_01"
                },
                {
                    "data": "comment_02"
                },
                {
                    "data": "comment_03"
                },
                {
                    "data": "comment_04"
                },
                {
                    "data": "autorizado"
                },
                {
                    "data": "nombre_usuario"
                },

            ],
            language: {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sSearch": "Buscar:",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                }
            },
            pageLength: 10,
            ordering: false,
        });
    });

    function granulometriaGreenbrierInfoReporte(jsonStr) {
        const data = JSON.parse(decodeURIComponent(jsonStr));
        const $form = $('#FrmReporteGreenbrierEditar');

        console.log(data);

        let [año, mes, dia] = data.fecha.split("-");
        let fechaFormateada = `${dia}/${mes}/${año}`;
        let Title = `${fechaFormateada} - ${data.cliente} - ${data.nombre} - ${data.usuario}`;
        document.getElementById('Autorizado_greenbrier').innerHTML = Title;

        // Comentarios y datos básicos
        $form.find('[name="cometario_1"]').val(data.comment_01);
        $form.find('[name="cometario_2"]').val(data.comment_02);
        $form.find('[name="cometario_3"]').val(data.comment_03);
        $form.find('[name="cometario_4"]').val(data.comment_04);
        $form.find('[name="idReporteGreenbrier"]').val(data.id);

        // Alertas
        data.alertas.forEach((alerta, index) => {
            const num = index + 1;

            // IDs
            $form.find(`[name="id_alerta_edicion${num > 1 ? num : ""}"]`).val(alerta.id);

            // Estado activo/inactivo
            const inputAlerta = document.getElementById(`alerta${num > 1 ? num : ""}Edicion`);
            const btnAlerta = document.getElementById(`toggleAlertaBtn${num > 1 ? num : ""}Edicion`);
            if (inputAlerta && btnAlerta) {
                inputAlerta.value = alerta.activa.toString();
                actualizarBotonAlertaEstado(btnAlerta, inputAlerta);
                btnAlerta.onclick = () => {
                    inputAlerta.value = inputAlerta.value === "1" ? "0" : "1";
                    actualizarBotonAlertaEstado(btnAlerta, inputAlerta);
                };
            }

            // Selección del título
            const selectTitulo = document.getElementById(`tituloAlerta${num}Edicion`);
            const inputMensaje = document.getElementById(`txtMensajeAlerta${num > 1 ? num : ""}Edicion`);
            if (selectTitulo && inputMensaje) {
                // Buscar opción con texto igual
                for (let option of selectTitulo.options) {
                    if (option.getAttribute("data-texto") === alerta.texto_01) {
                        selectTitulo.value = option.value;
                        break;
                    }
                }
                inputMensaje.value = alerta.texto_01;

                // Asegura que siga actualizándose al cambiar el select
                selectTitulo.addEventListener("change", function() {
                    const selected = this.options[this.selectedIndex];
                    inputMensaje.value = selected.getAttribute("data-texto") || "";
                });
            }
        });

        // Autorización
        const autorizado = String(data.autorizado).trim().toLowerCase();
        if (autorizado === "si" || autorizado === "sí" || autorizado === "1") {
            $('.btnGuardarGranulometriaReporteEditar, .btnAutorizarGranulometriaReporte').hide();
        } else {
            $('.btnGuardarGranulometriaReporteEditar, .btnAutorizarGranulometriaReporte').show();
        }
    }

    function actualizarBotonAlertaEstado(btn, input) {
        const isActiva = parseInt(input.value) === 1;
        btn.textContent = isActiva ? "ACTIVO" : "INACTIVO";
        btn.classList.toggle("btn-success", isActiva);
        btn.classList.toggle("btn-danger", !isActiva);
    }


    document.addEventListener("DOMContentLoaded", function() {
        const btn1 = document.getElementById("toggleAlertaBtn");
        const input1 = document.getElementById("alerta");

        const btn2 = document.getElementById("toggleAlertaBtn2");
        const input2 = document.getElementById("alerta2");

        const btn3 = document.getElementById("toggleAlertaBtn3");
        const input3 = document.getElementById("alerta3");

        if (btn1 && input1) {
            btn1.addEventListener("click", function() {
                input1.value = input1.value === "1" ? "0" : "1";
                actualizarBotonAlertaEstado(btn1, input1);
            });

            // ← actualiza visual al cargar
            actualizarBotonAlertaEstado(btn1, input1);
        }

        if (btn2 && input2) {
            btn2.addEventListener("click", function() {
                input2.value = input2.value === "1" ? "0" : "1";
                actualizarBotonAlertaEstado(btn2, input2);
            });

            actualizarBotonAlertaEstado(btn2, input2);
        }

        if (btn3 && input2) {
            btn3.addEventListener("click", function() {
                input3.value = input3.value === "1" ? "0" : "1";
                actualizarBotonAlertaEstado(btn3, input3);
            });

            actualizarBotonAlertaEstado(btn3, input3);
        }
    });
</script>