<?php
date_default_timezone_set('America/Mexico_City');
class ControladorManto
{
    static public function ctrTablaManto()
    {
        $respueta= ModeloManto::MdltablaManto();
        return $respueta;
    }
}
