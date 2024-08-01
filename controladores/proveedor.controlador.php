<?php
class ControladorProveedor{
    static public function ctrTablaProveedor(){
        $respueta= ModeloProveedor::MdltablaProv();
        return $respueta;
    }
}