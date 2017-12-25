<?php
Class createSession
{
  // Quickblox endpoints

  
function createQbSession($appId, $authKey, $authSecret, $login, $password) {

if (!$appId || !$authKey || !$authSecret || !$login || !$password) {

    return false;

  }
  //echo $QB_PATH_SESSION;die();

  // Generate signature

  $nonce = rand();

  $timestamp = time(); // time() method must return current timestamp in UTC but seems like hi is return timestamp in current time zone

  $signature_string = "application_id=" . $appId . "&auth_key=" . $authKey . "&nonce=" . $nonce . "&timestamp=" . $timestamp . "&user[login]=" . $login . "&user[password]=" . $password;

  print_r($signature_string);die();

  $signature = hash_hmac('sha1', $signature_string , $authSecret);

  // Build post body

  $post_body = http_build_query(array(

    'application_id' => $appId,

    'auth_key' => $authKey,

    'timestamp' => $timestamp,

    'nonce' => $nonce,

    'signature' => $signature,

    'user[login]' => $login,

    'user[password]' => $password

  ));



  // Configure cURL

  $curl = curl_init();

  curl_setopt($curl, CURLOPT_URL,'https://api.quickblox.com/session.json'); // Full path is - https://api.quickblox.com/session.json

  curl_setopt($curl, CURLOPT_POST, true); // Use POST

  curl_setopt($curl, CURLOPT_POSTFIELDS, $post_body); // Setup post body

  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Receive server response

  // Execute request and read response

  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

  $response = curl_exec($curl);

  print_r($response);die();
  $responseJSON = json_decode($response)->session;

  // $responseJSON = json_decode($response);

  // Check errors



  if ($responseJSON) {

    return $responseJSON;

  } else {

    $error = curl_error($curl). '(' .curl_errno($curl). ')';

    return $error;

  }

  

  // Close connection

  curl_close($curl);

}

}
?> 