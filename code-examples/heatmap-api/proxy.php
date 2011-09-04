<?php
try{
class RequestParams {
public $k;
public $u;
public $lat1;
public $lat2;
public $lon1;
public $lon2;
public $w;
public $h;
public $d;
public $b;
public $x;
}
$parameters = new RequestParams();
$parameters->k = $_REQUEST['k'];
$parameters->u = $_REQUEST['u'];
$parameters->lat1 = $_REQUEST['lat1'];
$parameters->lat2 = $_REQUEST['lat2'];
$parameters->lon1 = $_REQUEST['lon1'];
$parameters->lon2 = $_REQUEST['lon2'];
$parameters->w = $_REQUEST['w'];
$parameters->h = $_REQUEST['h'];
$parameters->d = $_REQUEST['d'];
$parameters->b = $_REQUEST['b'];

$parameters->x = $_REQUEST['x'];

ini_set("soap.wsdl_cache_enabled","0");
$client = new SoapClient("http://www.heatmapapi.com/HeatmapGenerate2WS.asmx?wsdl");
$i=$client->GetImagePathDecay($parameters);

print $i->GetImagePathDecayResult;
}
catch (Exception $e) {
echo $e -> getMessage ();
}
?>