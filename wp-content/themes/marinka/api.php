<?php

//libxml_disable_entity_loader(false);

class MMKStruct{
    public function __construct($a){
        $i = 0;
        foreach ($a as $var => $val) {
            $varName = 'in'.$i;
            $this->varName = $val;
            $i++;
        }
    }
}


//echo 'Curl: ', function_exists('curl_version') ? 'Enabled' : 'Disabled';
$opts = array(
    'ssl' => array(
        'ciphers' => 'RC4-SHA',
        'verify_peer' => false,
        'verify_peer_name' => false,
        'http' => array(
            'user_agent' => 'PHPSoapClient'
        )

    )
);
$params = array(
    'encoding' => 'UTF-8',
    'verifypeer' => false,
    'verifyhost' => false,
    'soap_version' => SOAP_1_2,
    'trace' => 1,
    'exceptions' => 1,
    'connection_timeout' => 180,
    'stream_context' => stream_context_create($opts)
);


$wsdl = 'https://www.booking-manager.com/cbm_web_service2/services/CBM?wsdl';

$soapClient = new SoapClient($wsdl, $params);



try{
    $struct = new MMKStruct(array('3497', 'office@sea-time.co.il', 'seatime0', '225', '2019', 'true', 0));

    $result = $soapClient->getAvaliabilityInfo($struct);

    if (isset($result->out)){
        $xml = $result->out;
        echo $xml;
    }
}catch (Exception $e){
    print_r($soapClient->__getLastRequest());
    print_r($soapClient->__getLastResponse());
    print_r($e->getTrace());
    var_dump($e);
}