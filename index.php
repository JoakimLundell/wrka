<?php
/*$url = 'https://slr.se/fretagslista/?city=&name=';
$html = file_get_contents($url);

//echo $html;

$dom = new DOMDocument();
$dom->loadHTML($html);

$xpath = new DOMXPath($dom);
$tags = $xpath->query('//div[@class="list-item"]');
foreach ($tags as $tag) {
    $node_value = trim($tag->nodeValue);
    echo $node_value."<br/>";
}*/

$curl = curl_init("http://testing-ground.scraping.pro/
             textlist");