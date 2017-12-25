<?php
class Tablet_model extends CI_Model {
	function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function medicine_update($data,$id)
    {
        $this->db->where('id',$id);
        $rr=$this->db->update('tablet',$data);
        if($rr)
        {
            $query=$this->db->get_where('tablet',array('id'=>$id));
            $res=$query->row();
            return $res;
        }
        else
        {
            $query=$this->db->get_where('tablet',array('id'=>$t_id));
            $res=$query->row();
            return $res;
        }
    }

    public function medicine_delete($t_id,$p_id)
    {
    	$this->db->where('id',$t_id);
    	$query=$this->db->delete('tablet');
	 	if($query)
	 	{
	 		$res=$this->db->get_where('tablet',array('pharmacist_id'=>$p_id));
	 		$count=$res->num_rows();
	 		if($count>0)
	 		{
	 			return $res;	
	 		}
	 		else
	 		{
	 			return $count;
	 		}
	 		
	 	}
	 	else
	 	{
	 		return false;
	 	}
    }

    public function all_tablets($id)
	{
		$query=$this->db->get_where('tablet',array('pharmacist_id'=>$id));
	 	return $query;
	}
    public function tablet_detail($t_id)
    {
        $query=$this->db->get_where('tablet',array('id'=>$t_id));
        $res=$query->row();
        return $res;
    }

    public function add_medicine($data)
    {
    	$r=$this->db->insert('tablet',$data);
    	if($r)
    	{
    		return true;
    	}
    	else
    	{
    		return false;
    	}
    }

    public function ios($customerToken,$message)
    {
        //$ctx = stream_context_create();
        //stream_context_set_option($ctx, 'ssl', 'local_cert', '/Users/Development/Dev/ck.pem');
        $deviceToken = $customerToken;//'0329955742ccbfdb084327f535d3102939eff60b83d90d12b307ed12ed6a0740';
        $ctx = stream_context_create();
        //stream_context_set_option($ctx, 'ssl', 'local_cert','cert/syploDevAPNsCertificates.pem');
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
                'title' => 'Banner',
                'body' => 'Banner',
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
        }        
    }

}