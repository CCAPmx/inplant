<?php
date_default_timezone_set('America/Mexico_City');

if (isset($_POST["action"])) {
    $action = $_POST["action"];
    $controlador = new ControladorSolicitudesGranalla();

    switch ($action) {
        case "preChange":
            if (isset($_POST["pk"])) {
                $pkSolicitud = $_POST["pk"];
                $currentStatus = $_POST["currentStatus"];
                $result = $controlador->preChangeStatus($pkSolicitud, $currentStatus);
                
                if ($result == false) {
                    echo json_encode(["error" => "Server Error"]);
                }else {
                    echo json_encode(['ok' => 'Status updated successfully']);
                }
            }else {
                echo json_encode(["error" => "Missing field"]);
            }
            break;
        case "getStatusDetails":
            if (isset($_POST["pk"])) {
                $pkSolicitud = $_POST["pk"];
                
                $result = $controlador->getSolicitudByPK($pkSolicitud);
                
                if ($result == false) {
                    echo json_encode(["error" => "Server Error"]);
                }else {
                    echo json_encode(['response' => $result]);
                }
            }else {
                echo json_encode(["error" => "Missing field"]);
            }
            break;
        default:
            echo json_encode(["error" => "Acción no válida"]);
            break;
    }
}else {
    echo json_encode(["error" => "Missing field"]);
}

class ControladorSolicitudesGranalla
{
    private $token;

    public function __construct() {
        session_start();
        $this->token = $_SESSION["ccap"];
    }
    public function preChangeStatus($pkSolicitud, $currentStatus)
    {
        // Validar actual estatus para evitar la edicion por inspeccionar elemento
        $solicitud = $this->getSolicitudByPK($pkSolicitud);

        if (is_array($solicitud) && isset($solicitud['error'])) {
            return false;
        }
        
        if (isset($solicitud->data[0]->fieldData->status) && $solicitud->data[0]->fieldData->status == $currentStatus) {
            $result = $this->changeStatus($solicitud->data[0]->recordId, $currentStatus);
            return $result;
        }else {
            return false;
        }
    }
    public function changeStatus($recordId, $currentStatus)
    {
        $newStatus = "";
        $dateField = "";
        switch ($currentStatus) {
            case "Solicitada":
                $newStatus = "Recibida";
                $dateField = "fecha_recibida";
                break;
            case "Recibida":
                $newStatus = "Despachada";
                $dateField = "fecha_despacho";
                break;
            case "Despachada":
                $newStatus = "Entregada";
                $dateField = "fecha_entrega";
                break;
            case "Entregada":
                $newStatus = "Firmada de Conformidad";
                $dateField = "fecha_conformidad";
                break;
            case "Firmada de conformidad":
                $newStatus = "";
                $dateField = "";
                break;
        }

        $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/solicitudes_web/records/'.$recordId;
        $query = '{
            "fieldData": {
                 "status": "'.$newStatus.'",
                 "'.$dateField.'": "'.date("m/d/Y H:i:s", time()).'"
               }
            }';
            
        $response = $this->curl($host, $query, 'PATCH');
        
        if ($response) {
            return true;
        } else {
            return false;
        }

    }
    /**
     * Consultar datos de solicitud al API FileMaker
     * @param $pkSolicitud, pk de la solicitud
     **/
    public function getSolicitudByPK($pkSolicitud)
    {
        $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/solicitudes_web/_find?';
        $query = '{
            "query": [
                {
                "pk": "'.$pkSolicitud.'"
                }
            ]
            }';
        $response = $this->curl($host, $query, 'POST');
        
        if ($response) {
            $solicitudGranalla = $response->response;
            return $solicitudGranalla;
        } else {
            echo json_encode(["error" => "Empty data"]);
            return false;
        }
    }
    /**
     * Consultar datos de solicitud al API FileMaker
     * @param $host  pk de la solicitud
     * @param $body  cuerpo de la peticion
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
