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
		width: 20%;
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
		gap: 0.5rem;
		/* Reducir el espacio entre el icono y el texto */
		width: 100%;
		/* Ajustar el ancho para ocupar todo el contenedor */
		padding: 10px 15px;
		/* Ajuste de padding para reducir el espacio vertical */
		margin: 0;
		/* Eliminar márgenes adicionales */
	}

	.list_img {
		color: rgb(233, 236, 239);
		text-decoration: none;
		border-left: 3px solid transparent;
		cursor: pointer;
		display: block;
		font-weight: 400;
		font-family: 'Inter', Courier, monospace;
		font-size: 16px;
		/* Ajustar el tamaño de la fuente para reducir el espacio */
		margin: 0;
		/* Eliminar márgenes adicionales */
		line-height: 1;
		/* Reducir el line-height para minimizar el espacio vertical */
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
		padding: 0;
		/* Reducir el padding alrededor de la flecha */
		font-size: 12px;
		/* Ajustar el tamaño de la flecha */
	}

	.list_show {
		height: 0;
		overflow: hidden;
		/* Ocultar contenido al contraer el submenú */
		transition: height 0.4s ease;
		/* Transición suave para la expansión y contracción */
		-webkit-transition: height 0.4s ease;
		-moz-transition: height 0.4s ease;
		-ms-transition: height 0.4s ease;
		-o-transition: height 0.4s ease;
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


	.list_button.active,
	.list_button--click.active {
		background-color: #1c2532;
	}

	.list_button.active a,
	.list_button--click.active a {
		color: #fff;
		font-weight: bold;
	}

	.list_show.open {
		height: auto !important;
		overflow: visible;
	}
</style>

<?php
// Configuración de la conexión
$dsn = 'mysql:host=localhost;dbname=lersanco_lersan;charset=utf8';
$username = 'root';
$password = '';

// $username = 'lersanco_lersan';
// $password = 'Q&h[)#[%C&{K';

try {
	// Crear una nueva instancia de PDO
	$pdo = new PDO($dsn, $username, $password);
	// Configurar PDO para que lance excepciones en caso de error
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo 'Error al conectar con la base de datos: ' . $e->getMessage();
	exit;
}
?>


<?php

$nombre_tipo_usuario = $_SESSION['tipousuarionombre'];
// Consulta para obtener los elementos del menú
$sql = "SELECT * FROM menu_items WHERE FIND_IN_SET(:nombre_tipo_usuario, tipo_usuario) > 0 ORDER BY parent_id, order_index";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':nombre_tipo_usuario', $nombre_tipo_usuario, PDO::PARAM_STR);
$stmt->execute();

$menu = [];

// Procesar los resultados de la consulta
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	if ($row['parent_id'] === NULL) {
		// Elemento de nivel superior
		$menu[$row['id']] = $row;
		$menu[$row['id']]['children'] = [];
	} else {
		// Si hay un parent_id, añadir este item a los children del padre
		if (isset($menu[$row['parent_id']])) {
			$menu[$row['parent_id']]['children'][] = $row;
		} else {
			// Inicializa una nueva entrada en caso de que el padre no se haya encontrado todavía
			$menu[$row['parent_id']] = ['children' => []];
			$menu[$row['parent_id']]['children'][] = $row;
		}
	}
}

// var_dump($menu);
?>


<?php
// function renderMenu($menu)
// {
// 	foreach ($menu as $item) {
// 		// Si el elemento del menú tiene subelementos
// 		if (!empty($item['children'])) {
// 			echo '<li class="list_item">
//                     <div class="list_button list_button--click">
//                         <i class="align-middle ' . htmlspecialchars($item['icon_class']) . '" style="color: #eaebef;"></i>
//                         <a href="' . htmlspecialchars($item['url']) . '" class="list_img a_nav">' . htmlspecialchars($item['name']) . '</a>
//                         <i class="fa-solid fa-chevron-up list_arrow i_list_arrow" style="color: #eaebef;"></i>
//                     </div>
//                     <ul class="list_show">';

// 			// Llamada recursiva para renderizar submenús
// 			renderMenu($item['children']);

// 			echo '</ul></li>';
// 		} else {
// 			// Si el elemento del menú no tiene subelementos
// 			echo '<li class="list_item">
//                     <div class="list_button">
//                         <i class="align-middle ' . htmlspecialchars($item['icon_class']) . '" style="color: #eaebef;"></i>
//                         <a href="' . htmlspecialchars($item['url']) . '" class="nav_link list_img a_nav">' . htmlspecialchars($item['name']) . '</a>
//                     </div>
//                 </li>';
// 		}
// 	}
// }


function markActiveItems(&$menu, $currentUrl)
{
    foreach ($menu as &$item) {
        $item['is_active'] = strpos($currentUrl, $item['url']) !== false;
        $item['is_open'] = false;

        if (!empty($item['children'])) {
            markActiveItems($item['children'], $currentUrl);

            // Si algún hijo está activo, el padre se debe marcar como abierto
            foreach ($item['children'] as $child) {
                if ($child['is_active'] || $child['is_open']) {
                    $item['is_open'] = true;
                    break;
                }
            }
        }
    }
}

$currentUrl = $_SERVER['REQUEST_URI'];
markActiveItems($menu, $currentUrl);


function renderMenu($menu)
{
    foreach ($menu as $item) {
        $isActive = !empty($item['is_active']) ? ' active' : '';
        $isOpen = !empty($item['is_open']) ? ' open' : '';

        if (!empty($item['children'])) {
            echo '<li class="list_item">
                    <div class="list_button list_button--click' . $isActive . '">';

            // ICONO: SVG personalizado o <i> estándar
            if ($item['icon_class'] === 'svg-piramide') {
                echo '<svg class="align-middle" style="width: 1.2em; height: 1.2em; fill: #eaebef; margin-right: 6px;" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="50" cy="10" r="5" />
                        <circle cx="40" cy="25" r="5" />
                        <circle cx="60" cy="25" r="5" />
                        <circle cx="30" cy="40" r="5" />
                        <circle cx="50" cy="40" r="5" />
                        <circle cx="70" cy="40" r="5" />
                        <circle cx="20" cy="55" r="5" />
                        <circle cx="40" cy="55" r="5" />
                        <circle cx="60" cy="55" r="5" />
                        <circle cx="80" cy="55" r="5" />
                      </svg>';
            } elseif ($item['icon_class'] === 'svg-greebrier') {
                echo '<img src="vistas/recursos/img/icons/letter-g_inversa.png" alt="Piramide" class="align-middle" style="width: 1.4em; height: 1.4em; margin-right: 6px;">';
            } else {
                echo '<i class="align-middle ' . htmlspecialchars($item['icon_class']) . '" style="color: #eaebef;"></i>';
            }

            echo '<a href="' . htmlspecialchars($item['url']) . '" class="list_img a_nav">' . htmlspecialchars($item['name']) . '</a>
                  <i class="fa-solid fa-chevron-up list_arrow i_list_arrow" style="color: #eaebef;"></i>
                </div>
                <ul class="list_show' . $isOpen . '" style="height:' . ($isOpen ? 'auto' : '0') . ';">';

            renderMenu($item['children']);

            echo '</ul></li>';
        } else {
            echo '<li class="list_item">
                    <div class="list_button' . $isActive . '">';

            if ($item['icon_class'] === 'svg-piramide') {
                echo '<svg class="align-middle" style="width: 1em; height: 1em; fill: #eaebef; margin-right: 6px;" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="50" cy="10" r="5" />
                        <circle cx="40" cy="25" r="5" />
                        <circle cx="60" cy="25" r="5" />
                        <circle cx="30" cy="40" r="5" />
                        <circle cx="50" cy="40" r="5" />
                        <circle cx="70" cy="40" r="5" />
                        <circle cx="20" cy="55" r="5" />
                        <circle cx="40" cy="55" r="5" />
                        <circle cx="60" cy="55" r="5" />
                        <circle cx="80" cy="55" r="5" />
                      </svg>';
            } elseif ($item['icon_class'] === 'svg-greebrier') {
                echo '<svg class="align-middle" style="width: 1em; height: 1em; stroke: #eaebef; fill: none; stroke-width: 6px; margin-right: 6px;" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                        <rect x="10" y="10" width="80" height="80" rx="20" ry="20" />
                        <path d="M65 40H55c0-10-6-15-15-15s-15 9-15 20v20c0 11 6 20 15 20s15-3 15-5v-15h-15v-15h30v25c0 3-10 15-30 15s-30-15-30-35V45c0-20 15-35 35-35s35 12 35 35" />
                      </svg>';
            } else {
                echo '<i class="align-middle ' . htmlspecialchars($item['icon_class']) . '" style="color: #eaebef;"></i>';
            }

            echo '<a href="' . htmlspecialchars($item['url']) . '" class="nav_link list_img a_nav">' . htmlspecialchars($item['name']) . '</a>
                  </div>
                </li>';
        }
    }
}




// Renderiza el menú principal
echo '<ul class="list">';
renderMenu($menu);
echo '</ul>';
?>






<script>
	document.addEventListener("DOMContentLoaded", function() {
		let listElements = document.querySelectorAll(".list_button--click");

		listElements.forEach(listElement => {
			listElement.addEventListener("click", () => {
				listElement.classList.toggle("arrow");
				let menu = listElement.nextElementSibling;

				// Comprobar la altura actual del submenú
				if (menu.clientHeight == 0) {
					menu.style.height = menu.scrollHeight + "px"; // Expande el submenú
				} else {
					menu.style.height = 0; // Contrae el submenú
				}
			});
		});
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