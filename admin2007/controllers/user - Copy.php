<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->library("form_validation");
        $this->load->model("user_model");
        $this->load->model("admin_model");
        $this->load->library("session"); 
        $this->load->library("upload"); 
	 }
	 public function index()
	 {
	 	$id=$_GET['id'];
	 	$data['userlist']=$this->user_model->get_user($id);
	 	$this->load->view('update_user',$data);
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
				        	//$picture = 'default.png';
				        	//print_r($_POST);die();

					   /* if(isset($_FILES['image']['name']) && $_FILES['image']['name']!=''){

					    		$s=$_FILES["image"]["tmp_name"];
						        $d="C:/xampp/htdocs/codeignator/medicalapp/image/".$_FILES["image"]["name"];
						        $picture=$_FILES["image"]["name"];
						        move_uploaded_file($s,$d);

					        }*/
				        	$data=array(
					                	"uniq_id"=>$uuid,	
								 		"first_name"=>$first_name,
								 		"last_name"=>$last_name,
								 		"email"=>$email,
								 		"gender"=>$gender,
								 		"phone"=>$mobile_no,
								 		"address"=>$address,
								 		"password"=>$enpass,
								 		//"image"=>$image	
			 							);
				            //print_r($data);die();
            				$id=$this->user_model->add_user($data);
            				if($id)
            				{
            					$config['upload_path'] = './image/';
								$config['max_size'] = '*';
								$config['allowed_types'] = '*';								
								$image_name = $_FILES['image']['name'];
								$ext = end((explode(".", $image_name)));
								$config['file_name'] =$image_name;
								//print_r($config);die;
								$this->load->library('upload', $config);
								$this->upload->initialize($config);
								if(!$this->upload->do_upload('image'))
								{
									echo "not";die;
									$display['error']=0; 
									$display['sucess']=1;
									$display['message']= "Registration Sucessfully";
									$this->load->view('add_user',$display);
								//echo $this->upload->display_errors();
								}
								else
								{
									echo $image_name;
									echo $id;die;									
									$imageDetails = $this->upload->data();
									$this->user_model->update_image($image_name,$id);
									$display['error']=0; 
									$display['sucess']=1;
									$display['message']= "Registration Sucessfully";
									$this->load->view('add_user',$display); 
            					}	                				
	                		}
							else
							{
								
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
	 		print_r($userlist->image);die();
	 	extract($_POST);
	 	$picture='';
	 	$id=$this->input->post('id');
	 	$picture =$this->input->post('pic');
	    if(isset($_FILES['image']['name']) && $_FILES['image']['name']!=''){
	    		$s=$_FILES["image"]["tmp_name"];
		        $d="C:/xampp/htdocs/codeignator/medicalapp/image/".$_FILES["image"]["name"];
		        $picture=$_FILES["image"]["name"];
		        move_uploaded_file($s,$d);
	        }
	 	$data=array(
	 		"first_name"=>$first_name,
	 		"last_name"=>$last_name,
	 		"email"=>$email,
	 		"gender"=>$gender,
	 		"phone"=>$mobile_no,
	 		"address"=>$address,
	 		"image"=>$picture	 		
	 		);
	 	$this->user_model->update_user($data,$id);
	 	$data['userlist']=$this->admin_model->registred_user();
	    $data['pharmalist']=$this->admin_model->registred_pharmasist();		    
		$this->load->view('userlist',$data);
	 }
	 public function userlist()
	 {
	 		$data=new stdClass();	
			$data->userlist=$this->admin_model->registred_user();			
			$this->load->view('userlist',$data);			
	 }

	 public function isuserexits($email)
	 {
	 		//$data=new stdClass();
			$res=$this->user_model->check_user($email);
			return $res;				
	 }

	 public function family_member()
	 {
	 	$id=$_GET['id'];
	 	$res=$this->user_model->family_member($id);
	 	$count=$res->num_rows();
	 	if($count>0)
	 	{
	 		$result=$res->result();
	 		$data= new stdClass();
	 		$data->error=0;
	 		$data->member_list=$result;
	 		$this->load->view('family_member',$data);
		 }
		 else{
		 	$dd= new stdClass();
		 	$dd->error=1;
		 	$dd->message="No family member found";
		 	$this->load->view('family_member',$dd);
		 }
		}

	public function delete_user()
	{
		$data=new stdClass();
		$id=$_GET['id'];
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
}
