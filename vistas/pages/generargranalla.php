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
        <div class="my-2 mx-2 flex-grow-1 bd-highlight">Carga granalla</div>
        <ol class="my-2 mx-2 breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashclientes">Inicio</a></li>
            <li class="breadcrumb-item active">Carga granalla</li>
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
                                       

                                         <div class="col-md-4">
                                            <!-- <label for="txtPkempresa" class="form-label">Pkempresa</label> -->
                                            <input type="hidden" class="form-control" id="txtPkempresa" name="txtPkempresa" required value="<?php echo $_SESSION['pk']; ?>" readonly>
                                        </div>

                                        <div class="col-md-4">
                                            <!-- <label for="txtPkusuario" class="form-label">Pkusuario</label>     -->
                                            <input type="hidden" class="form-control" id="txtPkusuario" name="txtPkusuario" required value="<?php echo  $_SESSION["pkuser"]; ?>" readonly>
                                        </div>
                                       
                                        <div class="col-md-4">
                                            <!-- <label for="txtUsario" class="form-label">Nombre</label>     -->
                                            <input type="hidden" class="form-control" id="txtUsario" name="txtUsario" required value="<?php echo  $_SESSION["usuario"]; ?>" readonly>
                                        </div>
                                

                                        <div class="col-md-4">
                                            <label for="cbmmaquina" class="form-label">Maquina</label>
                                            <select class="form-control select2 select2-purple" data-dropdown-css-class="select2-purple" style="width: 100%;" id="cbmmaquina" name="cbmmaquina">
                                            </select>
                                        </div> 

                                        <div class="col-md-4">
                                            <label for="cbmgranalla" class="form-label">Granalla</label>
                                            <select class="form-control select2 select2-purple" data-dropdown-css-class="select2-purple" style="width: 100%;" id="cbmgranalla" name="cbmgranalla">
                                            </select>
                                        </div>


                                        <div class="col-md-4">
                                            <label for="txtgranallo" class="form-label">Cantidad</label>
                                            <input type="number" class="form-control" id="txtgranallo" id="txtgranallo" placeholder="Cantidad">
                                        </div>

                                        <div class="col-12 text-center">
                                            <button type="button" class="btn btn-info" id="btnguardargranalla">Guardar granalla</button>
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
<script src="vistas/js/generargranalla.js"></script>


<script>
    /* menu */
    document.getElementById('generargranalla_menu').classList.toggle('active');
   



    // document.getElementById('menu_produccion_item').classList.remove('hide_menu');
    // document.getElementById('menu_bodegas_item').classList.remove('hide_menu');
    document.getElementById('menu_materias_primas_item').classList.remove('hide_menu');


    document.getElementById('reportevagones_menu').classList.remove('active');
    document.getElementById('proyectos_menu').classList.remove('active');
    document.getElementById('vagones_menu').classList.remove('active');
    document.getElementById('supervisores_menu').classList.remove('active');
    document.getElementById('maqclientes_menu').classList.remove('active');
    // document.getElementById('generargranalla_menu').classList.remove('active');
    document.getElementById('solicitudes_menu').classList.remove('active');
    document.getElementById('dashclientes_menu').classList.remove('active');    
    document.getElementById('informaciongranalla_menu').classList.remove('active');
    document.getElementById('stockgranalla_menu').classList.remove('active');
    document.getElementById('pedidosclientes_menu').classList.remove('active');
    document.getElementById('movbodega_menu').classList.remove('active');
    document.getElementById('pedidosclientes_menu').classList.remove('active');
    document.getElementById('pedidosclientes_menu').classList.remove('active');
    document.getElementById('pedidosclientes_menu').classList.remove('active');


</script>