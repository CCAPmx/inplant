<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Documento</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>

    <style>
        .header-container {
            background-color: #f4f4f4;
            /* Color de fondo del encabezado */
            padding: 10px 20px;
            /* Padding para el encabezado */
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-title {
            font-size: 24px;
            /* Tamaño del texto */
            color: #000;
            /* Color del texto */
            font-weight: bold;
            /* Fuente en negrita */
            margin: 0;
            /* Sin margen para el título */
            flex-grow: 1;
            /* Permite que el título ocupe el espacio disponible */
            text-align: center;
            /* Centrar el texto */
            background-color: grey;
            /* Fondo blanco para el área del texto */
            padding: 10px 20px;
            /* Espaciado interno para el texto */
        }

        .logo {
            height: 50px;
            /* Altura del logo */
            width: auto;
            /* Ancho automático para mantener la proporción */
        }





        .info-table {
            margin-top: 20px;
        }

        .info-header {
            /* background-color: #f8f8f8; */
            /* padding: 8px; */
            font-weight: bold;
            /* border: 1px solid #dee2e6; */
        }

        .info-data {
            /* padding: 8px; */
            /* border: 1px solid #dee2e6; */
        }


        /*  colores  */
        .bg-color-tb-blue {
            background-color: #c8f9fb;
        }

        .bg-color-tb-yellow {
            background-color: #ffff00;
        }

        .bg-color-tb-orage {
            background-color: orangered;
        }

        .bg-color-tb-greenyellow {
            background-color: #ffbf00;
        }

        .bg-color-tb-yellow2 {
            background-color: #ffff66;
        }

        .bg-color-tb-green-2 {
            background-color: #bff24d;
        }

        .bg-color-tb-gris {
            background-color: #bfbfbf;
        }

        /* estilos de tabla */
        .header-row {
            background-color: #FFD700;
            /* Amarillo para la fila del encabezado */
        }




        .functional {
            background-color: #90EE90;
            /* Verde claro para indicar funcional */
        }

        .text-yellow {
            background-color: #FFFF00;
            /* Amarillo claro para textos específicos */
        }

        .text-bold {
            font-weight: bold;
            /* Texto en negrita */
        }

        .info-text {
            background-color: #FFA07A;
            /* Salmón claro para recomendaciones */
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid black;
            /* Bordes negros para definición */
        }

        .custom-padding {
            padding: 8px;
            /* Espaciado interno personalizado */
        }


        .td-center-text-vertical-middle {
            vertical-align: middle;
        }


        .td-blue-text {
            background-color: #F0F8FF;

        }

        .table-borde-td {
            border: 1px solid #000 !important;
            /* Cambia el color y el grosor del borde aquí */
        }
    </style>
</head>

<body>
    
<?php include 'formatos/maquinaGranalladoPdf.php';?>




 <?php include 'formatos/procesoGranalladoPdf.php';?> 
 <?php include 'formatos/condicionGranalladoPdf.php';?> 

</body>





</html>



