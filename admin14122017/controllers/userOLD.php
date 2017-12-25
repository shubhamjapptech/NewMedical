<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->library("form_validation");
		$this->load->helper("form");
        $this->load->model("user_model");
        $this->load->model("admin_model");
        $this->load->model("PrescriptionCheck");
        $this->load->library("session"); 
        $this->load->library("upload"); 
        if($this->session->userdata('email') == '')
        {
           redirect('admin');
        }
	 }
	 public function index()
	 {
	 	$id=$_GET['id'];
	 	$data['userlist']=$this->user_model->get_user($id);
	 	$this->load->view('update_user',$data);
	 }
	 public function checkuser()
	 {
	 	$res=$this->PrescriptionCheck->usercount();
	 	print_r($res);
	 }
	 public function insert_user()
	 {	 
	 	$this->load->view('add_user');
	 }
	public function add_user()
	{		
		$data= new stdClass();
		if ($this->input->post('submit') && $this->input->post()) 
		{
		 	extract($_POST);
			$db=$this->isuserexits($email);
			if($db!=0)
			{  
		   		$data->error=1;
				$data->success=0;
				$data->message="This email Id already registred";
				$this->load->view('add_user',$data); 
			}
			else
			{
		   	   	$password=$_POST['password'];
		   		$confirm_password=$_POST['confirm_password'];
		   		if($password !=$confirm_password)
		   		{
		   			$data->error=2;
					$data->success=0;
					$data->message="Confirm password not match";
					$this->load->view('add_user',$data); 		 
				}
	            else
                {
                	$enpass=md5($password);
                	$length=12;
			        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			        $charactersLength = strlen($characters);
			        $uuid = '';
			        for ($i = 0; $i < $length; $i++) 
			        {
			        	$uuid .= $characters[rand(0, $charactersLength - 1)];
			        }
			        $picture = 'default.png';
		       		if(isset($_FILES['image']['name']) && $_FILES['image']['name']!='')
			 		{
			    		$s=$_FILES["image"]["tmp_name"];
			    		$imag_name=$_FILES["image"]["name"];
			    		$picture = preg_replace('/\s*/m', '',$imag_name);
				        $d="C:/xampp/htdocs/codeignator/medicalApp/image/".$picture;
				        move_uploaded_file($s,$d);
				    }		  
		        	$data=array(
			                	"uniq_id"=>$uuid,	
						 		"first_name"=>$first_name,
						 		"last_name"=>$last_name,
						 		"email"=>$email,
						 		"gender"=>$gender,
						 		"phone"=>$mobile_no,
						 		"zipcode"=>$address,
						 		"password"=>$enpass,
						 		"qbpass"=>$password,
						 		"image"=>$picture
	 							);
    				$id=$this->user_model->add_user($data);
    				if($id!='')
    				{ 

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
							    'user[full_name]' => $first_name.' '.$last_name,
							    'user[phone]' => $mobile_no
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
    					/*******QB User Register*******/
			            /*$this->load->view('layout/createSession.php');
			            //$session = createSession(1111, 'AOrewZF7Ap5ysa', 'jyhyu-HZbMZ', 'login', 'password');
			            $session = createSession(51792, 'y85qgkAVYvMKwAu', 'Oa9CkX5jPP44yFh', 'govindapptech', 'quickblox@123');
			            $token = $session->token;
			            $request = '{"user": {"login": "'.$email.' ", "password": "'.$password.'", "email": "'.$email.'","full_name": "'.$first_name. $last_name.'", "phone":"'.$mobile_no.'"}}';
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
			            $d=json_decode($pretty);   
			            $qb_id=$d->user->id; */ 
			            $qbloxId=$this->user_model->update_qbId($id,$quickblock_id);
			            /*******QB User Register End*******/
		           		$data= new stdClass();
			        	$data->error=0;
						$data->success=2;
						$data->message="User registred successfully";
						$this->load->view('add_user',$data); 
            		}
            		else
            		{
            			$data= new stdClass();
			        	$data->error=1;
						$data->success=0;
						$data->message="User not registred";
						$this->load->view('add_user',$data); 
            		}							
				}
			}
		}
		else
		{
			$this->load->view('add_user');
		}
	}        
        
    public function user_update()
	{
		if($this->input->post('update'))
		{
			extract($_POST);
		 	$id=$this->input->post('id');
		 	$data=array(
	 		"first_name"=>$first_name,
	 		"last_name"=>$last_name,
	 		"email"=>$email,
	 		"gender"=>$gender,
	 		"phone"=>$mobile_no,
	 		"address" =>$address,
	 		"zipcode"=>$zipcode	 		
	 		);
	 		$message='';
            if($this->user_model->ispharmaciesExisted($zipcode))
            {
            	$message ="User update success. Sorry! Repill does not have any pharmacist in your area, Please Enter differenct Zipcode";
            }
            else
            {
            	$message= "User update success";
            }
		 	$res=$this->user_model->update_user($data,$id);
		 	if($res!=false)
			{
		 	if(isset($_FILES['image']['name']) && $_FILES['image']['name']!='')
			    {
		    		$s=$_FILES["image"]["tmp_name"];
		    		$imag_name=$_FILES["image"]["name"];
			        $picture = preg_replace('/\s*/m', '',$imag_name);
			        $d="image/".$picture;
			        move_uploaded_file($s,$d);
			        $rr=$this->user_model->update_image($picture,$id);
			        if($rr!=false)
			        {

			        	$data= new stdClass();
			        	$data->userlist=$this->user_model->get_user($id);
				        $data->error=0;
						$data->success=1;
						$data->message=$message;
						$this->load->view('update_user',$data);
		        	}
			        else
			        {
			        	$data= new stdClass();
			        	$data->userlist=$this->user_model->get_user($id);
				        $data->error=1;
						$data->success=0;
						$data->message="Image Upload Error!User update successfully";
						$this->load->view('add_user',$data);
			        }    
				}
			    else
			    {
				    	$data= new stdClass();
			        	$data->userlist=$this->user_model->get_user($id);
				        $data->error=0;
						$data->success=2;
						$data->message=$message;
						$this->load->view('update_user',$data);
			    }
			}
			else
			{
				$data= new stdClass();
	        	$data->userlist=$this->user_model->get_user($id);
		        $data->error=2;
				$data->success=0;
				$data->message="Error Occur! User Not Update,Please try again";
				$this->load->view('update_user',$data);
			}
		}
		else
		{
			$id=$_GET['id'];
			$data['userlist']=$this->user_model->get_user($id);
			$this->load->view('update_user',$data);
		}
	}


	public function userPharmacy()
	{
		$user_id=$_GET['id'];
		if($this->input->post('add'))
		{
			extract($_POST);
			$data= array(
				"user_id"=>$id,
				"pharmacy_name"=>$pharmacy_name,
				"city" => $city,
				"contactNo"=>$contactno,
				"cross_street"=>$street
				);
			if($this->user_model->addUserPharmacy($data))
			{
				$details =$this->user_model->userPharmacy($user_id);
				$data["success"]  = 1;
				$data["message"]  = "User Pharmacy details has been saved successfully";
				$data["user_id"]  = $user_id;
				$data['userlist'] = $details; 
				$this->load->view('update_userPharmacy',$data);
			}
			else
			{
				$details =$this->user_model->userPharmacy($user_id);
				$data["error"]    = 1;
				$data["message"]  = "Error Occur, Please try agin! User Pharmacy details is not saved";
				$data["user_id"]  = $user_id;
				$data['userlist'] = $details; 
				$this->load->view('update_userPharmacy',$data);
			}
		}
		elseif($this->input->post('update'))
		{
			extract($_POST);
			$update = date('Y-m-d H:i');
			$data= array(
				"pharmacy_name"=>$pharmacy_name,
				"city" => $city,
				"cross_street"=>$street,
				"contactNo"=>$contactno,
				"update_at"=>$update
				);
			if($this->user_model->updateUserPharmacy($data,$user_id))
			{
				$details =$this->user_model->userPharmacy($user_id);
				$data["success"]  = 1;
				$data["message"]  = "User Pharmacy details has been updated successfully";
				$data["user_id"]  = $user_id;
				$data['userlist'] = $details; 
				$this->load->view('update_userPharmacy',$data);
			}
			else
			{
				$details =$this->user_model->userPharmacy($user_id);
				$data["error"]    = 1;
				$data["message"]  = "Error Occur, Please try agin! User Pharmacy details is not update";
				$data["user_id"]  = $user_id;
				$data['userlist'] = $details; 
				$this->load->view('update_userPharmacy',$data);
			}
		}
		else
		{
			$details =$this->user_model->userPharmacy($user_id);
			$data["user_id"]  = $user_id;
			$data['userlist'] = $details; 
			$this->load->view('update_userPharmacy',$data);
		}
	}

	 public function userlist()
	 {
	 	$table_name ='registration';
 		$data=new stdClass();	
 		$update = $this->PrescriptionCheck->updatecount($table_name);
 		$data->user_pharmacy=$this->admin_model->user_pharmacy();
		$data->userlist=$this->admin_model->registred_user();			
		$this->load->view('userlist',$data);			
	 }

	 public function isuserexits($email)
	 {
	 		//$data=new stdClass();
			$res=$this->user_model->check_user($email);
			return $res;				
	 }

	public function delete_user()
	{
		$data=new stdClass();
		$id=$_GET['id'];
		$user_detail=$this->user_model->get_user($id);
		
		//********** Qb Login ***************//
		echo base_url('assest/chat/config.js');
		echo "<script>QB.init(QBApp.appId, QBApp.authKey, QBApp.authSecret);
		$(document).ready(function() {
  		QB.createSession(function(err,result){
    	console.log('Session create callback', err, result);
  		});</script>";

		//********** Qb Login End ***************//
	 	$res=$this->user_model->delete_user($id);
	 	if($res!=false)
	 	{	 		
	 		$data->error=0;
	 		$data->success=1;
	 		$data->message="User Deleted";
	 		$data->userlist=$this->admin_model->registred_user();
	 		$this->load->view('userlist',$data);
	    }
	    else
	    {
	    	$data->error=1;
	    	$data->success=0;
	    	$data->message="User not delete";
	    	$data->userlist=$this->admin_model->registred_user();
	    	$this->load->view('userlist',$data);
	    }
	}

	public function chat()
	{		
		$this->load->view('chat');
	}

}
