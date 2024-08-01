

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="vistas/recursos/sweetalert/css/sweetalert2.min.css">
<?php
if ((time() - $_SESSION['time']) > 900) {
    echo "<script>window.location='salir'</script>";
}
?>
<style>
    .datepicker .datepicker-days tr td.active~td,
    .datepicker .datepicker-days tr td.active {
        color: #af1623 !important;
        background: transparent !important;
    }

    .datepicker .datepicker-days tr:hover td {
        color: #000;
        background: #e5e2e3;
        border-radius: 0;
    }


    ol li {
        /* list-style-type: upper-roman; */
        list-style: none;
        display: inline;
        padding-left: 3px;
        padding-right: 3px;
        margin-top: 9px;

    }


    #tbusuarios {
        font-size: 12px;
    }

    td {
        font-size: 12px;
    }

    th {
        font-size: 12px;
    }




    /* .mitabla {
        width: 100%;
        table-layout: fixed;
        border-collapse: collapse;
    }

    .mitabla thead {
        background-color: #333;
        color: #FDFDFD;
    }

    .mitabla thead tr {
        display: block;
        position: relative;
    }

    .mitabla tbody {
        display: block;
        overflow: auto;
        width: 100%;
        height: 250px;
    } */





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


    #contenedor {
        margin: 5px;
        position: relative;
        justify-content: center;
        width: 540px;
        height: 80px;
    }

    .reloj {
        float: left;
        font-size: 15px;
        font-family: Courier, sans-serif;
        color: #363431;
    }


    @import url("https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900");


    .contentenedor {
        position: relative;
        margin: 0 auto;
        margin-bottom: 40px;
        margin-top: 40px;

    }

    .contentenedor h2 {
        color: #fff;
        font-size: 4em;
        position: absolute;
        transform: translate(-50%, -50%);
    }

    .contentenedor h2:nth-child(1) {
        color: transparent;
        -webkit-text-stroke: 2px #03a9f4;
    }

    .contentenedor h2:nth-child(2) {
        color: #03a9f4;
        animation: animate 4s ease-in-out infinite;
    }

    @keyframes animate {

        0%,
        100% {
            clip-path: polygon(0% 45%,
                    16% 44%,
                    33% 50%,
                    54% 60%,
                    70% 61%,
                    84% 59%,
                    100% 52%,
                    100% 100%,
                    0% 100%);
        }

        50% {
            clip-path: polygon(0% 60%,
                    15% 65%,
                    34% 66%,
                    51% 62%,
                    67% 50%,
                    84% 45%,
                    100% 46%,
                    100% 100%,
                    0% 100%);
        }
    }
</style>

<div class="container-fluid p-0">
    <!-- <div id="contenedor">
		<div class="reloj" id="Horas">00</div>
		<div class="reloj" id="Minutos">:00</div>
		<div class="reloj" id="Segundos">:00</div>
		<div class="reloj" id="Centesimas">:00</div>
	</div> -->

    <div class="row">
        <h1 id="Nombmaq" class="text-center fw-bold fs-1" style="color:#07B5E8"><?php echo $_SESSION["u_clientes"]; ?></h1>
    </div>

    <div class="d-flex bd-highlight p-0 text-white" style="background-color: #07B5E8;">
        <div class="my-2 mx-2 flex-grow-1 bd-highlight">Maquinas</div>
        <ol class="my-2 mx-2 breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashclientes">Inicio</a></li>
            <li class="breadcrumb-item active">Maquinas</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">

                <div id="loader" class="loader"></div>

                <div class="card-body">
                    <input type="hidden" class="form-control" id="txtpkmaq" name="txtpkmaq" required value="<?php echo $_SESSION['pk']; ?>" readonly>
                    <div class="table-responsive">
                        <table class="table table-bordered border-info table-sm" id="tablamaq">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">Nombre</th>
                                    <th scope="col" class="text-center">Descripción</th>
                                    <th scope="col" class="text-center" style='display:none;'>fk_cliente_lersoft</th>
                                    <th scope="col" class="text-center" style='display:none;'>pk</th>
                                    <th scope="col" class="text-center" style='display:none;'>Tipo</th>
                                    <th scope="col" class="text-center">Ajustes y Partes</th>

                                </tr>
                            </thead>
                            <tbody id="DataPedidosMaq">
                            </tbody>
                        </table>
                    </div>
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

<div class="modal fade" id="ModalMaq" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                            <caption class="text-center"> <strong>DATOS GENERALES</strong></caption>
                            <table class="table table-bordered table-sm" id="tablaDatosmaq">
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
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="ModalRep" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-white">Modal Heading</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="card">
                <div class="card-body">
                    <form class="row g-3 text-center">
                        <div class="row mt-3">
                            
                                <input type="hidden" id="txtId" name="txtId">
                                <input type="hidden" id="txtNombre" name="txtNombre">
                                <input type="hidden" id="txtFcambio" name="txtFcambio">
                                <input type="hidden" id="txtPod" name="txtPod">
                                <input type="hidden" id="txtTipo" name="txtTipo">
                                <input type="hidden" id="txtTipomanto" name="txtTipomanto">
                                <input type="hidden" id="txtProcesador" name="txtProcesador">
                                <input type="hidden" id="txtOperacion" name="txtOperacion">
                                <input type="hidden" id="pkuser" name="pkuser" value="<?php echo $_SESSION['usuario']; ?>">
                           
                                <div class="col-md-12 mb-3 text-center">
                                     <label for="txtFecha" class="form-label">Fecha De Modificación</label>
                                    <input type="datetime-local" class="form-control" id="txtFecha" name="txtFecha" />

                                </div>
                                <div class="d-flex justify-content-center  mb-3">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-info" onclick="miFunc()">Actualizar Información</button>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="ModalReportedia" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="contentenedor" id='contentenedores'>
                <h2>Generando Reporte</h2>
                <h2>Generando Reporte</h2>
            </div>

            <div class="modal-body">

                <div class="row mb-3">
                    <div class="table-responsive">
                        <table class="table table-bordered border-info table-sm" id="tabladatos">
                            <thead>
                                <tr>
                                    <!-- <th scope="col" class="text-center"></th>
                                <th scope="col" class="text-center"></th> -->
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-xl-6 col-xxl-6 d-flex">
                        <div class="card flex-fill w-100">
                            <div class="card-header">

                                <h5 class="card-title mb-0">Horas Activas Del Día</h5>
                            </div>
                            <div class="card-body py-3">
                                <div class="table-responsive">
                                    <table class="table table-bordered border-info table-sm" id="tablapot">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">Pot</th>
                                                <th scope="col" class="text-center">Promedio</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-xxl-6">


                        <div class="row">
                            <div class="card flex-fill w-100">
                                <div class="card-header">

                                    <h5 class="card-title mb-0">Produccion Del Día</h5>
                                </div>
                                <div class="card-body py-3">
                                    <div class="table-responsive">
                                        <table class="table table-bordered border-info table-sm" id="tablaprod">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center">Turno</th>
                                                    <th scope="col" class="text-center">Vagones</th>
                                                    <th scope="col" class="text-center">Horas Totales</th>
                                                    <th scope="col" class="text-center">Vagones Por Hora</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="card flex-fill w-100">
                                <div class="card-header">

                                    <h5 class="card-title mb-0">Valores Diarios</h5>
                                </div>
                                <div class="card-body py-3">
                                    <div class="table-responsive">
                                        <table class="table table-bordered border-info table-sm" id="tabladiario">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center">Dato</th>
                                                    <th scope="col" class="text-center">Promedio</th>
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
                </div>

                <div class="row mb-3">

                    <div class="col-xl-12 col-xxl-12">
                        <div class="card flex-fill w-100">
                            <div class="card-header">

                                <h5 class="card-title mb-0">Uso de Cabina</h5>
                            </div>
                            <div class="card-body py-3">
                                <div class="table-responsive">
                                    <table class="table table-bordered border-info table-sm" id="tablacabina">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">Turno</th>
                                                <th scope="col" class="text-center">Inicio</th>
                                                <th scope="col" class="text-center">Fin</th>
                                                <th scope="col" class="text-center">Tiempo de uso de cabina</th>
                                                <th scope="col" class="text-center">Tiempo de chorreo</th>
                                                <th scope="col" class="text-center">Tiempo perdido</th>
                                                <th scope="col" class="text-center">Tiempo total</th>
                                                <th scope="col" class="text-center">Tiempo inactivo</th>
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

                <div class="row mb-3">
                    <div class="col-xl-6 col-xxl-6 d-flex">

                        <div class="card flex-fill w-100">
                            <div class="card-header">

                                <h5 class="card-title mb-0">Activación de Pots</h5>
                            </div>
                            <div class="card-body py-3">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>


                    <div class="col-xl-6 col-xxl-6 d-flex">

                        <div class="card flex-fill w-100">
                            <div class="card-header">

                                <h5 class="card-title mb-0">Lecturas de presion y Nivel de granalla en silo</h5>
                            </div>
                            <div class="card-body py-3">
                                <canvas id="myChartlecturas"></canvas>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row mb-3">
                    <div class="col-xl-6 col-xxl-6 d-flex">

                        <div class="card flex-fill w-100 text-black">
                            <div class="card-header">

                                <h5 class="card-title mb-0">Tiempo Productivo</h5>
                            </div>
                            <div class="card-body py-3">
                                <canvas id="myChartdona"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-xxl-6 d-flex">

                        <div class="card flex-fill w-100 text-black">
                            <div class="card-header">

                                <h5 class="card-title mb-0"></h5>
                            </div>
                            <div class="card-body py-3">

                            </div>
                        </div>
                    </div>



                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnEnviar">Descargar PDF <img src="vistas/recursos/img/pdfrojo.png" height="40" width="40" /></button>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalRepbatch" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="contentenedor" id='contentenedores'>
                <h2>Generando Reporte</h2>
                <h2>Generando Reporte</h2>
            </div>

            <div class="modal-body">
                <div class="row mb-3">
                    <div class="table-responsive">
                        <table class="table table-bordered border-info table-sm" id="tabladatosbatch">
                            <thead>
                                <tr></tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-xl-6 col-xxl-6 d-flex">
                        <div class="card flex-fill w-100">
                            <div class="card-header">

                                <h5 class="card-title mb-0"></h5>
                            </div>
                            <div class="card-body py-3">
                                <div class="table-responsive">
                                    <table class="table table-bordered border-info table-sm" id="tablamaquina">
                                        <thead>
                                            <tr></tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-xxl-6">
                        <div class="row">
                            <div class="card flex-fill w-100">
                                <div class="card-header">

                                    <h5 class="card-title mb-0"></h5>
                                </div>
                                <div class="card-body py-3">
                                    <div class="table-responsive">
                                        <table class="table table-bordered border-info table-sm" id="tablaresoper">
                                            <thead>
                                                <tr></tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="card flex-fill w-100">
                                <div class="card-header">

                                    <h5 class="card-title mb-0">Valores Diarios</h5>
                                </div>
                                <div class="card-body py-3">
                                    <div class="table-responsive">
                                        <table class="table table-bordered border-info table-sm" id="tabladiario">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center">Dato</th>
                                                    <th scope="col" class="text-center">Promedio</th>
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
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnEnviar">Descargar PDF <img src="vistas/recursos/img/pdfrojo.png" height="40" width="40" /></button>

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="Modalpdf" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Reporte De Compras</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="reportepdf"></div>
            </div>
        </div>
    </div>
</div>

<div id="ModalOrden" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="text-align: center;">
                <h4 class="modal-title">ORDEN DE SERVICIO</h4>
            </div>
            <div class="modal-body">
                <div id="reporteOden"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-lg" id="cerrarorden">Cerrar</button>
            </div>
        </div>
    </div>
</div>



<!-- <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalToggleLabel">Modal 1</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Muestra un segundo modal y oculta este con el botón de abajo.
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Abrir segundo modal</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalToggleLabel2">Modal 2</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Oculta este modal y muestra el primero con el botón de abajo.
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Volver al primero</button>
      </div>
    </div>
  </div>
</div> -->


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.es.min.js" integrity="sha512-3chOMtjYaSa9m2bCC8qGxmEcX449u63D1fMXMQdueS3/XgE12iHQdmZVXVVbhBLc9i7h9WUuuM15B0CCE6Jtvg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="vistas/js/inplanttv.js"></script>




<script>
    /* menu */

    document.getElementById('menuinplanttv').classList.toggle('active');
    document.getElementById('menu_inplanttv_item').classList.remove('hide_menu');
    
   


   
    
   
    document.getElementById('maqclientes_menu').classList.remove('active');
    document.getElementById('reportevagones_menu').classList.remove('active');
    document.getElementById('proyectos_menu').classList.remove('active');
    document.getElementById('vagones_menu').classList.remove('active');
    document.getElementById('supervisores_menu').classList.remove('active');
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

