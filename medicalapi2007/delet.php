<?php
if (isset($_POST['tag']) && $_POST['tag'] != '') {
		$tag = $_POST['tag'];
		require_once 'include/admin.php';
		$db = new Admin_Functions();
		if ($tag == 'deleteUser') {
			$token=$_POST['token'];
			$result=$db->deleteUser($token);
			if($result!=false)
			{
				$msg["sucess"]=1;
				$msg['message']="User deleted successfull";
				echo json_encode($msg);
			}
			else{
				$msg["Error"]=1;
				$msg['message']="User not deleted";
				echo json_encode($msg);
			}
		}
	}
?>