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
        //$this->check_cron();
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
            $repeatType          = $key->repeatType;
            $endDate             = $key->notification_endDate;
            $notification_switch = $key->notification_switch;
            //$messagetype    = $key->messageType;
            $messagetype    = rand(1,10);

            //echo $endDate;
            $todayEndCheck = strtotime(date('d-m-Y'));
            $endCheck      = strtotime($endDate);

            if($repeatType==1 && $todayEndCheck<=$endCheck && $notification_switch==0)
            {
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
                    //$message ="It's ".$medicine_name." med time! Come on in!";
                    //$message ="It’s time to take your meds! Come on in!";
                    $message =$this->notification_message($messagetype);
                    $this->send($device_token,$message);
                    $this->updateNotification($notification_id);

                }
            }
            
            if($repeatType==0 && $notification_switch==0)
            {    
                //print_r($notificationDate);
                //echo '<br>';
                //print_r($today);
                //echo '<br>';
                if($notificationDay == $tday)
                {
                    //echo 'match';
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
                    //$message ="It's ".$medicine_name." med time! Come on in!";
                    //$message ="It’s time to take your meds! Come on in!";
                    $message =$this->notification_message($messagetype);
                    $this->send($device_token,$message);
                    $this->updateNotification($notification_id);
                }
            }
        }
    }

    function notification_message($messagetype)
    {
        if($messagetype==1)
        {
            return 'Just a friendly reminder to take your meds. We’re friends right?';
        }
        elseif($messagetype==2)
        {
            return 'Taking your medication everyday, keeps the doctor away!';
        }
        elseif($messagetype==3)
        {
            return "Time to start the day right. Let's take our medications.";
        }
        elseif($messagetype==4)
        {
            return 'So you’re saying all I have to do is take my meds and I’ll have a free month’s supply? Yes!';
        }
        elseif($messagetype==5)
        {
            return 'Worried about potential side effects? Not taking your meds as prescribed may be a cause of that. Let’s avoid that and take them!';
        }
        elseif($messagetype==6)
        {
            return 'We want YOU to take your medication!';
        }
        elseif($messagetype==7)
        {
            return 'Wakey Wakey Eggs and RePill!';
        }
        elseif($messagetype==8)
        {
            return "You're so pharma-cute-ical! Come on in!";
        }
        elseif($messagetype==9)
        {
            return "Is it me or is there an interaction between us? Come check me out!";
        }
        else
        {
            return 'I think you are suffering from a lack of Vitamin Me. Take me!';
        }   
    }

    public function ios($deviceToken,$message)    //For testing purpose
    {
        $deviceToken = $deviceToken;//'0329955742ccbfdb084327f535d3102939eff60b83d90d12b307ed12ed6a0740';
        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert','cert/Certificates.pem');
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
                'title' => 'RePill',
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
        }        
    }


    public function send($customerToken,$message)
    {        
        $deviceToken = $customerToken;
        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert','assest/repill_Dis.pem');
        //stream_context_set_option($ctx, 'ssl', 'local_cert','assest/repill_Dev.pem');
        stream_context_set_option($ctx, 'ssl', 'passphrase', '123');
        /*$fp = stream_socket_client(
                'ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);*/  //For sendbox mode.
        $fp = stream_socket_client(
                'ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);  //For production mode.
        if (!$fp)
        {
            exit("Failed to connect: $err $errstr" . PHP_EOL);
        }
        else
        {
            $body['aps'] = array(
            'alert' => array(
                'title' => 'RePill',
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
            echo json_encode($result);   
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
                $messageType            = $key->messageType;
                /*Increase messageType for Cycling message*/
                if($messageType<10)
                {
                    $messageType++;
                }
                else
                {
                    $messageType=1;
                }
                //print_r($notification_frequency);

                $type    = $this->getNotification_type($notification_type);
                //print_r($type);

                $next_notificationDate = date('d-m-Y', strtotime("+".$notification_frequency.' '.$type));  
                //print_r($next_notificationDate);die();
                
                $this->db->where('id',$key->id);
                $this->db->update('notification',array('notification_date'=>$next_notificationDate,'messageType'=>$messageType));
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
        $sr = rand();
        $this->db->insert('check',array('srno'=>$sr));
    }
}


