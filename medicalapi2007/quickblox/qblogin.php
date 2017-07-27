<?php
 // Application credentials - change to yours (found in QB Dashboard)
 DEFINE('APPLICATION_ID', 51783);
 DEFINE('AUTH_KEY', "LOGryCnBU6rODVe");
 DEFINE('AUTH_SECRET', "y7KFHxDSuW4pGJU");
 // User credentials
 DEFINE('USER_LOGIN', "govind1235@gmail.com");
 DEFINE('USER_PASSWORD', "govind1235");
 // Quickblox endpoints
 DEFINE('QB_API_ENDPOINT', "https://api.quickblox.com");
 DEFINE('QB_PATH_SESSION', "session.json");
 // Generate signature
 $nonce = rand();
 $timestamp = time(); // time() method must return current timestamp in UTC but seems like hi is return timestamp in current time zone
 $signature_string = "application_id=".APPLICATION_ID."&auth_key=".AUTH_KEY."&nonce=".$nonce."&timestamp=".$timestamp."&user[login]=".USER_LOGIN."&user[password]=".USER_PASSWORD;
 //echo "stringForSignature: " . $signature_string . "<br><br>";
 $signature = hash_hmac('sha1', $signature_string , AUTH_SECRET);
 // Build post body
 $post_body = http_build_query(array(
                 'application_id' => APPLICATION_ID,
                 'auth_key' => AUTH_KEY,
                 'timestamp' => $timestamp,
                 'nonce' => $nonce,
                 'signature' => $signature,
                 'user[login]' => USER_LOGIN,
                 'user[password]' => USER_PASSWORD
                 ));
 // $post_body = "application_id=" . APPLICATION_ID . "&auth_key=" . AUTH_KEY . "&timestamp=" . $timestamp . "&nonce=" . $nonce . "&signature=" . $signature . "&user[login]=" . USER_LOGIN . "&user[password]=" . USER_PASSWORD;
 // echo "postBody: " . $post_body . "<br><br>";
 // Configure cURL
 $curl = curl_init();
 curl_setopt($curl, CURLOPT_URL, QB_API_ENDPOINT . '/' . QB_PATH_SESSION); // Full path is - https://api.quickblox.com/session.json
 curl_setopt($curl, CURLOPT_POST, true); // Use POST
 curl_setopt($curl, CURLOPT_POSTFIELDS, $post_body); // Setup post body
 curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Receive server response
  // Execute request and read response
 curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
 $response = curl_exec($curl);
 // Check errors
 $qb="";
 if ($response) {
        $qb= json_decode($response);
        $qb1=$qb->session;
        echo json_encode($qb1);
 } else {
         $error = curl_error($curl). '(' .curl_errno($curl). ')';
         $qb= json_decode($error);
         echo $error . "\n";
          }
 //echo json_encode($qb);
 // Close connection
 curl_close($curl);
 ?>