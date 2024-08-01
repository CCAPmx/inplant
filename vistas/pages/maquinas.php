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

    #tbMaquinas {
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
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
</style>

<div class="container-fluid p-0">
    <div class="d-flex bd-highlight p-0 text-white" style="background-color: #07B5E8;">
        <div class="my-2 mx-2 flex-grow-1 bd-highlight">Maquinas</div>
        <ol class="my-2 mx-2 breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Maquinas</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title">Catalogo de Maquinas</h5>
                    <!-- <button id="btnNuevousuario" type="button" class="btn btn-primary">
                        Agregar Maquinas
                    </button> -->

                    

                    <div class="d-flex justify-content-end">

                        <button type="button" class="btn btn-success mx-2" id="btnActualizarmaq">
                            Actualizar Información
                        </button>

                        <button type="button" class="btn btn-primary" id="btnNuevousuario">
                        Agregar Maquinas
                    </button>

                    </div>

                </div>

                <div id="loader" class="loader"></div>
                
                <div class="card-body caja">

                    <table id="tbMaquinas" class="table table-striped dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Maquina</th>
                                <th>Pk</th>
                                <th>Operaciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>

                    </table>

                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-white">Modal Heading</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <form id="Frmusuarios" class="row g-2" role="form" method="post" autocomplete="off">
                <div class="modal-body">
                    <div class="row">

                        <div class="form-group col-md-4">
                            <label for="txtNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="txtUsuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="txtUsuario" name="txtUsuario" placeholder="Usuario" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="txtContrasena" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="txtContrasena" name="txtContrasena" placeholder="Contraseña" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="cbmTipouser" class="form-label">Tipo Usuario</label>
                            <select class="form-control select2 select2-purple" data-dropdown-css-class="select2-purple" style="width: 100%;" id="cbmTipouser" name="cbmTipouser"></select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="cbmCliente" class="form-label">Clientes</label>
                            <select class="form-control select2 select2-purple" data-dropdown-css-class="select2-purple" style="width: 100%;" id="cbmCliente" name="cbmCliente"></select>
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label for="cbmNotificacion" class="form-label">Tipo Notificación</label>
                            <select class="form-control select2 select2-purple" data-dropdown-css-class="select2-purple" style="width: 100%;" id="cbmNotificacion" name="cbmNotificacion"></select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="txtMovil" class="form-label">Movil</label>
                            <input type="text" class="form-control" id="txtMovil" name="txtMovil" placeholder="Movil" required>
                        </div>

                        <div class="form-group col-md-2 my-3">
                            <div class="form-check my-3">
                            <input class="form-check-input" type="checkbox" id="CheckProd">
                            <label class="form-check-label" for="CheckProd">
                                Producción
                            </label>
                            </div>
                        </div>


                        <div class="form-group col-md-2  my-3">
                            <div class="form-check my-3">
                            <input class="form-check-input" type="checkbox" id="CheckManto">
                            <label class="form-check-label" for="CheckManto">
                               Mantenimiento
                            </label>
                            </div>
                        </div>

                        <div class="form-group col-md-2  my-3">
                            <div class="form-check my-3">
                            <input class="form-check-input" type="checkbox" id="CheckDir">
                            <label class="form-check-label" for="CheckDir">
                               Direccion
                            </label>
                            </div>
                        </div>

                        <div class="form-group col-md-2  my-3">
                            <div class="form-check my-3">
                            <input class="form-check-input" type="checkbox" id="CheckMaquinas">
                            <label class="form-check-label" for="CheckMaquinas">
                               Maquinas
                            </label>
                            </div>
                        </div>

                        <div class="form-group col-md-2  my-3">
                            <div class="form-check my-3">
                            <input class="form-check-input" type="checkbox" id="CheckProy">
                            <label class="form-check-label" for="CheckProy">
                               Proyectos
                            </label>
                            </div>
                        </div>


                        <div class="form-group col-md-2  my-2">
                            <div class="form-check my-2">
                            <input class="form-check-input" type="checkbox" id="CheckGranalla">
                            <label class="form-check-label" for="CheckGranalla">
                               Cargar Granalla
                            </label>
                            </div>
                        </div>

                        <div class="form-group col-md-2  my-2">
                            <div class="form-check my-2">
                            <input class="form-check-input" type="checkbox" id="CheckPiezas">
                            <label class="form-check-label" for="CheckPiezas">
                                Cargar Piezas
                            </label>
                            </div>
                        </div>

                        <div class="form-group col-md-2  my-2">
                            <div class="form-check my-2">
                            <input class="form-check-input" type="checkbox" id="CheckPartes">
                            <label class="form-check-label" for="CheckPartes">
                               Alta Partes
                            </label>
                            </div>
                        </div>

                        <div class="form-group col-md-2  my-2">
                            <div class="form-check my-2">
                            <input class="form-check-input" type="checkbox" id="CheckExtender">
                            <label class="form-check-label" for="CheckExtender">
                               Extender Vida Util
                            </label>
                            </div>
                        </div>

                        <div class="form-group col-md-2  my-2">
                            <div class="form-check my-2">
                            <input class="form-check-input" type="checkbox" id="CheckEntradas">
                            <label class="form-check-label" for="CheckEntradas">
                               Entradas
                            </label>
                            </div>
                        </div>

                        <div class="form-group col-md-2  my-2">
                            <div class="form-check my-2">
                            <input class="form-check-input" type="checkbox" id="CheckSalidas">
                            <label class="form-check-label" for="CheckSalidas">
                               Salidas
                            </label>
                            </div>
                        </div>

                      

                    </div>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" id="submit" class="btn btn-primary">Guardar</button>
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </form>

        </div>
    </div>
</div>