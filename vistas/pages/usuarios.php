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

    #tbusuarios {
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
</style>

<div class="container-fluid p-0">
    <div class="d-flex bd-highlight p-0 text-black" style="background-color: #07B5E8;">
        <div class="my-2 mx-2 flex-grow-1 bd-highlight">Usuarios</div>
        <ol class="my-2 mx-2 breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Usuarios</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header ">

                    <div class="d-flex bd-highlight">
                        <!-- <div class="p-2 bd-highlight">
                            <button type="button" class="btn btn-success mx-2" id="btnActualizarusuario">
                                Actualizar Información
                            </button>
                        </div> -->

                        <div class="ms-auto p-2 bd-highlight">
                            <button type="button" class="btn btn-primary" id="btnNuevousuario">
                                Agregar Usuarios
                            </button>
                        </div>
                    </div>
                </div>



                <!-- <div id="loader" class="loader"></div> -->

                <div class="card-body caja">

                    <table id="tbusuarios" class="table table-striped dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                               
                                <th>Nombre</th>
                                <th>Usuario</th>
                                <th>U_Clientes</th>
                                <th>id</th>
                                <th>Editar</th>
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
                <h4 class="modal-title text-black">Modal Heading</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div id="loader" class="loader"></div>

            <!-- Modal body -->
            <form id="Frmusuarios" class="row g-2" role="form" method="post" autocomplete="off">
                <div class="modal-body">

                    <p class="text-center text-black font-weight-bold mt-3">Datos Generales</p>

                    <div class="row mt-3">
                        <input type="hidden" name="fkEmpresa" id="fkEmpresa" value=<?php echo $_SESSION["fkEmpresa"]; ?>>
                        <input type="hidden" name="id" id="id" value=0>
                        
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

                    </div>

                    <div class="row mt-3">

                        <div class="form-group col-md-3">
                            <label for="cbmTipouser" class="form-label">Tipo Usuario</label>
                            <select class="form-control select2 select2-purple" data-dropdown-css-class="select2-purple" style="width: 100%;" id="cbmTipouser" name="cbmTipouser"></select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="cbmCliente" class="form-label">Clientes</label>
                            <select class="form-control select2 select2-purple" data-dropdown-css-class="select2-purple" style="width: 100%;" id="cbmCliente" name="cbmCliente"></select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="cbmNotificacion" class="form-label">Tipo Notificación</label>
                            <select class="form-control select2 select2-purple" data-dropdown-css-class="select2-purple" style="width: 100%;" id="cbmNotificacion" name="cbmNotificacion"></select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="txtMovil" class="form-label">Movil</label>
                            
                            <input type="text" class="form-control" id="txtMovil" name="txtMovil" placeholder="Movil" required>
                        </div>

                    </div>

                    <p class="text-center text-black font-weight-bold mt-3">Areas Permitidas</p>


                    <div class="d-flex justify-content-center align-items-center p-0" style="background-color: #def7ff; margin-top: -15px;">

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="CheckProd" value="option1">
                            <label class="form-check-label" for="CheckProd">Producción</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="CheckManto" value="option2">
                            <label class="form-check-label" for="CheckManto">Mantenimiento</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="CheckDir" value="option3">
                            <label class="form-check-label" for="CheckDir">Direccion</label>
                        </div>


                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="CheckBode" value="option4">
                            <label class="form-check-label" for="CheckBode">Bodega</label>
                        </div>


                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="CheckProy" value="option5">
                            <label class="form-check-label" for="CheckProy">Proyectos</label>
                        </div>

                    </div>


                    <p class="text-center text-black font-weight-bold mt-3">Permisos Extendidos</p>

                    <div class="d-flex justify-content-center align-items-center p-0" style="background-color: #def7ff; margin-top: -15px;">

                        <span class="text-black me-2">Produccion</span>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="CheckGranalla" value="option6">
                            <label class="form-check-label" for="CheckGranalla">Cargar Granalla</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="CheckPiezas" value="option7">
                            <label class="form-check-label" for="CheckPiezas">Cargar Piezas</label>
                        </div>

                        <span class="text-black me-2">Mantenimiento</span>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="CheckPartes" value="option8">
                            <label class="form-check-label" for="CheckPartes">Alta Partes</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="CheckExtender" value="option9">
                            <label class="form-check-label" for="CheckExtender">Extender Vida Util</label>
                        </div>

                        <span class="text-black me-2">Bodega</span>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="CheckEntradas" value="option10">
                            <label class="form-check-label" for="CheckEntradas">Entradas</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="CheckSalidas" value="option11">
                            <label class="form-check-label" for="CheckSalidas">Salidas</label>
                        </div>
                    </div>

                    <p class="text-center text-black font-weight-bold mt-3">Maquinas Permitidas</p>

                    <div class="d-flex justify-content-center align-items-center p-0" style="background-color: #def7ff; margin-top: -15px;">
                        <!-- <table id="tbpermisos" class="table table-striped dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Maquina</th>
                                <th>pk</th>
                                <th>Seleccionar</th>
                            </tr>
                        </thead>
                        <tbody></tbody>

                    </table> -->

                
                        <div class="card mt-3 w-75">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table caption-top">
                                        <caption class="text-center"> <strong>Lista De Maquinas</strong></caption>
                                        <table class="table table-bordered border-info table-sm" id="tablaMaquinass">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center">#</th>
                                                    <th scope="col" class="text-center">Nombre</th>
                                                    <th scope="col" class="text-center">Maquina</th>
                                                    <th scope="col" class="text-center">Seleccionar</th>
                                                </tr>
                                            </thead>
                                            <tbody id="DataResultmaquina">
                                            </tbody>
                                        </table>
                                    </table>
                                    
                                </div>
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



<script>
    /* menu */
    document.getElementById('Usuariosuper').classList.toggle('active');  


    // document.getElementById('Usuariosuper').classList.remove('active');
    document.getElementById('Iniciosuper').classList.remove('active');
    document.getElementById('Maquinasuper').classList.remove('active');
    document.getElementById('Granallasuper').classList.remove('active');
    document.getElementById('Clientesuper').classList.remove('active');
    document.getElementById('Produccionsuper').classList.remove('active');
    document.getElementById('Bodegasuper').classList.remove('active');
    document.getElementById('Mantenimientosuper').classList.remove('active');
    
    document.getElementById('Direccionsuper').classList.remove('active');
    document.getElementById('Granulometriasuper').classList.remove('active');
    document.getElementById('Contactosuper').classList.remove('active');
    
    
</script>