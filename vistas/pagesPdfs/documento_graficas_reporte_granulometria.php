<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Documento</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js v4 -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
    <!-- Datalabels plugin compatible -->
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>





</head>


<style>
    body {
        min-height: 1000px;
        /* o 1200px, ajusta según resultado */
    }

    #contenedorGraficas {
        min-height: 800px;
        padding: 20px;
        /* position: relative;
        top: 164px; */
    }

    #contenedorPDF {
        padding: 20px;
        background: white;
    }

    canvas {
        max-width: 100%;
        height: auto;
    }

    .grafica-container {
        margin-bottom: 20px;
    }
</style>

<body>

    <div id="contenedorPDF">
        <div id="encabezado" style="margin-bottom: 40px;">
            <?php include 'formatoGraficas/encabezado.php'; ?>
        </div>

        <div id="contenedorGraficas">
            <?php include 'formatoGraficas/contenedorGraficas.php'; ?>
        </div>
    </div>


</body>

<script>
    async function obtenerDatosMix() {
        const response = await fetch('../../vistas/pagesPdfs/formatoGraficas/proxy/proxy_grafico_grano_1.php?a1=808');
        const data = await response.json();
        return data; // 👈 ¡ESTO ES CLAVE!
    }


    async function cargarDatos() {
        const dataGraficas = await obtenerDatosMix();

        const grafica_1 = dataGraficas.GRAFICOS[3];
        console.log("Datos recibidos desde el proxy:", dataGraficas);
        console.log("Datos de la gráfica 1:", grafica_1);
    }
    cargarDatos();
</script>




</html>