<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Notification_model extends CI_Model
{
    function __construct() 
    {
        parent::__construct();
        $this->load->database();
    }

    public function sendNotification()
    {
        $res = $this->db->get_where('notification')->result();
        foreach ($res as $key)
        {
            date_default_timezone_set('America/New_York');
            //date_default_timezone_set('Asia/kolkata');
            $today   = date('d-m-Y h:i A');
            //print_r($today);
            //echo "<br>";
            $notificationDate =$key->notification_date.' '.$key->time.' '.$key->time_type;
            //print_r($notificationDate);
            //echo "<br>";
            $tday = strtotime($today);
            //print_r($tday);
            //echo "<br>";
            $notificationDay = strtotime($notificationDate);  
            //print_r($notificationDay);
            //echo "<br>";


            if($notificationDay == $tday)
            {
                $notification_id = $key->id;
                $user_id     = $key->user_id;
                $medicine_id = $key->medicine_id;
                $this->db->select('*');
                $this->db->from('registration');
                $this->db->join('prescription_medicine','prescription_medicine.user_id=registration.id');
                $this->db->where(array('registration.id'=>$user_id,'prescription_medicine.id'=>$medicine_id));
                $Notify = $this->db->get()->row();
                $device_token  = $Notify->device_token;
                $medicine_name = $Notify->medicine_name;
                $message ="It's ".$medicine_name." med time! Come on in!";
                $this->send($device_token,$message);
                $this->updateNotification($notification_id);

            }
        }
    }


    public function send($customerToken,$message)
    {        
        $deviceToken = $customerToken;
        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert','assest/APNsDevCertificates.pem');
        stream_context_set_option($ctx, 'ssl', 'passphrase', '123');
        $fp = stream_socket_client(
                'ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
        if (!$fp)
        {
            exit("Failed to connect: $err $errstr" . PHP_EOL);
        }
        else
        {
            $body['aps'] = array(
            'alert' => array(
                'title' => 'Repill',
                'body' => $message,
            ),
            'sound' => 'default'
            );
            $payload = json_encode($body);
            $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
            // Send it to the server
            $result = fwrite($fp, $msg, strlen($msg));
            // Close the connection to the server
            fclose($fp);  
            //echo json_encode($result);   
            $this->check_cron(); 
        }        
    }

    public function updateNotification($notification_id)
    {
        $key = $this->db->get_where('notification',array('notification_switch'=>0,'id'=>$notification_id))->row();
        if($key!='')
        {
            date_default_timezone_set('America/New_York');
            //date_default_timezone_set('Asia/kolkata');
            $today   = date('d-m-Y h:i A');
            //print_r($today);
            //echo "<br>";
            $notificationDate =$key->notification_date.' '.$key->time.' '.$key->time_type;
            //print_r($notificationDate);

            $tday = strtotime($today);
            //print_r($tday);
            //echo "<br>";
            $notificationDay = strtotime($notificationDate);  



            if($tday==$notificationDay)
            {

                $notification_type      = $key->notification_type;
                $notification_frequency = $key->frequency;
                //print_r($notification_frequency);

                $type    = $this->getNotification_type($notification_type);
                //print_r($type);

                $next_notificationDate = date('d-m-Y', strtotime("+".$notification_frequency.' '.$type));  
                //print_r($next_notificationDate);die();

                $this->db->where('id',$key->id);
                $this->db->update('notification',array('notification_date'=>$next_notificationDate));
            } 
        }     
    }

    public function getNotification_type($notification_type)
    {
        if($notification_type==0)
        {       
            $type = 'day';
        }
        if($notification_type==1)
        {     
            $type = 'week'; 
        }
        if($notification_type==2)
        {       
            $type = 'month';
        }
        if($notification_type==3)
        {
            $type = 'year';
        }
        return $type;
    }

    public function check_cron()
    {
        $sr = 123;
        $this->db->insert('check',array('srno'=>$sr));
    }
}


