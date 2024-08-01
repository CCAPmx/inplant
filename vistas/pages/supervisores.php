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
        <div class="my-2 mx-2 flex-grow-1 bd-highlight">Carga de turnos a supervisores</div>
        <ol class="my-2 mx-2 breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashclientes">Inicio</a></li>
            <li class="breadcrumb-item active">Carga de turnos a supervisores</li>
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
                                <div class="card-body">
                                    <form class="row g-3">
                                        <input type="hidden" class="form-control" id="txtpk" name="txtpk" required value="<?php echo $_SESSION['pk']; ?>" readonly>




                                        <div class="col-md-4">
                                            <label for="cbmaquinas" class="form-label">Maquina</label>
                                            <select class="form-control select2 select2-purple" autocomplete="off" data-dropdown-css-class="select2-purple" style="width: 100%;" id="cbmaquinas" name="cbmaquinas"></select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="cbmsuperv" class="form-label">Supervisor</label>
                                            <select class="form-control select2 select2-purple" autocomplete="off" data-dropdown-css-class="select2-purple" style="width: 100%;" id="cbmsuperv" name="cbmsuperv"></select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="cbmmodo" class="form-label">Modo Turno</label>
                                            <select class="form-control select2 select2-purple" autocomplete="off" data-dropdown-css-class="select2-purple" style="width: 100%;" id="cbmmodo" name="cbmmodo"></select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="cbmturno" class="form-label">Turno</label>
                                            <select class="form-control select2 select2-purple" autocomplete="off" data-dropdown-css-class="select2-purple" style="width: 100%;" id="cbmturno" name="cbmturno">
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="daypickerini" class="form-label">Fecha inicio</label>
                                            <input type="text" class="form-control" id="daypickerini" autocomplete="off" placeholder="Seleccionar Día">
                                        </div>

                                        <div class="col-md-4">
                                            <label for="daypickerfin" class="form-label">Fecha fin</label>
                                            <input type="text" class="form-control" id="daypickerfin" autocomplete="off" placeholder="Seleccionar Día">
                                        </div>

                                        <div class="col-12 text-center">
                                            <button type="button" class="btn btn-info" id="btnguardarsup">Guardar Turno</button>
                                        </div>

                                    </form>




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
<script src="vistas/js/supervisores.js"></script>




<script>
    /* menu */
    document.getElementById('supervisores_menu').classList.toggle('active');
    // document.getElementById('sub_menu_Turno').classList.toggle('active');



    document.getElementById('menu_produccion_item').classList.remove('hide_menu');
    document.getElementById('sub_menu_Turno_item').classList.remove('hide_menu');
    // document.getElementById('menu_bodegas_item').classList.remove('hide_menu');
    // document.getElementById('menu_materias_primas_item').classList.remove('hide_menu');


    document.getElementById('reportevagones_menu').classList.remove('active');
    document.getElementById('proyectos_menu').classList.remove('active');
    document.getElementById('vagones_menu').classList.remove('active');
    // document.getElementById('supervisores_menu').classList.remove('active');
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



    document.getElementById('alta_turno_menu').classList.remove('active');
    document.getElementById('eventosCalendario_menu').classList.remove('active');
    document.getElementById('infoTurno_menu').classList.remove('active');




</script>