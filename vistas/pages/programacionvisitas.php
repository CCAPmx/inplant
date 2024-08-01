<link rel="stylesheet" href="vistas/recursos/css/visitastecnicas.css">
<div class="container-fluid">
    <div class="row">
        <h1 class="text-center fw-bold fs-3" style="color:#07B5E8; padding: -35px;margin-top: -38px;"><?php echo $_SESSION["u_clientes"]; ?></h1>
    </div>

    <div class="d-flex bd-highlight p-0 text-white" style="background-color: #07B5E8;">
        <div class="my-2 mx-2 flex-grow-1 bd-highlight">Programación de Visitas Técnicas</div>
        <ol class="my-2 mx-2 breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashclientes">Inicio</a></li>
            <li class="breadcrumb-item active">Programación de Visitas Técnicas</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="d-flex justify-content-end">
                    <div class="btn-group  my-3 mx-2" role="group" aria-label="Basic example">
                        <button id="programar-visita"  class="btn btn-outline-info btn-sm mx-3" data-cliente="<?php echo $_SESSION["pk"]; ?>"> <i class="fas fa-plus-circle"></i></button>
                    </div>
                </div>
                <div class="text-center general-loader" style="display: none">
                    <strong role="status" class="text-info">Loading...</strong>
                    <div class="spinner-border ms-auto text-info" aria-hidden="true"></div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table style="visibility: hidden" id="tablaVisitas" data-url="controladores/programacionvisitas.controlador.php?action=getAllProgramaciones" data-pagination="true" data-search="true" data-toggle="table" data-locale="es-MX" data-show-button-icons="true" data-buttons-class="outline-info" data-filter-control="true" data-show-search-clear-button="true">
                            <thead>
                                <tr>
                                    <!--<th class="text-center" data-field="info" >Más Información</th>-->
                                    <th class="text-center" data-field="fecha" data-filter-control="input">Fecha</th>
                                    <th class="text-center" data-field="cliente" data-filter-control="input">Cliente</th>
                                    <th class="text-center" data-field="nombre_maquina" data-filter-control="input">Maquina</th>
                                    <th class="text-center" data-field="visitador" data-filter-control="input">Visitador</th>
                                    <th class="text-center" data-field="observaciones" data-filter-control="input">Observaciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="programarvisitaDetailModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" id="programarVisitaDetailModalContent">
            <div class="modal-header" id="programarVisitaDetailModalTitle">
            </div>
            <div class="modal-body" id="programarVisitaDetailModalBody">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closeBottomModal" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="vistas/js/programacionvisitas.js"></script>