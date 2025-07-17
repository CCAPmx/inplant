<div id="contenedorGraficas">
    <section class="container-fluid">

        <div class="row mb-3">
            <div class="col-12 text-center">
                   <h5>Fecha: <span id="fecha_graficas"> 15/06/2023</span></h5>
            </div>  
        </div>
        <!-- Primera fila -->
        <div class="row mb-3">
            <div class="col-4 grafica-container"><?php include 'graficaGrano.php'; ?></div>
            <div class="col-4 grafica-container"><?php include 'graficaRugosida.php'; ?></div>
            <div class="col-4 grafica-container"><?php include 'graficaMixActual.php'; ?></div>
        </div>

        <!-- Segunda fila -->
        <div class="row mb-3">
            <div class="col-4 grafica-container"><?php include 'graficoSilo.php'; ?></div>
            <div class="col-4 grafica-container"><?php include 'graficoCargaGranalla.php'; ?></div>
            <div class="col-4 grafica-container"><?php include 'graficoCargaGranallaSemana.php'; ?></div>
        </div>

        <div class="col-12">
            <strong>Comentarios:</strong>
            <div id="comentarios" style="margin-top: 40px;">

            </div>
        </div>
    </section>
</div>