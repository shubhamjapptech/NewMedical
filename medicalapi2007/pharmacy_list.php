<?php
if(isset($_POST['zipcode']))
{
	// $zipcode= $_POST['zipcode'];
	require_once 'include/Md_Functions.php';
	$db = new Md_Functions();
	$response = array("success" => 0, "error" => 0);
	$result='';
	$s="SELECT * FROM `pharmacy`";
	$q=mysql_query($s);
	if(mysql_num_rows($q)>0)
	{
		while($as=mysql_fetch_assoc($q))
		{
				$result[]=$as;
		}
		$response["success"]=1;
		$response["message"]="success";
		$response["data"]=$result;
		echo json_encode($response);
	}
	else
	{
		$response["error"]=1;
		$response["message"]="No pharmacy available";
		$response["data"]=[];
		echo json_encode($response);
	}
}
else
{
	$response["error"]=2;
	$response["message"]="Access Denied";
	echo json_encode($r);
}


// 	$latitude = $_POST["latitude"];
// 	$longitude= $_POST["longitude"];
// 	//echo $longitude;
// 	if($latitude!='' && $longitude!='')
// 	{
// 		$radius = 50;
// 		$result=array();
// 		$sql= "SELECT id,pharmacy_name, ( 3959 * acos( cos( radians($latitude) ) * cos( radians(`lat`) ) * cos( radians(`long`) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `lat` ) ) ) ) AS distance FROM pharmacy HAVING distance < $radius ORDER BY distance";
// 		//print_r($sql);
// 	    $q =mysql_query($sql);
// 	    $count= mysql_num_rows($q);
// 	    if ($count>0)
// 	    {
// 	        while($as=mysql_fetch_assoc($q))
// 			{
// 	 			$result[]=$as;
// 			}
// 				$as1['success']=1;
// 				$as1['error']=0;
// 				$as1['message']="success";
// 				$as1['data']=$result;
// 				echo json_encode($as1);  
// 				exit;           
// 	    }
// 	    else
// 	    {
// 	    	$r['success']=2;
// 	    	$r['error']=0;
// 	    	$r["msg"]="No Nearest pharmacy found";
// 	    	$r["data"]=[];
// 			echo json_encode($r);
// 	        exit;
// 	    }
// 	}
// 	else
// 	{
// 		$r['success']=0;
// 	   	$r['error']=1;
// 		$r['msg']="latitude or longitude missing";
// 		$r['data']=[];
// 		echo json_encode($r);
// 		exit;
// 	}
// }
// else
// {
// 	$r['success']=0;
// 	$r['error']=2;
//     $r['msg']="Access Denied";
//     $r['data']=[];
// 	echo json_encode($r);
// }








