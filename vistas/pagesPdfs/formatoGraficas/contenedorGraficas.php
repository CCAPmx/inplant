<div id="contenedorGraficas">
    <section class="container-fluid">
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
    </section>
</div>