<?php
if (isset($_POST['tag']) && $_POST['tag'] != '' && isset($_POST['user_type']) && $_POST['user_type']!='')
{
		$tag = $_POST['tag'];
		require_once 'include/Md_Functions.php';
		require_once 'include/config.php';
		$db = new Md_Functions();
		$respons = array("tag" => $tag, "success" => 0, "error" => 0);

	if ($tag == 'login')
	{
		$user_type   = $_POST['user_type'];
		$fb_id		 = $_POST['fb_id'];
		$devicetoken = $_POST['devicetoken'];
		$email 		 = $_POST['email'];
		$password    = $_POST['password'];
		$pasword     = md5($password);

		if($user_type==1)
		{
			$user = $db->loginViaFb($fb_id,$email,$user_type,$devicetoken);
			$db->updatetokenViaFb($devicetoken,$fb_id); 	
		}
		else
		{			
			$db->updatetoken($devicetoken,$email); 		//Update device Token;
			$user = $db->getUserByEmailAndPassword($email, $pasword);	
		}
		if ($user != false)
		{
		/********************************** Qb Login Start *********************************/
		DEFINE('APPLICATION_ID', 54310);
		DEFINE('AUTH_KEY', "j292Dy8Oyszfak9");
		DEFINE('AUTH_SECRET', "8-XPxGMpCZavUTT");	 
		// User credentials
		// DEFINE('USER_LOGIN', "shubhamj");
		// DEFINE('USER_PASSWORD',"9889520019");
		DEFINE('USER_LOGIN', "RepillHelpDesk");
		DEFINE('USER_PASSWORD',"Icenut77!");	 
		// Quickblox endpoints
		DEFINE('QB_API_ENDPOINT', "https://api.quickblox.com");
		DEFINE('QB_PATH_SESSION', "session.json");
		// Generate signature
		$nonce = rand();
 		$timestamp = time(); // time() method must return current timestamp in UTC but seems like hi is return timestamp in current time zone
 		$signature_string = "application_id=".APPLICATION_ID."&auth_key=".AUTH_KEY."&nonce=".$nonce."&timestamp=".$timestamp."&user[login]=".USER_LOGIN."&user[password]=".USER_PASSWORD;
		$signature = hash_hmac('sha1', $signature_string , AUTH_SECRET);
 		$post_body = http_build_query(array(
                 'application_id' => APPLICATION_ID,
                 'auth_key' => AUTH_KEY,
                 'timestamp' => $timestamp,
                 'nonce' => $nonce,
                 'signature' => $signature,
                 'user[login]' => USER_LOGIN,
                 'user[password]' => USER_PASSWORD
                 ));
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, QB_API_ENDPOINT . '/' . QB_PATH_SESSION); // Full path is - https://api.quickblox.com/session.json
		curl_setopt($curl, CURLOPT_POST, true); // Use POST
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_body); // Setup post body
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Receive server response
		  // Execute request and read response
		 //********** Handel for SSL ceritifacte error *******//
		 curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		 //********** Handel for SSL ceritifacte error End *******//
		 $response = curl_exec($curl);
		 $qb="";
		 // Check errors
		 if ($response)
		 {
		        $qb=json_decode($response);
		 }
		 else
		 {
		        $error = curl_error($curl). '(' .curl_errno($curl). ')';
		        $qb= json_decode($error);
		        //echo $error . "\n";
		 }
		 	// Close connection
			 curl_close($curl);
			/********************************** Qb Login End ***********************************/
			
			$admin=$db->admin_data();
			$id =$user["id"];
			$pres_status=$db->prescription_count($id);
			$pharmacy_detail = $db->pharmacy_details($id);
			if($pharmacy_detail=='')
			{
				$pharmacy_detail = '';
			}

			$respons["success"] = 1;
			$respons["token"] = $user["uniq_id"];
			$respons["admin_image"]=base_url.'image/'.$admin['image'];
			$respons["user"]["token"] = $user["uniq_id"];
			$respons["user"]["devucetoken"] = $user["device_token"];
			$respons["user"]["fb_id"] = $user["fb_id"];
			$respons["user"]["user_type"] = $user["user_type"];	
			$respons["user"]["pres_status"] = $pres_status;		
			$respons["user"]["user_id"] = $user["id"];
			$respons["user"]["user_qbid"]=$user["qb_id"];
			$respons["user"]["user_password"]=$user["upass"];	
			$respons["user"]["first_name"] = $user["first_name"];
			$respons["user"]["last_name"] = $user["last_name"];
			$respons["user"]["mobile"] = $user["phone"];		
			$respons["user"]["email"]=$user["email"];
			if($user['image_type']==0)
			{
				$image = base_url.'/image/'.$user["image"];
			}	
			else
			{
				$image = $user["image"];
			}
			// $image=base_url.'medical/image/'.$user["image"];
			$respons["user"]["image"]      = $image;
			$respons["user"]["image_type"] = $user['image_type'];
			$respons["user"]["gender"]     = $user["gender"];
			// $respons["user"]["zipcode"]=$user["zipcode"];
			$respons["user"]["created_at"] = $user["timestamp"];
			$respons["user"]["pharmacy_detail"] =$pharmacy_detail;
			$respons["QbDetail"]["password"]=$user["password"];
			$respons["QbDetail"]["admin_user"]=$qb;
			//$response["user"]["updated_at"] = $user["update_at"];
			echo json_encode($respons);
		} 
		else
		{
			$respons["error"] = 2;
			$respons["error_msg"] = "Incorrect email or password!";
			echo json_encode($respons);
		}
    } 
}	
else 
{
	$respons["error"] = 3;
	$respons["error_msg"] = "Access denied";
	echo json_encode($respons);
}
?>
