<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="vistas/recursos/sweetalert/css/sweetalert2.min.css">
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

</style>

<div class="container-fluid p-0">

<div class="row">
    <h1 id="Nombmaq" class="text-center fw-bold fs-1" style="color:#07B5E8"><?php echo $_SESSION["u_clientes"]; ?></h1>
</div>

<p class=" fw-bold fs-6 text-center"  style="color:#07B5E8" ><strong><span id="nombrerfc"></span></strong> </p>
    <div class="d-flex bd-highlight p-0 text-white" style="background-color: #07B5E8;">
        <div class="my-2 mx-2 flex-grow-1 bd-highlight">Estado de Cuenta</div>
        <ol class="my-2 mx-2 breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Estado de Cuenta</li>
        </ol>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">

                <div id="loader" class="loader"></div>

                <div class="card-body">
                    <input type="hidden" class="form-control" id="rfc" name="rfc" value=<?php echo $_SESSION["RFC"]; ?>>
                    <div class="table-responsive">
                        <table class="table table-bordered border-info table-sm" id="tablaedo">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">Fecha</th>
                                    <th scope="col" class="text-center">Serie</th>
                                    <th scope="col" class="text-center">Folio</th>
                                    <th scope="col" class="text-center">Importe</th>
                                    <th scope="col" class="text-center">IVA</th>
                                    <th scope="col" class="text-center">Total</th>
                                    <th scope="col" class="text-center">Moneda</th>
                                    <th scope="col" class="text-center">Saldo</th>
                                    <th scope="col" class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody id="DataEdocuenta">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer text-certer">
                <div class="d-flex justify-content-center">
                    <div id="pagination"></div>
                </div>
                <div class="text-center mt-3"><span class="text-dark" id="txtPag"></span></div>
            </div>
        </div>
    </div>

</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.es.min.js" integrity="sha512-3chOMtjYaSa9m2bCC8qGxmEcX449u63D1fMXMQdueS3/XgE12iHQdmZVXVVbhBLc9i7h9WUuuM15B0CCE6Jtvg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> 
<script src="vistas/js/edocuenta.js"></script>
