<?php
date_default_timezone_set('America/Mexico_City');
class ControladorGranalla
{
    static public function ctrTablaGranalla()
    {
        $respueta= ModeloGranalla::MdltablaGranalla();
        return $respueta;
    }
}
