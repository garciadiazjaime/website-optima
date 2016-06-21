<?php
class User extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
        date_default_timezone_set('America/Los_Angeles');
	}

    public function login($user, $pssw)
    {
        //$sql = "SELECT id FROM user WHERE email ='".$user."' AND password = '".$pssw."' AND status=1 LIMIT 1";
        $sql = "SELECT id FROM user WHERE email ='".$user."' AND password = '".$pssw."' LIMIT 1";        
        $query = $this->db->query($sql);
        if($query->num_rows())
            return $query->row()->id;
        return false;   
    }

    public function get_applications($user_id)
    {
        $sql = "SELECT j.title, DATE_FORMAT(j.updated, '%m/%d/%Y') as updated
            FROM applications a
            INNER JOIN job j
            ON a.job_id = j.id AND a.user_id = ".$user_id;
        $query = $this->db->query($sql);
        if($query->num_rows())
            return $query->result();
        return 0;
    }

    public function get_username($user_id)
    {
        $sql = "SELECT email
            FROM user 
            WHERE id = ".$user_id;
        $query = $this->db->query($sql);
        
        if($query->num_rows())
            return $query->row()->email;
        return '';
    }

    public function get_profile($user_id)
    {
        $sql = "SELECT * FROM user WHERE id = ".$user_id;
        $query = $this->db->query($sql);
        if($query->num_rows())
            return $query->row();
        return false;   
    }
	
	public function register($data)
	{
		$response = '';
        $error_msg = "";
        if(!$this->is_register($data['email']))
        {
            $sql = 'SELECT IFNULL(MAX(ID), 0)+1 AS max_id FROM user';
            $query = $this->db->query($sql);
            $max_id = $query->row()->max_id;
	    $max_id = !empty($max_id) ? $max_id : '0';
            $token = md5("wipay_".$max_id);
            $data['date_reg'] = date('Y-m-d H-i-s');
            $data['token'] = $token;
            $data['password'] = $data['password'];
            $data['passconf'] = $data['password'];

            $file_path = 'resources/cv/';
            $update_fields = array();
            $config['upload_path'] = $file_path;
            $config['allowed_types'] = 'jpg|png|doc|docx|pdf';
            $config['max_size'] = '2200';
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('upload_file_route'))
            {
                $cv_error = array('error' => $this->upload->display_errors());
                $response = $cv_error['error'];
            }
            else
            {
                $cv_data = array('upload_data' => $this->upload->data());
                $data['upload_file'] = $cv_data['upload_data']['file_name'];
                $this->db->insert('user', $data);
                $this->send_email('jaime@mintitmedia.com', 'fe/email_templates/register_success', array('token'=>$token));
                $response = $this->db->insert_id();
            }
        }
        else
        {
            $response = 'error_already_register';
        }
        return $response;
	}

    public function job_apply($user_id, $joborder_id)
    {
        $this->load->database();
        $sql = "SELECT id FROM job WHERE joborder_id = '".$joborder_id."'";
        $query = $this->db->query($sql);
        $job_id = '';
        if($query->num_rows() > 0)
        {
            $data = array(
            'job_id' => $query->row()->id,
            'user_id' => $user_id,
            'date' => date('Y-m-d H:i:s')
            );
            $this->db->insert('applications', $data);    
            return true;
        }
        return false;
    }

		
	public function confirmation($token = '')
    {        
        $sql = "SELECT * FROM user WHERE token = '".$token."'";
        $query = $this->db->query($sql);
        if($query->num_rows() > 0)
        {
            if($query->row()->status !=  0 )
            {
                return "error_already_register";
            }
            else
            {
                $username = $query->row()->email;
                $pssw = $query->row()->password;
                $sql = "UPDATE user SET 
                    status = 1,
                    date_conf = '".date('Y-m-d H-i-s')."'
                WHERE id = ".$query->row()->id;
                $query = $this->db->query($sql);
                $this->send_email('jaime@mintitmedia.com', 'fe/email_templates/register_confirmation', array('username'=>$username, 'pssw'=>$pssw));
                return "success";
            }    
        }
        return "error_confirmation";
    }

	public function is_register($username = '')
    {        
        $sql = "SELECT id FROM user WHERE email = '".$username."' LIMIT 1";
        $query = $this->db->query($sql);
        if($query->num_rows())
            return true;
        return false;
    }

    public function get_cv($user_id)
    {
        $sql = "SELECT upload_file FROM user WHERE id = '".$user_id."' LIMIT 1";
        $query = $this->db->query($sql);
        if($query->num_rows())
            return $query->row()->upload_file;
        return '';
    }

    public function get_email($user_id)
    {
        $this->load->database();
        $sql = "SELECT email FROM user WHERE id = '".$user_id."' LIMIT 1";
        $query = $this->db->query($sql);
        if($query->num_rows())
            return $query->row()->email;
        return '';
    }

    public function get_jobid($job_id)
    {
        $this->load->database();
        $sql = "SELECT joborder_id FROM job WHERE id = '".$job_id."' LIMIT 1";
        echo $sql;
        $query = $this->db->query($sql);
        if($query->num_rows())
            return $query->row()->joborder_id;
        return '';
    }

    public function update_candidate_id($user_id, $candidate_id)
    {
        $this->load->database();
        $data = array(
            'candidate_id' => $candidate_id
        );
        $this->db->update('user', $data, array('id'=>$user_id));
    }

    public function get_candidate_id($user_id)
    {
        $sql = "SELECT candidate_id FROM user WHERE id = '".$user_id."' LIMIT 1";
        $query = $this->db->query($sql);
        if($query->num_rows())
            return $query->row()->candidate_id;
        return '';   
    }

    public function recover_password($email)
    {
        $sql = "SELECT password FROM user WHERE email = '".$email."' LIMIT 1";
        $query = $this->db->query($sql);
        if($query->num_rows())
        {
            $this->send_email('jaime@mintitmedia.com', 'fe/email_templates/reset_password', array('email'=>$email, 'pssw'=>$query->row()->password));
            return true;    
        }
            
        return false;   
        
    }

    public function add_file($data)
    {
        $data['date_reg'] = date('Y-m-d H-i-s');

        $file_path = 'resources/knowledge/';
        $update_fields = array();
        $config['upload_path'] = $file_path;
        $config['allowed_types'] = 'jpg|png|doc|docx|pdf';
        $config['max_size'] = '2200';
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('upload_file_route'))
        {
            $cv_error = array('error' => $this->upload->display_errors());
            $response = $cv_error['error'];
        }
        else
        {
            $cv_data = array('upload_data' => $this->upload->data());
            $data['upload_file'] = $cv_data['upload_data']['file_name'];
            $this->db->insert('file', $data);
        }   
    }

    public function send_email($to, $view = '', $parameters = '')
    {
        $this->load->library('email');
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->from('info@optima-os.com', 'Optima');
        $this->email->to($to);
        $this->email->bcc('info@mintitmedia.com');
        $this->email->subject('Optima Registration');
        $this->email->message($this->load->view($view, $parameters, true));
        $this->email->send();
    }

	/*
	function all()
	{
		$query = $this->db->query("SELECT id, name, email, DATE_FORMAT(date, '%d/%m/%Y') AS date FROM register;");
		$users = array();
		$i = 0;
		if($query->num_rows())
		{
			foreach($query->result() as $user)
			{
				$users[$i]['id'] = $user->id;
				$users[$i]['name'] = $user->name;
				$users[$i]['email'] = $user->email;
				$users[$i]['date'] = $user->date;
				$i++;
			}
			if(sizeof($users)) return $users;
		}
		return false;
	}
	
	function howmany()
	{
		$query = $this->db->query('select count(*) as total from register;');
		$users = array();
		$i = 0;
		if($query->num_rows())
		{
			return $query->row()->total;
		}
		return false; 
	}
	*/
}
