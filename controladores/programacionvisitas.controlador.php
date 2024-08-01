<?php
class ControladorProgramacionVisitas
{
    private $token;
    private $fkCliente;

    public function __construct() {
        session_start();
        $this->token = $_SESSION["ccap"];
        $this->fkCliente = $_SESSION['fkEmpresa'];
    }
    public function getProgramaciones($fkCliente = null){
        $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/programacion_visitas_web/records';
        $body = '{
            "query": [
                {
                    "fkCliente": "'.$fkCliente.'"
                }
            ],
            "sort": [{
                "fieldName": "fecha","sortOrder": "descend"
            }]
            }';
        $response = $this->curl($host, '', 'GET');
        if ($response) {
            if(property_exists($response->response, 'data')){
                $programaciones = $response->response->data;
                return $this->convertProgramacionesArrayForView($programaciones);
            }else{
                echo json_encode(["error" => "Empty data"]);
                exit;
            }
            
        } else {
            echo json_encode(["error" => "Empty data"]);
            exit;
        }
    }
    public function createProgramacion($params){
        $fechaFormateada = date("m/d/Y", strtotime($params['fecha']));
        $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/programacion_visitas_web/records';
        $body = '{
                    "fieldData":
                        { 
                            "fecha": "'.$fechaFormateada.'", 
                            "visitador": "'.$params['nombre_visitador'].'", 
                            "fk_maquina" : "'.$params['fk_maquina'].'", 
                            "fk_cliente" : "'.$params['fk_cliente'].'", 
                            "observaciones" : "'.$params['observaciones'].'", 
                            "Cliente" : "'.$params['nombre_cliente'].'", 
                            "Nombre_maquina" : "'.$params['nombre_maquina'].'" 
                        } 
                }';
        $response = $this->curl($host, $body, 'POST');
        if ($response) {
            if(property_exists($response->response, 'data')){
                $programaciones = $response->response->data;
                return $this->convertProgramacionesArrayForView($programaciones);
            }else{
                echo json_encode(["error" => "Empty data"]);
                exit;
            }
            
        } else {
            echo json_encode(["error" => "Empty data"]);
            exit;
        }
    }
    public function getMaquinasbyPKCliente($pk_cliente){
        $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/maquinas_API_02/_find?';
        $body = '{
            "query": [
                {
                    "fk_cliente": "'.$pk_cliente.'"
                }
            ]
            }';
        $response = $this->curl($host, $body, 'POST');
        if ($response) {
            if(property_exists($response->response, 'data')){
                $maquinas = $response->response->data;
                return $this->convertMaquinasArrayForView($maquinas);
            }else{
                echo json_encode(["error" => "Empty data"]);
                exit;
            }
            
        } else {
            echo json_encode(["error" => "Empty data"]);
            exit;
        }
    }
    public function getIngenierosbyPKMaquina($pk_maquina){
        $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/IngenierosMaquinas_web/_find?';
        $body = '{
            "query": [
                {
                    "fk_maquina": "'.$pk_maquina.'"
                }
            ]
            }';
        $response = $this->curl($host, $body, 'POST');
        if ($response) {
            if(property_exists($response->response, 'data')){
                $ingenieros = $response->response->data;
                return $this->convertIngenierosArrayForView($ingenieros);
            }else{
                echo json_encode(["error" => "Empty data"]);
                exit;
            }
            
        } else {
            echo json_encode(["error" => "Empty data"]);
            exit;
        }
    }
    public function getClientes(){
        $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/clientes_web/records';
        $body = '';
        $response = $this->curl($host, $body, 'GET');
        if ($response) {
            if(property_exists($response->response, 'data')){
                $clientes = $response->response->data;
                return $this->convertClientesArrayForView($clientes);
            }else{
                echo json_encode(["error" => "Empty data"]);
                exit;
            }
            
        } else {
            echo json_encode(["error" => "Empty data"]);
            exit;
        }
    }
    private function convertProgramacionesArrayForView($data){
        
        $dataConverted = [];
        foreach ($data as $key => $value) {
            // Cambiar formato de fecha
            $fechaObj = DateTime::createFromFormat('m/d/Y', $value->fieldData->fecha);
            // Formatear la fecha al formato deseado
            $fechaFormateada = $fechaObj->format('d/m/Y');

            //$dataConverted[$key]['info'] = '<a class="more-info" data-index="' . $value->fieldData->pk . '"><i class="fas fa-info-circle fa-3x" style="color: #07b5e8;" width="30"></i></a><div style="display: none" class="spinner-border spinner-border-sm text-info" role="status"><span class="visually-hidden">Loading...</span></div>';
            $dataConverted[$key]['fecha'] = $fechaFormateada;
            $dataConverted[$key]['cliente'] = $value->fieldData->Cliente;
            $dataConverted[$key]['nombre_maquina'] = $value->fieldData->Nombre_maquina;
            $dataConverted[$key]['visitador'] = $value->fieldData->visitador;
            $dataConverted[$key]['observaciones'] = $value->fieldData->observaciones;
        }

        return $dataConverted;
    }
    private function convertMaquinasArrayForView($data){
        
        $dataConverted = [];
        foreach ($data as $key => $value) {
            $dataConverted[$key]['pk_maquina'] = $value->fieldData->pk;
            $dataConverted[$key]['nombre_maquina'] = $value->fieldData->descripcion;
            $dataConverted[$key]['cliente'] = $value->fieldData->cliente;
        }

        return $dataConverted;
    }
    private function convertIngenierosArrayForView($data){
        
        $dataConverted = [];
        foreach ($data as $key => $value) {
            $dataConverted[$key]['fk_ingeniero'] = $value->fieldData->fk_ingeniero;
            $dataConverted[$key]['nombre_ingeniero'] = $value->fieldData->NombreIngeniero;
        }

        return $dataConverted;
    }
    private function convertClientesArrayForView($data){
        
        $dataConverted = [];
        foreach ($data as $key => $value) {
            $dataConverted[$key]['pk_cliente'] = $value->fieldData->pk;
            $dataConverted[$key]['nombre_cliente'] = $value->fieldData->Nombre;
        }

        return $dataConverted;
    }
    /**
     * Ejecion de peticion
     * @param $host  pk de la solicitud
     * @param $body  cuerpo de la peticion
     * @param $protocol protocolo de la peticion
     **/
    private function curl($host, $body, $protocol) 
    {
        $additionalHeaders = "Authorization: Bearer " . $this->token;
        $ch = curl_init();
        curl_setopt($ch,  CURLOPT_URL, $host);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $protocol);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $additionalHeaders));
        $result = curl_exec($ch);
        curl_close($ch);
        
        if ($result === false) {
            echo json_encode(["error" => "Transaction error"]);
            return false;
        }

        $json_data = json_decode($result);

        if ($json_data === null) {
            echo json_encode(["error" => "Empty data"]);
            return false;
        }

        return $json_data;
    }
}
////////
date_default_timezone_set('America/Mexico_City');
$programacionVisitas = new ControladorProgramacionVisitas();
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'getAllProgramaciones':
            $data = $programacionVisitas->getProgramaciones();
            echo json_encode($data);
            break;
        case 'getMaquinas':
            $data = $programacionVisitas->getMaquinasbyPKCliente($_GET['pk']);
            echo json_encode($data);
            break;
        case 'getIngenieros':
            $data = $programacionVisitas->getIngenierosbyPKMaquina($_GET['pk']);
            echo json_encode($data);
            break;
        case 'getClientes':
            $data = $programacionVisitas->getClientes();
            echo json_encode($data);
            break;
    }
}elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'createVisita':
            $data = $programacionVisitas->createProgramacion($_POST);
            echo json_encode($data);
            break;
    }
}
?>