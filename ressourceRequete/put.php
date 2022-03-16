<?php
$url = "http://localhost/Epoka/api/parametre"; // modifier le produit 1
$data = array('forfaitJour' => '100', 'forfaitKm' => '0.01');
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
$response = curl_exec($ch);
var_dump($response);
if (!$response) 
{
    return false;
}
?>