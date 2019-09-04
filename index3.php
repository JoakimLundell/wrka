<?php

header('Content-Type: application/json');

$url = 'https://slr.se/fretagslista/?city=&name=';
$html = file_get_contents($url);

//echo $html;

$dom = new DOMDocument();
$dom->loadHTML($html);

$xpath = new DOMXPath($dom);
$pins = $xpath->query('//div[@class="map_pins"]');

$json = "";
foreach ($pins as $pin) {
    $node_value = trim($pin->nodeValue);
    
    $json = json_decode($node_value); 
} 



echo json_encode($json);






?>             