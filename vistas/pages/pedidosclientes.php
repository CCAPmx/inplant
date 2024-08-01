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

    #pagination span {
        display: inline-block;
        padding: 5px;
        margin-right: 5px;
        cursor: pointer;
        color: #000;

    }

    #pagination span.active {
        font-weight: bold;
        text-decoration: underline;
    }
</style>

<div class="container-fluid p-0">
    <div class="row">
        <h1 class="text-center fw-bold fs-1" style="color:#07B5E8"><?php echo $_SESSION["u_clientes"]; ?></h1>
    </div>
    <div class="d-flex bd-highlight p-0 text-white" style="background-color: #07B5E8;">
        <div class="my-2 mx-2 flex-grow-1 bd-highlight">Pedidos</div>
        <ol class="my-2 mx-2 breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashclientes">Inicio</a></li>
            <li class="breadcrumb-item active">Pedidos</li>
        </ol>
    </div>



    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">



                <div id="loader" class="loader"></div>

                <div class="card-body caja">
                    <input type="hidden" class="form-control" id="txtpk" name="txtpk" required value="<?php echo $_SESSION['pk']; ?>" readonly>
                    <div class="table-responsive">
                        <table class="table table-bordered border-info table-sm" id="tablaped">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">Fecha</th>
                                    <th scope="col" class="text-center">Lista de empaque</th>
                                    <th scope="col" class="text-center" style="visibility:collapse; display:none;">Total</th>
                                    <th scope="col" class="text-center" style="visibility:collapse; display:none;">Moneda</th>
                                    <th scope="col" class="text-center" style="display:none;">Pk_Orden</th>
                                    <th scope="col" class="text-center">Status del Despacho</th>
                                    <th scope="col" class="text-center" style="display:none;">Transporte</th>
                                    <th scope="col" class="text-center">Ver Detalle</th>
                                </tr>
                            </thead>
                            <tbody id="DataPedidos">
                            </tbody>
                        </table>


                    </div>


                </div>

                <div class="card-footer text-certer">
                    <div class="d-flex justify-content-center">
                        <div id="pagination"></div>
                    </div>
                    <div class="text-center mt-3"><span class="text-dark" id="txtPag"></span></div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="Modalpedidos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title text-white">Modal Heading</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table caption-top">
                            <caption class="text-center"> <strong>Lista De Empaque</strong></caption>
                            <table class="table table-bordered border-info table-sm" id="tablaDatos">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">ID</th>
                                        <th scope="col" class="text-center">Descripcion</th>
                                        <th scope="col" class="text-center">Cantidad</th>
                                        <th scope="col" class="text-center" style="display:none;">Precio</th>
                                        <th scope="col" class="text-center" style="display:none;">Total</th>
                                    </tr>
                                </thead>
                                <tbody id="DataResult">
                                </tbody>
                            </table>
                        </table>
                        <div id="paginacion"></div>

                    </div>
                </div>

                <div class="card-footer text-certer">
                    <div class="d-flex justify-content-end">
                        <h5 id="statustranspor"></h5>
                    </div>


                </div>


            </div>

        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="vistas/js/pedidosclientes.js"></script>

<script>
    /* menu */
    document.getElementById('pedidosclientes_menu').classList.toggle('active');



    // document.getElementById('menu_produccion_item').classList.remove('hide_menu');
    document.getElementById('menu_bodegas_item').classList.remove('hide_menu');
    // document.getElementById('menu_materias_primas_item').classList.remove('hide_menu');


    document.getElementById('reportevagones_menu').classList.remove('active');
    document.getElementById('proyectos_menu').classList.remove('active');
    document.getElementById('vagones_menu').classList.remove('active');
    document.getElementById('supervisores_menu').classList.remove('active');
    document.getElementById('maqclientes_menu').classList.remove('active');
    document.getElementById('generargranalla_menu').classList.remove('active');
    document.getElementById('solicitudes_menu').classList.remove('active');
    
    document.getElementById('dashclientes_menu').classList.remove('active');
    document.getElementById('informaciongranalla_menu').classList.remove('active');
    document.getElementById('stockgranalla_menu').classList.remove('active');
    // document.getElementById('pedidosclientes_menu').classList.remove('active');
    document.getElementById('movbodega_menu').classList.remove('active');
    // document.getElementById('pedidosclientes_menu').classList.remove('active');
    
</script>