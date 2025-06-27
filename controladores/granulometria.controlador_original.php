<?php
date_default_timezone_set('America/Mexico_City');
class ControladorGranulo
{
    static public function ctrTablaGranulo()
    {
        $respueta= ModeloGranulo::MdltablaGranulo();
        return $respueta;
    }


    static public function dataGranulometria($procesador)
    {
        $respueta= ModeloGranulo::dataGranulometria($procesador);
        return $respueta;
    }
}
