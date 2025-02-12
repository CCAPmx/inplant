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
</style>

<div class="container-fluid">

    <div class="d-flex bd-highlight p-0 text-white" style="background-color: #07B5E8;">
        <div class="my-2 mx-2 flex-grow-1 bd-highlight">granulometria</div>
        <!-- <?php
                echo $_SESSION["ccap"];
                // echo $_SESSION["lersant"];

                ?> -->
        <ol class="my-2 mx-2 breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashclientes">Inicio</a></li>
            <li class="breadcrumb-item active">granulometria</li>
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
                            <button id="btnNuevaGranulometria" class="btn btn-outline-info btn-sm mx-3" data-bs-toggle="modal" data-bs-target="#modalGranulometria"> <i class="fas fa-plus-circle"></i> Nueva granulometria</button>
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

<div class="modal fade" id="modalGranulometria" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" data-bs-target="#modalGranulometria" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="color:black;">
                <h4 class="modal-title ">Nueva granulometria</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <form id="FrmVisitas" class="row g-2" role="form" method="post" autocomplete="off">
                <div class="modal-body">
                    <div class="col-md-4">
                        <input type="" hidden class="form-control" id="txtPkempresa_v1" name="txtPkempresa_v1" required value="" readonly>

                    </div>
                    <div class="row contenedor_form_granulometria_nueva">



                        <div class="form-group col-md-4">
                            <label for="cbmCliente" class="form-label">Clientes</label>
                            <select class="form-control select2 select2-purple" data-dropdown-css-class="select2-purple" style="width: 100%;" id="cbmClienteGranulometria" name="cbmClienteGranulometria"></select>
                        </div>




                        <div class="col-md-4">
                            <!-- <div id="loader_m" style="display:none;">Cargando...</div> -->

                            <!-- <div id="loader_m" class="spinner-border text-primary" role="status" style="display:none;">
                                <span class="" style="display:block;">Cargando...</span>
                            </div> -->

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


                        <div class="col-md-4">
                            <label for="cbmmaquina" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="txtFechaGranulometria" name="txtFechaGranulometria" onchange="formatoFecha()">
                        </div>

                    </div>

                    <div class="row contenedor_form_granulometria" style="display: none;">

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

                        <div class="col-12">
                            <hr>
                        </div>

                        <div class="row">
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

                    </div>

                </div>
            </form>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" id="btnSiguienteGranulometria" class="btn btn-primary btnSiguienteGranulometria">CONTINUAR</button>
                <button type="button" id="btnRegresarGranulometria" class="btn btn-primary btnRegresarGranulometria" style="display: none;">REGRESAR</button>
                <button type="button" id="btnGuardarGranulometria" class="btn btn-success btnGuardarGranulometria" style="display: none;">Guardar</button>
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">CANCELAR</button>
            </div>


        </div>
    </div>
</div>


<!-- MODAL DINAMICO -->

<!-- Modal para mostrar la información de la fila -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">Edicion de granulometria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalContent">
                <div class="row contenedor_form_granulometria">

                    <div class="col-md-3">
                        <strong>Fecha: </strong> <span id="fecha_nueva_granulometria_edicio"></span>
                    </div>

                    <div class="col-md-3">
                        <strong>Maquina: </strong> <span id="maquina_nueva_granulometria_edicio"></span>
                    </div>

                    <div class="col-md-3">
                        <strong>Cliente: </strong><span id="cliente_nueva_granulometria_edicio"></span>
                    </div>

                    <div class="col-md-3">
                        <strong>Nombre Usuario: </strong> <span id="usuario_nueva_granulometria_edicion"><?php echo $_SESSION['nombre']; ?></span>
                    </div>

                    <div class="col-12">
                        <hr>
                    </div>

                    <form id="FrmGranulometriaEdicion" class="row g-2" role="form" method="post" autocomplete="off">

                        <input type="hidden" name="idGranulometria" id="idGranulometria" class="form-control">
                        <input type="hidden" name="procesado" id="procesador" class="form-control">

                        <div class="row">
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

                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="btnGranulometriaEdicion">Guardar</button>
            </div>
        </div>
    </div>
</div>





<script src="vistas/js/granulometria.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.4.1/purify.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
<script src="vistas/recursos/compressor/compressor.min.js"></script>

<script>
    var datosSesion = <?php echo json_encode($_SESSION['nombre']); ?>;
    $(document).ready(function() {
        table = $('#granulometriaTable').DataTable({
            "ajax": "controladores/granulometria.controlador.php?action=dataGranulometria", // URL del script PHP que retorna el JSON
            "columns": [{
                    "data": null,
                    "orderable": false,
                    "className": "text-center",
                    "render": function(data, type, row) {
                        // console.log(data);
                        var jsonStr = encodeURIComponent(JSON.stringify(data));
                        // Se devuelve el icono que, al hacer clic, abrirá el modal
                        return '<i class="fas fa-info-circle" style="color:#07B5E8;  cursor:pointer;" title="Más información" onclick="granulometriaInfo(\'' + jsonStr + '\')"></i>';
                    }
                },
                {
                    "data": "fecha"
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
            ordering: true
        });
    });

    function granulometriaInfo(jsonStr) {
        var data = JSON.parse(decodeURIComponent(jsonStr));
        console.log(data);

        document.getElementById('fecha_nueva_granulometria_edicio').innerHTML = data.fecha;
        document.getElementById('maquina_nueva_granulometria_edicio').innerHTML = data.nombre_maquina;
        document.getElementById('cliente_nueva_granulometria_edicio').innerHTML = data.cliente;
        // Si deseas actualizar el nombre de usuario (aunque ya viene del servidor en PHP, quizás no sea necesario)
        document.getElementById('usuario_nueva_granulometria_edicion').innerHTML = data.usuario;


        // Seleccionamos el formulario de edición
        var $form = $('#FrmGranulometriaEdicion');

        // Asignamos los valores a los campos correspondientes
        $form.find('input[name="polvo"]').val(data.polvo);
        $form.find('input[name="c_05"]').val(data.c_05);
        $form.find('input[name="c_09"]').val(data.c_09);
        $form.find('input[name="c_150"]').val(data.c_150);
        $form.find('input[name="c_212"]').val(data.c_212);
        $form.find('input[name="c_300"]').val(data.c_300);
        $form.find('input[name="c_425"]').val(data.c_425);
        $form.find('input[name="c_600"]').val(data.c_600);
        $form.find('input[name="c_850"]').val(data.c_850);
        $form.find('input[name="c_1180"]').val(data.c_1180);
        $form.find('input[name="c_1400"]').val(data.c_1400);
        $form.find('input[name="c_1700"]').val(data.c_1700);
        $form.find('input[name="c_2200"]').val(data.c_2200);
        $form.find('input[name="idGranulometria"]').val(data.id);
        $form.find('input[name="procesado"]').val(data.procesador);
        // Puedes agregar otros campos que necesites...

        $('#infoModal').modal('show');
    }
</script>