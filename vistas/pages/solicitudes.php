<?php
if ((time() - $_SESSION['time']) > 900) {
    echo "<script>window.location='salir'</script>";
}
?>
<style>
    ol li {
        /* list-style-type: upper-roman; */
        list-style: none;
        display: inline;
        padding-left: 3px;
        padding-right: 3px;
        margin-top: 9px;

    }


    * #tbusuarios {
        font-size: 12px;
    }

    td {
        font-size: 12px;
    }

    th {
        font-size: 12px;
    }





    .loader {
        border: 8px solid #f3f3f3;
        border-top: 8px solid #3498db;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        animation: spin 1s linear infinite;
        margin: 20px auto;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    #paginationproy span {
        display: inline-block;
        padding: 5px;
        margin-right: 5px;
        cursor: pointer;
        color: #000;

    }

    #paginationproy span.active {
        font-weight: bold;
        text-decoration: underline;
    }

    .fixed-table-loading {
        visibility: hidden;
        top: 0px;
        display: none;
    }

    .loading-wrap {
        visibility: hidden;
        display: none;
    }

    .table-loading {
        visibility: hidden;
        display: none;
    }

    .loading {
        visibility: hidden;
        display: none;
    }


    .oculto {
        display: none;
    }

    .modal-title {
        font-size: 15px;
        /* Ajusta el tamaño de fuente según tus preferencias */
    }

    thead input {
        width: 100%;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <h1 class="text-center fw-bold fs-3" style="color:#07B5E8; padding: -35px;margin-top: -38px;"><?php echo $_SESSION["u_clientes"]; ?></h1>
    </div>
    <div class="d-flex bd-highlight p-0 text-white" style="background-color: #07B5E8;">
        <div class="my-2 mx-2 flex-grow-1 bd-highlight">Solicitudes granalla</div>
        <ol class="my-2 mx-2 breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashclientes">Inicio</a></li>
            <li class="breadcrumb-item active">Solicitudes granalla</li>
        </ol>
    </div>



    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <input type="hidden" class="form-control" id="txtnombre" name="txtnombre" required value="<?php echo  $_SESSION["nombre"]; ?>" readonly>
                <input type="hidden" class="form-control" id="tipouser" name="tipouser" required value="<?php echo  $_SESSION["tipouser"]; ?>" readonly>
                <input type="hidden" class="form-control" id="txtpk" name="txtpk" required value="<?php echo $_SESSION['pk']; ?>" readonly>
                <div class="d-flex justify-content-end">
                                <div class="btn-group  my-3 mx-2" role="group" aria-label="Basic example">
                                    <button id="nuevo"  class="btn btn-outline-info btn-sm mx-3"> <i class="fas fa-plus-circle"></i></button>
                                    <button id="exportexcel" name="exportexcel" class="btn btn-outline-info btn-sm mx-1"><svg class="svg-inline--fa fa-file-excel" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="file-excel" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg=""><path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM155.7 250.2L192 302.1l36.3-51.9c7.6-10.9 22.6-13.5 33.4-5.9s13.5 22.6 5.9 33.4L221.3 344l46.4 66.2c7.6 10.9 5 25.8-5.9 33.4s-25.8 5-33.4-5.9L192 385.8l-36.3 51.9c-7.6 10.9-22.6 13.5-33.4 5.9s-13.5-22.6-5.9-33.4L162.7 344l-46.4-66.2c-7.6-10.9-5-25.8 5.9-33.4s25.8-5 33.4 5.9z"></path></svg><!-- <i class="fa-solid fa-file-excel"></i> Font Awesome fontawesome.com --></button>
                                    <button id="exportpdf" name="exportpdf" class="btn btn-outline-info btn-sm "><svg class="svg-inline--fa fa-file-pdf" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="file-pdf" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V304H176c-35.3 0-64 28.7-64 64V512H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128zM176 352h32c30.9 0 56 25.1 56 56s-25.1 56-56 56H192v32c0 8.8-7.2 16-16 16s-16-7.2-16-16V448 368c0-8.8 7.2-16 16-16zm32 80c13.3 0 24-10.7 24-24s-10.7-24-24-24H192v48h16zm96-80h32c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48H304c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16zm32 128c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H320v96h16zm80-112c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16s-7.2 16-16 16H448v32h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H448v48c0 8.8-7.2 16-16 16s-16-7.2-16-16V432 368z"></path></svg><!-- <i class="fa-solid fa-file-pdf"></i> Font Awesome fontawesome.com --></button>
                                </div>
                            </div>

                <div id="loader" class="loader"></div>




                <div class="card-body">



                    <div class="table-responsive">

                        <table id="tablesolicitud" data-toggle="table" data-locale="es-MX" data-show-button-icons="true" data-buttons-class="outline-info" data-filter-control="true" data-show-search-clear-button="true">
                            <thead>
                                <tr>

                                    <th class="text-center" data-field="solicitud" data-filter-control="input">Solicitud</th>
                                    <th class="text-center" data-field="granalla" data-filter-control="input">Granalla</th>
                                    <th class="text-center" data-field="cantidad" data-filter-control="input">Cantidad</th>
                                    <th class="text-center" data-field="fecha" data-filter-control="input">Fecha</th>
                                    <th class="text-center" data-field="usuario" data-filter-control="input">Usuario</th>
                                    <th class="text-center" data-field="cliente" data-filter-control="input">Cliente</th>
                                    <th class="text-center" data-field="status" data-filter-control="input">Estatus</th>
                                    <th class="text-center" data-field="more-info" data-filter-control="input">Más Información</th>
                                    <th class="text-center" data-field="change-status" data-filter-control="input">Cambiar Estatus</th>
                                </tr>
                            </thead>
                        </table>


                    </div>



                </div>




            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalEntradanew" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title text-white">Modal Heading</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="card">
                <div class="card-body">


                    <form class="row g-3">




                        <!-- <input type="text" class="form-control" id="txtUsario" name="txtUsario" required value="<?php echo  $_SESSION["usuario"]; ?>" readonly> -->

                        <div class="col-md-3">
                            <label for="cbmtipo" class="form-label">Tipo movimiento</label>
                            <select class="form-control select2 select2-purple" data-dropdown-css-class="select2-purple" style="width: 100%;" id="cbmtipo" name="cbmtipo">
                                <option value="Seleccione" selected>Seleccione</option>
                                <option value="Solicitud">Solicitud</option>
                                <option value="Devolucion">Devolucion</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="txtdevolucion" class="form-label">Razón de devolución</label>
                            <input type="text" class="form-control" id="txtdevolucion" id="txtdevolucion" placeholder="Razón de devolución" >
                        </div>

                        <div class="col-md-3">
                            <label for="cbmgranallaje" class="form-label">Granalla</label>
                            <select class="form-control select2 select2-purple" data-dropdown-css-class="select2-purple" style="width: 100%;" id="cbmgranallaje" name="cbmgranallaje"></select>
                        </div>


                        <div class="col-md-3">
                            <label for="txtEntradas" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="txtEntradas" id="txtEntradas" placeholder="Cantidad" value="0" min="0" onkeyup="validarNumero(this)">
                        </div>


                        <div class="col-12 text-center">
                            <button type="button" class="btn btn-info" id="btnguardarEntradasSoli">Guardar Solicitud</button>
                        </div>

                    </form>

                </div>

                <div class="card-footer text-certer">
                    <div class="d-flex justify-content-end">

                    </div>


                </div>


            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="ModalSalida" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title text-white">Modal Heading</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="card">
                <div class="card-body">


                    <form class="row g-3">



                        <input type="hidden" class="form-control" id="txtUsariosal" name="txtUsariosal" required value="<?php echo  $_SESSION["usuario"]; ?>" readonly>

                        <div class="col-md-6">
                            <label for="cbmmaquinasal" class="form-label">Maquina</label>
                            <select class="form-control select2 select2-purple" data-dropdown-css-class="select2-purple" style="width: 100%;" id="cbmmaquinasal" name="cbmmaquinasal">
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="cbmgranallasal" class="form-label">Granalla</label>
                            <select class="form-control select2 select2-purple" data-dropdown-css-class="select2-purple" style="width: 100%;" id="cbmgranallasal" name="cbmgranallasal">
                            </select>
                        </div>


                        <div class="col-md-4">
                            <label for="txtStocksal" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="txtStocksal" id="txtStocksal" placeholder="Stock" readonly>
                        </div>

                        <div class="col-md-4">
                            <label for="txtSalidas" class="form-label">Salidas</label>
                            <input type="number" class="form-control" id="txtSalidas" id="txtSalidas" placeholder="Salida" value="0" min="0" onkeyup="validarNumero(this)">
                        </div>

                        <div class="col-md-4">
                            <label for="txtFinalsal" class="form-label">Total</label>
                            <input type="number" class="form-control" id="txtFinalsal" id="txtFinalsal" placeholder="Total" readonly value="0">
                        </div>

                        <div class="col-12 text-center">
                            <button type="button" class="btn btn-info" id="btnguardarSalidas">Guardar Salidas</button>
                        </div>

                    </form>

                </div>

                <div class="card-footer text-certer">
                    <div class="d-flex justify-content-end">

                    </div>


                </div>


            </div>

        </div>
    </div>
</div>

<div class="modal" id="statusDetailModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="statusDetailModalTitle"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="statusDetailModalBody">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="vistas/js/solicitudes.js"></script>


<script>
    /* menu */
    document.getElementById('solicitudes_menu').classList.toggle('active');



    // document.getElementById('menu_produccion_item').classList.remove('hide_menu');
    document.getElementById('menu_bodegas_item').classList.remove('hide_menu');
    // document.getElementById('menu_materias_primas_item').classList.remove('hide_menu');


    document.getElementById('reportevagones_menu').classList.remove('active');
    document.getElementById('proyectos_menu').classList.remove('active');
    document.getElementById('vagones_menu').classList.remove('active');
    document.getElementById('supervisores_menu').classList.remove('active');
    document.getElementById('maqclientes_menu').classList.remove('active');
    document.getElementById('generargranalla_menu').classList.remove('active');
    // document.getElementById('solicitudes_menu').classList.remove('active');
    document.getElementById('dashclientes_menu').classList.remove('active');
    document.getElementById('informaciongranalla_menu').classList.remove('active');
    document.getElementById('stockgranalla_menu').classList.remove('active');
    document.getElementById('pedidosclientes_menu').classList.remove('active');
    document.getElementById('movbodega_menu').classList.remove('active');
    document.getElementById('pedidosclientes_menu').classList.remove('active');
    document.getElementById('pedidosclientes_menu').classList.remove('active');

</script>