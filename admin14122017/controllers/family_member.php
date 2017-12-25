<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Family_member extends CI_Controller {
    
	function __construct() {
        parent::__construct();
        $this->load->library("form_validation");
		$this->load->helper("form");
        $this->load->model("user_model");
        $this->load->model("admin_model");
        $this->load->model("family_member_model");
        $this->load->library("session"); 
        $this->load->library("upload"); 
        if($this->session->userdata('email') == '')
        {
           redirect('admin');
        }
	}
  
    public function index()
    {
        $data=new stdClass();
        $id=$_GET['u_id'];
        $res=$this->family_member_model->family_members($id);
        $count=$res->num_rows();
        if($count>0)
        {
            $result=$res->result();
            $data= new stdClass();
            $data->error=0;
            $data->u_id=$id;
            $data->member_list=$result;
            $this->load->view('family_member',$data);
         }
         else{
            $dd= new stdClass();
            $dd->error=1;
            $dd->u_id=$id;
            $dd->message="No family member found";
            $this->load->view('family_member',$dd);
         }
    }


    public function member_add()
    {
        $data=new stdClass();
        $data->id=$_GET['id'];
        $this->load->view('add_family_member',$data); 
    }

    public function add_member()
    {
        $data=new stdClass();
        if($this->input->post('submit'))
        {            
            extract($_POST);
            $data=new stdClass();
            $id=$this->input->post('id');
            $this->form_validation->set_rules('first_name', 'first_name', 'required');
            $this->form_validation->set_rules('last_name', 'last_name', 'required');
            $this->form_validation->set_rules('dob','Date of birth is','required');
            if ($this->form_validation->run() == FALSE)
            {
            $data->id=$id;
            $this->load->view('add_family_member',$data);
            }
            else
            {
                $image="default_member.jpg";
                if(isset($_FILES['image']['name']) && $_FILES['image']['name']!='')
                {
                    $s=$_FILES["image"]["tmp_name"];
                    $pic=$_FILES["image"]["name"];
                    $image = preg_replace('/\s*/m', '',$pic);
                    $d="family_member_image/".$image;
                    move_uploaded_file($s,$d); 
                }
                $data=array(
                            'user_id'=>$id,
                            'first_name'=>$first_name,
                            'last_name'=>$last_name,
                            'dob'=>$dob,
                            'image'=>$image
                            );
                $res=$this->family_member_model->add($data);
                if($res!=false)
                {
                    $data=new stdClass();
                    $data->id=$id;
                    $data->error=0;
                    $data->success=1;
                    $data->message="Member Added successfull";
                    $this->load->view('add_family_member',$data);
                }
                else
                {
                    $data=new stdClass();
                    $data->id=$id;
                    $data->error=1;
                    $data->success=0;
                    $data->message="Error! Member not add";
                    $this->load->view('add_family_member',$data);
                }
            }
        }
        else
        {
            $data=new stdClass();
            $id=$_GET['id'];           
            $data->id=$id;
            //redirect('add_famy_member?id='.$id);
            $this->load->view('add_family_member',$data);

        }
    }

    public function delete_member()
    {
        $data=new stdClass();
        $f_id=$_GET['f_id'];
        $u_id=$_GET['u_id'];
        $res=$this->family_member_model->delete_member($f_id);
        if($res!=false)
        {
            $res=$this->family_member_model->family_members($u_id);
            $count=$res->num_rows();
            if($count>0)
            {
                $data->error=0;
                $data->success=1;
                $data->message="Member Deleted";
                $result=$res->result();
                $data->u_id=$u_id;
                $data->member_list=$result;
                $this->load->view('family_member',$data);
            }
            else
            {
                $dd= new stdClass();
                $dd->success=1;
                $dd->u_id=$u_id;
                $dd->message="Member Deleted, No family member remain";
                $this->load->view('family_member',$dd);
            }
        }
        else
        {
            $data->error=1;
            $data->success=0;
            $data->message="Member not Deleted";
            $res=$this->family_member_model->family_members($u_id);
            $result=$res->result();
            $data->u_id=$u_id;
            $data->member_list=$result;
            $this->load->view('family_member',$data);
        }
    }

    public function update_member()
    {
        $data=new stdClass();
        if($this->input->post('submit'))
        {
          extract($_POST);
          $id=$this->input->post('id');
          $image=$this->input->post('img');
          //print_r($image);die();
          if(isset($_FILES['image']['name']) && $_FILES['image']['name']!='')
                {
                    $s=$_FILES["image"]["tmp_name"];
                    $pic=$_FILES["image"]["name"];
                    $image = preg_replace('/\s*/m', '',$pic);
                    $d="family_member_image/".$image;
                    move_uploaded_file($s,$d); 
            }
          $data=array(
                        'first_name'=>$first_name,
                        'last_name'=>$last_name,
                        'dob'=>$dob,
                        'image'=>$image
                      );
            $res=$this->family_member_model->update_member($data,$id);
            if($res!=false)
            {
                $data=new stdClass();
                $data->id=$id;
                $data->error=0;
                $data->success=1;
                $data->message="Member Update successfull";
                $res=$this->family_member_model->family_member_detail($id);
                $result=$res->row();
                $data->member_list=$result;
                $this->load->view('update_member',$data);
            }
            else
            {
                $data=new stdClass();
                $data->id=$id;
                $data->error=1;
                $data->success=0;
                $data->message="Error! Member not Update";
                $res=$this->family_member_model->family_member_detail($id);
                $result=$res->row();
                $data->member_list=$result;
                $this->load->view('update_member',$data);
            }

        }
        else
        {
            $data=new stdClass();
            $id=$_GET['id'];
            $data->id=$id;
            $res=$this->family_member_model->family_member_detail($id);
            $result=$res->row();
            $data->member_list=$result;
            $this->load->view('update_member',$data);
        }
    }

}
?>