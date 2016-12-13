<?php
require 'chatterbotapi.php';



$factory = new ChatterBotFactory();

$bot1 = $factory->create(ChatterBotType::CLEVERBOT);
$bot1session = $bot1->createSession();

$s = $_POST["message"];

function curl_get_contents($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;

}

if(preg_match("(^!gif)",$s)){
    $query = "";

    $result = explode('!gif', $s);

    $giphy = file_get_contents("http://api.giphy.com/v1/gifs/search?q=".urlencode($query)."&api_key=dc6zaTOxFJmzC");

    $jsonGiphy = json_decode($giphy, true);

    if(!empty($jsonGiphy['data'])) {
        $rep = '<img src="'.$jsonGiphy['data'][0]['images']['fixed_height']['url'].'">';
    } else {
        $rep = "Gif not found :(";
    }

} else if (preg_match("(^!wiki)",$s)) {
    $query = "";

    $result = explode('!wiki', $s);

    $query = $result[1];

    $url = 'https://en.wikipedia.org/w/api.php?action=query&prop=extracts&format=json&exintro=&titles='.urlencode($query);

    $wikiData = curl_get_contents($url);

    $jsonWiki = json_decode($wikiData, true);

    foreach($jsonWiki['query']['pages'] as $value) {
        $rep = $value['extract'];
    }
} else if (preg_match("(^!clear)",$s)) {
    echo '<script src="clear.js"></script>';
} else {
    $rep = $bot1session->think($s);
}



echo $rep;



