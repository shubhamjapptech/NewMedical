<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Testing extends CI_Controller
{
  function __construct() 
  {
    parent::__construct();
    $this->load->model("apiModel/Home_model");
    $this->load->model("apiModel/Testing_model");
  }

  /*public function check()
  {
    require_once __DIR__ . '/createSession.php';
    $session = new createSession();
    $email = 'shubhamj285@gmail.com';
    $cp    = '12345678';
    $session = $session->createQbSession(QbApplication_id,QbAuthorization_key,QbAuthorization_secret,$email,$cp);
    $token   = $session->token;
    print_r('toekn', $toekn);
  }*/

  	public function AddPrescriptionrequest()
  	{
	  	if (isset($_POST['tag']) && $_POST['tag']!='')
		{
			$tag = $_POST['tag'];
			$response = array("tag" => $tag, "success" => 0, "error" => 0);
			if ($tag =='prescription') 
			{			
				if(isset($_POST['user_id']) && $_POST['user_id']!='' && isset($_POST['pharmacy_id']) && $_POST['pharmacy_id']!='')
				{
					$token = $_POST['token'];
					$user_id=$_POST['user_id'];
					$pharmacy_id=$_POST['pharmacy_id'];
					$randno =$this->Home_model->radomno();
				    $nn='insurance-card.jpg';
					if(isset($_FILES['insurance_image']) && $_FILES['insurance_image']!='')
					{
		                $insurancename  = $randno.$_FILES['insurance_image']['name'];
						$s  = $_FILES['insurance_image']['tmp_name'];
						$nn = preg_replace('/\s*/m', '',$insurancename);
		                $d  = '../medical/insuranceImage/'.$nn;
		                move_uploaded_file($s,$d);
				    }			    
				    $bcode='';
				    if(isset($_POST['barcode']) && $_POST['barcode']!='')
				    {
				    	$bcode= $_POST['barcode'];	
				    }

					$user = $this->Testing_model->prescription($token,$user_id,$pharmacy_id,$nn,$bcode);

					if ($user) 
					{
						$prescription_id=$user;					
						$res["success"] = 1;
						$res["Error"] = 0;
						$res["prescription_id"]=$prescription_id;
						$res["Message"] ="Your prescription successfully submited";
						echo json_encode($res);
						exit();
					} 

					else
					{
						$res["success"] = 0;
						$res["Error"] = 1;
						$res["Message"] ="Try again! Your prescription not submited";
						echo json_encode($res);
						exit();

					 }
				}
				else
				{
					$res["success"] = 0;
					$res["Error"] = 1;
					$res["Message"] ="Medicine_id and pharmacy_id must to fill";
					echo json_encode($res);
					exit();
				}
			}
		
		}
		else
		{
			$msg["error"] = 4;
			$msg["message"]="Access Denied";
			echo json_encode($msg);
		}
	}

	public function tablet_prescription_detail()
	{
		if(isset($_POST['prescription_id']) && ($_POST['medicine_name']))
		{
			$pres_id  = $_POST['prescription_id'];
			$md_name  = $_POST['medicine_name'];
			$tabas = $this->Testing_model->tabletDetail($pres_id,$md_name);
			if(!empty($tabas))
			{
					$user_id = $tabas["user_id"];
					$ass = $this->Home_model->pharmacy_details($user_id);
					//echo json_encode($ass);
					$user["medicine"]["medicine_id"]	 = $tabas["id"];
					$user["medicine"]["user_id"]		 = $tabas["user_id"];
					$user["medicine"]["prescription_id"] = $tabas["prescription_id"];
					$user["medicine"]["manufacturer"]    = $tabas["medicine_company"];		 		
					$user["medicine"]["medicine_name"]	 = $tabas['medicine_name'];
					$user["medicine"]["status"]			 = $tabas['status'].' taken';
					$user["medicine"]["last_refil"]		 = date('d-m-Y', strtotime($tabas['timestamp']));;
					$user["medicine"]["refil_remain"]	 = $tabas['remain_medicine'].' '.$tabas['unit'];		
					$user["medicine"]["quantity"]	 	 = $tabas['total_medicine'].' '.$tabas['unit'];		
					$user["medicine"]["prescription"]	 = $tabas['prescription'];
					$user["Prescriber"]["name"]			 = $tabas['name'];
					$user["Prescriber"]["phone"]		 = $tabas['phone'];
					$user["Prescriber"]["address"]		 = $tabas['address'];
					$user["Prescriber"]["latitute"]		 = $tabas['lat'];
					$user["Prescriber"]["longitude"]	 = $tabas['long'];
					$user["Pharmacy"]["name"]			 = $ass->pharmacy_name;
					$user["Pharmacy"]["phone"]			 = $ass->contactNo;
					$user["Pharmacy"]["address"]		 = $ass->city;		
					$user["Pharmacy"]["cross_street"]	 = $ass->cross_street;		
					$response['success']	= "1";
					$response['message']	= "success";
					$response['data']		= $user;
					echo json_encode($response);
			}
			else
			{
				$response['error']		= "1";
				$response['message']	= "please enter corret detail";
				echo json_encode($response);
			}
		}
		else
		{
			$response['error']		= "2";
			$response['message']	= "Access Denied";
			echo json_encode($response);
		}
	}

	public function tablet_response()
	{
		if(isset($_POST['time_id']) && $_POST['time_id']!='' && isset($_POST['medicine_id'])&& $_POST['medicine_id']!='')
		{
			$response = array("success" => 0, "error" => 0);
			$time_id			= $_POST['time_id'];
			$medicine_id 		= $_POST['medicine_id'];   //patent tablet id
			$prescription_id	= $_POST['prescription_id'];
			$medicine_name		= $_POST['medicine_name'];
			$check_type         = $_POST['check_type']; //0=uncheck 1=checked
			$med = $this->Testing_model->medicine_detail($medicine_id);
			$total_medicine =  $med['total_medicine'];
			$remain 		=  $med['remain_medicine'];
			$take   		=  $med['dailyDose'];
			if($check_type==1)
			{
				$status =  "taken";	
				$remMed    =  $remain - $take;	
			}
			if($check_type==0)
			{
				$status =  "not";	
			    $remMed    =  $remain + $take;
			}	
			if($total_medicine>=$remMed && $remMed>=0)
			{
				if($this->Testing_model->updateTabResponse($status,$remMed,$time_id,$medicine_id))
				{
					$response["success"] = 1;
					$response["message"] = "success";
					echo json_encode($response);
				}
				else
				{
					$response["error"]   = 1;
					$response["message"] = "Error occur";
					echo json_encode($response);
				}	
			}
			else
			{
				$response["error"]   = 2;
				$response["message"] = "Something wrong";
				echo json_encode($response);
			}
		}
		else
		{
			$response["error"]		= 1;
			$response["success"]	= 0;
			$response["message"]	= "All field are required";
			echo json_encode($response);
		}
	}

	public function refillList_notification()
	{
		$response = array("success" => 0, "error" => 0, "message"=>'');
		if(isset($_POST['user_id']))
		{
			$user_id= $_POST['user_id'];
			$data   = array();
			$refillTab = $this->Testing_model->refillListAtNotificationTab($user_id);
			if(!empty($refillTab))
			{
				foreach ($refillTab as $reTab)
				{
					$result['medicine_id']=$reTab['id'];
					$result['time_id']	= $reTab['time_id'];
					$result['prescription_id']=$reTab['prescription_id'];
					$result['manufacturer']	= $reTab['medicine_company'];
		 			$result['medicine_name']=$reTab['medicine_name'];
		 			$result['prescription']=$reTab['prescription'];
		 			$result['dose_days']=$reTab['dose_days'];
		 			// $result['refill_remain'] =$as['remain_medicine'].' '.$as['unit'];
		 			$result['refill_remain'] 	= $reTab['refill_remain'];
		 			$result['medicineRemain'] 	= $reTab['remain_medicine'];
		 			$result['status']=$reTab['status'];
		 			$result['time']=$reTab['time'];
		 			$result['pharmacist_name']		= $reTab['name'];
		 			$result['medicine_image']    = base_url().'tablet_image/'.$reTab['medicine_image'];
		 			$result['last_refil']        = $reTab['end_date'];
		 			$data[]=$result;
				}
				$response["success"]	 = 1;
				$response["message"]     = "Success";
				$response["data"]		 = $data;	
				echo json_encode($response);
			}
			else
			{
				$response["error"]		 = 1;
				$response["message"]     = "No refill";
				$response["data"]		 = $data;	
				echo json_encode($response);
			}
		}
		else
		{
			$response["error"]	 = 2;
			$response["message"] = "Access Denied";
			echo json_encode($response);
		}
	}

	public function manuallNotificationSetting()
	{
		if(isset($_POST['medicine_id']) && $_POST['medicine_id']!='' && $_POST['user_id']!='')
		{
			$response = array("success" => 0, "error" => 0, "message"=>'');
			$medicine_id  		  = $_POST['medicine_id'];
			$user_id	 		  = $_POST['user_id'];	
			$prescription_id 	  = $_POST['prescription_id'];
			$notification_type 	  = $_POST['notification_type'];
			$frequency			  = $_POST['frequency'];
			$notificaton_date	  = $_POST['notification_date'];      //23-06-2017
			$notification_time 	  = $_POST['notification_time'];
			$type 				  = $_POST['type'];   //AM OR PM
			$notificaton_status   = $_POST['notificaton_status'];     // 0=manual 1=custom
			$notification_endDate = $_POST['notification_endDate'];  //23-06-2017
			$repeatType 		  = $_POST['repeatType'];    //0=always, 1= TillEndDate
			$notificationSwitch   = $_POST['notificationSwitch'];     //0=on 1=off
			$time  				  = explode(',',$notification_time);
			$types                = explode(',',$type);
			//$notificaton_date     = explode(',',$notificaton_date);
			//print_r($time);die();
			$medicineTime = $this->Testing_model->medicineTime($medicine_id);
			$preTime= count($medicineTime);
			$Newtimes = count($time);
			if($notificationSwitch==1)
			{
				if($this->Testing_model->UpdateNotificationSwitch($medicine_id,$notificationSwitch))
				{
					$response["error"]	 = 0;
					$response["success"] = 2;
					$response["message"] = "Notification has been switched off";
					echo json_encode($response);
				}
				else
				{
					$response["error"]	 = 3;
					$response["success"] = 0;
					$response["message"] = "Please try again,Notification does not switche off";
					echo json_encode($response);
				}
			}
			else
			{
				if($preTime==$Newtimes)
				{
					for($i=0; $i<$Newtimes; $i++)
					{
						//$notification_date = $date->format("d-m-Y");
						$data[] = '('."'".$medicine_id."'".','."'".$user_id."'".','."'".$prescription_id."'".','."'".$notification_type."'".','."'".$frequency."'".','."'".$notificaton_date."'".','."'".$time[$i]."'".','."'".$types[$i]."'".','."'".$notificaton_status."'".','."'".$repeatType."'".','."'".$notification_endDate."'".','."'".$notificationSwitch."'".')';
					}
					$query =implode(',', $data);
					//print_r($query);die();
					if($this->Testing_model->setNotification($query,$medicine_id,$notificaton_status))
					{
						$this->Prescriptions_model->updateMedicineTime($medicine_id,$time,$types);
						$response["error"]	 = 0;
						$response["success"] = 1;
						$response["message"] = "Notification setting has been saved Successfully";
						echo json_encode($response);
					}
					else
					{
						$response["error"]	 = 1;
						$response["success"] = 0;
						$response["message"] = "Not Success";
						echo json_encode($response);
					}
				}
				else
				{
					$response["error"]	 = 2;
					$response["success"] = 0;
					$response["message"] = "Number of time does not match.";
					echo json_encode($response);
				}
			}
		}
		else
		{
			$response['error']=1;
			$response["success"] = 0;
			$response['message']="Access Denied!";
			echo json_encode($response);
		}
	}


	public function notificationSetting()
	{
		if(isset($_POST['medicine_id']) && $_POST['medicine_id']!='' && $_POST['user_id']!='')
		{
			$response = array("success" => 0, "error" => 0, "message"=>'');
			$medicine_id  		  = $_POST['medicine_id'];
			$user_id	 		  = $_POST['user_id'];	
			$prescription_id 	  = $_POST['prescription_id'];
			$notification_type 	  = $_POST['notification_type'];
			$frequency			  = $_POST['frequency'];
			$notificaton_date	  = $_POST['notification_date'];      //23-06-2017
			$notification_time 	  = $_POST['notification_time'];
			$type 				  = $_POST['type'];   //AM OR PM
			$notificaton_status   = $_POST['notificaton_status'];
			$notification_endDate = $_POST['notification_endDate'];  //23-06-2017
			$repeatType 		  = $_POST['repeatType'];            //0=always, 1= TillEndDate  
			$time  = explode(',',$notification_time);
			$types = explode(',',$type);
			$notificaton_date = explode(',',$notificaton_date);
			//print_r($times);die();
			$times = count($time);
			for($i=0; $i<$times; $i++)
			{
				//$notification_date = $date->format("d-m-Y");
				$data[] = '('."'".$medicine_id."'".','."'".$user_id."'".','."'".$prescription_id."'".','."'".$notification_type."'".','."'".$frequency."'".','."'".$notificaton_date[$i]."'".','."'".$time[$i]."'".','."'".$types[$i]."'".','."'".$notificaton_status."'".','."'".$repeatType."'".','."'".$notification_endDate."'".')';
			}

			$query =implode(',', $data);
			if($this->Testing_model->setNotification($query,$medicine_id))
			{
				$response["error"]	 = 0;
				$response["success"] = 1;
				$response["message"] = "Notification setting has been saved Successfully";
				echo json_encode($response);
			}
			else
			{
				$response["error"]	 = 1;
				$response["success"] = 0;
				$response["message"] = "Not Success";
				echo json_encode($response);
			}
		}
	}

	public function renew_refill_request()
	{
		$response = array("success" => 0, "error" => 0);
		if(isset($_POST['prescription_id']) && $_POST['prescription_id']!='' && isset($_POST['medicine_id']) && $_POST['medicine_id']!='')
		{
			$pres_id     = $_POST['prescription_id'];
			$medicine_id = $_POST['medicine_id'];
			$refill_remain = $_POST['refill_remain'];
			$refill_remains  = $refill_remain-1;
			if($this->Testing_model->renew_request($pres_id,$medicine_id,$refill_remains))
			{
				$response['success']=1;
				$response['message']="Renew refill request has been sent successfully";
				echo json_encode($response);
			}
			else
			{
				$response['error']=1;
				$response['message']="Error occur! Try again";
				echo json_encode($response);
			}
		}
		else
		{
			$response['error']=1;
			$response['message']="Access Denied!";
			echo json_encode($response);
		}
	}

	public function updatePharmacy()
	{
		if(isset($_POST['user_id']) && $_POST['user_id']!='')
		{
			$response = array("success" => 0, "error" => 0);
			$user_id       = $_POST['user_id'];
			$pharmacy_name = $_POST['pharmacy_name'];
			$city 		   = $_POST['city'];
			$cross_street  = $_POST['cross_street'];
			$contactNo     = ''; 
			$pharmacy 	   = $this->Home_model->pharmacy_details($user_id);
			if(!empty($pharmacy))
			{
				$update_at  = date('Y-m-d H:i:s');
				$pData = array(
					'pharmacy_name'=>$pharmacy_name,
					'city'=>$city,
					'cross_street'=>$cross_street,
					'update_at'=>$update_at
					);
				if($pharmacy_detail= $this->Testing_model->updateUserPharmacy($user_id,$pData))
				{
					$response['success']=2;
					$response['message']="Success";	
		        	$response["user"]["pharmacy_detail"] =$pharmacy_detail;
		        	echo json_encode($response);
				}
				else
				{
					$response['error']=2;
					$response['message']="error occur";	
		        	$response["user"]["pharmacy_detail"] ='';
		        	echo json_encode($response);
				}
			}

			else
			{
				if($this->Home_model->StoreUserPharmacy($user_id,$pharmacy_name,$city,$cross_street,$contactNo))
				{
					$pharmacy_detail 	   = $this->Home_model->pharmacy_details($user_id);
					$response['success']=2;
					$response['message']="Success";	
		        	$response["user"]["pharmacy_detail"] =$pharmacy_detail;
		        	echo json_encode($response);
				}
				else
	    		{
		    		$response['error']=2;
					$response['message']="error occur";	
		        	$response["user"]["pharmacy_detail"] ='';
		        	echo json_encode($response);
	    		}
			}
		}
		else
		{
			$response['error']=3;
			$response['message']="Access Denied";
			echo json_encode($response);
		}
	}

	public function userDetail()
	{
		$response = array("success" => 0, "error" => 0);
		if (isset($_POST['user_id']) && $_POST['user_id'] != '')
		{ 
			$user_id = $_POST['user_id'];
			$user = $this->Home_model->user_details($user_id);
			if(!empty($user))
			{
				$admin= $this->Home_model->admin_data();
			    $pres_status=$this->Home_model->prescription_count($user_id);
			    $pharmacy_detail= $this->Home_model->pharmacy_details($user_id);
			    if(empty($pharmacy_detail))
			    {
			    	$pharmacy_detail='';
			    }
			    $response["success"] 	= 1;
				$response["token"] 		= $user["uniq_id"];
				$response["devicetoken"]=$user["device_token"];
				$response["admin_image"]=base_url().'image/'.$admin->image;
				$response["user1"]["pres_status"] = $pres_status;
				$response["user1"]["user_id"] = $user["id"];
				// $response["user1"]["user_qbid"]=$qb_id;
				$response["user1"]["user_password"] =$user["upass"];
				$response["user1"]["First_name"] = $user["first_name"];
				$response["user1"]["last_name"] = $user["last_name"];
				$response["user1"]["mobileNo"] = $user["phone"];
				if($user['image_type']==0)
				{
					$image = base_url().'image/'.$user["image"];
				}	
				else
				{
					$image = $user["image"];
				}
				$response["user1"]["image"] = $image;
				$response["user1"]["image_type"] = $user['image_type'];
				$response["user1"]["email"] = $user["email"];
				$response["user1"]["gender"] = $user["gender"];
				$response["user1"]["address"] = $user["address"];
				$response["user1"]["created_at"] = $user["timestamp"];
				$response["user1"]["pharmacy_detail"] =$pharmacy_detail;
				$response["QbDetail"]["admin_id"]="22363083";
				$response["QbDetail"]["password"]=$user["password"];
				echo json_encode($response);
			}
			else
			{
				$response["error"]=1;
				$response["msg"]="User is not found";
				echo json_encode($response);
			}
		}
		else
		{
			$response['error']=3;
			$response['message']="Access Denied";
			echo json_encode($response);
		}	
	}


	public function forget_password()
	{

		if (isset($_POST['tag']) && $_POST['tag'] != '') 
		{
			$tag = $_POST['tag'];
			$response = array("tag" => $tag, "success" => 0, "error" => 0);
			if ($tag == 'forget' && isset($_POST['email'])!='')
			{
				$email=$_POST['email'];
				$confirm=$this->Testing_model->forget_password($email);
				if($confirm!=FALSE)
				{
					$response['success']=1;
					$response['message']="Email send to your id";
					$response['Email ']= $email;
					echo json_encode($response);
					exit;
				}
				else
				{
					$response['error'] =1;
					$response['message']="Error occur during mail";
	                echo json_encode($response);
	                exit;
				}
			}
			else
			{
				$response['error']   = 2;
				$response["message"] = "!please enter email id";
				echo json_encode($r);
			}
		}
		else
		{
			$response['error']=3;
			$response['message']="Access Denied";
			echo json_encode($response);
		}
	}

	public function checkmail()
	{
		$to = 'shubhamj285@gmail.com';
		$mailcon = $this->Testing_model->mailconfig();
		$this->load->library('email');
		$this->email->initialize($mailcon);

		$message ='We have received a request to reset password. If you did not request,just ignore this email.Otherwise,You can reset your password using this link:'."\n";
        $message .="http://54.149.226.127/medical/index.php/admin/recover_userpassword?email=$to";


		$this->email->from('shubhamj285@gmail.com', 'Repillrx');
		$this->email->to('shubhamapptech6@gmail.com');
		$this->email->subject('forget password');
		$this->email->message($message);
		if($this->email->send())
        {
            echo 'send';die();
        } 
        else
        {
        	echo $this->email->print_debugger();
        }
	}

	public function change_password()
	{
		if (isset($_POST['tag']) && $_POST['tag'] != '') 
		{
			$tag = $_POST['tag'];
			$response = array("tag" => $tag, "success" => 0, "error" => 0);
			if ($tag == 'change_password')
		 	{
				$usertoken 	= $_POST['token'];
				$cp 		= $_POST['current_password'];
				$new_p  	= $_POST['new_password'];
				$qbpass		= $_POST['new_password'];
				$cpassword 	= $_POST['confirm_password'];
				$email 		= $_POST['email'];
				$user_qbid	= $_POST['user_qbid'];
				$enpass		= md5($cp);
				if($this->Testing_model->checkuserPassword($usertoken,$enpass))
				{
					if($new_p==$cpassword)
					{
						$new_p=md5($new_p);			
						$user = $this->Testing_model->change_password($usertoken,$new_p,$qbpass);
						if($user)
						{
							/*-------------------Change in Qb account-------------------------------*/
						   $this->load->view('layout/createSession.php');
					        //$session = createSession(1111, 'AOrewZF7Ap5ysa', 'jyhyu-HZbMZ', 'login', 'password');
					       $session = createSession(54310, 'j292Dy8Oyszfak9', '8-XPxGMpCZavUTT',$email,$cp);
					       $token = $session->token;
					        //print_r($token);*/
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
							/*-------------------Change in Qb account end-------------------------*/
							$response["success"] = 1;
							$response["Message"] = "Password Change success";
							$response["token"]   = $usertoken ;
							$response["UpdateAt"]= '';
							$response["qbdetails"]=$d;
							echo json_encode($response);
						}
						else 
						{
							$response["success"] = 0;
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
			else
			{
				$msg["error"]=1;
				$msg["msg"]="Access Denied";
				echo json_encode($msg);
			}
		}
	}

	public function medicineTime()
	{
		if (isset($_POST['tag']) && $_POST['tag'] != '' && isset($_POST['medicineId']) && $_POST['medicineId'] !='')
		{
			$tag = $_POST['tag'];
			$response = array("tag" => $tag, "success" => 0, "error" => 0);
			if ($tag == 'times')
		 	{
		 		$medicine_id = $_POST['medicineId'];
		 		$times = $this->Testing_model->medicineTime($medicine_id);
		 		if(!empty($times))
		 		{
		 			$timeresponse["success"] =1;
					$timeresponse["error"] = 0;
					$timeresponse["message"] = "Success";
					$timeresponse["data"] = $times;
					echo json_encode($timeresponse);
		 		}
		 		else
		 		{
		 			$timeresponse["success"] = 0;
					$timeresponse["error"] = 1;
					$timeresponse["message"] = "No Time found";
					$timeresponse["data"] = $times;
					echo json_encode($timeresponse);
		 		}
		 	}
		 	else
			{
				$timeresponse["success"] = 0;
				$timeresponse["error"]=2;
				$timeresponse["message"]="Access Denied";
				echo json_encode($timeresponse);
			}
		}
		else
		{
			$timeresponse["success"] = 0;
			$timeresponse["error"]=3;
			$timeresponse["message"]="Invalid request";
			echo json_encode($timeresponse);
		}
	}

	public function get_notificationSetting()
	{
		if (isset($_POST['tag']) && $_POST['tag'] != '' && isset($_POST['medicineId']) && $_POST['medicineId'] !='')
		{
			$tag = $_POST['tag'];
			$response = array("tag" => $tag, "success" => 0, "error" => 0);
			if ($tag == 'notificationsetting')
		 	{
		 		$medicine_id = $_POST['medicineId'];
		 		$notificationtimes = $this->Testing_model->getnotificationsetting($medicine_id);
		 		if(!empty($notificationtimes))
		 		{
		 			$notificationresponse["success"] =1;
					$notificationresponse["error"] = 0;
					$notificationresponse["message"] = "Success";
					$notificationresponse["data"] = $notificationtimes;
					echo json_encode($notificationresponse);
		 		}
		 		else
		 		{
		 			$notificationresponse["success"] = 0;
					$notificationresponse["error"] = 1;
					$notificationresponse["message"] = "Notification setting does not found";
					$notificationresponse["data"] = $notificationtimes;
					echo json_encode($notificationresponse);
		 		}
		 	}
		 	else
			{
				$notificationresponse["success"] = 0;
				$notificationresponse["error"]=2;
				$notificationresponse["message"]="Access Denied";
				echo json_encode($notificationresponse);
			}
		}
		else
		{
			$notificationresponse["success"] = 0;
			$notificationresponse["error"]=3;
			$notificationresponse["message"]="Invalid request";
			echo json_encode($notificationresponse);
		}

	}

}