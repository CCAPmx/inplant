
<?php
		if((time() - $_SESSION['time']) > 900){
            echo "<script>window.location='salir'</script>";
        }
	?>
<style>
  #tbprov {
    font-size: 12px;
  }

  td {
    font-size: 12px;
    /* color: re2; */
  }

  th {
    font-size: 12px;
    /* color:green; */
  }
</style>
 <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Proveedores</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Proveedores</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">

            <div class="d-flex">
    
                <div class="p-2">
                    <h2 class="card-title text-success">Catalogo de Proveedores</h2>
                </div>
                
                <div class="ml-auto p-2">
                    <button class="btn btn-dark" type="button" data-toggle="modal" data-target="#addNewUserModal">Agregar Proveedor</button>
                </div>

            </div>
        </div>
        <div class="card-body">
        <table id="tbprov" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Proveedor</th>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Ciudad</th>
                        <th>Localidad</th>
                        <th>Colonia</th>
                        <th>Calle</th>
                        <th>CP</th>
                        <th>Teléfono</th>
                        <th>RFC</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          Footer
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->