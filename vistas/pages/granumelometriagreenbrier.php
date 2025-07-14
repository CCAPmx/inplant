<link rel="stylesheet" href="vistas/recursos/css/visitastecnicas.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>


<style>
    /* Ocultar flechas en inputs de tipo number */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

    .input-invalido {
        background-color: rgba(255, 165, 0, 0.3) !important;
        /* Naranja pálido */
        border: 1px solid #ffa500;
    }
</style>

<div class="container-fluid">

    <div class="d-flex bd-highlight p-0 text-white" style="background-color: #07B5E8;">
        <div class="my-2 mx-2 flex-grow-1 bd-highlight">Granulometría Greenbrier</div>
        <!-- <?php
                echo $_SESSION["ccap"];
                // echo $_SESSION["lersant"];

                ?> -->
        <ol class="my-2 mx-2 breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashclientes">Inicio</a></li>
            <li class="breadcrumb-item active">Granulometría Greenbrier</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="d-flex justify-content-end">
                    <div class="btn-group  my-3 mx-2" role="group" aria-label="Basic example">
                    </div>
                </div>
                <div id="loader" class="loader"></div>



                <div class="card-body">
                    <!-- <button id="btnValidarSecion" class="btn btn-outline-info btn-sm mx-3" onclick="validarSesion()"> validar sesion</button> -->
                    <div class="d-flex justify-content-end">
                        <div class="btn-group  my-3 mx-2" role="group" aria-label="Basic example">
                            <button id="btnNuevaGranulometria" class="btn btn-outline-info btn-sm mx-3" data-bs-toggle="modal" data-bs-target="#modalGranulometriaGreenbrier"> <i class="fas fa-plus-circle"></i> Nueva Granulometría </button>
                           
                        </div>
                    </div>



                    <div class=" container" id="contenedor_granulometria">
                        <div class="col">
                            <table id="granulometriaTable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Mas informacion</th>
                                        <th>Fecha</th>
                                        <th>Usuario</th>
                                        <th>Nombre Maquina</th>
                                        <th>Nombre Cliente</th>
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

<div class="modal fade" id="modalGranulometriaGreenbrier" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" data-bs-target="#modalGranulometriaGreenbrier" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="color:black;">


                <h4 class="modal-title">Granulometría Greenbrier</h4>
                <div class="modal-subtitle w-100 row mt-2 info_granulometria_header" id="info_granulometria_header" style="display: none;">

                    <div class="col-md-3">
                        <strong>Fecha: </strong> <span id="fecha_nueva_granulometria"></span>
                    </div>

                    <div class="col-md-3">
                        <strong>Maquina: </strong> <span id="maquina_nueva_granulometria"></span>
                    </div>

                    <div class="col-md-3">
                        <strong>Cliente: </strong><span id="cliente_nueva_granulometria"></span>
                    </div>

                    <div class="col-md-3">
                        <strong>Nombre Usuario: </strong> <span id="usuario_nueva_granulometria"><?php echo $_SESSION['nombre']; ?></span>
                    </div>


                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <form id="FrmVisitas" class="row g-2" role="form" method="post" autocomplete="off">
                <div class="modal-body">

                    <div class="row">
                        <div class="container">
                            <div class="col-md-4">
                                <input type="" hidden class="form-control" id="txtPkempresa_v1" name="txtPkempresa_v1" required value="" readonly>

                            </div>
                            <div class="row contenedor_form_granulometria_nueva">



                                <!-- <div class="form-group col-md-4"> -->
                                <!-- <label for="cbmCliente" class="form-label">Clientes</label> -->
                                <select class="form-control select2 select2-purple" data-dropdown-css-class="select2-purple" style="width: 100%;" id="cbmClienteGranulometria" name="cbmClienteGranulometria" hidden></select>
                                <!-- </div> -->




                                <div class="col-md-6">

                                    <style>
                                        #loader_m {
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                        }
                                    </style>

                                    <div id="loader_m" style="display:none; text-align: center;">
                                        <div class="spinner-border text-primary" role="status"></div>
                                        <span style="display: inline-block; margin-left: 10px;">Cargando...</span>
                                    </div>

                                    <label for="cbmmaquina" class="form-label">Maquina</label>
                                    <select class="form-control select2 select2-purple" data-dropdown-css-class="select2-purple" style="width: 100%;" id="cbmmaquinaGranulometria" name="cbmmaquinaGranulometria">
                                    </select>
                                </div>


                                <div class="col-md-6">
                                    <label for="cbmmaquina" class="form-label">Fecha</label>
                                    <input type="date" class="form-control" id="txtFechaGranulometria" name="txtFechaGranulometria" onchange="" value="<?php echo date('Y-m-d'); ?>">
                                </div>

                            </div>

                            <div class="row contenedor_form_granulometria" style="display: none;">



                                <div class="row">
                                    <div id="mensaje_granulometria" class=" text-center col-12" style="display: none; color: red; font-size: 16px;font-weight: bold;"></div>
                                    <h4 class="mb-3">Granulometría</h4>
                                    <div class="col-12 row p-2">

                                        <div class="col-md-2 d-flex align-items-center">
                                            <label for="polvo" class="mr-2 p-1"> <strong>Polvo</strong> </label>
                                            <input type="number" name="polvo" id="polvo" class="form-control" required>
                                        </div>

                                        <div class="col-md-2 d-flex align-items-center">
                                            <label for="c_05" class="mr-2 p-1"><strong>c_05</strong></label>
                                            <input type="number" name="c_05" id="c_05" class="form-control" required>
                                        </div>

                                        <div class="col-md-2 d-flex align-items-center">
                                            <label for="c_09" class="mr-2 p-1"><strong>c_09</strong> </label>
                                            <input type="number" name="c_09" id="c_09" class="form-control" required>
                                        </div>

                                        <div class="col-md-2 d-flex align-items-center">
                                            <label for="c_150" class="mr-2 p-1"><strong> c_150</strong></label>
                                            <input type="number" name="c_150" id="c_150" class="form-control" required>
                                        </div>

                                        <div class="col-md-2 d-flex align-items-center">
                                            <label for="c_212" class="mr-2 p-1"><strong>c_212</strong></label>
                                            <input type="number" name="c_212" id="c_212" class="form-control" required>
                                        </div>

                                        <div class="col-md-2 d-flex align-items-center">
                                            <label for="c_300" class="mr-2 p-1"><strong>c_300</strong></label>
                                            <input type="number" name="c_300" id="c_300" class="form-control" required>
                                        </div>

                                    </div>

                                    <div class="col-12 row p-2">
                                        <div class="col-md-2 d-flex align-items-center">
                                            <label for="c_425" class="mr-2 p-1"><strong>c_425</strong></label>
                                            <input type="number" name="c_425" id="c_425" class="form-control" required>
                                        </div>

                                        <div class="col-md-2 d-flex align-items-center">
                                            <label for="c_600" class="mr-2 p-1"><strong>c_600</strong></label>
                                            <input type="number" name="c_600" id="c_600" class="form-control" required>
                                        </div>

                                        <div class="col-md-2 d-flex align-items-center">
                                            <label for="c_850" class="mr-2 p-1"><strong>c_850</strong></label>
                                            <input type="number" name="c_850" id="c_850" class="form-control" required>
                                        </div>

                                        <div class="col-md-2 d-flex align-items-center">
                                            <label for="c_1180" class="mr-2 p-1"><strong>c_1180</strong></label>
                                            <input type="number" name="c_1180" id="c_1180" class="form-control" required>
                                        </div>

                                        <div class="col-md-2 d-flex align-items-center">
                                            <label for="c_1400" class="mr-2 p-1"><strong>c_1400</strong></label>
                                            <input type="number" name="c_1400" id="c_1400" class="form-control" required>
                                        </div>

                                        <div class="col-md-2 d-flex align-items-center">
                                            <label for="c_1700" class="mr-2 p-1"><strong>c_1700</strong></label>
                                            <input type="number" name="c_1700" id="c_1700" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-12 row p-2">
                                        <div class="col-md-2 d-flex align-items-center">
                                            <label for="c_2200" class="mr-2 p-1"><strong>c_2200</strong></label>
                                            <input type="number" name="c_2200" id="c_2200" class="form-control" required>
                                        </div>
                                    </div>



                                </div>

                                <div class="row conteneror_rugosidad" style="display: none;">
                                    <div class="col-12 ">
                                        <hr> <!-- Rugosidad -->
                                    </div>
                                    <div class="col-12 row center">
                                        <!-- Rugosidad -->
                                        <h4 class="mb-3">Rugosidad</h4>
                                    </div>


                                    <div class="col-12 row g-2 justify-content-center  " style="    position: relative;
    left: -87px;">



                                        <div class="col-3 d-flex justify-content-end">
                                            <!-- Rugosidad -->
                                            <style>
                                                .tam_input_rugosidad {
                                                    max-width: 80px;
                                                    margin: 0 auto;
                                                    text-align: center;
                                                }
                                            </style>

                                            <div class="row flex-column g-2 justify-content-center">
                                                <div class="col-md-12 d-flex  align-items-center">
                                                    <label for="rig_01" class="me-2"><strong>01</strong></label>
                                                    <input type="number" name="rig_01" id="rig_01" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>

                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="rig_02" class="me-2"><strong>02</strong></label>
                                                    <input type="number" name="rig_02" id="rig_02" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>

                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="rig_03" class="me-2"><strong>03</strong></label>
                                                    <input type="number" name="rig_03" id="rig_03" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>

                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="rig_04" class="me-2"><strong>04</strong></label>
                                                    <input type="number" name="rig_04" id="rig_04" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>

                                                <div class="col-md-12 d-flex  align-items-center">
                                                    <label for="rig_05" class="me-2"><strong>05</strong></label>
                                                    <input type="number" name="rig_05" id="rig_05" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="col-3 d-flex justify-content-end">
                                            <!-- Rugosidad -->
                                            <div class="row flex-column g-2 justify-content-center">
                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="rig_06" class="me-2"><strong>06</strong></label>
                                                    <input type="number" name="rig_06" id="rig_06" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>

                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="rig_07" class="me-2"><strong>07</strong></label>
                                                    <input type="number" name="rig_07" id="rig_07" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>

                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="rig_08" class="me-2"><strong>08</strong></label>
                                                    <input type="number" name="rig_08" id="rig_08" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>
                                                <div class="col-md-12 d-flex  align-items-center">
                                                    <label for="rig_09" class="me-2"><strong>09</strong></label>
                                                    <input type="number" name="rig_09" id="rig_09" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>
                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="rig_10" class="me-2"><strong>10</strong></label>
                                                    <input type="number" name="rig_10" id="rig_10" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3 d-flex justify-content-end">
                                            <!-- Rugosidad -->
                                            <div class="row flex-column g-2 justify-content-center">
                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="rig_11" class="me-2"><strong>11</strong></label>
                                                    <input type="number" name="rig_11" id="rig_11" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>

                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="rig_12" class="me-2"><strong>12</strong></label>
                                                    <input type="number" name="rig_12" id="rig_12" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>

                                                <div class="col-md-12 d-flex  align-items-center">
                                                    <label for="rig_13" class="me-2"><strong>13</strong></label>
                                                    <input type="number" name="rig_13" id="rig_13" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>

                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="rig_14" class="me-2"><strong>14</strong></label>
                                                    <input type="number" name="rig_10" id="rig_14" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>

                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="rig_15" class="me-2"><strong>15</strong></label>
                                                    <input type="number" name="rig_15" id="rig_15" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-3 d-flex justify-content-end">
                                            <!-- Rugosidad -->
                                            <div class="row flex-column g-2 justify-content-center">
                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="rig_16" class="me-2"><strong>16</strong></label>
                                                    <input type="number" name="rig_16" id="rig_16" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>

                                                <div class="col-md-12 d-flex  align-items-center">
                                                    <label for="rig_17" class="me-2"><strong>17</strong></label>
                                                    <input type="number" name="rig_17" id="rig_17" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>


                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="rig_18" class="me-2"><strong>18</strong></label>
                                                    <input type="number" name="rig_18" id="rig_18" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>

                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="rig_19" class="me-2"><strong>19</strong></label>
                                                    <input type="number" name="rig_19" id="rig_19" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>

                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="rig_20" class="me-2"><strong>20</strong></label>
                                                    <input type="number" name="rig_20" id="rig_20" class="form-control rugosidad-input tam_input_rugosidad" required>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <div class="row contenedor_basura" style="display: none;">

                                    <div class="col-12 ">
                                        <hr> <!-- Rugosidad -->
                                    </div>


                                    <h4 class="mb-3">Basura</h4>


                                    <style>
                                        .label_with_text {
                                            width: 115px;
                                        }
                                    </style>





                                    <!-- Columna 1 -->
                                    <div class="col-4 text-center">
                                        <div class="row flex-column g-2">
                                            <div class="col-md-12">
                                                <label class="form-label"><strong>Norte der:</strong></label>
                                                <input type="radio" name="norte_der" value="0" checked required> 0
                                                <input type="radio" name="norte_der" value="1"> 1
                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label"><strong>Norte izq:</strong></label>
                                                <input type="radio" name="norte_izq" value="0" checked required> 0
                                                <input type="radio" name="norte_izq" value="1"> 1
                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label"><strong>Norte afuera:</strong></label>
                                                <input type="radio" name="norte_afuera" value="0" checked required> 0
                                                <input type="radio" name="norte_afuera" value="1"> 1
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Columna 2 -->
                                    <div class="col-4 text-center">
                                        <div class="row flex-column g-2">
                                            <div class="col-md-12">
                                                <label class="form-label"><strong>Centro der:</strong></label>
                                                <input type="radio" name="centro_der" value="0" checked required> 0
                                                <input type="radio" name="centro_der" value="1"> 1
                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label"><strong>Centro izq:</strong></label>
                                                <input type="radio" name="centro_izq" value="0" checked required> 0
                                                <input type="radio" name="centro_izq" value="1"> 1
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Columna 3 -->
                                    <div class="col-4 text-center">
                                        <div class="row flex-column g-2">
                                            <div class="col-md-12">
                                                <label class="form-label"><strong>Sur der:</strong></label>
                                                <input type="radio" name="sur_der" value="0" checked required> 0
                                                <input type="radio" name="sur_der" value="1"> 1
                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label"><strong>Sur izq:</strong></label>
                                                <input type="radio" name="sur_izq" value="0" checked required> 0
                                                <input type="radio" name="sur_izq" value="1"> 1
                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label"><strong>Sur afuera:</strong></label>
                                                <input type="radio" name="sur_afuera" value="0" checked required> 0
                                                <input type="radio" name="sur_afuera" value="1"> 1
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <br>
                                    <br>
                                    <br>



                                    <div class="row contenedor_imagenes mt-4">



                                        <div class="col-6  d-flex align-items-center">
                                            <div class="row flex-column g-2 justify-content-center text-center">

                                                <div class="mt-2 text-center imgPreview01">
                                                    <img id="imgPreview01" src="vistas/recursos/img/avatars/image-not-found.jpg" class="rounded mx-auto d-block " src="" alt="Vista previa imagen 1" class="img-fluid rounded border" style="max-height: 200px; width: 200;">
                                                </div>
                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="basura_img01" class="me-2 label_with_text" style="width: 200px;"><strong>Selecciona una imagen 1</strong></label>
                                                    <input type="file" name="basura_img01" id="basura_img01" class="form-control" required accept="image/jpeg, image/png, image/jpg">
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-6  d-flex align-items-center">
                                            <div class="row flex-column g-2 justify-content-center  text-center">

                                                <div class=" mt-2 text-center imgPreview02">
                                                    <img id="imgPreview02" src="vistas/recursos/img/avatars/image-not-found.jpg" class="rounded mx-auto d-block " src="" alt="Vista previa imagen 2" class="img-fluid rounded border" style="max-height: 200px; width: 200px;">
                                                </div>
                                                <div class="col-md-12 d-flex align-items-center">
                                                    <label for="basura_img02" class="me-2 label_with_text" style="width: 200px;"><strong>Selecciona una imagen 2</strong></label>
                                                    <input type="file" src="vistas/recursos/img/avatars/image-not-found.jpg" name="basura_img02" id="basura_img02" class="form-control" accept="image/jpeg, image/png, image/jpg" required>
                                                </div>

                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <strong> <small class="" style=" font-size: 12px;">*** puedes subir fotos opcionales, max 500 kB</small>
                                            </strong>
                                        </div>
                                    </div>





                                </div>



                                <div class="row contener_silo" style="display: none;">

                                    <div class="col-12 ">
                                        <hr> <!-- Rugosidad -->
                                    </div>


                                    <h4 class="mb-3">Silo </h4>


                                    <div class="col-6 text-center">
                                        <div class="row flex-column g-2 justify-content-center">
                                            <div class="col-md-12 d-flex  align-items-center">
                                                <label for="vacio_silo_2" class="me-2 label_with_text"><strong>Vacio Silo 2</strong></label>
                                                <input
                                                    type="number"
                                                    name="vacio_silo_2"
                                                    id="vacio_silo_2"
                                                    class="form-control"
                                                    required
                                                    style="width: 100px;"> <strong class="ms-2">CM</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6 text-center">
                                        <div class="row flex-column g-2 justify-content-center">
                                            <div class="col-md-12 d-flex align-items-center">
                                                <label for="vacio_silo_1" class="me-2 label_with_text"><strong>Vacio Silo 1</strong></label>
                                                <input
                                                    type="number"
                                                    name="vacio_silo_1"
                                                    id="vacio_silo_1"
                                                    class="form-control"
                                                    style="width: 100px;"
                                                    required>
                                                <strong class="ms-2">CM</strong>
                                            </div>


                                        </div>
                                    </div>
                                </div>



                                <div class="row contenedor_recargas_granalla ">
                                    <div class="col-12">
                                        <hr> <!-- Rugosidad -->
                                        <h4 class="mb-3">Recargas de Granalla
                                        </h4>
                                    </div>

                                    <style>
                                        #tablaHoy thead {
                                            display: none;
                                        }
                                    </style>

                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <div class="table-responsive d-flex justify-content-center">
                                                <table id="tablaHoy" class="" style="width: 80%;">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="3" class="bg-light text-dark" style="border: 2px solid #dee2e6;">

                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <!-- <th>ID</th> -->
                                                            <th>Fecha</th>
                                                            <th>Carga</th>
                                                            <th></th>
                                                            <!-- <th></th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="col-md-12 text-center">
                                            <!-- <h5 class="text-center">Registros Anteriores</h5> -->
                                            <div class="table-responsive d-flex justify-content-center">
                                                <table id="tablaAnteriores" class="table table-bordered table-striped text-center mx-auto" style="width: 80%;">
                                                    <thead>

                                                        <tr>
                                                            <th colspan="3" class="text-center">Recargas Anteriores</th>
                                                        </tr>
                                                        <tr>
                                                            <!-- <th>ID</th> -->
                                                            <th>Fecha</th>
                                                            <th>Carga</th>
                                                            <th></th>
                                                            <!-- <th></th> -->
                                                        </tr>


                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>



                        </div>

                    </div>
                </div>


            </form>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" id="btnSiguienteGranulometria" class="btn btn-primary btnSiguienteGranulometria">CONTINUAR</button>
                <button type="button" id="btnRegresarGranulometria" class="btn btn-primary btnRegresarGranulometria" style="display: none;">REGRESAR</button>
                <button type="button" id="btnGuardarGranulometria" class="btn btn-success btnGuardarGranulometria" style="display: none;">Guardar</button>
                <button type="button" id="btnGuardarCambiosGranulometria" class="btn btn-success btnGuardarCambiosGranulometria" style="display: none;">Guardar Cambios</button>
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">CANCELAR</button>
            </div>


        </div>
    </div>
</div>






<!-- MODAL DINAMICO -->

<!-- Modal para mostrar la información de la fila -->
<div class="modal fade" id="infoEdicionReporteGreenbrier" tabindex="-1" aria-labelledby="infoEdicionReporteGreenbrierLabel" data-bs-target="#infoEdicionReporteGreenbrier" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoEdicionReporteGreenbrierLabel">Edición de granulometría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="modalContent">



            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal" id="btnGranulometriaEdicion">Guardar</button>
        </div>
    </div>
</div>
</div>





<script src="vistas/js/greenbrierRer.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.4.1/purify.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
<script src="vistas/recursos/compressor/compressor.min.js"></script>

<script>
    document.querySelectorAll(".basura-input").forEach(input => {
        input.setAttribute("min", "0");
        input.setAttribute("max", "1");
        input.setAttribute("step", "1");

        input.addEventListener("input", function() {
            const value = this.value;
            // Si no es 0 o 1, borra el contenido
            if (value !== "0" && value !== "1") {
                this.value = "";
            }
        });
    });


    document.querySelectorAll(".rugosidad-input").forEach(input => {

        input.setAttribute('step', '0.1');
        // input.setAttribute('min', '1.0');
        input.setAttribute('max', '3.0');
        input.addEventListener("input", function() {


            let value = this.value;

            // Permite solo números con un decimal
            if (!/^\d+(\.\d{0,1})?$/.test(value)) {
                this.value = value.slice(0, -1); // borra último caracter inválido
            }

            // Elimina el valor si está fuera del rango permitido
            const num = parseFloat(this.value);
            if (num < 1.0 || num > 3.0) {
                this.value = '';
            }
        });
    });
    var datosSesion = <?php echo json_encode($_SESSION['nombre']); ?>;
    $(document).ready(function() {
        table = $('#granulometriaTable').DataTable({
            "ajax": "controladores/granulometria.controlador.php?action=dataGranulometriaGreenbrier", // URL del script PHP que retorna el JSON
            "columns": [

                {
                    "data": null,
                    "orderable": false,
                    "className": "text-center",
                    "render": function(data, type, row) {
                        // console.log(data);
                        var jsonStr = encodeURIComponent(JSON.stringify(data));
                        // Se devuelve el icono que, al hacer clic, abrirá el modal
                        return '<i class="fas fa-info-circle" style="color:#07B5E8;  cursor:pointer;" title="Más información" onclick="granulometriaGreenbrierInfo(\'' + jsonStr + '\')"></i>';

                        // return '<button id="btnNuevaGranulometriaEditar" class="btn btn-outline-info btn-sm mx-3" data-bs-toggle="modal" data-bs-target="#infoEdicionReporteGreenbrier"> <i class="fas fa-plus-circle"></i> editar Granulometría </button>'
                    }
                },
                {
                    data: "fecha",
                    width: "100px",
                    render: function(data, type, row) {
                        if (!data) return "";

                        const fecha = new Date(data);
                        const dia = String(fecha.getDate()).padStart(2, '0');
                        const mes = String(fecha.getMonth() + 1).padStart(2, '0');
                        const año = fecha.getFullYear();

                        return `${dia}/${mes}/${año}`;
                    }
                },
                {
                    "data": "usuario"
                },
                {
                    "data": "nombre_maquina"
                },
                {
                    "data": "cliente"
                }
            ],
            language: {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sSearch": "Buscar:",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                }
            },
            pageLength: 10,
            ordering: true,
            "order": [
                [0, "desc"]
            ]
        });
    });

    function granulometriaGreenbrierInfo(jsonStr) {
        var data = JSON.parse(decodeURIComponent(jsonStr));
        console.log(data);

        const dataEdicion = data; // Guardar los datos para la edición

        // Mostrar el modal correcto
        const modal = new bootstrap.Modal(document.getElementById('modalGranulometriaGreenbrier'));
        modal.show();




        $('.contenedor_form_granulometria_nueva').hide();
        $('.contenedor_form_granulometria').show();
        $('.conteneror_rugosidad').show();
        $('.contenedor_basura').show();
        $('.contener_silo').show();
        $('.info_granulometria_header').show();

        $(".modal-title").hide();
        // $(".info_granulometria_header").hide();

        $('.btnGuardarCambiosGranulometria').show();
        // $('.btnGuardarGranulometria').hiden();
        $('.btnSiguienteGranulometria').hide();

        // Llenar los campos del modal
        $('#fecha_nueva_granulometria').text(data.fecha);
        $('#maquina_nueva_granulometria').text(data.nombre_maquina);
        $('#cliente_nueva_granulometria').text(data.cliente);
        // document.getElementById('usuario_nueva_granulometria_edicion').textContent = data.usuario;

        $('#cbmmaquinaGranulometria').val(data.procesador_maq);

        const $form = $('#FrmVisitas');


        $form.find('[name="polvo"]').val(data.polvo);
        $form.find('[name="c_05"]').val(data.c_05);
        $form.find('[name="c_09"]').val(data.c_09);
        $form.find('[name="c_150"]').val(data.c_150);
        $form.find('[name="c_212"]').val(data.c_212);
        $form.find('[name="c_300"]').val(data.c_300);
        $form.find('[name="c_425"]').val(data.c_425);
        $form.find('[name="c_600"]').val(data.c_600);
        $form.find('[name="c_850"]').val(data.c_850);
        $form.find('[name="c_1180"]').val(data.c_1180);
        $form.find('[name="c_1400"]').val(data.c_1400);
        $form.find('[name="c_1700"]').val(data.c_1700);
        $form.find('[name="c_2200"]').val(data.c_2200);
        $form.find('[name="rig_01"]').val(data.rug01);
        $form.find('[name="rig_02"]').val(data.rug02);
        $form.find('[name="rig_03"]').val(data.rug03);
        $form.find('[name="rig_04"]').val(data.rug04);
        $form.find('[name="rig_05"]').val(data.rug05);
        $form.find('[name="rig_06"]').val(data.rug06);
        $form.find('[name="rig_07"]').val(data.rug07);
        $form.find('[name="rig_08"]').val(data.rug08);
        $form.find('[name="rig_09"]').val(data.rug09);
        $form.find('[name="rig_10"]').val(data.rug10);
        $form.find('[name="rig_11"]').val(data.rug11);
        $form.find('[name="rig_12"]').val(data.rug12);
        $form.find('[name="rig_13"]').val(data.rug13);
        $form.find('[name="rig_14"]').val(data.rug14);
        $form.find('[name="rig_15"]').val(data.rug15);
        $form.find('[name="rig_16"]').val(data.rug16);
        $form.find('[name="rig_17"]').val(data.rug17);
        $form.find('[name="rig_18"]').val(data.rug18);
        $form.find('[name="rig_19"]').val(data.rug19);
        $form.find('[name="rig_20"]').val(data.rug20);




        $form.find('[name="norte_der"][value="' + data.basura_N_der + '"]').prop('checked', true);
        $form.find('[name="norte_izq"][value="' + data.basura_N_izq + '"]').prop('checked', true);
        $form.find('[name="norte_afuera"][value="' + data.basura_F_n + '"]').prop('checked', true);
        $form.find('[name="centro_der"][value="' + data.basura_C_der + '"]').prop('checked', true);
        $form.find('[name="centro_izq"][value="' + data.basura_C_izq + '"]').prop('checked', true);
        $form.find('[name="sur_der"][value="' + data.basura_S_der + '"]').prop('checked', true);
        $form.find('[name="sur_izq"][value="' + data.basura_S_izq + '"]').prop('checked', true);
        $form.find('[name="sur_afuera"][value="' + data.basura_F_s + '"]').prop('checked', true);


        $form.find('[name="vacio_silo_1"]').val(data.vacio_silo_01);
        $form.find('[name="vacio_silo_2"]').val(data.vacio_silo_02);


        let dataFk = {
            id: data.id,
            fkCliente: data.fkCliente,
            fkMaquina: data.fkMaquina,
            maquinaNombre: data.nombre_maquina,
            procesador_maq: data.procesador,
            fecha: data.fecha,

        }

        document.getElementById('btnGuardarCambiosGranulometria').value = JSON.stringify(dataFk);

        // $form.find('#btnGuardarCambiosGranulometria').val(JSON.stringify(dataFk));


        let maquina = data.procesador;
        datatableRecargasGranalla(maquina, 'edicion');

        const baseUrl = `${window.location.origin}/modelos/ver_imagen_granulometria.php`;

        let img01 = `${baseUrl}?id=${data.id}&campo=basura_img01&nocache=${new Date().getTime()}`;
        let img02 = `${baseUrl}?id=${data.id}&campo=basura_img02&nocache=${new Date().getTime()}`;

        // console.log(baseUrl, img01, img02);

        document.getElementById('imgPreview01').src = img01;
        document.getElementById('imgPreview02').src = img02;

        $('#imgPreview01').on('error', function() {
            console.error('Error cargando imagen 1');
        });

        $('#imgPreview02').on('error', function() {
            console.error('Error cargando imagen 2');
        });
    }
</script>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        function previewImage(inputId, previewId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);

            input.addEventListener('change', function() {
                const file = this.files[0];

                if (!file) return;

                const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                const isValid = validTypes.includes(file.type);

                if (!isValid) {
                    alert("Solo se permiten archivos de imagen (.jpg, .jpeg, .png)");
                    input.value = ''; // limpiar input
                    preview.src = ''; // limpiar preview
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            });
        }

        previewImage('basura_img01', 'imgPreview01');
        previewImage('basura_img02', 'imgPreview02');

    });
    
</script>