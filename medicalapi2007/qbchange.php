<?php
	if (isset($_POST['tag']) && $_POST['tag'] != '') 
	{
		$tag = $_POST['tag'];
		require_once 'include/Md_Functions.php';
		$db = new Md_Functions();
		$response = array("tag" => $tag, "success" => 0, "error" => 0);
		if ($tag == 'change_password') 
		{
			$token = $_POST['token'];
			$cp = $_POST['current_password'];
			$new_p = $_POST['new_password'];
			$qbpass=$_POST['new_password'];
			$cpassword=$_POST['confirm_password'];
			$email =$_POST['email'];
			$user_qbid=$_POST['user_qbid'];
			include('quickblox/createSession.php');
			//$session = createSession(1111, 'AOrewZF7Ap5ysa', 'jyhyu-HZbMZ', 'login', 'password');
			$session = createSession(51783, 'LOGryCnBU6rODVe', 'y7KFHxDSuW4pGJU',$email, $cp);
			//echo json_encode($val);
			$token = $session->token;	
			$request = '{"user": {"old_password":"'.$cp.'","password":"'.$new_p.'"}}';
			$ch =
			curl_init('http://api.quickblox.com/users/'.$user_qbid.'.json'); 
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
			echo json_encode($d);
			//echo json_encode($session);
		}
	}
?>