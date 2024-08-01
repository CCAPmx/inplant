<?php
if ((time() - $_SESSION['time']) > 900) {
    echo "<script>window.location='salir'</script>";
}
?>
<style>
    ol li {

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
        <div class="my-2 mx-2 flex-grow-1 bd-highlight">Partes Maquinas</div>
        <ol class="my-2 mx-2 breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashclientes">Inicio</a></li>
            <li class="breadcrumb-item active">Partes Maquinas</li>
        </ol>
    </div>



    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <input type="hidden" class="form-control" id="txtnombre" name="txtnombre" required value="<?php echo  $_SESSION["nombre"]; ?>" readonly>
                <input type="hidden" class="form-control" id="txtpk" name="txtpk" required value="<?php echo $_SESSION['pk']; ?>" readonly>



                <div class="col-md-3 p-1 m-2">
                    <label for="cbmaquinas" class="form-label">Maquina</label>
                    <select class="form-control select2 select2-purple" autocomplete="off" data-dropdown-css-class="select2-purple" style="width: 100%;" id="cbmaquinas" name="cbmaquinas"></select>
                </div>






                <div id="loader" class="loader"></div>
                <div class="card-body">

                    <div class="alert alert-danger" id="error" role="alert" style="display:none">
                        Sin datos de esta maquina
                    </div>





                    <div class="d-flex justify-content-center">
                        <div class="spinner-border" role="status" id="spinner" style="display:none">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>



                    <div class="col-12" id="tabla">
                        <table id="table_partes_maquina" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Tipo</th>
                                    <th>Descripción</th>
                                    <th>vida útil actual</th>
                                    <th>Horometro</th>
                                    <th>Porcentaje cambio</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th>Tipo</th>
                                    <th>Descripción</th>
                                    <th>vida útil actual</th>
                                    <th>Horometro</th>
                                    <th>Porcentaje cambio</th>
                                    <th>Acciones</th>

                                </tr>
                            </tfoot>


                        </table>
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Vida util horas</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form id="form_hrs_util">
                    <div class="mb-3">
                        <input type="text" hidden class="form-control" name="pk" id="pk">
                        <input type="text" hidden class="form-control maquina" name="pk_maquina" id="pk_maquina">
                    </div>

                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Vida util:</label>
                        <input type="number" class="form-control" name="vida_hrs" id="vida_hrs">

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary" id="btn_guardar">Guardar</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade modal-lg" id="Editar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva Parte </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">



                <form class="row g-3" id="formPartes">
                    <input type="text" hidden class="form-control maquina" name="recordId" id="recordId">
                    <input type="text" hidden class="form-control maquina" name="noparte" id="noparte">
                    <input type="text" hidden class="form-control maquina" name="nombremaquina" id="nombremaquina">
                    <input type="text" hidden class="form-control maquina" name="fkmaquina" id="fkmaquina">

                    <div class="col-md-6">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="tipo" name="tipo">
                            <option value="" selected> Seleccionar</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="proveedor" class="form-label">Proveedor</label>
                        <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="proveedor" name="proveedor">
                            <option value="" selected> Seleccionar</option>
                        </select>
                    </div>

                    <div class="col-md-6" style="display: none;" id="div_materiales_boquillas">
                        <label for="tipo" class="form-label">Material boquilla </label>
                        <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="tipo_boquilla" name="tipo_boquilla">
                            <option value="" selected> Seleccionar</option>
                        </select>
                    </div>
                    <div class="col-md-6" style="display: none;" id="div_material_granalla">
                        <label for="tipo" class="form-label">Material Granalla </label>
                        <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="material_granalla" name="material_granalla">
                        </select>
                    </div>

                    <div class="col-md-12" style="display: none;" id="div_reversible">

                        <input class="form-check-input" type="checkbox" value="" id="reversible" name="reversible">
                        <label class="form-check-label" for="reversible">
                            Reversible
                        </label>
                    </div>


                    <div class="col-md-6">
                        <label for="vida_util" class="form-label">vida util</label>
                        <input type="number" class="form-control" id="vida_util" name="vida_util">

                    </div>
                    <div class="col-md-6">
                        <label for="parte" class="form-label">Parte</label>
                        <input type="text" class="form-control" id="parte" name="parte">
                    </div>
                    <div class="col-12">
                        <label for="Descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="Descripcion" name="Descripcion" rows="3"></textarea>
                    </div>
                    <div class="col-12">
                        <label for="comentarios" class="form-label">Comentarios</label>
                        <textarea class="form-control" id="comentarios" name="comentarios" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary" id="btn_guardar_parte">Guardar</button>
            </div>
        </div>
    </div>
</div>



<script>
    /* menu */

    document.getElementById('menu_partes_maquinas').classList.toggle('active');

    document.getElementById('menu_mantenimiento_item').classList.remove('hide_menu');
    // document.getElementById('menu_bodegas_item').classList.remove('hide_menu');
    // document.getElementById('menu_materias_primas_item').classList.remove('hide_menu');

    document.getElementById('dashclientes_menu').classList.remove('active');
    document.getElementById('vagones_menu').classList.remove('active');
    document.getElementById('proyectos_menu').classList.remove('active');
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
    document.getElementById('menu_mantenimiento_item').classList.remove('active');
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="vistas/js/partesMaquinas.js"></script>