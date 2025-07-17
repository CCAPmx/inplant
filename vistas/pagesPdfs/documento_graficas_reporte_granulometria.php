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







</body>

<script>
    async function obtenerDatosMix() {

        const params = new URLSearchParams(window.location.search);
        const id = params.get('id'); // Obtiene el id dinámicamente

        console.log("ID obtenido:", id); // Verifica que el ID se obtenga correctamente


        // Llama al proxy para obtener los datos de la gráfica 1
        const response = await fetch(`../../vistas/pagesPdfs/formatoGraficas/proxy/proxy_grafico_grano_1.php?a1=${id}`);
        const data = await response.json();
        console.log("Datos obtenidos desde el proxy:", data);
        return data; // 👈 ¡ESTO ES CLAVE!
    }


    async function cargarDatos() {
        const dataGraficas = await obtenerDatosMix();

        const grafica_1 = dataGraficas.GRAFICOS[5];
        graficasGrano_G1(grafica_1, dataGraficas.GRAFICOS[1].G3_b, dataGraficas.datos_locales[0].nombre_maquina);
        graficaRugosidad_G2(dataGraficas.GRAFICOS[6], dataGraficas.datos_locales[0].nombre_maquina);

        graficoMixActual_G3(dataGraficas.GRAFICOS[0].G3_a, dataGraficas.GRAFICOS[1].G3_b, dataGraficas.datos_locales[0].nombre_maquina);

        generarGraficoSilo_G4(dataGraficas.GRAFICOS[2], dataGraficas.datos_locales[0].nombre_maquina);
        graficoCargaGranalla_G5(dataGraficas.GRAFICOS[3].G5, dataGraficas.datos_locales[0].nombre_maquina);
        graficoCargaGranallaSemana_G6(dataGraficas.GRAFICOS[4].G6, dataGraficas.datos_locales[0].nombre_maquina);
        document.getElementById('graballa_encabezado').innerHTML = dataGraficas.datos_locales_maquina.nombre_cabina;

        document.getElementById('cabina_encabezado').innerHTML = dataGraficas.datos_locales[0].nombre_maquina;

        document.getElementById('fecha_graficas').innerHTML = dataGraficas.datos_locales[0].fecha_formateada;

        const comentariosDiv = document.getElementById('comentarios');

        // Verifica si hay al menos un comentario
        const comentarios = [
            dataGraficas.comentarios.comment_01,
            dataGraficas.comentarios.comment_02,
            dataGraficas.comentarios.comment_03,
            dataGraficas.comentarios.comment_04
        ].filter(comentario => comentario && comentario.trim() !== '');

        if (comentarios.length > 0) {
            let html = '';
            html += '<ol>';

            comentarios.forEach(comentario => {
                html += `<li>${comentario}</li>`;
            });

            html += '</ol>';

            comentariosDiv.innerHTML = html;
        } else {
            comentariosDiv.innerHTML = '<p><em>No hay comentarios registrados.</em></p>';
        }



        console.log("Datos recibidos desde el proxy:", dataGraficas);
        // console.log("Datos de la gráfica 1:", grafica_1);
    }
    cargarDatos();
</script>





</html>