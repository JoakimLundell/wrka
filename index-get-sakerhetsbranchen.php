<?php
require __DIR__ . '/vendor/autoload.php';
use \Curl\Curl;

header('Content-Type: application/json');

$url = 'https://sakerhetsbranschen.se/';
$html = file_get_contents($url);


$dom = new DOMDocument();
$internalErrors = libxml_use_internal_errors(true); // prevent error messages 
$content_utf = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'); // correct parsing of utf-8 chars
$dom->loadHTML($content_utf);

$xpath = new DOMXPath($dom);
$table = $xpath->query('//table[@id="front-end-datatable"]/tbody/tr');

//echo $html;

$array = [];

foreach($table as $row) {
    $name = trim($xpath->query('td', $row)->item(0)->nodeValue);
    $website = $xpath->query('td/a', $row)->item(0)->getAttribute('href');
    $street =  $xpath->query('td', $row)->item(1)->nodeValue;
    $zipcode =  $xpath->query('td', $row)->item(2)->nodeValue;
    $city =  $xpath->query('td', $row)->item(3)->nodeValue;
    $phone =  $xpath->query('td', $row)->item(4)->nodeValue;
    $lat = '';
    $lng = '';
   

    


        $url = 'https://geocode.xyz/'.$street.'+'.$city.'?json=1&region=SE';
        $curl = new \Curl\Curl();

        $curl->get($url);
        if ($curl->error) {
            echo $curl->error_code;
        }
        else {
            $response = $curl->response;
            $json = json_decode($response);
            $lat = $json->latt;
            $lng = $json->longt;
        }

        sleep(1);
        $curl->close();


    $tmp = array(  
        "name"=> $name, 
        "street"=> $street,
        "zipcode" => $zipcode,
        "city"=> $city,
        "phone"=> $phone,
        "email"=> $email,
        "website"=> $website,
        "latlng"=> '',
        "lat" => $lat,
        "lng" => $lng
    );

    array_push($array, $tmp);

    //eniro api key = OaZB_Fukt_7pTTLLB__rZoul6yO2dTKlfRUy-zsXLm8
    //eniro username = jocke@bluestripes.se
    // Not in use remove account
}




echo json_encode($array);

?>             