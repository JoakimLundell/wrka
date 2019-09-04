<?php

header('Content-Type: application/json');

$url = 'https://slr.se/fretagslista/?city=&name=';
$html = file_get_contents($url);


$dom = new DOMDocument();
$internalErrors = libxml_use_internal_errors(true); // prevent error messages 
$content_utf = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'); // correct parsing of utf-8 chars
$dom->loadHTML($content_utf);

$xpath = new DOMXPath($dom);
$resellers = $xpath->query('//div[@class="list-item"]');

$pinsdata = $xpath->query('//div[@class="map_pins"]');
$pins = [];
foreach ($pinsdata as $data) {
    $node_value = trim($data->nodeValue);
    $pins = json_decode($node_value, true);    
}

$array = [];

foreach ($resellers as $node) {
    $id = $node->getAttribute('data-id'); 
    
    $latlng = getChoords($id, $pins);
    
    $name = $xpath->query('h5', $node)->item(0)->nodeValue;
    //echo $name->item(0)->nodeValue;
    
    $small = $xpath->query('small', $node);
    $license = $small->item(0)->nodeValue;
    $address = $small->item(1)->textContent;
    //echo $dom->saveXML($address);

    //echo $address;
    $phone = $xpath->query('div[@class="phone"]', $node)->item(0)->nodeValue;
    $email = $xpath->query('div[@class="email"]', $node)->item(0)->nodeValue;
    $website = $xpath->query('div[@class="website"]', $node)->item(0)->nodeValue;
    
    // get city from address
    preg_match('/[a-öA-Ö ]*$/', $address, $match);
    // add space in address
    preg_match('/[0-9]{3}[ ][0-9]{2}[a-öA-Ö ]*$/', $address, $zipcode);
    $street = str_replace($zipcode, '', $address);

    $ll = explode(",", $latlng);
    $lat = $ll[0];
    $lng = $ll[1];

    $tmp = array(
        "id"=> $id,
        "name"=> $name, 
        "license"=> $license,
        "street"=> $street,
        "zipcode" => $zipcode[0],
        "city"=> trim($match[0]),
        "phone"=> $phone,
        "email"=> $email,
        "website"=> $website,
        "latlng"=> $latlng,
        "lat" => $lat,
        "lng" => $lng

    );
    array_push($array, $tmp);
}

function getChoords(int $i, $pins) {
    foreach ($pins as $p) {
        if($i == $p['data-id']){
            return $p['latLng'];
        }
    }
    
    return false;
}

echo json_encode($array);

?>             