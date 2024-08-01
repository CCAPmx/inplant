<?php
date_default_timezone_set('America/Mexico_City');
class ControladorMaquinas
{
    static public function ctrTablaMaquinas()
    {
        $respueta= ModeloMaquinas::MdltablaMaquinas();
        return $respueta;
    }
}