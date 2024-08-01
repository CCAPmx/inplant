<?php
date_default_timezone_set('America/Mexico_City');
class ControladorNotificacion
{
 
    static public function ctrCbmnotificacion()
    {
        $respuesta = ModeloNotificacion::MdlCombo();
        return $respuesta ; 
    }
 
}
