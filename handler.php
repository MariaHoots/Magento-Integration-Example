<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  exit("No direct access to this file, please start with index.php");
}

// The headers for the curl request
$curlRequestHeaders = array(
  'accept: application/json',
  'content-type: application/json;charset=utf-8',
  "Authorization: Bearer ".$_SESSION['token']
);

$productData = '
{
  "product": {
    "sku": "'.strip_tags(trim($_POST['sku'])).'",
    "name": "'.strip_tags(trim($_POST['productName'])).'",
    "price": '.strip_tags(trim($_POST['price'])).',
    "status": 1,
    "visibility": '.strip_tags(trim($_POST['visibility'])).',
    "type_id": "simple",
    "attribute_set_id":4,
    "weight": '.strip_tags(trim($_POST['weight'])).',
    "custom_attributes": [
    	{
    		"attribute_code": "description",
    		"value": "'.strip_tags(trim($_POST['description'])).'"
    	},
    	{
    		"attribute_code": "short_description",
    		"value": "'.strip_tags(trim($_POST['short_description'])).'"
    	},
    	{
    		"attribute_code": "category_ids",
    		"value": '.json_encode($_POST['categories']).'
    	}
    ]
  }
}
';

// POST product data
$ch = curl_init($_SESSION['apiURL'].'/V1/products');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $productData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $curlRequestHeaders);
$result = json_decode(curl_exec($ch));

if (isset($result->message)) {
  echo '<div class="alert alert-danger" role="alert">'.$result->message.'</div>';
  die();
} else {
  echo '<div class="alert alert-success" role="alert">Product <strong>'.$result->name.'</strong> with the ID '.$result->id.' was added!</div>';
}

//IMAGE UPLOAD
$productImage = '
{
  "entry": {
    "media_type": "image",
    "label": "Image",
    "position": 1,
    "disabled": false,
    "types": [
      "image",
      "small_image",
      "thumbnail"
    ],
    "content": {
      "base64EncodedData": "'.$_POST['image'].'",
      "type": "'.$_POST['imageMIME'].'",
      "name": "'.$_POST['imageName'].'"
    }
  }
}
';
$ch = curl_init($_SESSION['apiURL'].'/V1/products/'.strip_tags(trim($_POST['sku'])).'/media');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $productImage);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $curlRequestHeaders);
$result = json_decode(curl_exec($ch));

if (isset($result->message)) {
  echo '<div class="alert alert-danger" role="alert">'.$result->message.'</div>';
} else {
  echo '<div class="alert alert-success" role="alert">Image was uploaded</div>';
}

?>
