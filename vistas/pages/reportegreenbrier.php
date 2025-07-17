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

                            <!-- <button id="btnCrearPdfReporte" class="btn btn-outline-info btn-sm mx-3">
                                <i class="fas fa-plus-circle"></i> PDF
                            </button> -->

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


<div class="modal fade" id="modalGranulometriaGreenbrierReporteEditar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" data-bs-target="#modalGranulometriaGreenbrierReporteEditar" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="color:black;">


                <!-- <h4 class="modal-title">Granulometría Greenbrier</h4> -->
                <div class="modal-subtitle w-100 row mt-2 info_granulometria_header" id="info_granulometria_header">

                    <div class="col-md-3">
                        <strong>Fecha: </strong> <span id="fecha_nueva_granulometria_reporte_editar"></span>
                    </div>

                    <div class="col-md-3">
                        <strong>Maquina: </strong> <span id="maquina_nueva_granulometria_reporte_editar"></span>
                    </div>

                    <div class="col-md-3">
                        <strong>Cliente: </strong><span id="cliente_nueva_granulometria_reporte_editar"></span>
                    </div>

                    <div class="col-md-3">
                        <strong>Nombre Usuario: </strong> <span id="usuario_nueva_granulometria_reporte_editar"><?php echo $_SESSION['nombre']; ?></span>
                    </div>


                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <form id="FrmReporteGreenbrierGranulometriaEditar" class="row g-2" role="form" method="post" autocomplete="off">
                <div class="modal-body">

                    <div class="row">
                        <div class="container">
                            <div class="col-md-4">
                                <input type="" hidden class="form-control" id="txtPkempresa_v1" name="txtPkempresa_v1" required value="" readonly>

                            </div>
                            <div class="row contenedor_form_granulometria_nueva" style="display: none;">
                                <!-- <div class="form-group col-md-4"> -->
                                <!-- <label for="cbmCliente" class="form-label">Clientes</label> -->
                                <select class="form-control select2 select2-purple" data-dropdown-css-class="select2-purple" style="width: 100%;" id="cbmClienteGranulometria" name="cbmClienteGranulometria" hidden></select>
                                <!-- </div> -->




                                <div class="col-md-6">
                                    <style>
                                        #loader_m {
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                        }
                                    </style>

                                    <div id="loader_m" style="display:none; text-align: center;">
                                        <div class="spinner-border text-primary" role="status"></div>
                                        <span style="display: inline-block; margin-left: 10px;">Cargando...</span>
                                    </div>

                                    <label for="cbmmaquina" class="form-label">Maquina</label>
                                    <select class="form-control select2 select2-purple" data-dropdown-css-class="select2-purple" style="width: 100%;" id="cbmmaquinaGranulometria" name="cbmmaquinaGranulometria">
                                    </select>
                                </div>


                                <div class="col-md-6">
                                    <label for="cbmmaquina" class="form-label">Fecha</label>
                                    <input type="date" class="form-control" id="txtFechaGranulometria" name="txtFechaGranulometria" onchange="" value="<?php echo date('Y-m-d'); ?>">
                                </div>

                            </div>

                            <div class="row contenedor_form_granulometria_reporte">



                                <div class="row">
                                    <div id="mensaje_granulometria_reporte" class=" text-center col-12" style="display: none; color: red; font-size: 16px;font-weight: bold;"></div>
                                    <h4 class="mb-3">Granulometría</h4>
                                    <div class="col-12 row p-2">

                                        <div class="col-md-2 d-flex align-items-center">
                                            <label for="polvo" class="mr-2 p-1"> <strong>Polvo</strong> </label>
                                            <input type="number" name="polvo" id="polvo" class="form-control" required>
                                        </div>

                                        <div class="col-md-2 d-flex align-items-center">
                                            <label for="c_05" class="mr-2 p-1"><strong>c_05</strong></label>
                                            <input type="number" name="c_05" id="c_05" class="form-control" required>
                                        </div>

                                        <div class="col-md-2 d-flex align-items-center">
                                            <label for="c_09" class="mr-2 p-1"><strong>c_09</strong> </label>
                                            <input type="number" name="c_09" id="c_09" class="form-control" required>
                                        </div>

                                        <div class="col-md-2 d-flex align-items-center">
                                            <label for="c_150" class="mr-2 p-1"><strong> c_150</strong></label>
                                            <input type="number" name="c_150" id="c_150" class="form-control" required>
                                        </div>

                                        <div class="col-md-2 d-flex align-items-center">
                                            <label for="c_212" class="mr-2 p-1"><strong>c_212</strong></label>
                                            <input type="number" name="c_212" id="c_212" class="form-control" required>
                                        </div>

                                        <div class="col-md-2 d-flex align-items-center">
                                            <label for="c_300" class="mr-2 p-1"><strong>c_300</strong></label>
                                            <input type="number" name="c_300" id="c_300" class="form-control" required>
                                        </div>

                                    </div>

                                    <div class="col-12 row p-2">
                                        <div class="col-md-2 d-flex align-items-center">
                                            <label for="c_425" class="mr-2 p-1"><strong>c_425</strong></label>
                                            <input type="number" name="c_425" id="c_425" class="form-control" required>
                                        </div>

                                        <div class="col-md-2 d-flex align-items-center">
                                            <label for="c_600" class="mr-2 p-1"><strong>c_600</strong></label>
                                            <input type="number" name="c_600" id="c_600" class="form-control" required>
                                        </div>

                                        <div class="col-md-2 d-flex align-items-center">
                                            <label for="c_850" class="mr-2 p-1"><strong>c_850</strong></label>
                                            <input type="number" name="c_850" id="c_850" class="form-control" required>
                                        </div>

                                        <div class="col-md-2 d-flex align-items-center">
                                            <label for="c_1180" class="mr-2 p-1"><strong>c_1180</strong></label>
                                            <input type="number" name="c_1180" id="c_1180" class="form-control" required>
                                        </div>

                                        <div class="col-md-2 d-flex align-items-center">
                                            <label for="c_1400" class="mr-2 p-1"><strong>c_1400</strong></label>
                                            <input type="number" name="c_1400" id="c_1400" class="form-control" required>
                                        </div>

                                        <div class="col-md-2 d-flex align-items-center">
                                            <label for="c_1700" class="mr-2 p-1"><strong>c_1700</strong></label>
                                            <input type="number" name="c_1700" id="c_1700" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-12 row p-2">
                                        <div class="col-md-2 d-flex align-items-center">
                                            <label for="c_2200" class="mr-2 p-1"><strong>c_2200</strong></label>
                                            <input type="number" name="c_2200" id="c_2200" class="form-control" required>
                                        </div>
                                    </div>



                                </div>

                                <div class="row conteneror_rugosidad_reporte">
                                    <div class="col-12 ">
                                        <hr> <!-- Rugosidad -->
                                    </div>
                                    <div class="col-12 row center">
                                        <!-- Rugosidad -->
                                        <h4 class="mb-3">Rugosidad</h4>
                                    </div>


                                    <div class="col-12 row g-2 justify-content-center  " style="    position: relative;
    left: -87px;">



                                        <div class="col-3 d-flex justify-content-end">
                                            <!-- Rugosidad -->
                                            <style>
                                                .tam_input_rugosidad {
                                                    max-width: 80px;
                                                    margin: 0 auto;
                                                    text-align: center;
                                                }
                                            </style>

                                            <div class="row flex-column g-2 justify-content-center">
                                                <div class="col-md-12 d-flex  align-items-center">
                                                    <label for="rig_01" class="me-2"><strong>01</strong></label>
                                                    <input type="number" name="rig_01" id="rig_01" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>

                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="rig_02" class="me-2"><strong>02</strong></label>
                                                    <input type="number" name="rig_02" id="rig_02" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>

                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="rig_03" class="me-2"><strong>03</strong></label>
                                                    <input type="number" name="rig_03" id="rig_03" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>

                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="rig_04" class="me-2"><strong>04</strong></label>
                                                    <input type="number" name="rig_04" id="rig_04" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>

                                                <div class="col-md-12 d-flex  align-items-center">
                                                    <label for="rig_05" class="me-2"><strong>05</strong></label>
                                                    <input type="number" name="rig_05" id="rig_05" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="col-3 d-flex justify-content-end">
                                            <!-- Rugosidad -->
                                            <div class="row flex-column g-2 justify-content-center">
                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="rig_06" class="me-2"><strong>06</strong></label>
                                                    <input type="number" name="rig_06" id="rig_06" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>

                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="rig_07" class="me-2"><strong>07</strong></label>
                                                    <input type="number" name="rig_07" id="rig_07" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>

                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="rig_08" class="me-2"><strong>08</strong></label>
                                                    <input type="number" name="rig_08" id="rig_08" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>
                                                <div class="col-md-12 d-flex  align-items-center">
                                                    <label for="rig_09" class="me-2"><strong>09</strong></label>
                                                    <input type="number" name="rig_09" id="rig_09" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>
                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="rig_10" class="me-2"><strong>10</strong></label>
                                                    <input type="number" name="rig_10" id="rig_10" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3 d-flex justify-content-end">
                                            <!-- Rugosidad -->
                                            <div class="row flex-column g-2 justify-content-center">
                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="rig_11" class="me-2"><strong>11</strong></label>
                                                    <input type="number" name="rig_11" id="rig_11" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>

                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="rig_12" class="me-2"><strong>12</strong></label>
                                                    <input type="number" name="rig_12" id="rig_12" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>

                                                <div class="col-md-12 d-flex  align-items-center">
                                                    <label for="rig_13" class="me-2"><strong>13</strong></label>
                                                    <input type="number" name="rig_13" id="rig_13" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>

                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="rig_14" class="me-2"><strong>14</strong></label>
                                                    <input type="number" name="rig_10" id="rig_14" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>

                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="rig_15" class="me-2"><strong>15</strong></label>
                                                    <input type="number" name="rig_15" id="rig_15" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-3 d-flex justify-content-end">
                                            <!-- Rugosidad -->
                                            <div class="row flex-column g-2 justify-content-center">
                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="rig_16" class="me-2"><strong>16</strong></label>
                                                    <input type="number" name="rig_16" id="rig_16" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>

                                                <div class="col-md-12 d-flex  align-items-center">
                                                    <label for="rig_17" class="me-2"><strong>17</strong></label>
                                                    <input type="number" name="rig_17" id="rig_17" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>


                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="rig_18" class="me-2"><strong>18</strong></label>
                                                    <input type="number" name="rig_18" id="rig_18" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>

                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="rig_19" class="me-2"><strong>19</strong></label>
                                                    <input type="number" name="rig_19" id="rig_19" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>

                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="rig_20" class="me-2"><strong>20</strong></label>
                                                    <input type="number" name="rig_20" id="rig_20" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <div class="row contenedor_basura_reporte">

                                    <div class="col-12 ">
                                        <hr> <!-- Rugosidad -->
                                    </div>


                                    <h4 class="mb-3">Basura</h4>


                                    <style>
                                        .label_with_text {
                                            width: 115px;
                                        }
                                    </style>





                                    <!-- Columna 1 -->
                                    <div class="col-4 text-center">
                                        <div class="row flex-column g-2">
                                            <div class="col-md-12">
                                                <label class="form-label"><strong>Norte der:</strong></label>
                                                <input type="radio" name="norte_der" value="0" checked required> 0
                                                <input type="radio" name="norte_der" value="1"> 1
                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label"><strong>Norte izq:</strong></label>
                                                <input type="radio" name="norte_izq" value="0" checked required> 0
                                                <input type="radio" name="norte_izq" value="1"> 1
                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label"><strong>Norte afuera:</strong></label>
                                                <input type="radio" name="norte_afuera" value="0" checked required> 0
                                                <input type="radio" name="norte_afuera" value="1"> 1
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Columna 2 -->
                                    <div class="col-4 text-center">
                                        <div class="row flex-column g-2">
                                            <div class="col-md-12">
                                                <label class="form-label"><strong>Centro der:</strong></label>
                                                <input type="radio" name="centro_der" value="0" checked required> 0
                                                <input type="radio" name="centro_der" value="1"> 1
                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label"><strong>Centro izq:</strong></label>
                                                <input type="radio" name="centro_izq" value="0" checked required> 0
                                                <input type="radio" name="centro_izq" value="1"> 1
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Columna 3 -->
                                    <div class="col-4 text-center">
                                        <div class="row flex-column g-2">
                                            <div class="col-md-12">
                                                <label class="form-label"><strong>Sur der:</strong></label>
                                                <input type="radio" name="sur_der" value="0" checked required> 0
                                                <input type="radio" name="sur_der" value="1"> 1
                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label"><strong>Sur izq:</strong></label>
                                                <input type="radio" name="sur_izq" value="0" checked required> 0
                                                <input type="radio" name="sur_izq" value="1"> 1
                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label"><strong>Sur afuera:</strong></label>
                                                <input type="radio" name="sur_afuera" value="0" checked required> 0
                                                <input type="radio" name="sur_afuera" value="1"> 1
                                            </div>
                                        </div>
                                    </div>





                                    <div class="row contenedor_imagenes_reporte mt-4">



                                        <div class="col-6  d-flex align-items-center">
                                            <div class="row flex-column g-2 justify-content-center text-center">

                                                <div class="mt-2 text-center imgPreview01">
                                                    <img id="imgPreview01" src="vistas/recursos/img/avatars/image-not-found.jpg" class="rounded mx-auto d-block " src="" alt="Vista previa imagen 1" class="img-fluid rounded border" style="max-height: 200px; width: 200;">
                                                </div>
                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="basura_img01" class="me-2 label_with_text" style="width: 200px;"><strong>Selecciona una imagen 1</strong></label>
                                                    <input type="file" name="basura_img01" id="basura_img01" class="form-control" required accept="image/jpeg, image/png, image/jpg">
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-6  d-flex align-items-center">
                                            <div class="row flex-column g-2 justify-content-center  text-center">

                                                <div class=" mt-2 text-center imgPreview02">
                                                    <img id="imgPreview02" src="vistas/recursos/img/avatars/image-not-found.jpg" class="rounded mx-auto d-block " src="" alt="Vista previa imagen 2" class="img-fluid rounded border" style="max-height: 200px; width: 200px;">
                                                </div>
                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="basura_img02" class="me-2 label_with_text" style="width: 200px;"><strong>Selecciona una imagen 2</strong></label>
                                                    <input type="file" src="vistas/recursos/img/avatars/image-not-found.jpg" name="basura_img02" id="basura_img02" class="form-control" accept="image/jpeg, image/png, image/jpg" required>
                                                </div>

                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <strong> <small class="" style=" font-size: 12px;">*** puedes subir fotos opcionales, max 500 kB</small>
                                            </strong>
                                        </div>
                                    </div>





                                </div>



                                <div class="row contener_silo_reporte">

                                    <div class="col-12 ">
                                        <hr> <!-- Rugosidad -->
                                    </div>


                                    <h4 class="mb-3">Silo </h4>


                                    <div class="col-6 text-center">
                                        <div class="row flex-column g-2 justify-content-center">
                                            <div class="col-md-12 d-flex  align-items-center">
                                                <label for="vacio_silo_2" class="me-2 label_with_text"><strong>Vacio Silo 2</strong></label>
                                                <input
                                                    type="number"
                                                    name="vacio_silo_2"
                                                    id="vacio_silo_2"
                                                    class="form-control"
                                                    required
                                                    style="width: 100px;"> <strong class="ms-2">CM</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6 text-center">
                                        <div class="row flex-column g-2 justify-content-center">
                                            <div class="col-md-12 d-flex align-items-center">
                                                <label for="vacio_silo_1" class="me-2 label_with_text"><strong>Vacio Silo 1</strong></label>
                                                <input
                                                    type="number"
                                                    name="vacio_silo_1"
                                                    id="vacio_silo_1"
                                                    class="form-control"
                                                    style="width: 100px;"
                                                    required>
                                                <strong class="ms-2">CM</strong>
                                            </div>


                                        </div>
                                    </div>
                                </div>



                                <div class="row contenedor_recargas_granalla ">
                                    <div class="col-12">
                                        <hr> <!-- Rugosidad -->
                                        <h4 class="mb-3">Recargas de Granalla
                                        </h4>
                                    </div>

                                    <style>
                                        #tablaHoy thead {
                                            display: none;
                                        }
                                    </style>

                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <div class="table-responsive d-flex justify-content-center">
                                                <table id="tablaHoy" class="" style="width: 80%;">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="3" class="bg-light text-dark" style="border: 2px solid #dee2e6;">

                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <!-- <th>ID</th> -->
                                                            <th>Fecha</th>
                                                            <th>Carga</th>
                                                            <th></th>
                                                            <!-- <th></th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="col-md-12 text-center">
                                            <!-- <h5 class="text-center">Registros Anteriores</h5> -->
                                            <div class="table-responsive d-flex justify-content-center">
                                                <table id="tablaAnteriores" class="table table-bordered table-striped text-center mx-auto" style="width: 80%;">
                                                    <thead>

                                                        <tr>
                                                            <th colspan="3" class="text-center">Recargas Anteriores</th>
                                                        </tr>
                                                        <tr>
                                                            <!-- <th>ID</th> -->
                                                            <th>Fecha</th>
                                                            <th>Carga</th>
                                                            <th></th>
                                                            <!-- <th></th> -->
                                                        </tr>


                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>



                        </div>

                    </div>
                </div>


            </form>

            <!-- Modal footer -->
            <div class="modal-footer">
                <!-- <button type="button" id="btnSiguienteGranulometria" class="btn btn-primary btnSiguienteGranulometria">CONTINUAR</button> -->
                <!-- <button type="button" id="btnRegresarGranulometria" class="btn btn-primary btnRegresarGranulometria" style="display: none;">REGRESAR</button> -->
                <!-- <button type="button" id="btnGuardarGranulometria" class="btn btn-success btnGuardarGranulometria" style="display: none;">Guardar</button> -->
                <button type="button" id="btnGuardarCambiosGranulometriaReporte" class="btn btn-success btnGuardarCambiosGranulometriaReporte">Guardar Cambios</button>
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">CANCELAR</button>
            </div>


        </div>
    </div>
</div>


<!-- // Modal para mostrar el PDF generado -->
<!-- Modal para ver el PDF -->
<div class="modal fade" id="modalPDF" tabindex="-1" aria-labelledby="modalPDFLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="max-width: 100%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Vista previa del PDF</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <iframe id="visorPDF" style="width: 100%; height: 80vh;" frameborder="0"></iframe>
            </div>
            <div class="modal-footer">
                <button id="descargarPDFBtn" class="btn btn-primary">Descargar PDF</button>
                <button id="enviarPDFBtn" class="btn btn-primary" onclick="enviarPDF()">Enviar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<script>
    // Variables globales
    let pdfBlob;
    let nombreArchivoGlobal;

    let printToPDFReporteGrafica = function(paramJson) {
        const dataPDF = JSON.parse(paramJson);
        let param = dataPDF.id_granulometria;

        if (dataPDF.autorizado === "No") {
            document.getElementById("enviarPDFBtn").style.display = "none";
        } else {
            document.getElementById("enviarPDFBtn").style.display = "block";
        }

        document.getElementById("enviarPDFBtn").value = dataPDF.fk_maquina;

        const iframe = document.createElement("iframe");
        document.body.appendChild(iframe);
        iframe.style.width = "100%";
        iframe.style.height = "100vh";
        iframe.style.position = "absolute";
        iframe.style.left = "-10000px";

        iframe.onload = async function() {
            setTimeout(async () => {
                const doc = iframe.contentWindow.document;
                const encabezado = doc.getElementById("encabezado");
                const graficas = doc.getElementById("contenedorGraficas");

                if (!encabezado || !graficas) {
                    console.warn("⚠️ No se encontraron encabezado o gráficas.");
                    document.body.removeChild(iframe);
                    return;
                }

                const [encCanvas, grafCanvas] = await Promise.all([
                    html2canvas(encabezado, {
                        scale: 1.5,
                        useCORS: true,
                        scrollY: -window.scrollY
                    }),
                    html2canvas(graficas, {
                        scale: 1.5,
                        useCORS: true,
                        scrollY: -window.scrollY
                    })
                ]);

                const {
                    jsPDF
                } = window.jspdf;
                const pdf = new jsPDF({
                    orientation: "landscape",
                    unit: "mm",
                    format: "a4"
                });

                const margin = 15;
                const pageWidth = pdf.internal.pageSize.getWidth() - 2 * margin;
                const pageHeight = pdf.internal.pageSize.getHeight() - 2 * margin;

                // Encabezado
                const encRatio = encCanvas.height / encCanvas.width;
                const encHeight = pageWidth * encRatio;
                const encImg = encCanvas.toDataURL("image/jpeg", 0.9);

                // Gráficas ajustadas al espacio restante para caber en la misma página
                const espacioDisponibleGraficas = pageHeight - encHeight - 10; // 10mm de separación
                const grafRatio = grafCanvas.height / grafCanvas.width;
                const grafHeight = espacioDisponibleGraficas;
                const grafWidth = grafHeight / grafRatio;
                const grafImg = grafCanvas.toDataURL("image/jpeg", 0.9);

                // Centrar las gráficas si sobra espacio horizontal
                const grafX = margin + (pageWidth - grafWidth) / 2;

                // Insertar encabezado y gráficas en la misma página
                pdf.addImage(encImg, "JPEG", margin, margin, pageWidth, encHeight);
                pdf.addImage(grafImg, "JPEG", grafX, margin + encHeight + 10, grafWidth, grafHeight);

                // Footer con número de página
                pdf.setFontSize(5);
                pdf.setTextColor(150, 150, 150);
                // pdf.text(`Página 1 de 1`, pdf.internal.pageSize.getWidth() / 2, pdf.internal.pageSize.getHeight() - 5, {
                //     align: "center"
                // });

                pdf.text(`Página 1 de 1`, pdf.internal.pageSize.getWidth() / 2, pdf.internal.pageSize.getHeight() - 3, {
                    align: "center"
                });

                // Marca de agua si no está autorizado
                if (dataPDF.autorizado === "No") {
                    pdf.setFontSize(25);
                    pdf.setTextColor(255, 150, 150);
                    pdf.text("**** REPORTE NO AUTORIZADO ****", pdf.internal.pageSize.getWidth() / 2, pdf.internal.pageSize.getHeight() / 2, {
                        angle: 45,
                        align: "center"
                    });
                }

                // Guardar en blob
                pdfBlob = pdf.output("blob");

                // Nombre de archivo global
                let fechaActual = new Date();
                let dia = ("0" + fechaActual.getDate()).slice(-2);
                let mes = ("0" + (fechaActual.getMonth() + 1)).slice(-2);
                let anio = fechaActual.getFullYear();
                nombreArchivoGlobal = `${dataPDF.nombre}_${dia}_${mes}_${anio}.pdf`;

                // Mostrar visor
                const pdfUrl = URL.createObjectURL(pdfBlob);
                const visor = document.getElementById("visorPDF");
                visor.setAttribute("title", nombreArchivoGlobal);
                visor.src = pdfUrl + "#pagemode=none";

                new bootstrap.Modal(document.getElementById("modalPDF")).show();

                // Descargar
                document.getElementById("descargarPDFBtn").onclick = () => {
                    const a = document.createElement("a");
                    a.href = pdfUrl;
                    a.download = nombreArchivoGlobal;
                    a.click();
                };

                document.body.removeChild(iframe);
            }, 1500);
        };

        const url = "vistas/pagesPdfs/documento_graficas_reporte_granulometria.php?id=" + param;
        iframe.src = url;
    };



    // Evento enviar PDF por correo
    document.getElementById("enviarPDFBtn").addEventListener("click", function() {
        console.log("Enviando correo...");
        console.log("pdfBlob:", pdfBlob);
        console.log("nombreArchivoGlobal:", nombreArchivoGlobal);

        let valorMaquina = this.value;

        if (!pdfBlob || !nombreArchivoGlobal) {
            Swal.fire("Error", "No se ha generado el PDF aún", "error");
            return;
        }

        const formData = new FormData();
        formData.append("archivo_pdf", pdfBlob, nombreArchivoGlobal);
        formData.append("fkMaquina", valorMaquina);

        const urlDestino = "modelos/enviarCorreo.php";

        fetch(urlDestino, {
                method: "POST",
                body: formData
            })
            .then(res => res.text())
            .then(data => {
                console.log("Respuesta del servidor:", data);
                Swal.fire("Correo", data, "success");
            })
            .catch(err => {
                console.error("Error al enviar correo:", err);
                Swal.fire("Error", "No se pudo enviar el correo", "error");
            });
    });
</script>






<script src="vistas/js/greenbrier.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.4.1/purify.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
<script src="vistas/recursos/compressor/compressor.min.js"></script>

<script>
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
                    "width": "100px", // Ajusta el ancho de la columna with: "100px",
                    "className": "text-center",
                    "render": function(data, type, row) {
                        const jsonStr = encodeURIComponent(JSON.stringify(data));
                        const idReporte = row.id; // Ajusta según tu campo real
                        const id_granulometria = row.id_granulometria;

                        return `
            <div class="d-flex flex-row justify-content-center align-items-center gap-2">

    <button 
        class="btn  btn-sm"
        style="width: 40px; height: 40px;"
        data-bs-toggle="modal"
        data-bs-target="#modalReporteGreenbrierAutorizarEditar"
        onclick="granulometriaGreenbrierInfoReporte(decodeURIComponent('${jsonStr}'))"
    >
        <i class="fas fa-edit" style="color: blue;"></i>
    </button>

    <button 
        class="btn  btn-sm"
        style="width: 40px; height: 40px;"
        onclick="printToPDFReporteGrafica(decodeURIComponent('${jsonStr}'))"
    >
        <i class="fas fa-file-pdf" style="color: green;"></i>
    </button>

    <button 
        class="btn btn-sm"
        style="width: 40px; height: 40px;"
        onclick="granulometriaGreenbrierInfoReporteEdicion('${id_granulometria}')"
    >
        <svg class="align-middle" style=" color: #0d6efd; width: 1.3em; height: 1.3em; fill:#0d6efd; margin-right: 6px;" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="50" cy="10" r="5" />
                        <circle cx="40" cy="25" r="5" />
                        <circle cx="60" cy="25" r="5" />
                        <circle cx="30" cy="40" r="5" />
                        <circle cx="50" cy="40" r="5" />
                        <circle cx="70" cy="40" r="5" />
                        <circle cx="20" cy="55" r="5" />
                        <circle cx="40" cy="55" r="5" />
                        <circle cx="60" cy="55" r="5" />
                        <circle cx="80" cy="55" r="5" />
                      </svg>
    </button>

</div>
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


    function granulometriaGreenbrierInfoReporteEdicion(jsonStr) {
        var dataId = JSON.parse(decodeURIComponent(jsonStr));
        // console.log(dataId);



        const formData = new FormData();

        formData.append("id", dataId);

        let options = {
            method: "POST",
            body: formData,
        };

        // console.log("Enviando datos para obtener información de la granulometría:", formData.getAll("id"));
        let url = "controladores/granulometria.controlador.php?action=jsonDataEditarGranulometriaGreenbrierModal";
        let mensaje = "Cargando datos de la granulometría para edición...";

        async function cargarDatos() {
            const resultado = await obtenerDatos(url, options);

            if (resultado) {
                // console.log("Voy a usar los datos después:", resultado.data);
                // Puedes hacer más operaciones aquí
            }

            let data = resultado.data[0];
            // console.log("Datos obtenidos para edición:", data);

            const $form = $('#FrmReporteGreenbrierGranulometriaEditar');


            $form.find('[name="polvo"]').val(data.polvo);
            $form.find('[name="c_05"]').val(data.c_05);
            $form.find('[name="c_09"]').val(data.c_09);
            $form.find('[name="c_150"]').val(data.c_150);
            $form.find('[name="c_212"]').val(data.c_212);
            $form.find('[name="c_300"]').val(data.c_300);
            $form.find('[name="c_425"]').val(data.c_425);
            $form.find('[name="c_600"]').val(data.c_600);
            $form.find('[name="c_850"]').val(data.c_850);
            $form.find('[name="c_1180"]').val(data.c_1180);
            $form.find('[name="c_1400"]').val(data.c_1400);
            $form.find('[name="c_1700"]').val(data.c_1700);
            $form.find('[name="c_2200"]').val(data.c_2200);
            $form.find('[name="rig_01"]').val(data.rug01);
            $form.find('[name="rig_02"]').val(data.rug02);
            $form.find('[name="rig_03"]').val(data.rug03);
            $form.find('[name="rig_04"]').val(data.rug04);
            $form.find('[name="rig_05"]').val(data.rug05);
            $form.find('[name="rig_06"]').val(data.rug06);
            $form.find('[name="rig_07"]').val(data.rug07);
            $form.find('[name="rig_08"]').val(data.rug08);
            $form.find('[name="rig_09"]').val(data.rug09);
            $form.find('[name="rig_10"]').val(data.rug10);
            $form.find('[name="rig_11"]').val(data.rug11);
            $form.find('[name="rig_12"]').val(data.rug12);
            $form.find('[name="rig_13"]').val(data.rug13);
            $form.find('[name="rig_14"]').val(data.rug14);
            $form.find('[name="rig_15"]').val(data.rug15);
            $form.find('[name="rig_16"]').val(data.rug16);
            $form.find('[name="rig_17"]').val(data.rug17);
            $form.find('[name="rig_18"]').val(data.rug18);
            $form.find('[name="rig_19"]').val(data.rug19);
            $form.find('[name="rig_20"]').val(data.rug20);

            $form.find('[name="norte_der"][value="' + data.basura_N_der + '"]').prop('checked', true);
            $form.find('[name="norte_izq"][value="' + data.basura_N_izq + '"]').prop('checked', true);
            $form.find('[name="norte_afuera"][value="' + data.basura_F_n + '"]').prop('checked', true);
            $form.find('[name="centro_der"][value="' + data.basura_C_der + '"]').prop('checked', true);
            $form.find('[name="centro_izq"][value="' + data.basura_C_izq + '"]').prop('checked', true);
            $form.find('[name="sur_der"][value="' + data.basura_S_der + '"]').prop('checked', true);
            $form.find('[name="sur_izq"][value="' + data.basura_S_izq + '"]').prop('checked', true);
            $form.find('[name="sur_afuera"][value="' + data.basura_F_s + '"]').prop('checked', true);

            $form.find('[name="vacio_silo_1"]').val(data.vacio_silo_01);
            $form.find('[name="vacio_silo_2"]').val(data.vacio_silo_02);


            let maquina = data.procesador;
            datatableRecargasGranallaReporte(maquina, 'edicion');

            const baseUrl = `${window.location.origin}/modelos/ver_imagen_granulometria.php`;

            let img01 = data.imagen_url_1 !== null ? `${baseUrl}?id=${data.id}&campo=basura_img01&nocache=${new Date().getTime()}` : 'vistas/recursos/img/avatars/image-not-found.jpg';
            let img02 = data.imagen_url_2 !== null ? `${baseUrl}?id=${data.id}&campo=basura_img02&nocache=${new Date().getTime()}` : 'vistas/recursos/img/avatars/image-not-found.jpg';

            // console.log("🔄 imagen 1:", img01);
            // console.log("🔄 imagen 2:", img02);
            document.getElementById('imgPreview01').src = img01;
            document.getElementById('imgPreview02').src = img02;


            let dataFk = {
                id: data.id,
                fkCliente: data.fkCliente,
                fkMaquina: data.fkMaquina,
                maquinaNombre: data.nombre_maquina,
                procesador_maq: data.procesador,
                fecha: data.fecha,
                cliente: data.cliente,

            };

            document.getElementById('btnGuardarCambiosGranulometriaReporte').value = JSON.stringify(dataFk);

            document.getElementById('fecha_nueva_granulometria_reporte_editar').textContent = data.fecha;
            document.getElementById('maquina_nueva_granulometria_reporte_editar').textContent = data.nombre_maquina;
            document.getElementById('cliente_nueva_granulometria_reporte_editar').textContent = data.cliente;
        }


        cargarDatos();
        // Guardar los datos para la edición

        // Mostrar el modal correcto
        const modal = new bootstrap.Modal(document.getElementById('modalGranulometriaGreenbrierReporteEditar'));
        modal.show();




        // $('.contenedor_form_granulometria_nueva').hide();
        // $('.contenedor_form_granulometria').show();
        // $('.conteneror_rugosidad').show();
        // $('.contenedor_basura').show();
        // $('.contener_silo').show();
        // $('.info_granulometria_header').show();

        // $(".modal-title").hide();
        // // $(".info_granulometria_header").hide();

        // $('.btnGuardarCambiosGranulometria').show();
        // // $('.btnGuardarGranulometria').hiden();
        // $('.btnSiguienteGranulometria').hide();

        // // Llenar los campos del modal
        // $('#fecha_nueva_granulometria').text(data.fecha);
        // $('#maquina_nueva_granulometria').text(data.nombre_maquina);
        // $('#cliente_nueva_granulometria').text(data.cliente);
        // // document.getElementById('usuario_nueva_granulometria_edicion').textContent = data.usuario;

        // $('#cbmmaquinaGranulometria').val(data.procesador_maq);

        const $form = $('#FrmReporteGreenbrierGranulometriaEditar');










        // $form.find('[name="vacio_silo_1"]').val(data.vacio_silo_01);
        // $form.find('[name="vacio_silo_2"]').val(data.vacio_silo_02);


        // let dataFk = {
        //     id: data.id,
        //     fkCliente: data.fkCliente,
        //     fkMaquina: data.fkMaquina,
        //     maquinaNombre: data.nombre_maquina,
        //     procesador_maq: data.procesador,
        //     fecha: data.fecha,

        // }

        // document.getElementById('btnGuardarCambiosGranulometria').value = JSON.stringify(dataFk);

        // // $form.find('#btnGuardarCambiosGranulometria').val(JSON.stringify(dataFk));


        // let maquina = data.procesador;
        // datatableRecargasGranalla(maquina, 'edicion');

        // const baseUrl = `${window.location.origin}/modelos/ver_imagen_granulometria.php`;

        // let img01 = `${baseUrl}?id=${data.id}&campo=basura_img01&nocache=${new Date().getTime()}`;
        // let img02 = `${baseUrl}?id=${data.id}&campo=basura_img02&nocache=${new Date().getTime()}`;

        // // console.log(baseUrl, img01, img02);

        // document.getElementById('imgPreview01').src = img01;
        // document.getElementById('imgPreview02').src = img02;

        // $('#imgPreview01').on('error', function() {
        //     console.error('Error cargando imagen 1');
        // });

        // $('#imgPreview02').on('error', function() {
        //     console.error('Error cargando imagen 2');
        // });
    }


    async function obtenerDatos(url, options) {
        try {
            const response = await fetch(url, options);
            const data = await response.json();
            // console.log("Datos recibidos:", data);



            // Aquí puedes usar la variable `data`
            return data; // ⬅️ Retornas la data
        } catch (error) {
            console.error("Error en el fetch:", error);
            return null;
        }
    }


    function datatableRecargasGranallaReporte(maquina, tipo) {

        // console.log("🔄 Cargando datos de recargas para la máquina:", maquina);
        // console.log("🔄 Tipo de carga:", tipo);
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
            data: JSON.stringify({
                arrayDatos: {
                    maquina
                }
            }),
            success: function(responseRaw) {
                let response;
                try {
                    response =
                        typeof responseRaw === "string" ?
                        JSON.parse(responseRaw) :
                        responseRaw;
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

                // console.log("🔄 Registros hoy:", hoy);
                // console.log("🔄 Registros hoy:", tablaNuevoReporte);

                response.data.forEach((item) => {
                    if (item.fecha === hoy) {
                        registrosHoy.push(item);
                    } else {
                        registrosAnteriores.push(item);
                    }
                });

                // console.log("🔄 Registros de hoy:", registrosHoy);
                // console.log("🔄 Registros anteriores:", registrosAnteriores);

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
            error: function(xhr, status, error) {
                console.error("❌ Error AJAX:", status, error);
            },
        });
    }

    function getColumnDefs() {
        return [
            // { data: "id", className: "text-center" },
            {
                data: "fecha",
                className: "text-center p-1",
                render: function(data) {
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
                className: "text-center p-1",
                render: function(data, type, row) {
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
                className: "text-center p-1",
                defaultContent: "KG", // 👉 fallback si falta
            },
        ];
    }
</script>