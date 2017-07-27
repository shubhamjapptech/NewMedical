<?php

if (isset($_POST['tag']) && $_POST['tag'] != '')

 	{

		$tag = $_POST['tag'];

		require_once 'include/Md_Functions.php';

		require_once 'include/config.php';

		$db = new Md_Functions();

		$response = array("tag" => $tag, "success" => 0, "error" => 0);

		if ($tag == 'signup')

		{

			$devicetoken = $_POST['devicetoken'];

			$fb_id 		 = $_POST['fb_id'];	

			$user_type   = $_POST['user_type']; //0=normal, 1=fbLogin

			$fname 		 = $_POST['first_name'];

			$lname 		 = $_POST['last_name'];

			// $zipcode	 = $_POST["zipcode"];			

			$mobile 	 = $_POST['mobile_no'];

			$email 		 = $_POST['email'];

			$password 	 = $_POST['password'];

			$cpassword   = $_POST['confirm_password'];

			$fb_image    = $_POST['fb_image'];

			$image_type	 = $_POST['image_type'];    //0=simple, 1= fb;

			$pharmacy_name =''; $city=''; $cross_street='';

			if(isset($_POST['pharmacy_name']) && $_POST['pharmacy_name']!='')
			{
				$pharmacy_name = $_POST['pharmacy_name'];
				$city 		   = $_POST['city'];
				$cross_street  = $_POST['cross_street'];
				$contactNo	   = $_POST['contactNo'];
			}

			$plength=strlen($password);

			if($plength<8)

			{

				$response["error"]=3;

				$response["error_msg"]="Password length must be greater then 7";

				echo json_encode($response);

			}

			else

			{
				
				if($password==$cpassword)

				{

					$enpass=md5($password);

					if($db->isUserExisted($email))

					{

						$response["error"] = 2;

						$response["error_msg"] = "User already existed";

						echo json_encode($response);

					} 

					else 

					{
						/*if($db->ispharmaciesExisted($zipcode))
						{
							$response['error']=3;
							$response['error_msg']="Sorry! Repill does not have any pharmacist in your area";
						}*/
						$ss='default1.jpg';
						$uuid =$db->radomno();
						if(isset($_FILES["img"])!='')
						{
				            $s=$_FILES["img"]["tmp_name"];
				            //$ss=$fname.$_FILES["img"]["name"];
				            $image=$uuid.$_FILES['img']['name'];
				            $ss = preg_replace('/\s*/m', '',$image);
				            $d='../medical/image/'.$ss;
				            move_uploaded_file($s,$d);
						}

						if($fb_image!='' && $image_type==1)
						{
							$ss = $fb_image;
						}

						// $userDetails = $db->storeUser($devicetoken,$fname,$lname,$zipcode,$mobile,$email,$password,$enpass,$ss);
						$userDetails = $db->storeUser($devicetoken,$fb_id,$user_type,$fname,$lname,$mobile,$email,$password,$enpass,$ss,$image_type);

						if ($userDetails)
						{
						 	$userid=$userDetails["id"];
							$pharmacy_detail='';
							if($pharmacy_name!=''&& $city!='')
							{
								$pharmacy_detail=$db->StoreUserPharmacy($userid,$pharmacy_name,$city,$cross_street,$contactNo);
							}
							// user stored successfully

							/*******QB User Register*******/

				            $APPLICATION_ID = "54310";
							$AUTH_KEY = "j292Dy8Oyszfak9";
							$AUTH_SECRET = "8-XPxGMpCZavUTT";							 
							// GO TO account you found creditial
							$USER_LOGIN = "shubhamj";
							$USER_PASSWORD = "9889520019";
							$quickbox_api_url = "https://api.quickblox.com";
							////// END CREDENTIAL
							/// RETRIVE TOKEN
							$nonce = rand();
							$timestamp = time(); // time() method must return current timestamp in UTC but seems like hi is return timestamp in current time zone
							$signature_string = "application_id=" . $APPLICATION_ID . "&auth_key=" . $AUTH_KEY . "&nonce=" . $nonce . "&timestamp=" . $timestamp . "&user[login]=" . $USER_LOGIN . "&user[password]=" . $USER_PASSWORD;
							$signature = hash_hmac('sha1', $signature_string, $AUTH_SECRET);
							 
							$post_body = http_build_query(array(
							    'application_id' => $APPLICATION_ID,
							    'auth_key' => $AUTH_KEY,
							    'timestamp' => $timestamp,
							    'nonce' => $nonce,
							    'signature' => $signature,
							    'user[login]' => $USER_LOGIN,
							    'user[password]' => $USER_PASSWORD
							        ));
							$url = $quickbox_api_url . "/session.json";
							$curl = curl_init();
							curl_setopt($curl, CURLOPT_URL, $url); // Full path is - https://api.quickblox.com/session.json
							curl_setopt($curl, CURLOPT_POST, true); // Use POST
							curl_setopt($curl, CURLOPT_POSTFIELDS, $post_body); // Setup post body
							curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
							curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
							curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
							// Execute request and read response
							$qbresponse = curl_exec($curl);
							// Close connection
							curl_close($curl);
							$qbresponse = json_decode($qbresponse, TRUE);
							 
							 
							$token = $qbresponse['session']['token'];
							//print_r($token);
							$post_body = http_build_query(array(
							    'user[login]' => $email,
							    'user[password]' => $password,
							    'user[email]' => $email,
							    'user[external_user_id]' => "",
							    'user[facebook_id]' => '',
							    'user[twitter_id]' => '',
							    'user[full_name]' => $fname.' '.$lname,
							    'user[phone]' => $mobile
							        ));
							 
							$url = $quickbox_api_url . "/users.json";
							$curl = curl_init();
							curl_setopt($curl, CURLOPT_URL, $url); // Full path is - https://api.quickblox.com/session.json
							curl_setopt($curl, CURLOPT_POST, true); // Use POST
							curl_setopt($curl, CURLOPT_POSTFIELDS, $post_body); // Setup post body
							curl_setopt($curl, CURLOPT_HTTPHEADER, array('QB-Token: ' . $token));
							curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
							curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
							curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
							// Execute request and read response
							$qbresponse = curl_exec($curl);
							curl_close($curl);
							$qbresponse = json_decode($qbresponse, TRUE);
							//print_r($qbresponse);
							$quickblock_id = $qbresponse['user']['id'];   

				            //$userid=$userDetails["id"];

				            $db->update_qbId($userid,$quickblock_id); 				            

				            //echo $pretty;
				            /*******QB User Register*******/
				            $pres_status=$db->prescription_count($userid);
				            $admin=$db->admin_data();
							$response["success"] = 1;
							$response["token"] = $userDetails["uniq_id"];
							$response["devicetoken"]=$userDetails["device_token"];
							$response["admin_image"]=base_url.'/medical/image/'.$admin['image'];
							$response["user1"]["pres_status"] = $pres_status;
							$respons["user"]["fb_id"] = $userDetails["fb_id"];
							$respons["user"]["user_type"] = $userDetails["user_type"];
							$response["user1"]["user_id"] = $userDetails["id"];
							$response["user1"]["user_qbid"]=$quickblock_id;
							$response["user1"]["user_password"] =$userDetails["upass"];
							$response["user1"]["First_name"] = $userDetails["first_name"];
							$response["user1"]["last_name"] = $userDetails["last_name"];
							$response["user1"]["mobileNo"] = $userDetails["phone"];
							// $response["user1"]["zipcode"] = $userDetails["zipcode"];
							if($userDetails['image_type']==0)
							{
								$image = base_url.'/medical/image/'.$userDetails["image"];
							}	
							else
							{
								$image = $userDetails["image"];
							}
							$response["user1"]["image"] = $image;
							$response["user1"]["image_type"] = $userDetails['image_type'];
							$response["user1"]["email"] = $userDetails["email"];
							$response["user1"]["created_at"] = $userDetails["timestamp"];
							$response["user1"]["pharmacy_detail"] =$pharmacy_detail;
							// $response["QbDetail"]["admin_id"]="22363083";
							$response["QbDetail"]["admin_id"]  = "26889668";
							$response["QbDetail"]["password"]  =$userDetails["password"];
							$response["QbDetail"]["admin_user"]=$qbresponse;
							echo json_encode($response);
						} 
						else 
						{
							$response["error"] = 1;
							$response["error_msg"] = "Not Registred! Some Error Occured";
							echo json_encode($response);
						}
					}
				}
				else
				{
					$msg["error"]=1;
					$msg["msg"]="Password does not match";
					echo json_encode($msg);
				}
			}	
		} 
		else
		{
			$msg["error"]=2;
			$msg["msg"]="Access Denied";
			echo json_encode($msg);
		}
	}	
	else
	{
		$msg["error"]=3;
		$msg["msg"]="Access Denied";
		echo json_encode($msg);
	}
?>

