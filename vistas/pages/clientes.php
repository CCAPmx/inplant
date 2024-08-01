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
        font-size: 10px;
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
<p class=" fw-bold fs-6 text-center"  style="color:#07B5E8" ><strong><span id="nombrerfc"></span></strong> </p>
    <div class="d-flex bd-highlight p-0 text-white" style="background-color: #07B5E8;">
        <div class="my-2 mx-2 flex-grow-1 bd-highlight">Clientes</div>
        <ol class="my-2 mx-2 breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Clientes</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title">Catalogo de Clientes</h5>
                    <input type="hidden" class="form-control" id="tipousuarionivel" name="tipousuarionivel" value=<?php echo $_SESSION["tipousuarionivel"]; ?>>
                    <div class="d-flex justify-content-end">

                        <!-- <button type="button" class="btn btn-success mx-2" id="btnActualizar">
                            Actualizar Información
                        </button> -->
                        
                        <button type="button" class="btn btn-primary mx-2" id="btnActualizar">
                            Actualizar Información
                        </button>

                        
                    </div>

                   

                </div>

                <div id="loader" class="loader"></div>

                
                <div class="card-body">
                        
                    <div class="table-responsive">
                        <table id="tbclientes" class="table table-striped dt-responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Razon Social</th>
                                    <th>Direccion Fiscal</th>
                                    <th>RFC</th>
                                    <!--<th>PK</th>-->
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
</div>


<script>
    /* menu */
    document.getElementById('Clientesuper').classList.toggle('active');  


    document.getElementById('Usuariosuper').classList.remove('active');
    document.getElementById('Iniciosuper').classList.remove('active');
    document.getElementById('Maquinasuper').classList.remove('active');
    document.getElementById('Granallasuper').classList.remove('active');
    // document.getElementById('Clientesuper').classList.remove('active');
    document.getElementById('Produccionsuper').classList.remove('active');
    document.getElementById('Bodegasuper').classList.remove('active');
    document.getElementById('Mantenimientosuper').classList.remove('active');
    
    document.getElementById('Direccionsuper').classList.remove('active');
    document.getElementById('Granulometriasuper').classList.remove('active');
    document.getElementById('Contactosuper').classList.remove('active');
    
    
</script>





<!-- <div class="modal fade" id="Modalclientes" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title text-white">Modal Heading</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

   
            <form id="FrmClientes" class="row g-2" role="form" method="post" autocomplete="off">
                <div class="modal-body">
                    <div class="row mb-3">
                        <input type="hidden" class="form-control" id="idcliente" name="idcliente" value="0">
                        <input type="hidden" class="form-control" id="txtPkcleinte" name="txtPkcleinte" value="0">
                        <div class="form-group col-md-12 mb-3">
                            <label for="txtRazonsocial" class="form-label">Razon Social</label>
                            <input type="text" class="form-control" id="txtRazonsocial" name="txtRazonsocial" placeholder="Razon Social" required readonly>
                        </div>

                        <div class="form-group col-md-12 mb-3">
                            <label for="txtDireccionfiscal" class="form-label">Dirección Fiscal</label>
                            <input type="text" class="form-control" id="txtDireccionfiscal" name="txtDireccionfiscal" placeholder="Dirección Fiscal" required readonly>
                        </div>

                        <div class="form-group col-md-12 mb-3">
                            <label for="Txtrfc" class="form-label">RFC</label>
                            <input type="text" class="form-control" id="Txtrfc" name="Txtrfc" placeholder="RFC" required readonly>
                        </div>
                    
                    </div>

                </div>

                <div class="modal-footer">

                <div class="row">
                        <div class="d-flex bd-highlight mb-3">

                            <div class="me-auto p-2 bd-highlight">
                            <button class="btn btn-warning" type="button" id="btneditar">Editar</button>
                            </div>
                            
                            <div class="p-2 bd-highlight">
                                <button type="submit" id="btnguardarcliente" class="btn btn-primary" disabled>Guardar</button>
                            </div>
                            
                            <div class="p-2 bd-highlight">
                                <button button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div> 

                </div>


                </div>
            </form>

        </div>
    </div>
</div> -->