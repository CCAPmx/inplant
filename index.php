<?php
include "controladores/plantilla.controlador.php";
include "controladores/usuarios.controlador.php";
include "controladores/clientes.controlador.php";
include "controladores/notificacion.controlador.php";
include "controladores/granulometria.controlador.php";
include "controladores/contactos.controlador.php";
include "controladores/granalla.controlador.php";
include "controladores/movimientos.controlador.php";
include "controladores/maquinas.controlador.php";
include "controladores/mantenimiento.controlador.php";

include "modelos/usuarios.modelo.php";
include "modelos/clientes.modelo.php";
include "modelos/notificacion.modelo.php";
include "modelos/granulometria.modelo.php";
include "modelos/contactos.modelo.php";
include "modelos/granalla.modelo.php";
include "modelos/movimientos.modelo.php";
include "modelos/maquinas.modelo.php";
include "modelos/mantenimiento.modelo.php";
// include "modelos/MGranulometria.php";


$plantilla = new ControloadorPlantilla();
$plantilla->ctrPlantilla();

