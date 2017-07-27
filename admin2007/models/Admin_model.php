<?php

class Admin_model extends CI_Model {

	function __construct() {

        parent::__construct();

        $this->load->database();

    }

	public function login($data)

	{
				
		$query =$this->db->get_where('admin', array('email' => $data['email'],'password'
			=>$data['password']));
		$result=$query->row();
		if($result !='')
		{
			return $result;
		}
		else 
		{
			$query1 =$this->db->get_where('pharmasist', array('email' => $data['email'],'password'
			=>$data['password']));
			 $result1=$query1->row();
			 if($result1!='')
			 {
			 	return $result1;
			 }
			 else
			 {
			 	return false;
			 }
		}
	}

	public function admin_profile($id)
	{
		return $this->db->get_where('admin',array('id'=>$id))->row();
	}

	public function update_profile($id,$data)
	{
		$this->db->where('id',$id);
		return $this->db->update('admin',$data);
	}



	public function registred_user()
	{
		$this->db->order_by("id","DESC");
		$query=$this->db->get("registration");		
		$result=$query->result();
		return $result;
	}

	public function Fbregistred_user()
	{
		$this->db->order_by("id","DESC");
		$this->db->where('fb_id!=','');	
		$query=$this->db->get("registration");		
		$result=$query->result();
		return $result;
	}


	public function registred_pharmasist()

	{

		$query=$this->db->get('pharmasist');

		$count=$query->num_rows();

		$res="";

		if($count>0)
		{
			$result=$query->result();
			return $result;

		}

		else

		{

			return false;

		}

	}



	public function checkuser($id,$opass)

	{

		$check=$this->db->get_where('admin',array('id'=>$id,'password'=>$opass));

		$count=$check->num_rows();

		if($count>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function checkpharmacist($id,$opass)
	{
		$check=$this->db->get_where('pharmasist',array('id'=>$id,'password'=>$opass));
		$count=$check->num_rows();
		if($count>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function change_password($enpass,$id)

	{

		$this->db->where('id',$id);

		$rr=$this->db->update('admin',array('password'=>$enpass));

		if($rr)

		{

			return true;

		}	

		else

		{

			return false;

		}

	}

	public function change_pharmacist_password($enpass,$id)
	{
		$this->db->where('id',$id);
		$rr=$this->db->update('pharmasist',array('password'=>$enpass));
		if($rr)
		{
			return true;
		}	
		else
		{
			return false;
		}
	}

	public function mailconfig()
    {
        $config = array();
        $config['useragent']           = "CodeIgniter";
        $config['mailpath']            = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail 25"
        $config['protocol']            = "smtp";
        $config['smtp_host']           = "localhost";
        $config['smtp_port']           = "25";
        $config['mailtype']            = 'mail';
        $config['charset']             = 'utf-8';
        $config['newline']             = "\r\n";
        $config['wordwrap']            = TRUE;
        return $config;
    }

	public function forget_password($email)
	{
		$check=$this->db->get_where('admin',array('email'=>$email));
		$count=$check->num_rows();
		if($count>0)
		{
			//$message = 'Click on the link -'.base_url('index.php/admin/recover_password?email='.$email.')';
			$message = 'Click on this link -http://52.41.221.184/medical/index.php/admin/recover_password?email='.$email.'';
			$config= $this->mailconfig();
			$this->load->library('email');
			$this->email->initialize($config);
			$this->email->set_newline("\r\n");
			$this->email->from('repillrx.com'); 
			$this->email->to($email);
			$this->email->subject('Remind Passwoord');
			$this->email->message($message);
			if($this->email->send())
			{
				echo "success";
				return 'success';
			} 
			else
			{
				echo "fails";
				return 'fail';  
			}
		}
		elseif($email!='')
		{
			$check=$this->db->get_where('pharmasist',array('email'=>$email));
			$count=$check->num_rows();
			if($count>0)
			{
				 	$message = 'Click on this link -http://app.repillrx.com/medical/index.php/admin/recover_pharmacist_password?email='.$email.'';
				   $this->load->library('email');
				   $this->email->set_newline("\r\n");
				   $this->email->from('repillrx.com'); 
				   $this->email->to($email);
				   $this->email->subject('Remind Passwoord');
				   $this->email->message($message);
				   if($this->email->send())
				   {
				   		return 'success';
				   } 
				  else
				  {
				  	 return 'fail';  
				  }
			}
		}
		else
		{
			return false;
		}
	}
	//For Admin password Recover//

	public function recover_password($enpass,$email)
	{
		$this->db->where('email',$email);
		$rr=$this->db->update('admin',array('password'=>$enpass));
		if($rr)
		{
			return true;
		}	
		else
		{
			return false;
		}
	}

	//For Pharmacist password Recover//

	public function recover_pharmacist_password($enpass,$email)
	{
		$this->db->where('email',$email);
		$rr=$this->db->update('pharmasist',array('password'=>$enpass));
		if($rr)
		{
			return true;
		}	
		else
		{
			return false;
		}
	}
	// For User detail
	public function userdetail($email)
	{
		return $this->db->get_where('registration',array('email' =>$email))->row();
	}
	//For Register User password Recover//
	public function recover_userpassword($enpass,$upass,$email)
	{
		$this->db->where('email',$email);
		$rr=$this->db->update('registration',array('password'=>$enpass,'upass'=>$upass,'qbpass'=>$upass));
		if($rr)
		{
			return true;
		}	
		else
		{
			return false;
		}
	}

}



?>