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
			$devicetoken= $_POST['devicetoken'];

			$fname = $_POST['first_name'];

			$lname = $_POST['last_name'];

			$zipcode=$_POST["zipcode"];			

			$mobile = $_POST['mobile_no'];

			$email = $_POST['email'];

			$password = $_POST['password'];

			$cpassword=$_POST['confirm_password'];
			$pharmacy_name=''; $city=''; $cross_street='';
			if(isset($_POST['pharmacy_name']) && $_POST['pharmacy_name']!='')
			{
				$pharmacy_name = $_POST['pharmacy_name'];
				$city 		   = $_POST['city'];
				$cross_street  = $_POST['cross_street'];
			}

			/*******QB User Register*******/

				            $fr1=rand(10000000,999999999);

				            $tr1=rand(10000000,999999999);

				            $extr1=rand(10000000,999999999);

				            include('quickblox/createSession.php');

				            //$session = createSession(1111, 'AOrewZF7Ap5ysa', 'jyhyu-HZbMZ', 'login', 'password');

				            $session = createSession(Application_id,Authorization_key,Authorization_secret,'shubhamj', '9889520019');

				            $token = $session->token;
				            print_r($token);
				            //$request = '{"user": {"login": "'.$email.' ", "password": "'.$password.'", "email": "'.$email.'", "external_user_id": "", "facebook_id": "", "twitter_id": "", "full_name": "'.$fname.' '.$lname.'", "phone": "'.$mobile.'",website": "'.$email.'","Version": "0.1.0"}}';
				            $request = '{"user": {"login": "Lena1", "password": "Lena12345", "email": "lena@domain.com","full_name": "Lena Laktionova", "phone": "87654351"}}';
				            print_r($request);
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

				            $user_qb=json_decode($pretty);   
				            print_r('expression'.$user_qb);
				            $qb_id=$user_qb->user->id;
				            print_r($qb_id);

			/*$plength=strlen($password);

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
						if($db->ispharmaciesExisted($zipcode))
						{
							$response['error']=3;
							$response['error_msg']="Sorry! Repill does not have any pharmacist in your area";
						}
						$ss='default1.jpg';
						$uuid =$db->radomno();
						if(isset($_FILES["img"])!='')
						{
				            $s=$_FILES["img"]["tmp_name"];
				            //$ss=$fname.$_FILES["img"]["name"];
				            $image=$uuid.$_FILES['img']['name'];
				            $ss = preg_replace('/\s/m', '',$image);
				            $d='../medical/image/'.$ss;
				            move_uploaded_file($s,$d);
						}

						$user = $db->storeUser($devicetoken,$fname,$lname,$zipcode,$mobile,$email,$password,$enpass,$ss);

						if ($user)
						 {
						 	$userid=$user["id"];
							$pharmacy_detail='';
							if($pharmacy_name!=''&& $city!='')
							{
								$pharmacy_detail=$db->StoreUserPharmacy($userid,$pharmacy_name,$city,$cross_street);
							}
						// user stored successfully

						/*******QB User Register*******/

				            /*$fr1=rand(10000000,999999999);

				            $tr1=rand(10000000,999999999);

				            $extr1=rand(10000000,999999999);

				            include('quickblox/createSession.php');

				            //$session = createSession(1111, 'AOrewZF7Ap5ysa', 'jyhyu-HZbMZ', 'login', 'password');

				            $session = createSession(Application_id,Authorization_key,Authorization_secret,'shubhamj', '9889520019');

				            $token = $session->token;

				            $request = '{"user": {"login": "'.$email.' ", "password": "'.$password.'", "email": "'.$email.'", "external_user_id": "", "facebook_id": "", "twitter_id": "", "full_name": "'.$fname.' '.$lname.'", "phone": "'.$mobile.'"}}';

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

				            $user_qb=json_decode($pretty);   

				            $qb_id=$user_qb->user->id;   

				            $userid=$user["id"];

				            $db->update_qbId($userid,$qb_id); 

				            $pres_status=$db->prescription_count($userid);

				            $admin=$db->admin_data();

				            //echo $pretty;

				            /*******QB User Register*******/

							/*$response["success"] = 1;

							$response["token"] = $user["uniq_id"];

							$response["devicetoken"]=$user["device_token"];

							$response["admin_image"]=base_url.'/medical/image/'.$admin['image'];

							$response["user1"]["user_id"] = $user["id"];

							$response["user1"]["pres_status"] = $pres_status;

							$response["user1"]["user_qbid"]=$qb_id;

							$response["user1"]["user_password"] =$user["upass"];

							$response["user1"]["First_name"] = $user["first_name"];

							$response["user1"]["last_name"] = $user["last_name"];

							$response["user1"]["zipcode"]= $user['zipcode'];

							$response["user1"]["mobileNo"] = $user["phone"];

							$response["user1"]["image"] = base_url.'/medical/image/'.$user["image"];

							$response["user1"]["email"] = $user["email"];

							$response["user1"]["created_at"] = $user["timestamp"];
							
							$response["user1"]["pharmacy_detail"] =$pharmacy_detail;
							// $response["QbDetail"]["admin_id"]="22363083";
							$response["QbDetail"]["admin_id"]  = "26889668";
							$response["QbDetail"]["password"]  = $user["password"];
							$response["QbDetail"]["admin_user"]= $user_qb;
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

			}*/	

		} 

	}	

	else

	{

		echo "Access Denied";

	}

?>

