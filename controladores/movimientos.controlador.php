<?php
date_default_timezone_set('America/Mexico_City');
class ControladorMov
{
    static public function ctrTablaMov()
    {
        $respueta= ModeloMov::MdltablaMov();
        return $respueta;
    }
}