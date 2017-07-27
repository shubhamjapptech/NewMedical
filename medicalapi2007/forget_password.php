<?php

if (isset($_POST['tag']) && $_POST['tag'] != '') {

		$tag = $_POST['tag'];

		require_once 'include/Md_Functions.php';

		$db = new Md_Functions();

		$response = array("tag" => $tag, "success" => 0, "error" => 0);

		if ($tag == 'forget' && isset($_POST['email'])!='') {

			$email=$_POST['email'];

			$confirm=$db->forgetpassword($email);

			if($confirm!=FALSE)

			{

				     $response['message']="Email send to your id";
                     $response['Email ']= $email;
                     echo json_encode($response);

                     exit;

			}

			else

			{
				$row['message']="Error occur during mail";
                echo json_encode($row);
                exit;
				}
			}
			else
			{
				$r["message"]="!please enter email id";
				echo json_encode($r);
			}
		}
		else
		{
			echo "Access denied";
		}

?>