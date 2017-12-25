<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tablet extends CI_Controller
{
	function __construct() {
        parent::__construct();
        $this->load->library("form_validation");
		$this->load->helper("form");
        $this->load->model("user_model");
        $this->load->model("admin_model");
        $this->load->model("tablet_model");        
        $this->load->library("session"); 
        $this->load->library("upload"); 
        if($this->session->userdata('email') == '')
        {
           redirect('admin');
        }
	 }

   public function index()
    {
        $id=$_GET['p_id'];
        $res=$this->tablet_model->all_tablets($id);
        $count=$res->num_rows();
        if($count>0)
        {
            $data = new stdClass();
            $data->error=0;
            $data->tablets=$res->result();
            $this->load->view('all_tablets',$data);
         }
         else{
            $data= new stdClass();
            $data->error=1;
            $data->message="No Medicin found";
            $this->load->view('all_tablets',$data);
         }
    }

     public function add_medicine()
     {
        $data=new stdClass();
        if($this->input->post('submit'))
        {
            extract($_POST);
            $this->form_validation->set_rules('name', 'Medicine name', 'required');
            $this->form_validation->set_rules('price', 'Price', 'required');    
            $this->form_validation->set_rules('status','status','required');
            $this->form_validation->set_message('status', 'Select status');
            $this->form_validation->set_rules('remain','remain','required');
            $this->form_validation->set_rules('side_effect','side_effect','required');
            if ($this->form_validation->run() == FALSE)
            {
                $data->id=$this->input->post('id');
                $this->load->view('add_medicine',$data);
            }
            else
            {
                $a=array("pink","green","blue","yellow","brown");
                $col=array_rand($a,1);
                $color=$a[$col];
                $picture="";
                if(isset($_FILES['image']['name']) && $_FILES['image']['name']!='')
                {
                    $s=$_FILES["image"]["tmp_name"];
                    $d="tablet_image/".$_FILES["image"]["name"];
                    $picture=$_FILES["image"]["name"];
                    move_uploaded_file($s,$d); 
                }

                 $data=array(
                            "pharmacist_id"=>$id,
                            "tablet_name"=>$name,
                            "tablet_prise"=>$price,
                            "status"=>$status,
                            "remain"=>$remain,
                            "side_effect"=>$side_effect,
                            "tablet_image"=>$picture,
                            "color"=>$color
                            );
                 $res = $this->tablet_model->add_medicine($data);
                 if($res!=false)
                    {
                        $data=new stdClass();
                        $data->id=$id;
                        $data->error=0;
                        $data->success=1;
                        $data->message="Medicine add successfull";
                        $this->load->view('add_medicine',$data);
                    }
                    else
                    {
                        $data=new stdClass();
                        $data->id=$id;
                        $data->error=1;
                        $data->success=0;
                        $data->message="Error Occur!Medicine not Added,try again";
                        $this->load->view('add_medicine',$data);
                    }
            }        
        }
        else
        {
            $data->id=$_GET['id'];
            $this->load->view('add_medicine',$data);
        }
     }

     public function medicine_update()
     {
        $data=new stdClass();
        if(isset($_POST['submit']))
        {
            extract($_POST);
            $id=$this->input->post('id');
            $data=array(
                        "tablet_name"=>$name,
                        "tablet_prise"=>$price,
                        "status"=>$status,
                        "remain"=>$remain,
                        "side_effect"=>$side_effect,        
                        );
            $res=$this->tablet_model->medicine_update($data,$id);
            if($res!=false)
            {
                $data=new stdClass();
                $data->error=0;
                $data->success=1;
                $data->message="Medicine update";
                $data->id=$res->id;
                $data->details=$res;
                $this->load->view('medicine_update',$data);
            }
            else
            {
                $data=new stdClass();
                $data->error=1;
                $data->success=0;
                $data->message="Medicine not update";
                $data->id=$res->id;
                $data->details=$res;
                $this->load->view('medicine_update',$data);
            }
        }
        else
        {
            $data=new stdClass();
            $id=$_GET['t_id'];
            $res=$this->tablet_model->tablet_detail($id);
            $data->id=$res->id;
            $data->details=$res;
            $this->load->view('medicine_update',$data);           
        }
    }

     public function medicine_delete()
     {
        $data=new stdClass();
        $t_id=$_GET['t_id'];
        $p_id=$_GET['p_id'];
        $res=$this->tablet_model->medicine_delete($t_id,$p_id);
        if($res!='0' & $res!=false)
        {
            $data=new stdClass();
            $data->err=0;
            $data->success=1;
            $data->message="Medicine Deleted";
            $result=$res->result();
            $data->tablets=$result;
            $this->load->view('all_tablets',$data);
        }
        else if($res=='0')
        {
            $data=new stdClass();
            $data->err=1;
            $data->success=0;
            $data->message="No Medicine Found";
            $this->load->view('all_tablets',$data);
        }
        else
        {
            $data=new stdClass();
            $data->err=2;
            $data->success=0;
            $data->message="Medicine Deleted";
            $data->tablets=$res->result();
            $this->load->view('all_tablets',$data);
        }
        
     }

}