<?php
/**
 * Created by PhpStorm.
 * User: Ben
 * Date: 8/16/2015
 * Time: 8:46 PM
 */
require_once 'vendor/autoload.php';
use \Curl\Curl;

set_time_limit( 300 );
libxml_use_internal_errors(true);

$count = 2;
$countToQuit = 0;
$link = 'http://getwreckt.com/home/insult/';
$curl = new Curl();
$dom = new DOMDocument();
$bool = TRUE;

$insults = array();

while( $bool ){
    $curl->get( $link . $count );
    $dom->loadHTML( $curl->response );
    $selector = new DOMXPath( $dom );
    $result = $selector->query( '/html/body/header//h1' );
    $insult = $result[0]->nodeValue;
    if( isset( $insults[$insult] ) ){
        $count++;
        $countToQuit++;
    } else {
        $insults[$insult] = 1;
        $count++;
    }

    if( $countToQuit > 20 )
        break;

}
$curl->close();

$output = fopen("insults.txt", "w");

foreach( $insults as $key => $i )
    fwrite( $output, $key . PHP_EOL );

fclose( $output );
echo count( $insults );



?>
