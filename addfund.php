<?php
require 'config.php';

$curl = curl_init();
$reference = isset($_GET['reference']) ? $_GET['reference'] : '';
if(!$reference){
  die('No reference supplied');
}

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER => [
    "accept: application/json",
    "authorization: Bearer " . PAYSTACK_SECRET,
    "cache-control: no-cache"
  ],
));

$response = curl_exec($curl);
$err = curl_error($curl);

if($err){
    // there was an error contacting the Paystack API
  die('Curl returned error: ' . $err);
}

$tranx = json_decode($response);

if(!$tranx->status){
  // there was an error from the API
  die('API returned error: ' . $tranx->message);
}

if('success' == $tranx->data->status){
  // transaction was successful...
  // please check other things like whether you already gave value for this ref
  // if the email matches the customer who owns the product etc
  // Give value
  header("content-type: application/json");

  // uncomment this line if you want to see the payment data
  //echo $response;
  //die();
  
  if ( $tranx->data->customer->email == $_SESSION['user']['email']) {
      // update the user wallet
      $user = $_SESSION['user']['id'];
      $amount = $tranx->data->amount  / 100;
      $sql = "UPDATE `wallets` SET amount = amount + '$amount' WHERE user = $user";
      $stmt = $db->query($sql);
      
      // redirect to wallet
      header("Location:index.php");
  }
}