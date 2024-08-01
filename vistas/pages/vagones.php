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
</style>

<div class="container-fluid">
    <div class="row">
        <h1 class="text-center fw-bold fs-3" style="color:#07B5E8"><?php echo $_SESSION["u_clientes"]; ?></h1>
    </div>
    <div class="d-flex bd-highlight p-0 text-white" style="background-color: #07B5E8;">
        <div class="my-2 mx-2 flex-grow-1 bd-highlight">Captura de vagones</div>
        <ol class="my-2 mx-2 breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashclientes">Inicio</a></li>
            <li class="breadcrumb-item active">Captura de vagones</li>
        </ol>
    </div>



    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">



                <div id="loader" class="loader"></div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-info">





                                <div class="card-body caja">

                                    <!-- <div class="table-responsive">
                        <table class="table table-bordered border-info table-sm" id="tablaproyec">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">Fecha</th>
                                    <th scope="col" class="text-center">Proyecto</th>
                                    <th scope="col" class="text-center" >fkcliente</th>
                                    <th scope="col" class="text-center">Cantidad</th>
                                    <th scope="col" class="text-center">Producidos</th>
                                    <th scope="col" class="text-center" style="display:none;">fk_cliente_lersoft</th>
                                    <th scope="col" class="text-center" style="display:none;">Tipo vagon</th>
                                    <th scope="col" class="text-center">Producto</th>
                                    <th scope="col" class="text-center" style="display:none;">pk</th>
                                    <th scope="col" class="text-center">Crear Vagon</th>
                                </tr>
                            </thead>
                            <tbody id="DataProyec">
                            </tbody>
                        </table>
                    </div> -->

                                    <form class="row g-3">
                                        <input type="hidden" class="form-control" id="txtpk" name="txtpk" required value="<?php echo $_SESSION['pk']; ?>" readonly>

                                        <div class="col-md-3">
                                            <!-- <label for="txtFkvag" class="form-label">Cliente Lersoft</label> -->
                                            <input type="hidden" class="form-control" id="txtFkvag" name="txtFkvag" required value="<?php echo $_SESSION['pk']; ?>" readonly>
                                        </div>

                                        <div class="col-md-3">
                                            <!-- <label for="txtCliente" class="form-label">Cliente</label>     -->
                                            <input type="hidden" class="form-control" id="txtCliente" name="txtCliente" required value="" readonly>
                                        </div>

                                        <div class="col-md-3">
                                            <!-- <label for="txtTipovag" class="form-label">Tipo De Vagon</label>     -->
                                            <input type="hidden" class="form-control" id="txtTipovag" name="txtTipovag" required value="" readonly>
                                        </div>

                                        <div class="col-md-3">
                                            <!-- <label for="txtpkproy" class="form-label">PkProy</label>     -->
                                            <input type="hidden" class="form-control" id="txtpkproy" name="txtpkproy" required value="" readonly>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="cbmmaquinavag" class="form-label">Cabina de Granallado</label>
                                            <select class="form-control select2 select2-purple" data-dropdown-css-class="select2-purple" style="width: 100%;" id="cbmmaquinavag" name="cbmmaquinavag"></select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="cbmproy" class="form-label">Proyecto</label>
                                            <select class="form-control select2 select2-purple" data-dropdown-css-class="select2-purple" style="width: 100%;" id="cbmproy" name="cbmproy"></select>
                                        </div>


                                       


                                        <!-- <div class="col-md-6"> -->
                                        <!-- <label for="txtProyectos" class="form-label">Proyecto</label> -->
                                        <input type="hidden" class="form-control" id="txtProyectos" name="txtProyectos" placeholder="Proyecto" readonly>
                                        <!-- </div> -->

                                        <div class="col-md-4">
                                            <label for="txtSerie" class="form-label">Serie de vagón</label>
                                            <input type="text" class="form-control" id="txtSerie" name="txtSerie" placeholder="Serie de vagón">
                                        </div>

                                        <!-- <div class="col-md-6">
                            <label for="txtCuarto" class="form-label">Cabina de Granallo</label>
                            <input type="text" class="form-control" id="txtCuarto" name="txtCuarto" placeholder="Cabina de Granallo">
                        </div>  -->

                                        <div class="col-12 text-center">
                                            <button type="button" class="btn btn-info" id="btnguardarvag">GENERAR VAGON</button>
                                        </div>

                                    </form>


                                    <div class="row my-3">
                                        <p class="text-center text-light bg-info" id="datoscabina"></p>
                                        <div class="col-xl-4 col-xxl-4 d-flex">

                                            <div class="card flex-fill w-100">
                                                <div class="card-header">

                                                    <h5 class="card-title mb-0 text-center">Vagones Terminados</h5>
                                                </div>
                                                <div class="card-body py-3">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered border-info table-sm" id="tablaterminado">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col" class="text-center">Serie de Vagón</th>
                                                                    <th scope="col" class="text-center">Fecha de Granallado</th>
                                                                    <th scope="col" class="text-center">Proyecto</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-xxl-4 d-flex">

                                            <div class="card flex-fill w-100">
                                                <div class="card-header">

                                                    <h5 class="card-title mb-0 text-center">Vagones en cabina</h5>
                                                </div>
                                                <div class="card-body py-3">
                                                    <table class="table table-bordered border-info table-sm" id="tablacabina">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col" class="text-center">Serie de Vagón</th>
                                                                <th scope="col" class="text-center">Proyecto</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-xxl-4 d-flex">

                                            <div class="card flex-fill w-100">
                                                <div class="card-header">

                                                    <h5 class="card-title mb-0 text-center">Vagones en espera</h5>
                                                </div>
                                                <div class="card-body py-3">
                                                    <table class="table table-bordered border-info table-sm" id="tablaespera">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col" class="text-center">Serie de Vagón</th>
                                                                <th scope="col" class="text-center">Proyecto</th>
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

                                <div class="card-footer text-certer">
                                    <div class="d-flex justify-content-center">
                                        <div id="paginationproy"></div>
                                    </div>
                                    <div class="text-center mt-3"><span class="text-dark" id="txtPag"></span></div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-footer text-certer">
                    <div class="d-flex justify-content-center">
                        <div id="paginationproy"></div>
                    </div>
                    <div class="text-center mt-3"><span class="text-dark" id="txtPag"></span></div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalVagon" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-ms">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title text-white">Modal Heading</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="card">
                <div class="card-body">


                    <form class="row g-3">

                        <div class="col-md-6 text-center">
                            <button type="button" class="btn btn-outline-info" id="btngranallado">Regranallado </button>
                        </div>

                        <div class="col-md-6 text-center">
                            <button type="button" class="btn btn-outline-info" id="btncorregir">Corregir La Serie</button>
                        </div>

                        <!-- <div class="col-md-3">
                              <label for="txtFkvag" class="form-label">Cliente Lersoft</label> 
                            <input type="text" class="form-control" id="txtFkvag" name="txtFkvag" required value="<?php echo $_SESSION['pk']; ?>" readonly>
                        </div>

                        <div class="col-md-3">
                             <label for="txtCliente" class="form-label">Cliente</label> 
                            <input type="text" class="form-control" id="txtCliente" name="txtCliente" required value="" readonly>
                        </div>

                        <div class="col-md-3">
                             <label for="txtTipovag" class="form-label">Tipo De Vagon</label> 
                            <input type="text" class="form-control" id="txtTipovag" name="txtTipovag" required value="" readonly>
                        </div>

                        <div class="col-md-3">
                             <label for="txtpkproy" class="form-label">PkProy</label> 
                            <input type="text" class="form-control" id="txtpkproy" name="txtpkproy" required value="" readonly>
                        </div>


                        <div class="col-md-4">
                            <label for="cbmmaquina" class="form-label">Cabina de Granallado</label>
                            <select class="form-control select2 select2-purple" data-dropdown-css-class="select2-purple" style="width: 100%;" id="cbmmaquina" name="cbmmaquina"></select>
                        </div>


                        <div class="col-md-4">
                            <label for="txtProyectos" class="form-label">Proyecto</label>
                            <input type="text" class="form-control" id="txtProyectos" name="txtProyectos" placeholder="Proyecto" readonly>
                        </div>

                        <div class="col-md-4">
                            <label for="txtSerie" class="form-label">Serie de vagón</label>
                            <input type="text" class="form-control" id="txtSerie" name="txtSerie" placeholder="Serie de vagón">
                        </div>

                        <div class="col-md-6">
                            <label for="txtCuarto" class="form-label">Cabina de Granallo</label>
                            <input type="text" class="form-control" id="txtCuarto" name="txtCuarto" placeholder="Cabina de Granallo">
                        </div>
                        
                        <div class="col-12 text-center">
                            <button type="button" class="btn btn-dark" id="btnguardarvag">Guardar</button>
                        </div> -->

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="vistas/js/vagones.js"></script>

<script>

    /* menu */
document.getElementById('vagones_menu').classList.toggle('active');


document.getElementById('menu_produccion_item').classList.remove('hide_menu');
// document.getElementById('menu_bodegas_item').classList.remove('hide_menu');
// document.getElementById('menu_materias_primas_item').classList.remove('hide_menu');


document.getElementById('dashclientes_menu').classList.remove('active');
document.getElementById('proyectos_menu').classList.remove('active');
document.getElementById('reportevagones_menu').classList.remove('active');
document.getElementById('supervisores_menu').classList.remove('active');
document.getElementById('maqclientes_menu').classList.remove('active');
document.getElementById('generargranalla_menu').classList.remove('active');
document.getElementById('solicitudes_menu').classList.remove('active');
document.getElementById('dashclientes_menu').classList.remove('active');
document.getElementById('generargranalla_menu').classList.remove('active');
document.getElementById('informaciongranalla_menu').classList.remove('active');
document.getElementById('stockgranalla_menu').classList.remove('active');
document.getElementById('pedidosclientes_menu').classList.remove('active');
document.getElementById('movbodega_menu').classList.remove('active');
document.getElementById('pedidosclientes_menu').classList.remove('active');

</script>



