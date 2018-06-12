<?php

session_start();

$_SESSION['apiURL'] = ""; //here the API URL

//we check for token set, debug on and if token is older than 4 hours
if (!isset($_SESSION['token']) || !(time() < $_SESSION['token_date'] + 14400)) {

  //username and password
  $data_string = '{
  "username": "",
  "password": ""
  }';

  $ch = curl_init($_SESSION['apiURL'].'/default/V1/integration/admin/token');
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'accept: application/json',
      'content-type: application/json;charset=utf-8'
  ));

  $_SESSION['token'] = json_decode(curl_exec($ch));
  $_SESSION['token_date'] = time();
  curl_close($ch);
}

// The headers for the curl request
$curlRequestHeaders = array(
  'accept: application/json',
  'content-type: application/json;charset=utf-8',
  "Authorization: Bearer ".$_SESSION['token']
);

// GET CATEGORIES
$ch = curl_init($_SESSION['apiURL'].'/all/V1/categories');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $curlRequestHeaders);
$result = json_decode(curl_exec($ch));

//build array of root's children
$rootCategory = $result->children_data;
foreach ($rootCategory as $categoryObj) {
  $categories[$categoryObj->id] = $categoryObj->name;
}

require 'template.php';

?>
