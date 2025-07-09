<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
  <meta name="author" content="AdminKit">
  <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="shortcut icon" href="vistas/recursos/img/icons/favicon.png" />
  <!-- <link rel="icon" type="image/x-icon" href="/images/favicon.ico"> -->

  <title>INPLANT</title>

  <link href="vistas/recursos/css/app.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
  <link href="vistas/recursos/datatable/css/cdnjs.cloudflare.com_ajax_libs_twitter-bootstrap_5.2.0_css_bootstrap.min.css" rel="stylesheet">
  <link href="vistas/recursos/datatable/css/cdn.datatables.net_1.13.4_css_dataTables.bootstrap5.min.css" rel="stylesheet">
  <link href="vistas/recursos/datatable/css/cdn.datatables.net_responsive_2.4.1_css_responsive.bootstrap5.min.css" rel="stylesheet">
  <link href="vistas/recursos/datatable/css/cdn.datatables.net_select_1.6.2_css_select.dataTables.min.css" rel="stylesheet">



  <!-- Fullcalendario -->
  <script src="vistas/recursos/fullcalendar/index.global.js"> </script>
  <script src="vistas/recursos/fullcalendar/index.global.min.js"> </script>

  <!-- searchPanes -->
  <link rel="stylesheet" href="https://cdn.datatables.net/searchpanes/1.0.1/css/searchPanes.dataTables.min.css">
  <!-- select -->
  <link href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">

  <!-- Select2 -->
  <link href="vistas/recursos/select2/select2.min.css" rel="stylesheet">
  <link href="vistas/recursos/select2-bootstrap-5-theme/select2-bootstrap-5-theme.min.css" rel="stylesheet">
  <!-- sweetalert2 -->
  <link rel="stylesheet" href="vistas/recursos/sweetalert/css/sweetalert2.min.css">

  <!-- daterange picker -->
  <link rel="stylesheet" href="vistas/recursos/daterangepicker/daterangepicker.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">

  <link href="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <!-- 
  <link href="https://unpkg.com/bootstrap-table@1.21.4/dist/bootstrap-table.min.css" rel="stylesheet"> -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paginationjs/2.1.4/pagination.css"/> -->

  <!-- datatables -->
  <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.dataTables.min.css" rel="stylesheet">


</head>

<body>
    <style> 
.active {
    background-color: #6c757d;
}

 .breadcrumb-item.active {
      background-color: #07b5e8 !important;
      
    }

</style>
  <?php

  if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok") {
    echo '<div class="wrapper">';
    include "modulos/menu.php";
    echo '<div class="main">';
    include "modulos/header.php";
    if (isset($_GET["pages"])) {

      echo '<main class="content">';
      if (
        $_GET["pages"] == "inicio" ||
        $_GET["pages"] == "proveedor" ||
        $_GET["pages"] == "clientes" ||
        $_GET["pages"] == "granulometria" ||
        $_GET["pages"] == "usuarios" ||
        $_GET["pages"] == "contactos" ||
        $_GET["pages"] == "granalla" ||
        $_GET["pages"] == "movimientos" ||
        $_GET["pages"] == "maquinas" ||
        $_GET["pages"] == "mantenimiento" ||
        $_GET["pages"] == "dashclientes" ||
        $_GET["pages"] == "datoscliente" ||
        $_GET["pages"] == "pedidosclientes" ||
        $_GET["pages"] == "maqclientes" ||
        $_GET["pages"] == "regresar" ||
        $_GET["pages"] == "edocuenta" ||
        $_GET["pages"] == "proyectos" ||
        $_GET["pages"] == "vagones" ||
        $_GET["pages"] == "reportevagones" ||
        $_GET["pages"] == "supervisores" ||
        $_GET["pages"] == "generargranalla" ||
        $_GET["pages"] == "informaciongranalla" ||
        $_GET["pages"] == "stockgranalla" ||
        $_GET["pages"] == "movbodega" ||
        $_GET["pages"] == "solicitudes" ||
        $_GET["pages"] == "eventosCalendario" ||
        $_GET["pages"] == "reporteTurno" ||
        $_GET["pages"] == "altaSupervisores" ||
        $_GET["pages"] == "partesMaquinas" ||
        $_GET["pages"] == "visitastecnicas" ||
        $_GET["pages"] == "programacionvisitas" ||
        $_GET["pages"] == "inplanttv" ||
        $_GET["pages"] == "reportegreenbrier" ||
        $_GET["pages"] == "granumelometriagreenbrier" ||
        $_GET["pages"] == "salir"
      ) {
        include "pages/" . $_GET["pages"] . ".php";
      } else {
        include "pages/404.php";
      }
      echo '</main>';

      

      //  include "modulos/footer.php";

    } else {
      include "pages/login.php";
    }
    echo '</div>';

    echo '</div>';
  } else {

    include "pages/login.php";
  }
  ?>




  <script src="vistas/recursos/js/app.js"></script>
  <script src="vistas/recursos/datatable/js/code.jquery.com_jquery-3.5.1.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
  
  <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.16/sorting/datetime-moment.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.21/dataRender/datetime.js"></script> -->

  <script src="vistas/recursos/datatable/js/cdn.datatables.net_1.13.4_js_jquery.dataTables.min.js"></script>
  <script src="vistas/recursos/datatable/js/cdn.datatables.net_1.13.4_js_dataTables.bootstrap5.min.js"></script>
  <script src="vistas/recursos/datatable/js/cdn.datatables.net_responsive_2.4.1_js_dataTables.responsive.min.js"></script>
  <script src="vistas/recursos/datatable/js/cdn.datatables.net_responsive_2.4.1_js_responsive.bootstrap5.min.js"></script>
  <script src="vistas/recursos/datatable/js/cdn.datatables.net_select_1.6.2_js_dataTables.select.min.js"></script>
  <!-- Select2 -->
  <script src="vistas/recursos/select2/select2.min.js"> </script>
  <script src="vistas/recursos/select2/select2.full.min.js"> </script>
  <!-- sweetalert2 -->
  <script src="vistas/recursos/sweetalert/js/sweetalert2.min.js" defer></script>
  <!-- date-range-picker -->
  <script src="vistas/recursos/moment/moment.min.js"></script>
  <script src="vistas/recursos/daterangepicker/daterangepicker.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" integrity="sha512-fD9DI5bZwQxOi7MhYWnnNPlvXdp/2Pj3XSTRrFs5FQa4mizyGLnJcN6tuvUS6LbmgN1ut+XGSABKvjN0H6Aoow==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="vistas/recursos/js/accounting.min.js" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>

  <!-- <script src="https://cdn.jsdelivr.net/npm/quickchart-js@3.1.2/build/quickchart.min.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.3.0/chart.js" integrity="sha512-L6yov5P1r9QnZX2ZRiq+XBLsm1GQ38zfSDJ6gy3pKmPCqkWvK2nz8Ojlju9q36+zOsMmMB+hYgGrJtJWo4Gy/w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-doughnutlabel/2.0.3/chartjs-plugin-doughnutlabel.min.js" integrity="sha512-bUT48RorCgRb7/kCkXnpNFwDr/xKF0o1vIFI9Y5NGYZ4uZCZBZTI4p6SygRqLkxxRsDSG4BEc7HNq8FOxeGEbA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0-rc"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js" integrity="sha512-JPcRR8yFa8mmCsfrw4TNte1ZvF1e3+1SdGMslZvmrzDYxS69J7J49vkFL8u6u8PlPJK+H3voElBtUCzaXj+6ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-to-image"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/downloadjs/1.4.8/download.min.js" integrity="sha512-WiGQZv8WpmQVRUFXZywo7pHIO0G/o3RyiAJZj8YXNN4AV7ReR1RYWVmZJ6y3H06blPcjJmG/sBpOVZjTSFFlzQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


  <script src="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.js"></script>
  <script src="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table-locale-all.min.js"></script>
  <script src="https://unpkg.com/bootstrap-table@1.22.1/dist/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>


  <script type="text/javascript" src="vistas/recursos/pdf/pdf.min.js"></script>
  <script type="text/javascript" src="vistas/pdfobject/pdfobject.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.14.3/xlsx.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js" integrity="sha512-/cZZTKETbsuutvNXdPji/z8N+9e+LHq9D60JhcBCigq9I5a2VDEcLzml8PdVlVqzmWlVbhZCuTx+9CTi2xb30A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.es.min.js" integrity="sha512-3chOMtjYaSa9m2bCC8qGxmEcX449u63D1fMXMQdueS3/XgE12iHQdmZVXVVbhBLc9i7h9WUuuM15B0CCE6Jtvg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js"></script>


  <!-- searchPanes   -->
  <script src="https://cdn.datatables.net/searchpanes/1.0.1/js/dataTables.searchPanes.min.js"></script>
  <!-- select -->
  <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>

  <script src="vistas/js/validaSession.js"></script>
  <script src="vistas/js/plantilla.js"></script>
  <script src="vistas/js/usuarios.js"></script>
  <script src="vistas/js/clientes.js"></script>
  <script src="vistas/js/notificacion.js"></script>
  <script src="vistas/js/granulometria.js"></script>
  <script src="vistas/js/greenbrier.js"></script>
  <script src="vistas/js/greenbrierRer.js"></script>
  <script src="vistas/js/contactos.js"></script>
  <script src="vistas/js/granalla.js"></script>
  <script src="vistas/js/movimientos.js"></script>
  <script src="vistas/js/mantenimiento.js"></script>
  <script src="vistas/js/datoscliente.js"></script>
  <script src="vistas/js/maquinas.js"></script>
  <script src="vistas/js/ordenventa.js"></script>
  <script src="vistas/js/pedclients.js"></script>
  <script src="vistas/js/dashclientes.js"></script>
  <script src="vistas/js/dashclientes.js"></script>
  <!-- <script src="vistas/js/reporteTurno.js"></script> -->
  <!-- <script src="vistas/js/partesMaquinas.js"></script> -->
  <script src="vistas/js/menu.js"></script>
  
</body>

</html>