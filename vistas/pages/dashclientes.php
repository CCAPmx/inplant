<?php
if ((time() - $_SESSION['time']) > 900) {
    echo "<script>window.location='salir'</script>";
}
?>

<!-- <style>
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

</style> -->


<div class="container-fluid p-0">

    <!-- <h1 class="h3 mb-3 fw-bold fs-2 text-center"  style="color:#07B5E8" ><strong><span id="nombrerfc"></span></strong> </h1> -->

    <div class="row">
        <strong class="text-center fw-bold fs-3" style="color:#07B5E8"> BIENVENIDO: </strong>
    </div>

    <div class="row">

        <div class="col-md-12">
            <div class="card card-info">

                <div class="card-body">

                    <form id="FrmClientes" class="row g-2" role="form" method="post" autocomplete="off">
                        <div class="row mb-3">
                            <input type="hidden" class="form-control" id="idcliente" name="idcliente" value="0">
                            <input type="hidden" class="form-control" id="txtPkcleinte" name="txtPkcleinte" value="0">

                            <input type="hidden" class="form-control" id="txtpk" name="txtpk" placeholder="txtpk" required value="<?php echo $_SESSION['pk']; ?>" readonly>

                            <div class="form-group col-md-4 mb-3">
                                <label for="txtRazonsocial" class="form-label">Razon Social</label>
                                <input type="text" class="form-control" id="txtRazonsocial" name="txtRazonsocial" placeholder="Razon Social" value="<?php echo $_SESSION['Razon_social']; ?>" readonly>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="txtDireccionfiscal" class="form-label">Dirección Fiscal</label>
                                <input type="text" class="form-control" id="txtDireccionfiscal" name="txtDireccionfiscal" placeholder="Dirección Fiscal" value="<?php echo $_SESSION['direccion_fiscal']; ?>" readonly>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="Txtrfc" class="form-label">RFC</label>
                                <input type="text" class="form-control" id="Txtrfc" name="Txtrfc" placeholder="RFC" value="<?php echo $_SESSION['RFC']; ?>" readonly>
                            </div>

                            <!-- <div class="form-group col-md-4 mb-3">
                                <label for="txtpk" class="form-label">PK</label>
                                
                            </div> -->

                        </div>



                        <!-- <div class="row">
                            <div class="d-flex justify-content-end mb-3">

                               

                                <div class="p-2 bd-highlight">
                                <button class="btn btn-warning" type="button" id="btneditar">Editar</button>
                                    
                                </div>

                                <div class="p-2 bd-highlight">
                                <button type="submit" id="btnguardarcliente" class="btn btn-primary" disabled>Guardar</button>
                                </div>
                            </div>

                        </div> -->

                    </form>

                </div>
            </div>
        </div>
    </div>
    
</div>
</div>



</div>

<script>

    /* menu */


    document.getElementById('dashclientes_menu').classList.add('active');


</script>