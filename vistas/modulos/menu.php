<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="vistas/recursos/sweetalert/css/sweetalert2.min.css">

<style>
	.show_menu {
		display: block;
	}

	.hide_menu {
		display: none;
	}
</style>



<nav id="sidebar" class="sidebar js-sidebar">
	<div class="sidebar-content js-simplebar">
		<div class="text-center">
			<a class="sidebar-brand" href="index.html">
				<span class="text-center">INPLANT</span>
			</a>
		</div>


		<ul class="sidebar-nav">
			<!-- <li class="sidebar-header text-center">
						<span class="text-white fs-6">Tipo User: <?php echo $_SESSION["tipouser"]; ?></span>
					</li> -->




			<?php
			$Id = $_SESSION["tipousuarionombre"];
			if ($Id != "") {
				switch ($Id) {
					case "SuperUsuario":
						echo "<li class='sidebar-item active' id='Iniciosuper'>
							<a class='sidebar-link' href='inicio'>
								<i class='align-middle fa-solid fa-house'></i> <span class='align-middle'>Home</span>
							</a>
						</li>

						<li class='sidebar-item' id='Usuariosuper'>
							<a class='sidebar-link' href='usuarios'>
								<i class='align-middle fa-solid fa-circle-user'></i> <span class='align-middle'>Usuarios</span>
							</a>
						</li>

						<li class='sidebar-item' id='Maquinasuper'>
							<a class='sidebar-link' href='maqclientes'>
								<i class='fa-solid fa-gears align-middle'></i> <span class='align-middle'>Info Proceso</span>
							</a>
						</li>

						<li class='sidebar-item' id='Granallasuper'>
							<a class='sidebar-link' href='granalla'>
								<i class='fa-solid fa-mound align-middle'></i> <span class='align-middle'>Granalla</span>
							</a>
						</li>



						<li class='sidebar-item' id='Clientesuper'>
							<a class='sidebar-link' href='clientes'>
								<i class='align-middle fa-solid fa-users'></i> <span class='align-middle'>Clientes</span>
							</a>
						</li>

						<li class='sidebar-item' id='Produccionsuper'>
							<a class='sidebar-link' href='#'>
								<i class='align-middle fa-solid fa-recycle'></i><span class='align-middle'>Produccion</span>
							</a>
						</li>

						<li class='sidebar-item' id='Bodegasuper'>
							<a class='sidebar-link' href='movimientos'>
								<i class='align-middle fa-solid fa-city'></i><span class='align-middle'>Bodega</span>
							</a>
						</li>

						<li class='sidebar-item' id='Mantenimientosuper'>
							<a class='sidebar-link' href='mantenimiento'>
								<i class='align-middle fa-solid fa-screwdriver-wrench'></i><span class='align-middle'>Mantenimiento</span>
							</a>
						</li>


						<li class='sidebar-item' id='Direccionsuper'>
							<a class='sidebar-link' href='#'>
								<i class='align-middle fa-solid fa-user-tie'></i><span class='align-middle'>Direccion</span>
							</a>
						</li>

						<li class='sidebar-item' id='Granulometriasuper'>
							<a class='sidebar-link' href='granulometria'>
								<i class='align-middle fa-regular fa-gem'></i><span class='align-middle'>Granulometria</span>
							</a>
						</li>

						<li class='sidebar-item' id='Contactosuper'>
							<a class='sidebar-link' href='contactos'>
								<i class='align-middle fa-brands fa-whatsapp'></i><span class='align-middle'>Contactos</span>
							</a>
						</li>

						<li class='sidebar-item' id='visitas_tecnicas_menu'>
							<a class='sidebar-link' href='visitastecnicas'>
							<i class='fa-solid fa-person-circle-exclamation'></i></i> <span class='align-middle'>Visitas Técnicas</span>
							</a>
						</li>

						<li class='sidebar-item' id='programacion_visitas_menu'>
							<a class='sidebar-link' href='programacionvisitas'>
							<i class='fa-solid fa-person-circle-exclamation'></i></i> <span class='align-middle'>Programación Visitas</span>
							</a>
						</li>

						<li class='sidebar-item' id='Salirsuper'>
							<a class='sidebar-link' href='salir'>
								<i class='align-middle fa-solid fa-door-open'></i><span class='align-middle'>Salir</span>
							</a>
						</li>
						





						<li class='sidebar-item active'>
							<a class='sidebar-link' href='dashclientes' id='InicioJefe'>
								<i class='align-middle fa-solid fa-house'></i> <span class='align-middle'>Inicio</span>
							</a>
						</li>

						<li class='sidebar-item'>
							<a class='sidebar-link' href='pedidosclientes' id='PedidosJefe'>
								<i class='align-middle fa-solid fa-circle-user'></i> <span class='align-middle'>Pedidos</span>
							</a>
						</li>

						<li class='sidebar-item'>
							<a class='sidebar-link' href='maqclientes' id='MaquinasJefe'>
								<i class='fa-solid fa-gears align-middle'></i> <span class='align-middle'>Info Proceso</span>
							</a>
						</li>

						<li class='sidebar-item'>
							<a class='sidebar-link' href='#' id='ProduccionJefe'>
								<i class='fa-solid fa-mound align-middle'></i> <span class='align-middle'>Producción</span>
							</a>
						</li>

						<li class='sidebar-item'>
							<a class='sidebar-link' href='edocuenta' id='EstadoJefe'>
								<i class='align-middle fa-solid fa-users'></i> <span class='align-middle'>Facturas / Estado de Cuenta</span>
							</a>
						</li>

						<li class='sidebar-item'  id='SalirJefe'>
						<a class='sidebar-link' href='clientes'>
								<i class='align-middle fa-solid fa-door-open'></i><span class='align-middle'>Regresar</span>
							</a>
						</li>
						

						

						";
						break;



					case "Cliente Jefe":


						if ($_SESSION["produccion"] == 1 and $_SESSION["maquinas"] == 1 and $_SESSION["bodega"] == 1 and $_SESSION["mantenimiento"] == 1) {

							echo "

						<li class='sidebar-item active' id='dashclientes_menu'>
							<a class='sidebar-link' href='dashclientes'>
								<i class='align-middle fa-solid fa-house fa-2xs'></i> <span class='align-middle'>Home</span>
							</a>
						</li>

						<li class='sidebar-header' id='menu_produccion' >
							Producción
						</li>


						<div class='hide_menu' id='menu_produccion_item'> 
						<li class='sidebar-item' id='proyectos_menu' >
							<a class='sidebar-link' href='proyectos' >
								<i class='align-middle fa-solid fa-mound fa-2xs'></i> <span class='align-middle'>Proyectos</span>
							</a>
						</li>

						<li class='sidebar-item' id='vagones_menu' >
							<a class='sidebar-link' href='vagones' >
								<i class='align-middle fa-solid fa-mound fa-2xs'></i> <span class='align-middle'>Generar vagón</span>
							</a>
						</li>

						<li class='sidebar-item' id='reportevagones_menu' >
							<a class='sidebar-link' href='reportevagones' >
								<i class='align-middle fa-solid fa-list-ol fa-2xs'></i> <span class='align-middle'>Info Vagones</span>
							</a>
						</li>

						
						<li class='sidebar-item' id='maqclientes_menu' >
							<a class='sidebar-link' href='maqclientes' >
								<i class='align-middle fa-solid fa-gears fa-2xs'></i> <span class='align-middle'>Info Proceso</span>
							</a>
						</li>


						<li class='sidebar-header' id='sub_menu_Turno' >
							Turno Supervisores
						</li>


						<div class='hide_menu' id='sub_menu_Turno_item'> 
						<li class='sidebar-item'  id='alta_turno_menu' >
							<a class='sidebar-link' href='altaSupervisores' >
							<i class='align-middle fa-solid fa-user-tie fa-2xs'></i><span class='align-middle'>Alta  Supervisores</span>
							</a>
						</li>

						<li class='sidebar-item'  id='supervisores_menu' >
							<a class='sidebar-link' href='supervisores' >
							<i class='align-middle fa-solid fa-user-tie fa-2xs'></i><span class='align-middle'>Alta Turnos</span>
							</a>
						</li>

						

						<li class='sidebar-item'  id='infoTurno_menu' >
							<a class='sidebar-link' href='reporteTurno' >
							<i class='align-middle fa-solid fa-list-ol fa-2xs'></i><span class='align-middle'>Info Turnos</span>
							</a>
						</li>

						<li class='sidebar-item'  id='eventosCalendario_menu' >
							<a class='sidebar-link' href='eventosCalendario' >
							<i class='fa-solid fa-calendar'></i><span class='align-middle'>Calendario</span>
							</a>
						</li>
						
						</div>

						</div>


						<li class='sidebar-header' id='menu_materias_primas'>
							Materias Primas
						</li>


						<div class='hide_menu' id='menu_materias_primas_item'> 
						<li class='sidebar-item' id='generargranalla_menu' >
							<a class='sidebar-link' href='generargranalla'>
								<i class='align-middle fa-solid fa-mound fa-2xs'></i> <span class='align-middle'>Carga granalla</span>
							</a>
						</li>

						<li class='sidebar-item' id='informaciongranalla_menu' >
							<a class='sidebar-link' href='informaciongranalla'>
								<i class='align-middle fa-solid fa-mound fa-2xs'></i> <span class='align-middle'>Info Carga Granalla</span>
							</a>
						</li>
						</div>


						
						

						<li class='sidebar-header' id='menu_bodegas'>
						Bodega
						</li>

						<div class='hide_menu' id='menu_bodegas_item'> 
					<li class='sidebar-item' id='stockgranalla_menu'>
						<a class='sidebar-link' href='stockgranalla'>
							<i class='align-middle fa-solid fa-mound fa-2xs'></i> <span class='align-middle'>Stock Granalla</span>
						</a>
					</li>
					<li class='sidebar-item' id='solicitudes_menu'>
						<a class='sidebar-link' href='solicitudes'>
							<i class='align-middle fa-solid fa-mound fa-2xs'></i> <span class='align-middle'>Solicitudes Granalla</span>
						</a>
					</li>
					<li class='sidebar-item' id='movbodega_menu'>
						<a class='sidebar-link' href='movbodega'>
							<i class='align-middle fa-solid fa-mound fa-2xs'></i> <span class='align-middle'>Movimientos de bodega</span>
						</a>
					</li>
					<li class='sidebar-item' id='pedidosclientes_menu'>
							<a class='sidebar-link' href='pedidosclientes'>
								<i class='align-middle fa-solid fa-circle-user fa-2xs'></i> <span class='align-middle'>Despachos</span>
							</a>
						</li>
							
					</div>


					<li class='sidebar-header' id='menu_mantenimiento'>
						Mantenimiento
					</li>
						

					<div class='hide_menu' id='menu_mantenimiento_item'> 
					<li class='sidebar-item' id='menu_partes_maquinas'>
							<a class='sidebar-link' href='partesMaquinas'>
								<i class='align-middle fa-solid fa-circle-user fa-2xs'></i> <span class='align-middle'>Partes Maquinas</span>
							</a>
						</li>

					</div>


					<li class='sidebar-header' id='menu_inplanttv'>
					Inplant TV
					</li>

					<div class='hide_menu' id='menu_inplanttv_item'> 
					<li class='sidebar-item' id='menuinplanttv'>
							<a class='sidebar-link' href='inplanttv'>
								<i class='align-middle fa-solid fa-gears fa-2xs'></i> <span class='align-middle'>Maquinas</span>
							</a>
						</li>

					</div>



					<li class='sidebar-header'></li>

						<li class='sidebar-header'></li>

						<li class='sidebar-item' id='LiSalircuatro'>
							<a class='sidebar-link' href='salir'>
								<i class='align-middle fa-solid fa-door-open fa-2xs'></i><span class='align-middle'>Salir</span>
							</a>
						</li>
						
						";
						} elseif ($_SESSION["produccion"] == 1 and $_SESSION["maquinas"] == 0 and $_SESSION["bodega"] == 1 and $_SESSION["mantenimiento"] == 1) {
							echo "

						<li class='sidebar-item active' id='dashclientes_menu'>
							<a class='sidebar-link' href='dashclientes'>
								<i class='align-middle fa-solid fa-house fa-2xs'></i> <span class='align-middle'>Home</span>
							</a>
						</li>

						<li class='sidebar-header' id='menu_produccion' >
							Producción
						</li>

						<div class='hide_menu' id='menu_produccion_item'> 
						<li class='sidebar-item' id='proyectos_menu' >
							<a class='sidebar-link' href='proyectos' >
								<i class='align-middle fa-solid fa-mound fa-2xs'></i> <span class='align-middle'>Proyectos</span>
							</a>
						</li>


						<li class='sidebar-item' id='vagones_menu' >
							<a class='sidebar-link' href='vagones' >
								<i class='align-middle fa-solid fa-mound fa-2xs'></i> <span class='align-middle'>Generar vagón</span>
							</a>
						</li>

						<li class='sidebar-item' id='reportevagones_menu' >
							<a class='sidebar-link' href='reportevagones' >
								<i class='align-middle fa-solid fa-list-ol fa-2xs'></i> <span class='align-middle'>Info Vagones</span>
							</a>
						</li>

						<li class='sidebar-item'  id='supervisores_menu' >
							<a class='sidebar-link' href='supervisores' >
							<i class='align-middle fa-solid fa-user-tie fa-2xs'></i><span class='align-middle'>Supervisores</span>
							</a>
						</li>

						<li class='sidebar-item' id='maqclientes_menu' >
							<a class='sidebar-link' href='maqclientes' >
								<i class='align-middle fa-solid fa-gears fa-2xs'></i> <span class='align-middle'>Maquinas</span>
							</a>
						</li>

						</div>


						<li class='sidebar-header' id='menu_bodegas'>
						Bodega
						</li>

						<div class='hide_menu' id='menu_bodegas_item'> 
					<li class='sidebar-item' id='stockgranalla_menu'>
						<a class='sidebar-link' href='stockgranalla'>
							<i class='align-middle fa-solid fa-mound fa-2xs'></i> <span class='align-middle'>Stock Granalla</span>
						</a>
					</li>
					<li class='sidebar-item' id='solicitudes_menu'>
						<a class='sidebar-link' href='solicitudes'>
							<i class='align-middle fa-solid fa-mound fa-2xs'></i> <span class='align-middle'>Solicitudes Granalla</span>
						</a>
					</li>
					<li class='sidebar-item' id='movbodega_menu'>
						<a class='sidebar-link' href='movbodega'>
							<i class='align-middle fa-solid fa-mound fa-2xs'></i> <span class='align-middle'>Movimientos de bodega</span>
						</a>
					</li>
					<li class='sidebar-item' id='pedidosclientes_menu'>
							<a class='sidebar-link' href='pedidosclientes'>
								<i class='align-middle fa-solid fa-circle-user fa-2xs'></i> <span class='align-middle'>Despachos</span>
							</a>
						</li>
							
					</div>


					<li class='sidebar-header' id='menu_manto'>
						Mantenimiento
						</li>
						
					<li class='sidebar-header'></li>

						<li class='sidebar-header'></li>

						<li class='sidebar-item' id='LiSalircuatro'>
							<a class='sidebar-link' href='salir'>
								<i class='align-middle fa-solid fa-door-open fa-2xs'></i><span class='align-middle'>Salir</span>
							</a>
						</li>
						
						";
						} elseif ($_SESSION["produccion"] == 1 and $_SESSION["maquinas"] == 1 and $_SESSION["bodega"] == 0 and $_SESSION["mantenimiento"] == 1) {
							echo "

						<li class='sidebar-item active' id='dashclientes_menu'>
							<a class='sidebar-link' href='dashclientes'>
								<i class='align-middle fa-solid fa-house fa-2xs'></i> <span class='align-middle'>Home</span>
							</a>
						</li>

						<li class='sidebar-header' id='menu_produccion' >
							Producción
						</li>

						<div class='hide_menu' id='menu_produccion_item'> 
						<li class='sidebar-item' id='proyectos_menu' >
							<a class='sidebar-link' href='proyectos' >
								<i class='align-middle fa-solid fa-mound fa-2xs'></i> <span class='align-middle'>Proyectos</span>
							</a>
						</li>


						<li class='sidebar-item' id='vagones_menu' >
							<a class='sidebar-link' href='vagones' >
								<i class='align-middle fa-solid fa-mound fa-2xs'></i> <span class='align-middle'>Generar vagón</span>
							</a>
						</li>

						<li class='sidebar-item' id='reportevagones_menu' >
							<a class='sidebar-link' href='reportevagones' >
								<i class='align-middle fa-solid fa-list-ol fa-2xs'></i> <span class='align-middle'>Info Vagones</span>
							</a>
						</li>

						<li class='sidebar-item'  id='supervisores_menu' >
							<a class='sidebar-link' href='supervisores' >
							<i class='align-middle fa-solid fa-user-tie fa-2xs'></i><span class='align-middle'>Supervisores</span>
							</a>
						</li>

						<li class='sidebar-item' id='maqclientes_menu' >
							<a class='sidebar-link' href='maqclientes' >
								<i class='align-middle fa-solid fa-gears fa-2xs'></i> <span class='align-middle'>Maquinas</span>
							</a>
						</li>

						</div>


						<li class='sidebar-header' id='menu_materias_primas'>
							Materias Primas
						</li>


						<div class='hide_menu' id='menu_materias_primas_item'> 
						<li class='sidebar-item' id='generargranalla_menu' >
							<a class='sidebar-link' href='generargranalla'>
								<i class='align-middle fa-solid fa-mound fa-2xs'></i> <span class='align-middle'>Carga granalla</span>
							</a>
						</li>

						<li class='sidebar-item' id='informaciongranalla_menu' >
							<a class='sidebar-link' href='informaciongranalla'>
								<i class='align-middle fa-solid fa-mound fa-2xs'></i> <span class='align-middle'>Info Carga Granalla</span>
							</a>
						</li>
						</div>




					<li class='sidebar-header' id='menu_manto'>
						Mantenimiento
						</li>
						
					<li class='sidebar-header'></li>

						<li class='sidebar-header'></li>

						<li class='sidebar-item' id='LiSalircuatro'>
							<a class='sidebar-link' href='salir'>
								<i class='align-middle fa-solid fa-door-open fa-2xs'></i><span class='align-middle'>Salir</span>
							</a>
						</li>
						
						";
						} elseif ($_SESSION["produccion"] == 1 and $_SESSION["maquinas"] == 1 and $_SESSION["bodega"] == 1 and $_SESSION["mantenimiento"] == 0) {
							echo "

						<li class='sidebar-item active' id='dashclientes_menu'>
							<a class='sidebar-link' href='dashclientes'>
								<i class='align-middle fa-solid fa-house fa-2xs'></i> <span class='align-middle'>Home</span>
							</a>
						</li>

						<li class='sidebar-header' id='menu_produccion' >
							Producción
						</li>

						<div class='hide_menu' id='menu_produccion_item'> 
						<li class='sidebar-item' id='proyectos_menu' >
							<a class='sidebar-link' href='proyectos' >
								<i class='align-middle fa-solid fa-mound fa-2xs'></i> <span class='align-middle'>Proyectos</span>
							</a>
						</li>


						<li class='sidebar-item' id='vagones_menu' >
							<a class='sidebar-link' href='vagones' >
								<i class='align-middle fa-solid fa-mound fa-2xs'></i> <span class='align-middle'>Generar vagón</span>
							</a>
						</li>

						<li class='sidebar-item' id='reportevagones_menu' >
							<a class='sidebar-link' href='reportevagones' >
								<i class='align-middle fa-solid fa-list-ol fa-2xs'></i> <span class='align-middle'>Info Vagones</span>
							</a>
						</li>

						<li class='sidebar-header' id='sub_menu_Turno' >
							Turno
						</li>

						<div class='hide_menu' id='menu_bodegas_item'> 
						<li class='sidebar-item'  id='alta_turno_menu' >
							<a class='sidebar-link' href='' >
							<i class='align-middle fa-solid fa-user-tie fa-2xs'></i><span class='align-middle'>Alta Turnoa</span>
							</a>
						</li>
						
						
						</div>
						


						<li class='sidebar-item'  id='supervisores_menu' >
							<a class='sidebar-link' href='supervisores' >
							<i class='align-middle fa-solid fa-user-tie fa-2xs'></i><span class='align-middle'>Supervisores</span>
							</a>
						</li>

						<li class='sidebar-item' id='maqclientes_menu' >
							<a class='sidebar-link' href='maqclientes' >
								<i class='align-middle fa-solid fa-gears fa-2xs'></i> <span class='align-middle'>Maquinas</span>
							</a>
						</li>

						</div>


						<li class='sidebar-header' id='menu_materias_primas'>
							Materias Primas
						</li>


						<div class='hide_menu' id='menu_materias_primas_item'> 
						<li class='sidebar-item' id='generargranalla_menu' >
							<a class='sidebar-link' href='generargranalla'>
								<i class='align-middle fa-solid fa-mound fa-2xs'></i> <span class='align-middle'>Carga granalla</span>
							</a>
						</li>

						<li class='sidebar-item' id='informaciongranalla_menu' >
							<a class='sidebar-link' href='informaciongranalla'>
								<i class='align-middle fa-solid fa-mound fa-2xs'></i> <span class='align-middle'>Info Carga Granalla</span>
							</a>
						</li>
						</div>


						
						

						<li class='sidebar-header' id='menu_bodegas'>
						Bodega
						</li>

						<div class='hide_menu' id='menu_bodegas_item'> 
					<li class='sidebar-item' id='stockgranalla_menu'>
						<a class='sidebar-link' href='stockgranalla'>
							<i class='align-middle fa-solid fa-mound fa-2xs'></i> <span class='align-middle'>Stock Granalla</span>
						</a>
					</li>
					<li class='sidebar-item' id='solicitudes_menu'>
						<a class='sidebar-link' href='solicitudes'>
							<i class='align-middle fa-solid fa-mound fa-2xs'></i> <span class='align-middle'>Solicitudes Granalla</span>
						</a>
					</li>
					<li class='sidebar-item' id='movbodega_menu'>
						<a class='sidebar-link' href='movbodega'>
							<i class='align-middle fa-solid fa-mound fa-2xs'></i> <span class='align-middle'>Movimientos de bodega</span>
						</a>
					</li>
					<li class='sidebar-item' id='pedidosclientes_menu'>
							<a class='sidebar-link' href='pedidosclientes'>
								<i class='align-middle fa-solid fa-circle-user fa-2xs'></i> <span class='align-middle'>Despachos</span>
							</a>
						</li>
							
					</div>


				
					<li class='sidebar-header'></li>

						<li class='sidebar-header'></li>

						<li class='sidebar-item' id='LiSalircuatro'>
							<a class='sidebar-link' href='salir'>
								<i class='align-middle fa-solid fa-door-open fa-2xs'></i><span class='align-middle'>Salir</span>
							</a>
						</li>
						
						";
						}



						break;

					case "Cliente operador":
						echo "
	
							<li class='sidebar-item active'>
								<a class='sidebar-link' href='dashclientes'>
									<i class='align-middle fa-solid fa-house'></i> <span class='align-middle'>Inicio</span>
								</a>
							</li>
	
						
							<li class='sidebar-item'>
								<a class='sidebar-link' href='maquinas'>
									<i class='fa-solid fa-gears align-middle'></i> <span class='align-middle'>Maquinas</span>
								</a>
							</li>
	
							<li class='sidebar-item'>
								<a class='sidebar-link' href='#'>
									<i class='fa-solid fa-mound align-middle'></i> <span class='align-middle'>Producción</span>
								</a>
							</li>
	
							<li class='sidebar-item' id='LiSalircinco'>
							<a class='sidebar-link' href='salir'>
								<i class='align-middle fa-solid fa-door-open'></i><span class='align-middle'>Salir</span>
							</a>
						</li>
	
							";

						break;

					default:
						echo "Your favorite color is neither red, blue, nor green!";
				}
			}

			?>





		</ul>


	</div>
</nav>

<div class="modal fade" id="ModalDia" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title text-white">Modal Heading</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>
			<div class="card">
				<div class="card-body">
					<form class="row g-3 text-center">
						<div class="row mt-3">
							<div class="col-md-4 mb-3 text-center">
								<label for="">Fecha Del Día</label>
							</div>
							<div class="col-md-8 mb-3 text-center">
								<button type="button" class="btn btn-outline-info col-12 mx-auto" id="btnhoy">Generar</button>
							</div>
							<div class="col-md-4 text-center">
								<label for="">Fecha Diario</label>
							</div>
							<div class="col-md-8 mb-3 text-center">
								<div class="form-group">
									<input type="text" class="form-control" id="daypickersel" placeholder="Seleccionar Día">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.es.min.js" integrity="sha512-3chOMtjYaSa9m2bCC8qGxmEcX449u63D1fMXMQdueS3/XgE12iHQdmZVXVVbhBLc9i7h9WUuuM15B0CCE6Jtvg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
	function abreModal() {
		$(".modal-header").css("background-color", "#07B5E8");
		$(".modal-title").text("Fechas");
		$('#ModalDia').modal('show');

	}

	/*funcion para ocultar menu */

	// document.getElementById('menu_produccion_item').classList.remove('hide_menu');

	const buttonProduccion = document.getElementById("menu_produccion");


	if (buttonProduccion) {
		buttonProduccion.addEventListener("click", function() {
			let produccion = document.getElementById('menu_produccion_item');
			produccion.classList.toggle('hide_menu');


			// document.getElementById('menu_produccion_item').classList.remove('hide_menu');

		});
	}


	const buttonMateriasPrimas = document.getElementById("menu_materias_primas");


	if (buttonMateriasPrimas) {
		buttonMateriasPrimas.addEventListener("click", function() {
			let itemMaterias = document.getElementById('menu_materias_primas_item');
			itemMaterias.classList.toggle('hide_menu');
		});
	}


	const buttonBodega = document.getElementById("menu_bodegas");

	if (buttonBodega) {
		buttonBodega.addEventListener("click", function() {
			let itemMaterias = document.getElementById('menu_bodegas_item');
			itemMaterias.classList.toggle('hide_menu');
		});
	}

	const buttonMantenimiento = document.getElementById("menu_mantenimiento");

	if (buttonMantenimiento) {
		buttonMantenimiento.addEventListener("click", function() {
			let itemMaterias = document.getElementById('menu_mantenimiento_item');
			itemMaterias.classList.toggle('hide_menu');
		});
	}


	const buttonInplantv = document.getElementById("menu_inplanttv");

	if (buttonInplantv) {
		buttonInplantv.addEventListener("click", function() {
			let itemMaterias = document.getElementById('menu_inplanttv_item');
			itemMaterias.classList.toggle('hide_menu');
		});
	}


	

	const buttonTurno = document.getElementById("sub_menu_Turno");

	if (buttonTurno) {
		buttonTurno.addEventListener("click", function() {
			let itemMaterias = document.getElementById('sub_menu_Turno_item');
			itemMaterias.classList.toggle('hide_menu');
		});
	}

	// buttonBodega.addEventListener("click", function() {
	// 	let itemMaterias = document.getElementById('menu_bodegas_item');
	// 	itemMaterias.classList.toggle('hide_menu');
	// });

	const buttonVisitasTecnicas = document.getElementById("menu_visitas_tecnicas");
	buttonVisitasTecnicas.addEventListener("click", function() {
		let itemVisitas = document.getElementById('menu_visitas_tecnicas_item');
		itemVisitas.classList.toggle('hide_menu');
	});
</script>