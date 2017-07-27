<?php

if (isset($_POST['tag']) && $_POST['tag'] != '') 

{

	$tag = $_POST['tag'];

	require_once 'include/Md_Functions.php';
	require_once 'include/config.php';

	$db = new Md_Functions();

	$response = array("tag" => $tag, "success" => 0, "error" => 0);

	if ($tag == 'change_password')

	 {

		$token 		= $_POST['token'];

		$cp 		= $_POST['current_password'];

		$new_p  	= $_POST['new_password'];

		$qbpass		= $_POST['new_password'];

		$cpassword 	= $_POST['confirm_password'];

		$email 		= $_POST['email'];

		$user_qbid	= $_POST['user_qbid'];

		$enpass		= md5($cp);

		if($db->checkuser($token,$enpass))

		{

			if($new_p==$cpassword)

			{	

				$new_p=md5($new_p);			

				$user = $db->change_password($token,$new_p,$qbpass);

				if ($user)

				{

					// user stored successfully

					include('quickblox/createSession.php');

					//$session = createSession(1111, 'AOrewZF7Ap5ysa', 'jyhyu-HZbMZ', 'login', 'password');

					$session = createSession(Application_id, Authorization_key, Authorization_secret,$email,$cp);

					$token = $session->token;

					//print_r('toekn', $toekn);

					$request = '{"user": {"old_password":"'.$cp.'","password":"'.$qbpass.'"}}';

					$ch =

					curl_init('https://api.quickblox.com/users/'.$user_qbid.'.json'); 

					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

					curl_setopt($ch, CURLOPT_POSTFIELDS, $request);

					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

					curl_setopt($ch, CURLOPT_HTTPHEADER, array(

					  'Content-Type: application/json',

					  'QuickBlox-REST-API-Version: 0.1.0',

					  'QB-Token:'.$token

					));

					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

					$resultJSON = curl_exec($ch);

					$pretty = json_encode(json_decode($resultJSON), JSON_PRETTY_PRINT);

					$d=json_decode($pretty);

					//echo json_encode($d);

					$response["success"] = 1;

					$response["Message"] ="Password Change success";

					$response["token"] = $user["uniq_id"];

					$response["UpdateAt"]=$user["updateAt"];

					$response["qbdetails"]=$d;

					echo json_encode($response);

				} 

				else 

				{

					$response["error"] = 1;

					$response["error_msg"] = "Password not change! Some Error Occured";

					echo json_encode($response);

				}

			}

			else

			{

				$msg["error"]=1;

				$msg["message"] ="New password and Confirm password must be same";

				echo json_encode($msg);

			}

		}

		else

		{

			$msg["error"]=1;

			$msg["msg"]="This Password or token not found! Please Enter correct Details";

			echo json_encode($msg);

		}

  	} 

}	

else

{

	$msg["error"]=1;

	$msg["msg"]="Access Denied";

	echo json_encode($msg);

}

?>