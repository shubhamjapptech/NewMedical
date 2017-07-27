<?php
include('createSession.php');
//$session = createSession(1111, 'AOrewZF7Ap5ysa', 'jyhyu-HZbMZ', 'login', 'password');
$session = createSession(51783, 'LOGryCnBU6rODVe', 'y7KFHxDSuW4pGJU', 'shubhamj', '9889520019');
$token = $session->token;
$request = '{"user": {"login": "shubham", "password": "shubham12345", "email": "lenna@domain.com", "external_user_id": "687646413", "facebook_id": "879646541", "twitter_id": "657654136141", "full_name": "shubham jain", "phone": "87654351", "website": "http://lena.com", "tag_list": "name,age"}}';
$ch = curl_init('http://api.quickblox.com/users.json'); 
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Content-Type: application/json',
  'QuickBlox-REST-API-Version: 0.1.0',
  'QB-Token: ' . $token
));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$resultJSON = curl_exec($ch);
$pretty = json_encode(json_decode($resultJSON), JSON_PRETTY_PRINT);
echo $pretty;
?>