<?php
		if((time() - $_SESSION['time']) > 900){
            echo "<script>window.location='salir'</script>";
        }
	?>

<div class="container-fluid p-0">

<div class="row">
  <h1 class="text-center fw-bold fs-1" style="color:#07B5E8">Bienvenido <?php echo $_SESSION["nombre"] ; ?></h1>
</div>



<!-- <h1 class="h3 mb-3"><strong>Panel</strong> Analisis</h1> -->



<div class="row">
  <div class="text-center my-4">
    <img src="vistas/recursos/img/avatars/lersan.png" alt="Lersan" class="img-fluid" />
  </div>
  <!-- <div class="col-xl-6 col-xxl-5 d-flex">
    <div class="w-100">
      <div class="row">
        <div class="col-sm-6">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col mt-0">
                  <h5 class="card-title">Ventas</h5>
                </div>

                <div class="col-auto">
                  <div class="stat text-primary">
                    <i class="align-middle" data-feather="truck"></i>
                  </div>
                </div>
              </div>
              <h1 class="mt-1 mb-3">2.382</h1>
              <div class="mb-0">
                <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -3.65% </span>
                <span class="text-muted">Semana Pasada</span>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col mt-0">
                  <h5 class="card-title">Visitantes</h5>
                </div>

                <div class="col-auto">
                  <div class="stat text-primary">
                    <i class="align-middle" data-feather="users"></i>
                  </div>
                </div>
              </div>
              <h1 class="mt-1 mb-3">14.212</h1>
              <div class="mb-0">
                <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> 5.25% </span>
                <span class="text-muted">Semana Pasada</span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col mt-0">
                  <h5 class="card-title">Ganancias</h5>
                </div>

                <div class="col-auto">
                  <div class="stat text-primary">
                    <i class="align-middle" data-feather="dollar-sign"></i>
                  </div>
                </div>
              </div>
              <h1 class="mt-1 mb-3">$21.300</h1>
              <div class="mb-0">
                <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> 6.65% </span>
                <span class="text-muted">Semana Pasada</span>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col mt-0">
                  <h5 class="card-title">Pedidos</h5>
                </div>

                <div class="col-auto">
                  <div class="stat text-primary">
                    <i class="align-middle" data-feather="shopping-cart"></i>
                  </div>
                </div>
              </div>
              <h1 class="mt-1 mb-3">64</h1>
              <div class="mb-0">
                <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -2.25% </span>
                <span class="text-muted">Semana Pasada</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-6 col-xxl-7">
    <div class="card flex-fill w-100">
      <div class="card-header">

        <h5 class="card-title mb-0">Movimientos Recientes</h5>
      </div>
      <div class="card-body py-3">
        <div class="chart chart-sm">
          <canvas id="chartjs-dashboard-line"></canvas>
        </div>
      </div>
    </div>
  </div> -->
</div>

<!-- <div class="row">
  <div class="col-12 col-md-6 col-xxl-3 d-flex order-2 order-xxl-3">
    <div class="card flex-fill w-100">
      <div class="card-header">

        <h5 class="card-title mb-0">Uso del navegador</h5>
      </div>
      <div class="card-body d-flex">
        <div class="align-self-center w-100">
          <div class="py-3">
            <div class="chart chart-xs">
              <canvas id="chartjs-dashboard-pie"></canvas>
            </div>
          </div>

          <table class="table mb-0">
            <tbody>
              <tr>
                <td>Chrome</td>
                <td class="text-end">4306</td>
              </tr>
              <tr>
                <td>Firefox</td>
                <td class="text-end">3801</td>
              </tr>
              <tr>
                <td>IE</td>
                <td class="text-end">1689</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-12 col-xxl-6 d-flex order-3 order-xxl-2">
    <div class="card flex-fill w-100">
      <div class="card-header">

        <h5 class="card-title mb-0">Tiempo real</h5>
      </div>
      <div class="card-body px-4">
        <div id="world_map" style="height:350px;"></div>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-6 col-xxl-3 d-flex order-1 order-xxl-1">
    <div class="card flex-fill">
      <div class="card-header">

        <h5 class="card-title mb-0">Calendario</h5>
      </div>
      <div class="card-body d-flex">
        <div class="align-self-center w-100">
          <div class="chart">
            <div id="datetimepicker-dashboard"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12 col-lg-8 col-xxl-9 d-flex">
    <div class="card flex-fill">
      <div class="card-header">

        <h5 class="card-title mb-0">Últimos proyecto</h5>
      </div>
      <table class="table table-hover my-0">
        <thead>
          <tr>
            <th>Nombre</th>
            <th class="d-none d-xl-table-cell">Fecha Inicio</th>
            <th class="d-none d-xl-table-cell">Fecha Final</th>
            <th>Status</th>
            <th class="d-none d-md-table-cell">Asignado</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Project Apollo</td>
            <td class="d-none d-xl-table-cell">01/01/2021</td>
            <td class="d-none d-xl-table-cell">31/06/2021</td>
            <td><span class="badge bg-success">Done</span></td>
            <td class="d-none d-md-table-cell">Vanessa Tucker</td>
          </tr>
          <tr>
            <td>Project Fireball</td>
            <td class="d-none d-xl-table-cell">01/01/2021</td>
            <td class="d-none d-xl-table-cell">31/06/2021</td>
            <td><span class="badge bg-danger">Cancelled</span></td>
            <td class="d-none d-md-table-cell">William Harris</td>
          </tr>
          <tr>
            <td>Project Hades</td>
            <td class="d-none d-xl-table-cell">01/01/2021</td>
            <td class="d-none d-xl-table-cell">31/06/2021</td>
            <td><span class="badge bg-success">Done</span></td>
            <td class="d-none d-md-table-cell">Sharon Lessman</td>
          </tr>
          <tr>
            <td>Project Nitro</td>
            <td class="d-none d-xl-table-cell">01/01/2021</td>
            <td class="d-none d-xl-table-cell">31/06/2021</td>
            <td><span class="badge bg-warning">In progress</span></td>
            <td class="d-none d-md-table-cell">Vanessa Tucker</td>
          </tr>
          <tr>
            <td>Project Phoenix</td>
            <td class="d-none d-xl-table-cell">01/01/2021</td>
            <td class="d-none d-xl-table-cell">31/06/2021</td>
            <td><span class="badge bg-success">Done</span></td>
            <td class="d-none d-md-table-cell">William Harris</td>
          </tr>
          <tr>
            <td>Project X</td>
            <td class="d-none d-xl-table-cell">01/01/2021</td>
            <td class="d-none d-xl-table-cell">31/06/2021</td>
            <td><span class="badge bg-success">Done</span></td>
            <td class="d-none d-md-table-cell">Sharon Lessman</td>
          </tr>
          <tr>
            <td>Project Romeo</td>
            <td class="d-none d-xl-table-cell">01/01/2021</td>
            <td class="d-none d-xl-table-cell">31/06/2021</td>
            <td><span class="badge bg-success">Done</span></td>
            <td class="d-none d-md-table-cell">Christina Mason</td>
          </tr>
          <tr>
            <td>Project Wombat</td>
            <td class="d-none d-xl-table-cell">01/01/2021</td>
            <td class="d-none d-xl-table-cell">31/06/2021</td>
            <td><span class="badge bg-warning">In progress</span></td>
            <td class="d-none d-md-table-cell">William Harris</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="col-12 col-lg-4 col-xxl-3 d-flex">
    <div class="card flex-fill w-100">
      <div class="card-header">

        <h5 class="card-title mb-0">Ventas mensuales</h5>
      </div>
      <div class="card-body d-flex w-100">
        <div class="align-self-center chart chart-lg">
          <canvas id="chartjs-dashboard-bar"></canvas>
        </div>
      </div>
    </div>
  </div>
</div> -->

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.es.min.js" integrity="sha512-3chOMtjYaSa9m2bCC8qGxmEcX449u63D1fMXMQdueS3/XgE12iHQdmZVXVVbhBLc9i7h9WUuuM15B0CCE6Jtvg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> 
<!--  -->
<script src="vistas/js/inicio.js"></script>


<script>
    /* menu */
    // document.getElementById('Iniciosuper').classList.toggle('active');  


    document.getElementById('Usuariosuper').classList.remove('active');
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
