<?php
session_start();
if (isset($_POST["pk"])) {
    $token= $_SESSION["ccap"];

     $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/vagones_web_detalle/_find';
     $payloadName = '{"query": [{"alias_produccion":"' . $_POST["alias"] .'", "fk_proyecto":"'. $_POST["pk"] . '"}],
     "sort":[
        {"fieldName": "resumen_presion_vagones::fecha_fin","sortOrder":"ascend"}]}';
     $requestAll = get_dataOne($host,$token,$payloadName); 
     $Contar = $requestAll->response->dataInfo->foundCount;
    

     
    $detallemaquinas = array(); //creamos un array
         for ($i = 0; $i < $Contar; $i++) {

            $alias_produccion=$requestAll->response->data[$i]->fieldData->{'alias_produccion'};
            $fk_maquina=$requestAll->response->data[$i]->fieldData->{'fk_maquina'};
            $fkProducto=$requestAll->response->data[$i]->fieldData->{'fkProducto'};
            $flag_granallado=$requestAll->response->data[$i]->fieldData->{'flag_granallado'};
            $fk_proyecto=$requestAll->response->data[$i]->fieldData->{'fk_proyecto'};
            $serie_proyecto=$requestAll->response->data[$i]->fieldData->{'serie_proyecto'};
            $consecutivo_cabina=$requestAll->response->data[$i]->fieldData->{'consecutivo_cabina'};
            $fkCliente=$requestAll->response->data[$i]->fieldData->{'fkCliente'};
            $fk_cliente_lersoft=$requestAll->response->data[$i]->fieldData->{'fk_cliente_lersoft'};
            $nombre_cabina=$requestAll->response->data[$i]->fieldData->{'nombre_cabina'};
            $fecha_granallado=$requestAll->response->data[$i]->fieldData->{'fecha_granallado'};
            $flag_regranallado=$requestAll->response->data[$i]->fieldData->{'flag_regranallado'};
            $fecha_api=$requestAll->response->data[$i]->fieldData->{'fecha_api'};
            $pk=$requestAll->response->data[$i]->fieldData->{'pk'};
            $veces_regranallado=$requestAll->response->data[$i]->fieldData->{'veces_regranallado'};
            $resumen_presion_vagones=$requestAll->response->data[$i]->portalData->{'resumen_presion_vagones'};
            // $Num = sizeof($resumen_presion_vagones);
             $Num = ($i + 1);
            
                $recordIduno=0;
                $recordIddos=0;
                $recordIdtres=0;
            

                $turnouno="";
                $turnodos="";
                $turnotres="";


                $fecha_iniciouno="";
                $fecha_iniciodos="";
                $fecha_iniciotres="";


                $fecha_finuno="";
                $fecha_findos="";
                $fecha_fintres="";


                $tiempo_totaluno="";
                $tiempo_totaldos="";
                $tiempo_totaltres="";


                $efe_granalladouno="";
                $efe_granalladodos="";
                $efe_granalladotres="";


                $flaguno="";
                $flagdos="";
                $flagtres="";
    

                $turnosuno="";
                $turnosdos="";
                $turnostres="";


                $tiempo_finuno="";
                $tiempo_findos="";
                $tiempo_fintres="";

                $tiempo_granalladouno="";
                $tiempo_granalladodos="";
                $tiempo_granalladotres="";
                

                $tiempo_realuno="";
                $tiempo_realdos="";
                $tiempo_realtres="";

                $tiempo_inactivouno="";
                $tiempo_inactivodos="";
                $tiempo_inactivotres="";


            if ($Num==1){
                $array =$resumen_presion_vagones[0] ;
                if (empty($array)) {
                    $recordIduno=0;
                    $turnouno="";
                    $fecha_iniciouno="";
                    $fecha_finuno="";
                    $tiempo_totaluno="";
                    $efe_granalladouno="";
                    $flaguno="";
                    $turnosuno="";
                    $tiempo_finuno="";
                    $tiempo_granalladouno="";
                    $tiempo_realuno="";
                    $tiempo_inactivouno="";
                } else {
                    foreach ( $array as $nombre => $hexa ) {
    
                        if($nombre=='recordId'){
                            $recordIduno=$hexa;
                        }
        
                        if($nombre=='resumen_presion_vagones::fecha_inicio'){
                            $fecha_iniciouno=$hexa;
                        }
        
                        if($nombre=='resumen_presion_vagones::fecha_fin'){
                            $fecha_finuno=$hexa;
                        }
        
        
                        if($nombre=='resumen_presion_vagones::tiempo_total'){
                            $tiempo_totaluno=$hexa;
                        }
        
        
                        if($nombre=='resumen_presion_vagones::efe_granallado'){
                            $efe_granalladouno=$hexa;
                        }
        
        
                        if($nombre=='resumen_presion_vagones::flag'){
                            $flaguno=$hexa;
                        }
        
        
                        if($nombre=='resumen_presion_vagones::turno'){
                            $turnosuno=$hexa;
                        }
        
                        if($nombre=='resumen_presion_vagones::tiempo_totalfin'){
                            $tiempo_finuno=$hexa;
                        }
        
        
                        if($nombre=='resumen_presion_vagones::tiempo_granallado'){
                            $tiempo_granalladouno=$hexa;
                        }
        
                        if($nombre=='resumen_presion_vagones::tiempo_real'){
                            $tiempo_realuno=$hexa;
                        }

                        if($nombre=='resumen_presion_vagones::tiempo_inactivo'){
                            $tiempo_inactivouno=$hexa;
                        }
        
                       
                    }
        
                }

            }else if($Num==2){

             

                
                $array =$resumen_presion_vagones[0] ;
                if (empty($array )) {
                    $recordIddos=0;
                    $turnodos="";
                    $fecha_iniciodos="";
                    $fecha_findos="";
                    $tiempo_totaldos="";
                    $efe_granalladodos="";
                    $flagdos="";
                    $turnosdos="";
                    $tiempo_findos="";
                    $tiempo_granalladodos="";
                    $tiempo_realdos="";
                    $tiempo_inactivodos="";
                } else {
                    foreach ( $array as $nombre => $hexa ) {
                        if($nombre=='recordId'){
                            $recordIddos=$hexa;
                        }
        
                        if($nombre=='resumen_presion_vagones::fecha_inicio'){
                            $fecha_iniciodos=$hexa;
                        }
        
                        if($nombre=='resumen_presion_vagones::fecha_fin'){
                            $fecha_findos=$hexa;
                        }
        
        
                        if($nombre=='resumen_presion_vagones::tiempo_total'){
                            $tiempo_totaldos=$hexa;
                        }
        
        
                        if($nombre=='resumen_presion_vagones::efe_granallado'){
                            $efe_granalladodos=$hexa;
                        }
        
        
                        if($nombre=='resumen_presion_vagones::flag'){
                            $flagdos=$hexa;
                        }
        
        
                        if($nombre=='resumen_presion_vagones::turno'){
                            $turnosdos=$hexa;
                        }
        
                        if($nombre=='resumen_presion_vagones::tiempo_totalfin'){
                            $tiempo_findos=$hexa;
                        }
        
        
                        if($nombre=='resumen_presion_vagones::tiempo_granallado'){
                            $tiempo_granalladodos=$hexa;
                        }
        
                        if($nombre=='resumen_presion_vagones::tiempo_real'){
                            $tiempo_realdos=$hexa;
                        }

                        if($nombre=='resumen_presion_vagones::tiempo_inactivo'){
                            $tiempo_inactivodos=$hexa;
                        }
        
                    }
                }


    
            }else if($Num==3){
                
               
               

                $array =$resumen_presion_vagones[0] ;
                if (empty($array)) {
                    $recordIdtres=0;
                    $turnotres="";
                    $fecha_iniciotres="";
                    $fecha_fintres="";
                    $tiempo_totaltres="";
                    $efe_granalladotres="";
                    $flagtres="";
                    $turnostres="";
                    $tiempo_fintres="";
                    $tiempo_granalladotres="";
                    $tiempo_realtres="";
                    $tiempo_inactivotres="";
                } else {        
                foreach ( $array as $nombre => $hexa ) {
                    if($nombre=='recordId'){
                        $recordIdtres=$hexa;
                    }
    
                    if($nombre=='resumen_presion_vagones::fecha_inicio'){
                        $fecha_iniciotres=$hexa;
                    }
    
                    if($nombre=='resumen_presion_vagones::fecha_fin'){
                        $fecha_fintres=$hexa;
                    }
    
    
                    if($nombre=='resumen_presion_vagones::tiempo_total'){
                        $tiempo_totaltres=$hexa;
                    }
    
    
                    if($nombre=='resumen_presion_vagones::efe_granallado'){
                        $efe_granalladotres=$hexa;
                    }
    
    
                    if($nombre=='resumen_presion_vagones::flag'){
                        $flagtres=$hexa;
                    }
    
    
                    if($nombre=='resumen_presion_vagones::turno'){
                        $turnostres=$hexa;
                    }
    
                    if($nombre=='resumen_presion_vagones::tiempo_totalfin'){
                        $tiempo_fintres=$hexa;
                    }
    
    
                    if($nombre=='resumen_presion_vagones::tiempo_granallado'){
                        $tiempo_granalladotres=$hexa;
                    }
    
                    if($nombre=='resumen_presion_vagones::tiempo_real'){
                        $tiempo_realtres=$hexa;
                    }

                    if($nombre=='resumen_presion_vagones::tiempo_inactivo'){
                        $tiempo_inactivotres=$hexa;
                    }
    
                }
            }

            }


            

        // $fecha_inicio=$requestAll->response->data[$i]->fieldData->{'fecha_inicio'};
        // $fecha_fin=$requestAll->response->data[$i]->fieldData->{'fecha_fin'};
        // $tiempo_real=$requestAll->response->data[$i]->fieldData->{'tiempo_real'};
        // $tiempo_granallado=$requestAll->response->data[$i]->fieldData->{'tiempo_granallado'};
        // $eficiencia_total=$requestAll->response->data[$i]->fieldData->{'eficiencia_total'};
        // $tiempo_total=$requestAll->response->data[$i]->fieldData->{'tiempo_total'};

        $alias_produccion=$requestAll->response->data[$i]->fieldData->{'alias_produccion'};
        $fk_maquina=$requestAll->response->data[$i]->fieldData->{'fk_maquina'};
        $fkProducto=$requestAll->response->data[$i]->fieldData->{'fkProducto'};
        $flag_granallado=$requestAll->response->data[$i]->fieldData->{'flag_granallado'};
        $fk_proyecto=$requestAll->response->data[$i]->fieldData->{'fk_proyecto'};
        $serie_proyecto=$requestAll->response->data[$i]->fieldData->{'serie_proyecto'};
        $consecutivo_cabina=$requestAll->response->data[$i]->fieldData->{'consecutivo_cabina'};
        $fkCliente=$requestAll->response->data[$i]->fieldData->{'fkCliente'};
        $fk_cliente_lersoft=$requestAll->response->data[$i]->fieldData->{'fk_cliente_lersoft'};
        $nombre_cabina=$requestAll->response->data[$i]->fieldData->{'nombre_cabina'};
        $fecha_granallado=$requestAll->response->data[$i]->fieldData->{'fecha_granallado'};
        $flag_regranallado=$requestAll->response->data[$i]->fieldData->{'flag_regranallado'};
        $fecha_api=$requestAll->response->data[$i]->fieldData->{'fecha_api'};
        $pk=$requestAll->response->data[$i]->fieldData->{'pk'};
        $veces_regranallado=$requestAll->response->data[$i]->fieldData->{'veces_regranallado'};
        $resumen_presion_vagones=$requestAll->response->data[$i]->portalData->{'resumen_presion_vagones'};

           $detallemaquinas[] = array(
            'alias_produccion'=>$alias_produccion,
            'fk_maquina'=>$fk_maquina,
            'fkProducto'=>$fkProducto,
            'fk_proyecto'=>$fk_proyecto,
            'serie_proyecto'=>$serie_proyecto,
            'consecutivo_cabina'=>$consecutivo_cabina,
            'fkCliente'=>$fkCliente,
            'fk_cliente_lersoft'=>$fk_cliente_lersoft,
            'nombre_cabina'=>$nombre_cabina,
            'fecha_granallado'=>$fecha_granallado,
            'flag_regranallado'=>$flag_regranallado,
            'fecha_api'=>$fecha_api,
            'pk'=>$pk,
            'veces_regranallado'=>$veces_regranallado,
            'resumen_presion_vagones'=>$resumen_presion_vagones,

            
        
           'recordIduno'=> $recordIduno,
           'turnouno'=> $turnosuno, 
           'fecha_iniciouno'=> $fecha_iniciouno,  
           'fecha_finuno'=> $fecha_finuno , 
           'tiempo_realuno'=> $tiempo_realuno, 
           'tiempo_granalladouno'=> $tiempo_granalladouno, 
           'eficiencia_totaluno'=> $efe_granalladouno,  
           'tiempo_totaluno'=> $tiempo_totaluno,  
           'tiempo_inactivouno'=> $tiempo_inactivouno,
           'flaguno'=> $flaguno,

           'recordIddos'=> $recordIddos,
           'turnodos'=> $turnosdos, 
           'fecha_iniciodos'=> $fecha_iniciodos,  
           'fecha_findos'=> $fecha_findos , 
           'tiempo_realdos'=> $tiempo_realdos, 
           'tiempo_granalladodos'=> $tiempo_granalladodos, 
           'eficiencia_totaldos'=> $efe_granalladodos,  
           'tiempo_totaldos'=> $tiempo_totaldos,  
           'tiempo_inactivodos'=> $tiempo_inactivodos,
           'flagdos'=> $flagdos,


           'recordIdtres'=> $recordIdtres,
           'turnotres'=> $turnostres, 
           'fecha_iniciotres'=> $fecha_iniciotres,  
           'fecha_fintres'=> $fecha_fintres , 
           'tiempo_realtres'=> $tiempo_realtres, 
           'tiempo_granalladotres'=> $tiempo_granalladotres, 
           'eficiencia_totaltres'=> $efe_granalladotres,  
           'tiempo_totaltres'=> $tiempo_totaltres,  
           'tiempo_inactivotres'=> $tiempo_inactivotres,
           'flagtres'=> $flagtres
        
        );
      
      }
  
    $json_string = json_encode($detallemaquinas);
    echo  $json_string;
}



   


    function get_token($host,$username,$password,$payloadName) {
        $additionalHeaders = '';
        $ch = curl_init($host);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $additionalHeaders));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadName);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch); // Execute the cURL statement
        curl_close($ch); // Close the cURL connection
        $json_token = json_decode($result, true);
        $token_received = $json_token['response']['token'];
        return($token_received);
    
    };

    function get_dataAll($host,$token,$payloadName) {
        $additionalHeaders = "Authorization: Bearer ".$token;
        $ch = curl_init();
        curl_setopt($ch,  CURLOPT_URL , $host);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadName);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array( $additionalHeaders ));
        $result = curl_exec($ch);
        curl_close($ch);
        $json_data = json_decode($result);
        return $json_data;
    };


    function get_dataOne($host,$token,$payloadName) {
        $additionalHeaders = "Authorization: Bearer ".$token;
        $ch = curl_init();
        curl_setopt($ch,  CURLOPT_URL , $host);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadName);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', $additionalHeaders ));
        $result = curl_exec($ch);
        curl_close($ch);
        $json_data = json_decode($result);
        
        return $json_data;
    };
    
    
        
    
    function delete_token($host) {
    
        $additionalHeaders = '';
        $payloadName = '';
        $ch = curl_init($host);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $additionalHeaders));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); // Specify the request method as DELETE
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadName);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch); // Execute the cURL statement
        curl_close($ch); // Close the cURL connection
    
        // Return the result
        return($result);
    
    };
