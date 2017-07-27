<?php defined('BASEPATH') OR exit('No direct script access allowed');
class PrescriptionControler extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->library("form_validation");
		$this->load->helper("form");
        $this->load->model("user_model");
        $this->load->model("admin_model");
        $this->load->model("PrescriptionModel");
        $this->load->model("Prescriptioncheck");
        $this->load->model("pharmasist_model");
        

        $this->load->library("upload"); 
        $this->load->library("session");
        if($this->session->userdata('email') == '')
        {
           redirect('admin');
        }
	}
	public function index()
	{
        if($this->session->userdata('status')=='admin')
        {
            $table_name='prescription';
            $statusupdate= $this->Prescriptioncheck->updatecount($table_name);
            $res=$this->PrescriptionModel->prescriptionimage();            
            $pharma=$this->PrescriptionModel->pharmasistname();
            if($res!=false)
                {
                    $pres_images=$this->PrescriptionModel->pres_image();
                    $data=new stdClass();
                    $data->image=$res;
                    $data->pharmaname=$pharma;
                    $data->pres_image=$pres_images;
                    $this->load->view('prescription',$data);
                }
                else
                {
                    $data=new stdClass();
                    $data->error=1;
                    $data->message="No prescription request";
                    $this->load->view('prescription',$data);
                }
        }
        else
        {
            $id=$this->session->userdata('id');
            $res=$this->PrescriptionModel->prescriptionimage1($id);
            if($res!=false)
            {
                $pres_images=$this->PrescriptionModel->pres_image1($id);
                $data=new stdClass();
                $data->image=$res;
                $data->pres_image=$pres_images;
                $this->load->view('prescription',$data);
            }
            else
            {
                 $data=new stdClass();
                 $data->error=1;
                 $data->message="No prescription request";
                 $this->load->view('prescription',$data);
            }
            // $data=new stdClass();
            // $data->image=$res;
            // $this->load->view('prescription',$data);
        }   
	}
    
    public function checkprescription()
    {
        $res=$this->Prescriptioncheck->prescriptioncount();          
        print_r($res);
    }

    public function checkpopup()
    {
        $res=$this->Prescriptioncheck->checkpopup();
        if($res!=false)
        {
            foreach ($res as $key)
            {
                $response['name'][]='Name :'.$key->first_name.' '.$key->last_name.'<br> Email : '.$key->email.'<br>';
            }
            //$full_name["name"]= $res->first_name.' '.$res->last_name;
            echo json_encode($response);
            //print_r("User  : ".$full_name);
            //echo "<br>";
           // print_r("User Email : ".$res->email);
        }
        else
        {
            return false;
        }
       //print_r($email);
    }

    public function popupremove()
    {
        $table_name='prescription';
        $statusupdate= $this->Prescriptioncheck->removepopup($table_name);
    }



    public function add_prescription()
    {
        $u_id=$_GET['u_id'];
        $p_id=$_GET['p_id'];
        $pres_id=$_GET['pres_id'];
        if($this->input->post('submit'))
        {
            extract($_POST);
            $total_day      = $_POST['days'];
            $total_time     = count($time);
            $total_medicine = $_POST['quantity'];  
            $Dailytake        = $total_medicine/($total_day*$total_time);      

            $picture="default_tablet.png";
            if(isset($_FILES['image']['name']) && $_FILES['image']['name']!='')
            {
                $s=$_FILES["image"]["tmp_name"];
                $pic=$_FILES["image"]["name"];
                $picture = preg_replace('/\s*/m', '',$pic);
                $d="tablet_image/".$picture;
                move_uploaded_file($s,$d); 
            } 

            $basic_data = array(
                    "user_id"=>$user_id,
                    "pharmacist_id"     => $pharmasist_id,
                    "medicine_company"  => $company,   
                    "medicine_name"     => $medicine,
                    "medicine_type"     => $type,
                    "medicine_image"    => $picture,
                    "prescription_id"   => $prescription_id,
                    "prescription"      => $prescription,
                    "dose_days"         => $days,
                    "total_medicine"    => $quantity,
                    "unit"              => $unit,
                    "remain_medicine"   => $quantity,
                    "dailyDose"         => $Dailytake,
                    "end_date"          => $endDate,
                );


            if($medicine_id = $this->PrescriptionModel->add_prescription($basic_data))
            { 
                $this->PrescriptionModel->add_time($medicine_id,$prescription_id,$time,$endDate);        
                $p_id=$this->session->userdata('id');
                $data=new stdClass();
                $data->u_id=$u_id;
                $data->p_id=$p_id;
                $data->pres_id=$pres_id;
                $data->med=1;
                $data->success=1;
                $data->message="Prescription hass been Added Successfully";
                $this->load->view('add_prescription',$data);
            }
            else
            {
                $p_id=$this->session->userdata('id');
                $data=new stdClass();
                $data->med=1;
                $data->u_id=$u_id;
                // $data->m_id=$m_id;
                $data->p_id=$p_id;
                $data->pres_id=$pres_id;
                $data->error=1;
                $data->message="Error Occur! Prescription Not Submit";
                $this->load->view('add_prescription',$data);
            }
        }
        else
        {
            $data=new stdClass();
            $data->med=0;
            $data->u_id=$u_id;
            $data->p_id=$p_id;
            $data->pres_id=$pres_id;
            $this->load->view('add_prescription',$data);
        }
    }

    // -------------------------------------------------------------------------------------------------------------
    
    //When user send Renew Request of prescription


    public function renew_prescription()
    {
        $data=new stdClass();
        if($this->session->userdata('status')=='admin')
        {        
            $res1=$this->PrescriptionModel->renew_prescription();
            $pharma=$this->PrescriptionModel->pharmasistname();
            if($res1!=false)
            {
                $result1=$res1->result();
                $data->prescription1=$result1;
                $data->pharmaname=$pharma;
                $this->load->view('renew_prescription',$data);
            }
            else
            {
                $data->error=1;
                $data->message="No Renew Prescription Request Available";
                $this->load->view('renew_prescription',$data);
            }
        }
        else
        {
            $id=$this->session->userdata('id');
            $res1=$this->PrescriptionModel->renew_prescription1($id);
            $pharma=$this->PrescriptionModel->pharmasistname();
            if($res1!=false)
            {
                $result1=$res1->result();
                $data->prescription1=$result1;
                $data->pharmaname=$pharma;
                $this->load->view('renew_prescription',$data);
            }
            else
            {
                $data->error=1;
                $data->message="No Renew Prescription Request Available";
                $this->load->view('renew_prescription',$data);
            }

        }
    }

// -------------------------------------------------------------------------------------------------------------

    public function add_renew_prescription()
    {
        $timestamp = date('Y/m/d H:i:s');
        $med_id = $_GET['med_id'];
        $pres_id=$_GET['pres_id'];
        $data=new stdClass();
        if($this->input->post('update'))
        {
            extract($_POST);
            $today = date('d-m-Y');
            $todays = strtotime($today.'+1 day');
            $previous = strtotime($previousendDate);
            if($todays>=$previous)
            {
                $startdate = date('d-m-Y',$todays);
                $end       = strtotime($startdate.'+'.$newdays.' day');
                $enddate   = date('d-m-Y',$end);
            }
            else
            {
                $startdate = $previousendDate;
                $end       = strtotime($previousendDate.'+'.$newdays.' day');
                $enddate   = date('d-m-Y',$end);
                //echo '2endDate'.date('d-m-Y',$end);
            }
            //print_r($startdate);
            //print_r($enddate);
            //echo "<pre>";
           // print_r($_POST);die();
            $total_day      = $_POST['newdays'];
            $total_time     = count($time);
            $total_medicine = $_POST['quantity'];  
            $take           = $total_medicine/($total_day*$total_time);

            $picture=$img;
            if(isset($_FILES['image']['name']) && $_FILES['image']['name']!='')
            {
                $s=$_FILES["image"]["tmp_name"];
                $pic=$_FILES["image"]["name"];
                $picture = preg_replace('/\s*/m', '',$pic);
                $d="tablet_image/".$picture;
                move_uploaded_file($s,$d); 
            } 

            $c=count($time);
            $data=array(
                "medicine_company"  => $company,   
                "medicine_name"     => $medicine,
                "medicine_type"     => $type,
                "medicine_image"    => $picture,
                "prescription"      => $prescription,
                "dose_days"         => $newdays,
                "total_medicine"    => $quantity,
                "remain_medicine"   => $remain,
                "dailyDose"         => $take,
                "unit"              => $unit,
                "end_date"          => $enddate,
                "pres_status"       => 0
                );
            
            $response=$this->PrescriptionModel->Add_renew_presctiption($data,$pres_id,$med_id);          
            //$response=$this->PrescriptionModel->update_presctiption($timedata);
            if($response!=false)
            {
                $this->PrescriptionModel->add_renewtime($med_id,$pres_id,$time,$startdate,$enddate);
                $data=new stdClass();
                $record=$this->PrescriptionModel->prescription_record($med_id,$pres_id);
                $rec_time=$this->PrescriptionModel->prescription_time($med_id,$pres_id);
                $data->success=1;
                $data->message="Prescription has been successfully submitted";
                $data->list=$record;
                $data->mtime=$rec_time;
                $this->load->view('add_renew_prescription',$data);
            }
            else
            {
                $data=new stdClass();
                $record=$this->PrescriptionModel->prescription_record($med_id,$pres_id);
                $rec_time=$this->PrescriptionModel->prescription_time($med_id,$pres_id);
                $data->error=1;
                $data->message="Try Again!Prescription Not Update";
                $data->list=$record;
                $data->mtime=$rec_time;
                $this->load->view('add_renew_prescription',$data);
            }
        }
        else
        {
            $data=new stdClass();
            $record=$this->PrescriptionModel->prescription_record($med_id,$pres_id);
            $rec_time=$this->PrescriptionModel->prescription_time($med_id,$pres_id);
            $data->list=$record;
            $data->mtime=$rec_time;
            $this->load->view('add_renew_prescription',$data);
        }
    }

// -------------------------------------------------------------------------------------------------------------

    public function update_prescription()
    {
        $medicine_id=$_GET['med_id'];
        $pres_id=$_GET['pres_id'];
        // $med_name=$_GET['med_name'];
        $data=new stdClass();
        if($this->input->post('update'))
        {   
            extract($_POST); 
            // echo "<pre>";
            //print_r($_POST);die();
            $total_day      = $_POST['newdays'];
            $total_time     = count($time);
            $total_medicine = $_POST['quantity'];  
            $take           = $total_medicine/($total_day*$total_time);
            $picture=$img;
            if(isset($_FILES['image']['name']) && $_FILES['image']['name']!='')
            {
                $s=$_FILES["image"]["tmp_name"];
                $pic=$_FILES["image"]["name"];
                $picture = preg_replace('/\s*/m', '',$pic);
                $d="tablet_image/".$picture;
                move_uploaded_file($s,$d); 
            } 
                $c=count($time);
                $data=array(
                    "medicine_company"  => $company,   
                    "medicine_name"     => $medicine,
                    "medicine_type"     => $type,
                    "medicine_image"    => $picture,
                    "prescription"      => $prescription,
                    "dose_days"         => $newdays,
                    "total_medicine"    => $quantity,
                    "remain_medicine"   => $remain,
                    "dailyDose"         => $take,
                    "unit"              => $unit,
                    "end_date"          => $endDate
                    );

                 $timedata = array(
                    "startDate" =>$start_date,
                    "olddays"=>$olddays,
                    "newdays"=>$newdays,
                    "time"=>$time,
                    "previousEndDate"=>$previousendDate,
                    "endDate"=>$endDate,
                    );

                 //echo "<pre>";
                 //print_r($data);
                 //print_r($timedata);die();
            $response=$this->PrescriptionModel->update_presctiption($data,$timedata,$pres_id,$medicine_id);
            // $response=$this->PrescriptionModel->update_presctiption($timedata);
            if($response!=false)
            {
                $data=new stdClass();
                $record=$this->PrescriptionModel->prescription_record($medicine_id,$pres_id);
                $rec_time=$this->PrescriptionModel->prescription_time($medicine_id,$pres_id);
                $data->success=1;
                $data->message="Update success";
                $data->list=$record;
                $data->mtime=$rec_time;
                $this->load->view('update_prescription',$data);
            }
            else
            {
                $data=new stdClass();
                $record=$this->PrescriptionModel->prescription_record($medicine_id,$pres_id);
                $rec_time=$this->PrescriptionModel->prescription_time($medicine_id,$pres_id);
                $data->error=1;
                $data->message="Try Again! Not Update";
                $data->list=$record;
                $data->mtime=$rec_time;
                $this->load->view('update_prescription',$data);
            }

        }
        else
        {
            $data=new stdClass();
            $record=$this->PrescriptionModel->prescription_record($medicine_id,$pres_id);
            $rec_time=$this->PrescriptionModel->prescription_time($medicine_id,$pres_id);
            $data->list=$record;
            $data->mtime=$rec_time;
            $this->load->view('update_prescription',$data);
        }
    }

    public function assign_pharmacist()
    {
        $data=new stdClass();
        $pres_id=$_GET['pres_id'];
        $ph_name=$_GET['ph_name'];
        // $rf_image=$_GET['rf_img'];
        $data->pres_id=$pres_id;
        $data->ph_name=$ph_name;
        // $data->rf_image=$rf_image;
        $data->pharmalist=$this->pharmasist_model->registred_pharmasist();
        $this->load->view('assign_pharmacist',$data);
    } 

    public function assigned()
    {
        $ph_id=$_GET['ph_id'];
        $pres_id=$_GET['pres_id'];
        $res=$this->PrescriptionModel->assigned($ph_id,$pres_id);
        if($res!=false)
        {
            $data=new stdClass();
            $data->sucess=1;
            $data->message="Pharmacist assigned Successful";
            $data->pres_id=$_GET['pres_id'];
            $data->ph_name=$_GET['ph_name'];
            $data->change=$this->PrescriptionModel->assignedpharmacist($ph_id);
            $data->pharmalist=$this->pharmasist_model->registred_pharmasist();
            $this->load->view('assign_pharmacist',$data);
        }
        else
        {
            $data=new stdClass();
            $data->error=1;
            $data->message="Error Occur! Pharmacist Not Assigned";
            $data->pres_id=$_GET['pres_id'];
            $data->pharmalist=$this->pharmasist_model->registred_pharmasist();
            $this->load->view('assign_pharmacist',$data);
        }
    }

    public function change_pharmacist()
    {
        $ph_id=$_GET['ph_id'];
        $data=new stdClass();
        $data->pres_id=$_GET['pres_id'];
        $data->ph_name=$_GET['ph_name'];
        $data->change=$this->PrescriptionModel->assignedpharmacist($ph_id);
        $data->pharmalist=$this->pharmasist_model->registred_pharmasist();
        $this->load->view('assign_pharmacist',$data);
    } 
    

    public function medicine_type()
    {
        $data=new stdClass();
        if(!empty($_POST["id"])) 
        {
            $id=$_POST['id'];
            $medicine_type=$this->PrescriptionModel->medicine_type($id);
            print_r($medicine_type);
        }

    }

     public function medicine()
     {
        if(!empty($_POST["id"])) 
        {
            $id=$_POST['id'];
            $medicine=$this->PrescriptionModel->medicine_type($id);

        }
    }

    public function show_prescription()
    {
        $data=new stdClass();
        $pres_id=$_GET['pres_id'];
        $res1=$this->PrescriptionModel->prescription_list($pres_id);
        if($res1!=false)
        {
            $result1=$res1->result();
            // $a=array();
            // foreach ($result1 as $key) 
            // {
            //      $a[]=$key->medicine_name; 
            // }         
            // $res=$this->PrescriptionModel->prescription_time($pres_id,$a);
            //$data->prescription=$res;
            $data->prescription1=$result1;
            $this->load->view('prescription_list',$data);
        }
        else
        {
            $data->error=1;
            $data->message="No Prescription Available";
            $this->load->view('prescription_list',$data);

        }
    }

    public function search_company()
    {
        if(isset($_GET['term']))
        {
            $result=$this->PrescriptionModel->search_company($_GET['term']);
            if(count($result)>0)
            {
                foreach($result as $pr)
                $arr_result[]=$pr->name;
                echo json_encode($arr_result);
            }
        }
    }
    
    public function search_medicine()
    {
        if(isset($_GET['term']))
        {
            $result=$this->PrescriptionModel->search_medicine($_GET['term']);
            if(count($result)>0)
            {
                foreach($result as $pr)
                $arr_result[]=$pr->medicine_name;
                echo json_encode($arr_result);
            }
        }
    }

    public function allprescription()
    {
        $data=new stdClass();
        $pharmacist_id=$_GET['p_id'];
        $res1=$this->PrescriptionModel->allprescription($pharmacist_id);
        if($res1!=false)
        {
            $result1=$res1->result();
            $data->prescription1=$result1;
            $this->load->view('pharmacist_Allprescription',$data);
        }
        else
        {
            $data->error=1;
            $data->message="No Prescription Available";
            $this->load->view('pharmacist_Allprescription',$data);
        }
    }

    
    //******************When Prescription Delete from show_prescription page**************//

    public function delete_prescription()
     {
        $data=new stdClass();
        $med_id  = $_GET['med_id'];
        $pres_id = $_GET['pres_id'];
        $res=$this->PrescriptionModel->delete_prescription($med_id);
        if($res!=false)
        {
            $res1=$this->PrescriptionModel->prescription_list($pres_id);
            if($res1!=false)
            {
                $data->success=1;
                $data->message="Prescription has been removed sucessfully";
                $result1=$res1->result();
                $data->prescription1=$result1;
                $this->load->view('prescription_list',$data);
            }
            else
            {
                $data->success=2;
                //$data->prescription1="";
                $data->message="Prescription has been removed sucessfully , No Prescription Remain";
                $this->load->view('prescription_list',$data);
            }       
        }
        else
        {
            $data->error=1;
            $data->message="Error occur! Prescription does not remove";
            $res1=$this->PrescriptionModel->prescription_list($pres_id);
            //$data->prescription1="";
            $this->load->view('prescription_list',$data);
        }
    }

    //******************When Prescription Delete from All prescription page**************//
    public function delete_prescription1()
    {
        $data=new stdClass();
        $id=$_GET['id'];
        $pres_id=$_GET['pres_id'];
        $pharmacist_id=$_GET['p_id'];
        //print_r($id);
        $res=$this->PrescriptionModel->delete_prescription($id);
        if($res!=false)
        {
            $res1=$this->PrescriptionModel->allprescription($pharmacist_id);
            if($res1!=false)
            {
                $data->success=1;
                $data->message="Prescription has been removed sucessfully";
                $result1=$res1->result();
                $data->prescription1=$result1;
                $this->load->view('pharmacist_Allprescription',$data);
            }
            else
            {
                $data->success=2;
                $data->message="Prescription has been removed sucessfully , No Prescription Remain";
                $this->load->view('pharmacist_Allprescription',$data);
            }  
        }
        else
        {
            $data->error=1;
            $data->message="Error occur! Prescription does not remove";
            $res1=$this->PrescriptionModel->allprescription($pharmacist_id);
            $result1=$res1->result();
            $data->prescription1=$result1;
            $this->load->view('pharmacist_Allprescription',$data);
        }
    }
}

