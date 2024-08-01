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
        <div class="my-2 mx-2 flex-grow-1 bd-highlight">Eventos Calendario</div>
        <ol class="my-2 mx-2 breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashclientes">Inicio</a></li>
            <li class="breadcrumb-item active">Eventos Calendario</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">

                <div class="container">
                    <div class="row">

                        <!-- <button id="refrescar"> Cargar datos <button> -->


                        <div class="col-md-12 p-2">
                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> <span class="sr-only" id="titulo"> </span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row ">
                    <div class="col-12 text-center"><span class="badge rounded-pill bg-info ">Información del evento</span></div>
                    <div class="col-12" ><strong> Fecha:</strong> <div id="fecha"> </div></div>
                    <div class="col-12" ><strong> Turno:</strong> <div id="turno"> </div></div>
                    <div class="col-12"><strong> Hora inicio</strong> <div id="hora_ini"></div></div>
                    <div class="col-12"> <strong> Hora fin</strong> <div id="hora_fin"></div></div>
                    <div class="col-12" ><strong> Maquina:</strong> <div id="maquina"></div></div>                    
                    <div class="col-12" ><strong> Supervisor:</strong> <div id="supervisor"> </div></div>
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Salir</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="vistas/js/eventosCalendario.js"></script>


<script>
    /* menu */
    document.getElementById('eventosCalendario_menu').classList.toggle('active');



    document.getElementById('menu_produccion_item').classList.remove('hide_menu');
    document.getElementById('sub_menu_Turno_item').classList.remove('hide_menu');
    // document.getElementById('menu_bodegas_item').classList.remove('hide_menu');
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
    document.getElementById('pedidosclientes_menu').classList.remove('active');
    document.getElementById('movbodega_menu').classList.remove('active');
    document.getElementById('pedidosclientes_menu').classList.remove('active');
    document.getElementById('pedidosclientes_menu').classList.remove('active');


    document.getElementById('alta_turno_menu').classList.remove('active');
    // document.getElementById('eventosCalendario_menu').classList.remove('active');
    document.getElementById('infoTurno_menu').classList.remove('active');

</script>