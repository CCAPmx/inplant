<?php
		if((time() - $_SESSION['time']) > 900){
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

<div class="container-fluid p-0">
    <div class="row">
        <h1 class="text-center fw-bold fs-1" style="color:#07B5E8"><?php echo $_SESSION["u_clientes"]; ?></h1>
    </div>
    <div class="d-flex bd-highlight p-0 text-white" style="background-color: #07B5E8;">
        <div class="my-2 mx-2 flex-grow-1 bd-highlight">Proyectos</div>
        <ol class="my-2 mx-2 breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashclientes">Inicio</a></li>
            <li class="breadcrumb-item active">Proyectos</li>
        </ol>
    </div>



    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
             

                <div id="loader" class="loader"></div>

                <div class="card-body caja">
                    <input type="hidden" class="form-control" id="txtpk" name="txtpk" required value="<?php echo $_SESSION['pk']; ?>" readonly>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-info mb-3" id="btnnewproyect">Nuevo Proyecto</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered border-info table-sm" id="tablaproyectos">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">Fecha de Proyecto</th>
                                    <th scope="col" class="text-center">Producto</th>
                                    <th scope="col" class="text-center">Proyecto</th>
                                    <th scope="col" class="text-center" style="display:none;">fkcliente</th>
                                    <th scope="col" class="text-center">Volumen Proyecto</th>
                                    <th scope="col" class="text-center">Producidos Actuales</th>
                                    <th scope="col" class="text-center" style="display:none;">fk_cliente_lersoft</th>
                                    <th scope="col" class="text-center" style="display:none;">Tipo vagon</th>
                                    
                                </tr>
                            </thead>
                            <tbody id="DataProyectos">
                            </tbody>
                        </table>


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

<div class="modal fade" id="ModalProyecto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title text-white">Modal Heading</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="card">
                <div class="card-body">


                    <form class="row g-3">
                        <div class="col-md-6">
                            <input type="hidden" class="form-control" id="txtFk" name="txtFk" required value="<?php echo $_SESSION['pk']; ?>" readonly>
                        </div>

                        <div class="col-md-6">
                            <input type="hidden" class="form-control" id="txtpks" name="txtpks" required value="" readonly>
                        </div>

                        <div class="col-md-2">
                            <label for="txtfechahoy" class="form-label">Fecha</label>
                            <input type="text" class="form-control" id="txtfechahoy" name="txtfechahoy" readonly>
                        </div>

                        <div class="col-2">
                            <label for="txtcantidad" class="form-label">Cantidad</label>
                            <input type="text" maxlength="10" name="txtcantidad" id="txtcantidad" placeholder="Solo caracteres Numericos"   class="form-control"
                                required autocomplete="off" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" min="1" />
                            <!-- <input type="number" class="form-control" id="txtcantidad" name="txtcantidad" value=0 min=0> -->
                        </div> 

                        <div class="col-md-2">

                            <label for="cbmtipo" class="form-label">Producto</label>
                            <select class="form-control select2 select2-purple" data-dropdown-css-class="select2-purple" style="width: 100%;" id="cbmtipo" name="cbmtipo"></select>
                            
                            <!-- <input type="text" class="form-control" id="txttipovagon" name="txttipovagon" placeholder="Tipo Vagon"> -->
                        </div>

                        <div class="col-md-6">
                            <label for="txtproyecto" class="form-label">Proyecto</label>
                            <input type="text" class="form-control" id="txtproyecto" name="txtproyecto" placeholder="Proyecto">
                        </div>
                        
                    
                        <!-- <div class="col-4">
                            <label for="txtproducidos" class="form-label">Producidos</label>
                            <input type="number" class="form-control" id="txtproducidos" name="txtproducidos" value=0 min=0>
                        </div> -->
                        

                        <!-- <div class="col-md-12">
                            <label for="txtproducto" class="form-label">Producto</label>
                            <input type="text" class="form-control" id="txtproducto" name="txtproducto" placeholder="Producto">
                        </div> -->
                        
                        <div class="col-12 text-center">
                            <button type="button" class="btn btn-dark" id="btnguardar">Guardar</button>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="vistas/js/proyectos.js"></script>

<script>

    /* menu */
    
document.getElementById('proyectos_menu').classList.toggle('active');
// document.getElementById('sub_menu_Turno').classList.toggle('active');


document.getElementById('menu_produccion_item').classList.remove('hide_menu');
// document.getElementById('sub_menu_Turno_item').classList.remove('hide_menu');
// document.getElementById('menu_bodegas_item').classList.remove('hide_menu');
// document.getElementById('menu_materias_primas_item').classList.remove('hide_menu');

document.getElementById('dashclientes_menu').classList.remove('active');
document.getElementById('vagones_menu').classList.remove('active');
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

document.getElementById('infoTurno_menu').classList.remove('active');
document.getElementById('sub_menu_Turno').classList.remove('active');
document.getElementById('eventosCalendario_menu').classList.remove('active');


</script>