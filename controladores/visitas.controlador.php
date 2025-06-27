<?php
date_default_timezone_set('America/Mexico_City');
$visitasTecnicas = new ControladorVisitasTecnicas();
require __DIR__ . "/../modelos/MGranulometria.php";
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {

    switch ($_GET['action']) {
        case 'getAllVisitas':
            $data = $visitasTecnicas->getVisitaTecnicaSencilla();
            // header('Content-Type: application/json');
            echo json_encode($data);
            break;
        case 'getVisitaDetails':
            if (isset($_GET['pk'])) {
                $key = $_GET['pk'];
            } else {
                $key = '';
            }
            $data = $visitasTecnicas->getVisitaTecnicaCompleta($key);
            // header('Content-Type: application/json');

            // $dataGranumelitria  =  $visitasTecnicas->dataGranulometriaSelector($key);

            // var_dump($dataGranumelitria);

            // var_dump('getVisitaDetails');
            echo json_encode($data);
            break;
        case 'getVisitaTecnicaCompletaId':
            // echo 'getVisitaDetailsId';

            if (isset($_GET['id'])) {
                $key = $_GET['id'];
            } else {
                $key = '';
            }


            $data = $visitasTecnicas->getVisitaTecnicaCompletaId($key);
            // header('Content-Type: application/json');
            echo json_encode($data);

            break;

        case 'dataGranulometriaSelector':
            $key = isset($_GET['fkMaquina']) ? $_GET['fkMaquina'] : '';
            // var_dump($key);
            // $key = 00000000000;
            $data = $visitasTecnicas->dataGranulometriaSelector($key);
            header('Content-Type: application/json'); // Muy importante
            echo json_encode($data);
            break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'updateVisit':
            $result = $visitasTecnicas->updateVisitaTecnica($_POST['recordid'], $_POST['data']);
            if ($result == false) {
                echo json_encode(["error" => "Server Error"]);
            } else {
                echo json_encode(['ok' => 'Visit updated successfully']);
            }
            break;
    }
}


class ControladorVisitasTecnicas
{
    private $token;
    private $fkCliente;

    public function __construct()
    {
        session_start();
        $this->token = $_SESSION["ccap"];
        $this->fkCliente = $_SESSION['fkEmpresa'];
    }

    public function index()
    {
        return $this->getVisitaTecnicaSencilla();
    }
    public function getVisitaTecnicaSencilla()
    {
        $query = '_offset=1&_limit=10&_sort=[{%20%22fieldName%22%3A%20%22fecha%22%2C%20%22sortOrder%22%3A%20%22descend%22%20}]';
        $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/visita_tecnica_web_sencilla/records?' . $query;
        $body = '';
        // var_dump('gellVisitasTecnicaSencilla');
        $response = $this->curl($host, $body, 'GET');
        if ($response) {
            $visitasTecnicas = $response->response->data;
            // var_dump($visitasTecnicas);
            return $this->convertArrayForView($visitasTecnicas);
        } else {
            echo json_encode(["error" => "Empty data"]);
            return false;
        }
    }
    public function getVisitaTecnicaSencilla_V1()
    {
        $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/visita_tecnica_web_sencilla/_find?';
        $body = '{
            "query": [
                {
                    "fkCliente": "' . $this->fkCliente . '"
                }
            ],
            "sort": [{
                "fieldName": "fecha","sortOrder": "descend"
            }]
            }';
        $response = $this->curl($host, $body, 'POST');
        if ($response) {
            $visitasTecnicas = $response->response->data;
            return $this->convertArrayForView($visitasTecnicas);
        } else {
            echo json_encode(["error" => "Empty data"]);
            return false;
        }
    }


    public function getVisitaTecnicaCompleta($pk = '')
    {


        $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/visita_tecnica_web/_find?';
        if (!empty($pk)) {




            $body = '{
                "query": [
                    {
                        "pk": "' . $pk . '"
                    }
                ]
               
                }';
        } else {
            $body = '{
                "query": [
                    {
                        "fkCliente": "' . $this->fkCliente . '"
                    }
                ]
                
                }';
        }

        $response = $this->curl($host, $body, 'POST');

        // var_dump('response',$response);
        if ($response) {
            $visitasTecnicas = (isset($response->response->data)) ? $response->response->data : $response;
            return $visitasTecnicas;
        } else {
            echo json_encode(["error" => "Empty data"]);
            return false;
        }
    }

    public function getVisitaTecnicaCompletaId($id = '')
    {
        $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/visita_tecnica_web/_find?';

        // var_dump($id);
        if (!empty($id)) {
            $body = '{
                "query": [
                    {
                        "recordId": "' . $id . '"
                    }
                ]
                }';
        } else {
            $body = '{
                "query": [
                    {
                        "fkCliente": "' . $this->fkCliente . '"
                    }
                ]
                }';
        }

        $response = $this->curl($host, $body, 'POST');
        if ($response) {
            $visitasTecnicas = (isset($response->response->data)) ? $response->response->data : $response;
            return $visitasTecnicas;
        } else {
            echo json_encode(["error" => "Empty data"]);
            return false;
        }
    }
    public function updateVisitaTecnica($recordid, $data)
    {

        // var_dump($recordid, $data);
        $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/visita_tecnica_web/records/' . $recordid;
        $body = '{
            "fieldData":
                ' . $data . '
        }';
        // var_dump($body);
        $response = $this->curl($host, $body, 'PATCH');
        //DEBUG
        /*$response = json_decode('{
            "response": {
              "modId": "3"
            },
            "messages": [
              {
                "code": "0",
                "message": "OK"
              }
            ]
          }');*/

        // var_dump($response);

        // echo json_encode($response);

        // if (isset($response->messages[0]->message) && $response->messages[0]->message == 'OK') {
        //     return true;
        // } else {
        //     return false;
        // }

        if (isset($response->messages[0]->message) && $response->messages[0]->message == 'OK') {
            echo json_encode([
                'success' => true,
                'message' => 'Actualización realizada correctamente',
                'modId' => $response
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Error al actualizar',
                'detalle' => $response->messages[0]->message ?? 'Respuesta inesperada'
            ]);
        }
        exit;
    }

    public function dataGranulometriaSelector($procesador)
    {
        $obj = new mainGranulometria();
        $respueta = $obj->dataGranulometriaSelector($procesador);
        return $respueta;
    }

    private function convertArrayForView($data)
    {
        // var_dump($data);
        $dataConverted = [];
        foreach ($data as $key => $value) {
            // Cambiar formato de fecha
            $fechaObj = DateTime::createFromFormat('m/d/Y', $value->fieldData->fecha);
            // var_dump($fechaObj);
            // Formatear la fecha al formato deseado
            $fechaFormateada = $fechaObj->format('d/m/Y');

            $dataConverted[$key]['info'] = '<a class="more-info" data-index="' . $value->fieldData->pk . '"><i class="fas fa-info-circle fa-3x" style="color: #07b5e8;" width="30"></i></a><div style="display: none" class="spinner-border spinner-border-sm text-info" role="status"><span class="visually-hidden">Loading...</span></div>';
            $dataConverted[$key]['fecha'] = $fechaFormateada;
            $dataConverted[$key]['nombre_usuario'] = $value->fieldData->nombre_usuario;
            $dataConverted[$key]['nombre_maquina'] = $value->fieldData->nombre_maquina;
            $dataConverted[$key]['nombre_cliente'] = $value->fieldData->nombre_cliente;
            $dataConverted[$key]['fkCliente'] = $value->fieldData->fkCliente;
            $dataConverted[$key]['zzHcreo'] = $value->fieldData->zzHcreo;
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
