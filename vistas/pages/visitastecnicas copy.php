<link rel="stylesheet" href="vistas/recursos/css/visitastecnicas.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>


<div class="container-fluid">

    <div class="d-flex bd-highlight p-0 text-white" style="background-color: #07B5E8;">
        <div class="my-2 mx-2 flex-grow-1 bd-highlight">Visitas Técnicas</div>
        <!-- <?php
                echo $_SESSION["ccap"];
                // echo $_SESSION["lersant"];

                ?> -->
        <ol class="my-2 mx-2 breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashclientes">Inicio</a></li>
            <li class="breadcrumb-item active">Visitas Técnicas</li>
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
                            <button id="btnNuevaVisita" class="btn btn-outline-info btn-sm mx-3"> <i class="fas fa-plus-circle"></i> Nueva Visita</button>
                        </div>
                    </div>
                    <!-- <button type="button" class="btn btn-primary mx-2" id="btnNuevaVisita">
                        Nueva Visita
                    </button> -->
                    <div class="table-responsive">
                        <table style="visibility: hidden" id="tablaVisitas" data-url="controladores/visitas.controlador.php?action=getAllVisitas" data-pagination="true" data-search="true" data-toggle="table" data-locale="es-MX" data-show-button-icons="true" data-buttons-class="outline-info" data-filter-control="true" data-show-search-clear-button="true">
                            <thead>
                                <tr>
                                    <th class="text-center" data-field="info">Más Información</th>
                                    <th class="text-center" data-field="fecha" data-filter-control="input">Fecha</th>
                                    <th class="text-center" data-field="nombre_usuario" data-filter-control="input">Usuario</th>
                                    <th class="text-center" data-field="nombre_cliente" data-filter-control="input">Nombre Cliente</th>
                                    <!-- <th class="text-center" data-field="fkCliente" data-filter-control="input">Clave Cliente</th> -->
                                    <th class="text-center" data-field="nombre_maquina" data-filter-control="input">Nombre Maquina</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="color:black;">
                <h4 class="modal-title ">Modal Heading</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <form id="FrmVisitas" class="row g-2" role="form" method="post" autocomplete="off">
                <div class="modal-body">
                    <div class="col-md-4">
                        <input type="" hidden class="form-control" id="txtPkempresa_v1" name="txtPkempresa_v1" required value="" readonly>

                    </div>
                    <div class="row contenedor_form_visitas_nueva">



                        <div class="form-group col-md-4">
                            <label for="cbmCliente" class="form-label">Clientes</label>
                            <select class="form-control select2 select2-purple" data-dropdown-css-class="select2-purple" style="width: 100%;" id="cbmCliente" name="cbmCliente"></select>
                        </div>




                        <div class="col-md-4">
                            <!-- <div id="loader_m" style="display:none;">Cargando...</div> -->

                            <!-- <div id="loader_m" class="spinner-border text-primary" role="status" style="display:none;">
                                <span class="" style="display:block;">Cargando...</span>
                            </div> -->

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
                            <select class="form-control select2 select2-purple" data-dropdown-css-class="select2-purple" style="width: 100%;" id="cbmmaquina" name="cbmmaquina">
                            </select>
                        </div>


                        <div class="col-md-4">
                            <label for="cbmmaquina" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="txtFechaVisita" name="txtFechaVisita" onchange="formatoFecha()">
                        </div>

                    </div>

                    <div class="row contenedor_form_visita_granumetria" style="display: none;">

                    <div  class="col-md-3">
                        <strong>Fecha: </strong> <span id="fecha_nueva_visita"></span>
                    </div>

                    <div  class="col-md-3">
                        <strong>Maquina: </strong> <span id="maquina_nueva_visita"></span>
                    </div>

                    <div  class="col-md-3">
                        <strong>Cliente: </strong><span id="cliente_nueva_visita"></span>
                    </div>

                    <div  class="col-md-3">
                        <strong>Nombre Usuario: </strong> <span id="usuario_nueva_visita"><?php echo $_SESSION['nombre']; ?></span>
                    </div>

                    <div class="col-12"><hr>
                </div>

                        <div class="col-md-4">
                            <label for="inputPassword5" class="form-label">c_05</label>
                            <input type="number" name="c_05" id="c_05" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="inputPassword5" class="form-label">c_09</label>
                            <input type="number" name="c_09" id="c_09" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="inputPassword5" class="form-label">c_150</label>
                            <input type="number" name="c_150" id="c_150" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="inputPassword5" class="form-label">c_212</label>
                            <input type="number" name="c_212" id="c_212" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="inputPassword5" class="form-label">c_300</label>
                            <input type="number" name="c_300" id="c_300" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="inputPassword5" class="form-label">c_425</label>
                            <input type="number" name="c_425" id="c_425" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="inputPassword5" class="form-label">c_600</label>
                            <input type="number" name="c_600" id="c_600" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="inputPassword5" class="form-label">c_850</label>
                            <input type="number" name="c_850" id="c_850" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="inputPassword5" class="form-label">c_1180</label>
                            <input type="number" name="c_1180" id="c_1180" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="inputPassword5" class="form-label">c_1400</label>
                            <input type="number" name="c_1400" id="c_1400" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="inputPassword5" class="form-label">c_1700</label>
                            <input type="number" name="c_1700" id="c_1700" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="inputPassword5" class="form-label">c_2200</label>
                            <input type="number" name="c_2200" id="c_2200" class="form-control">
                        </div>                    

                       
                    </div>

                </div>
            </form>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" id="btnSiguienteVisita" class="btn btn-primary btnSiguienteVisita" style="display: none;">CONTINUAR</button>
                <button type="button" id="btnRegresarVisita" class="btn btn-primary btnRegresarvisita" style="display: none;">REGRESAR</button>
                <button type="button" id="btnGuardarVisita" class="btn btn-success btnGuardarVisita" >Guardar</button>
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">CANCELAR</button>
            </div>


        </div>
    </div>
</div>

<div class="modal" id="visitaDetailModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" id="visitaDetailModalContent">
            <div class="modal-header" id="visitaDetailModalTitle">
            </div>
            <div class="modal-body" id="visitaDetailModalBody">
                <!-- <div id="temporizador">10:00</div> -->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary updateVisit">Guardar</button>
                <button type="button" class="btn btn-secondary" id="closeBottomModal" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Galería de Imágenes Modal -->
<div id="imageModal" class="modal">
    <span class="closeImageModal" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="modalImage">
</div>

<script src="vistas/js/visitas.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.4.1/purify.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="vistas/recursos/compressor/compressor.min.js"></script>

<script>

</script>