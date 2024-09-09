<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="vistas/recursos/sweetalert/css/sweetalert2.min.css">


<style>
	* {
		margin: 0;
		padding: 0;
		box-sizing: border-box;
		@import url('https://fonts.googleapis.com/css2?family=Radio+Canada+Big:ital,wght@0,400..700;1,400..700&display=swap');
	}

	body {
		background: #eaebef;
	}

	.nav {
		width: 300px
	}

	.nav_link {
		color: #303440;
		display: block;
		padding: 15px 0;
		text-decoration: none;
	}

	.nav_link--inside {
		border-radius: 6px;
		padding-left: 20px;
		-webkit-border-radius: 6px;
		-moz-border-radius: 6px;
		-ms-border-radius: 6px;
		-o-border-radius: 6px;
		text-align: left;
		color: #eaebef;
	}

	.nav_link--inside:hover {
		background: #f6f8fa;
		color: black;
	}

	.list {
		position: relative;
		left: -40px;
		width: 100%;
		height: 100vh;
		display: flex;
		/* justify-content: center; */
		flex-direction: column;
		border-radius: 0 16px 16px 0;
		background: #222e3c;

		-webkit-border-radius: 0 16px 16;
		-moz-border-radius: 0 16px 16;
		-ms-border-radius: 0 16px 16;
		-o-border-radius: 0 16px 16;
	}

	.list_item {
		list-style: none;
		width: 100%;
		text-align: center;
		overflow: hidden;
	}

	.list_item--click {
		cursor: pointer;
	}

	.list_button {
		display: flex;
		align-items: center;
		gap: 1rem;
		width: 80%;
		margin: 0 auto;
	}

	.list_img {
		color: rgb(233 236 239);
		text-decoration: none;
		border-left: 3px solid transparent;
		cursor: pointer;
		display: block;
		font-weight: 400;
		position: relative;
		font-family: 'Inter', Courier, monospace;
		font-size: 18px;

	}

	.arrow .list_arrow {
		transform: rotate(90deg);
		-webkit-transform: rotate(90deg);
		-moz-transform: rotate(90deg);
		-ms-transform: rotate(90deg);
		-o-transform: rotate(90deg);
	}

	.list_arrow {
		margin-left: auto;
		transition: transform 0.4s;
		-webkit-transition: transform;
		-moz-transition: transform;
		-ms-transition: transform;
		-o-transition: transform;
	}

	.list_show {
		margin: 5px;
		width: 80%;
		margin-left: auto;
		border-left: 2px solid #303440;
		list-style: none;
		height: 0;
		transition: height 0.4s;
		-webkit-transition: height 0.4s;
		-moz-transition: height 0.4s;
		-ms-transition: height 0.4s;
		-o-transition: height 0.4s;
	}

	.i_list_arrow {
		transform: rotate(90deg);
		/* Rota el ícono 90 grados a la izquierda */
		display: inline-block;
		/* Permite la transformación del ícono */
	}



	.a_nav {
		text-decoration: none !important;
	}
</style>

<div class="contenedor_nav">
	<nav class="nav sidebar js-sidebar">
		<ul class="list">

			<?php
			$Id = $_SESSION["tipousuarionombre"];

			// var_dump($Id);

			if ($Id != "") {
				switch ($Id) {
					case "SuperUsuario":
						include "menu/tipoUsuarioNombre.php";
						
						break;
					case "Ingenieros":
						include "menu/Ingenieros.php";
						break;
					default:
						echo "Your favorite color is neither red, blue, nor green!";
				}
			}
			?>








		</ul>
	</nav>
</div>




<script>
	let listElements = document.querySelectorAll(".list_button--click");


	listElements.forEach(listElement => {
		listElement.addEventListener("click", () => {
			listElement.classList.toggle("arrow");
			let height = 0;
			let menu = listElement.nextElementSibling;
			console.log(menu.scrollHeight);

			if (menu.clientHeight == 0) {
				height = menu.scrollHeight;
			}

			menu.style.height = `${height}px`;
		})
	});
</script>


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