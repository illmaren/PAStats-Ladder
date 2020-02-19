<?php 
class JiffyBox {

    function __construct($id=NULL) {
        define('HOST','https://api.jiffybox.de/1f6ELMXFzDu0dEhWFqbtUMvRZKRF3PqV/v1.0/');
        define('DEFAULT_PLAN_ID',10);
        $this->id = $id;
        if ($id) {
            $this->getInfo();

        }
        
    }
    
    function requestCurl( $id, $method='GET', $data=array(), $command='jiffyBoxes' ) {
    
        $ch = curl_init( HOST.$command.'/'.$id );
        
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );    
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, FALSE);
        
        if (strtoupper($method) == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1 );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query($data) ); 
        }
        if (strtoupper($method) == 'GET') curl_setopt($ch, CURLOPT_HTTPGET, 1 );
        if (strtoupper($method) == 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); 
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: ' . strlen($data)));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
        }

        if( !$data = curl_exec( $ch )) {
            echo "Curl execusion error.", curl_error( $ch ) ."\n";
            return FALSE;
        }
        if($data->messages[0]->type == 'error') {
            die($data->messages[0]->message);
        }

        curl_close( $ch );

        return $data;
    }

    
    function getInfo() {
        $json = $this->requestCurl($id = $this->id, $method = 'GET');
        $json = json_decode($json);
        if (is_object($json)) {
            foreach($json->result AS $var=>$value){
                $this->$var = $value;
            }
            return $json->result;
        }
        else {
            return FALSE;
        }
    }
    

    function getBackups() {
        $json = $this->requestCurl($id = $this->id, $method = 'GET',$data=NULL, $command='backups');
        return json_decode($json);
    }
    
    function create($name, $planid = DEFAULT_PLAN_ID, $backupid=NULL, $distribution=NULL, $password=NULL, $use_sshkey = TRUE, $metadata=NULL) {
        $data = array(
                    
                    'name' => $name,
                    'planid' => $planid,
                    'backupid' => $backupid,
                    'distribution' => $distribution,
                    'password' => $password,
                    'use_sshkey' => $use_sshke, 
                    'metadata' => $metadata
                );
        return $this->requestCurl($id = $this->id, $method = 'POST', $data);
    }
    
    function stop() {
        if ($this->getStatus() == 'READY') {
            $json = json_encode(array('status'=>'SHUTDOWN'));
            return $this->requestCurl($id = $this->id, $method = 'PUT', $data = $json);
        }
        else return FALSE;
    }
    
    function thaw($planid=DEFAULT_PLAN_ID) {
        if ($this->getStatus() == 'FROZEN') {
            $json = json_encode(array('status'=>'THAW', 'planid'=>$planid));
            return $this->requestCurl($id = $this->id, $method = 'PUT', $data = $json);
        }
        else return FALSE;
    }
    
    function freeze() {
        if ($this->getStatus() == 'READY') {
            $json = json_encode(array('status'=>'FREEZE'));
            return $this->requestCurl($id = $this->id, $method = 'PUT', $data = $json);
        }
        else return FALSE;
    }
    
    function start() {
        if ($this->getStatus() == 'READY') {
            $json = json_encode(array('status'=>'START'));
            return $this->requestCurl($id = $this->id, $method = 'PUT', $data = $json);
        }
        else return FALSE;
    }
    
    function getStatus() {
        $json = $this->requestCurl($id = $this->id, $method = 'GET', $data = NULL);        
        $json = json_decode($json);
        return $json->result->status;
    }
    
} 
?>