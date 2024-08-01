<?php
date_default_timezone_set('America/Mexico_City');
class ControladorContacto
{
    static public function ctrTablaContacto()
    {
        $respueta= ModeloContacto::MdltablaContacto();
        return $respueta;
    }
}
