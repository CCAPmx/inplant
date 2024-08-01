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
    font-size: 15px; /* Ajusta el tamaño de fuente según tus preferencias */
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
        <div class="my-2 mx-2 flex-grow-1 bd-highlight">Información granalla</div>
        <ol class="my-2 mx-2 breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashclientes">Inicio</a></li>
            <li class="breadcrumb-item active">Información granalla</li>
        </ol>
    </div>



    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <input type="hidden" class="form-control" id="txtnombre" name="txtnombre" required value="<?php echo  $_SESSION["nombre"]; ?>" readonly>
                <input type="hidden" class="form-control" id="txtpk" name="txtpk" required value="<?php echo $_SESSION['pk']; ?>" readonly>


                <div id="loader" class="loader"></div>

              


                <div class="card-body">


                    <form class="row text-center">
                   

                        <div class="row mt-2">
                            <div class="col-md-2 col-sm-12 my-2 text-center">
                            <input type="text" class="form-control" id="daypickerhoygra" placeholder="Seleccionar Día">
                            </div>
                        
                            <div class="col-md-2 col-sm-12 my-2 text-center">
                                <button type="button" class="btn btn-outline-info" id="btnsemact" >Semana Actual</button>
                            </div>
                           
                            <div class="col-md-2 col-sm-12 my-2 text-center">
                                <button type="button" class="btn btn-outline-info" id="btnsempas">Semana Pasada</button>
                            </div>

                            <div class="col-md-2 col-sm-12 my-2 text-center">
                                <button type="button" class="btn btn-outline-info" id="btnmesact">Mes Actual</button>
                            </div>

                            <div class="col-md-2 col-sm-12 my-2 text-center">
                                <button type="button" class="btn btn-outline-info" id="btnmespas">Mes Pasado</button>
                            </div>


                            <div class="col-md-2 col-sm-12 my-2 text-center">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button id="exportexcel" name="exportexcel" class="btn btn-outline-info btn-sm mx-1"><i class="fa-solid fa-file-excel"></i></button>
                                    <button id="exportpdf" name="exportpdf" class="btn btn-outline-info btn-sm "><i class="fa-solid fa-file-pdf"></i></button>
                                </div>
                            </div>



                            
                        </div>
                    </form>
                    
             
                    <div class="card-body">

                  
                    
                    <div class="table-responsive">

                        <table id="tablegranalla" 
                        data-toggle="table"
                        data-locale="es-MX"
                        data-show-button-icons="true"
                        data-buttons-class="outline-info"
                        data-filter-control="true"
                        data-show-search-clear-button="true">
                        <thead>
                            <tr>
                        
                            <th data-field="granalla" data-filter-control="input">Granalla</th>
                            <th class="text-center" data-field="cargas" data-filter-control="input">Cargas</th>
                            <th data-field="cabina" data-filter-control="input">Cabina</th>
                            <th class="text-center" data-field="cantidad" data-filter-control="input">Cantidad</th>
                            </tr>
                        </thead>
                        </table>

                        <p class="text-center text-white bg-info" id="parrafoinfo" class="mostrar">Selecciona una fecha o un periodo para visualizar los vagones</p>

                    </div> 
                   

                  
                </div>





                </div>

                <div class="card-footer text-certer">
                    <div class="d-flex justify-content-center">
                       
                    </div>
                    
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

<div class="modal fade" id="ModalVagon" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title text-white">Modal Heading</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table caption-top">
                            <!-- <caption class="text-center"> <strong>DATOS GENERALES</strong></caption> -->
                            <table class="table table-bordered table-sm" id="tablaVagon">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody id="DataResultados">
                                </tbody>
                            </table>
                        </table>
                    </div>

                </div>
                <div class="card-footer text-center">
                    <button type="button" class="btn btn-outline-info" id="btnpdf"><i class="fas fa-file-pdf"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="vistas/js/informaciongranalla.js"></script>

<script>
    /* menu */
    document.getElementById('informaciongranalla_menu').classList.toggle('active');



    // document.getElementById('menu_produccion_item').classList.remove('hide_menu');
    // document.getElementById('menu_bodegas_item').classList.remove('hide_menu');
    document.getElementById('menu_materias_primas_item').classList.remove('hide_menu');


    document.getElementById('reportevagones_menu').classList.remove('active');
    document.getElementById('proyectos_menu').classList.remove('active');
    document.getElementById('vagones_menu').classList.remove('active');
    document.getElementById('supervisores_menu').classList.remove('active');
    document.getElementById('maqclientes_menu').classList.remove('active');
    document.getElementById('generargranalla_menu').classList.remove('active');
    document.getElementById('solicitudes_menu').classList.remove('active');
    document.getElementById('dashclientes_menu').classList.remove('active');    
    // document.getElementById('informaciongranalla_menu').classList.remove('active');
    document.getElementById('stockgranalla_menu').classList.remove('active');
    document.getElementById('pedidosclientes_menu').classList.remove('active');
    document.getElementById('movbodega_menu').classList.remove('active');
    document.getElementById('pedidosclientes_menu').classList.remove('active');

</script>