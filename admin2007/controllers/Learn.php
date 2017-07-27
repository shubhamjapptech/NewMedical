<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Learn extends CI_Controller {
function __construct() {
        parent::__construct();
        $this->load->library("form_validation");
        //$this->load->model("admin_model");
        $this->load->library('session');
		$this->load->helper(array('form', 'url'));
		//$this->load->library('upload');
		$this->load->model('user_model');
		$this->load->library('Ga_api');
		$this->load->database();
    }

	public function index()
	{
		$this->load->view('add_user');
	}

	public function insert()
	{
		if($this->input->post('submit') && $this->input->post())
		{
			$first_name=$this->input->post('first_name');			
				$last_name=$this->input->post('last_name');
				$email=$this->input->post('email');
				$gender=$this->input->post('gender');
				$mobile=$this->input->post('mobile_no');
				$address=$this->input->post('address');
				$uuid=123;
				$enpass=12112;
				
				$data=array(
							"uniq_id"=>$uuid,	
							"first_name"=>$first_name,
							"last_name"=>$last_name,
							"email"=>$email,
							"gender"=>$gender,
							"phone"=>$mobile,
							"address"=>$address,
							"password"=>$enpass						
							);
			
			$id=$this->user_model->add_user($data);
			
			if($id)
			{
				$config['upload_path'] = './upload/';
				$config['max_size'] = '*';
				$config['allowed_types'] = '*';								
				$image_name = $_FILES['image']['name'];
				//$ext = end((explode(".", $image_name)));
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
					echo $this->upload->display_errors();
				}
				else
				{
					//echo $image_name;
					//echo $id;die;									
					$imageDetails = $this->upload->data();
					$this->user_model->update_image($image_name,$id);
					$display['error']=0; 
					$display['sucess']=1;
					$display['message']= "Registration Sucessfully";
					$this->load->view('imageupload',$display); 
				}	                				
			}	
		}
		else
		{ 
			$this->load->view('imageupload');
		}
	}

	public function dashboard()
	{
		$login = $this->ga_api->login();
		//print_r($login);
		$this->ga_api->dimension('adGroup , campaign , adwordsCampaignId , adwordsAdGroupId');
		$this->ga_api->metric('impressions');
		$this->ga_api->limit(30);
		$this->ga_api->get_object();
		$data['accounts'] = $this->ga_api->login()->get_accounts();
		print_r($data);
		echo json_encode($data);
	}
}