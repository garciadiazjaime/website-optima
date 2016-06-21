<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Talent extends CI_Controller {

	var $menu = '';
	var $location = '';
	var $title = '';
	var $keywords = '';
	var $footer='';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('miscellaneous');
		$this->clear_cache();
	}

	public function login()
	{
		$title = 'Optima - HR Functional Support and talent search';
		$keywords = 'optima hr functional support solutions talent search recruiting human resources organizational excellence business transitions';
		$this->lang->load('general', 'english');
		$this->menu = $this->miscellaneous->printMENU('home');

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		if ($this->form_validation->run('login') == FALSE)
		{
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			$content = $this->load->view('fe/talent/login', array('msg'=>''), true);
		}
		else
		{		
			$this->load->model('user');			
			$user_id = $this->user->login($this->input->post('email'), $this->input->post('password'));			
			if($user_id)
			{
				$this->load->library('session');
				$this->session->set_userdata('user_id', $user_id);
				$job_id = $this->session->userdata('job_id');
				if(!empty($job_id))
				{
					redirect(base_url().'talent/job/'.$job_id, 'refresh');	
				}
				else
				{
					redirect(base_url().'my_account', 'refresh');
				}
			}
			else
			{
				$content = $this->load->view('fe/talent/login', array('msg'=>'invalid login'), true);	
			}
		}	

		$this->load->view('fe/layout/main', array(
			'content' => $content, 
			'menu'=>$this->menu, 
			'location'=>'talent', 
			'footer'=>$this->footer, 
			'title'=>$title, 
			'keywords'=>$keywords) 
		);
	}

	public function logout()
	{
		$this->load->library('session');
		$this->session->sess_destroy();
		redirect(base_url()."login");
	}

	public function my_account()
	{
		$title = 'Optima - HR Functional Support and talent search';
		$keywords = 'optima hr functional support solutions talent search recruiting human resources organizational excellence business transitions';
		$this->lang->load('general', 'english');
		$this->menu = $this->miscellaneous->printMENU('home');

		$this->load->library('session');
		$user_id = $this->session->userdata('user_id');
		if(is_numeric($user_id))
		{
			$this->load->model('user');
			$applications = $this->user->get_applications($user_id);
			$user_name = $this->user->get_username($user_id);

			$content = $this->load->view('fe/talent/my_account', array('user_name'=>$user_name, 'applications'=>$applications), true);
			$this->load->view('fe/layout/main', array(
				'content' => $content, 
				'menu'=>$this->menu, 
				'location'=>'talent', 
				'footer'=>$this->footer, 
				'title'=>$title, 
				'keywords'=>$keywords) 
			);
		}
		else
		{
			redirect(base_url()."login");
		}
	}

	public function profile($flag = '')
	{
		$title = 'Optima - HR Functional Support and talent search';
		$keywords = 'optima hr functional support solutions talent search recruiting human resources organizational excellence business transitions';
		$this->lang->load('general', 'english');
		$this->menu = $this->miscellaneous->printMENU('home');

		$this->load->library('session');
		$user_id = $this->session->userdata('user_id');
		$msg = "";
		$error_msg = "";
		if(is_numeric($user_id))
		{
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->load->model('user');

			$data = $this->user->get_profile($user_id);
			if ($this->form_validation->run('register') == FALSE)
			{
				$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			}
			else
			{	
				$file_path = 'resources/cv/';
		        $update_fields = array();
		        $config['upload_path'] = $file_path;
				$config['allowed_types'] = 'gif|jpg|png|doc|docx|pdf';
				$config['max_size']	= '5000';
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload('upload_file_route'))
				{
					$cv_error = array('error' => $this->upload->display_errors());
					$error_msg = $cv_error['error'];
				}
				else
				{
					$cv_data = array('upload_data' => $this->upload->data());
					$update_fields['upload_file'] = $cv_data['upload_data']['file_name'];
					if(!empty($data->upload_file))
					{
						$this->load->helper('file');
						echo $file_path.$cv_data['upload_data']['file_name'];
						if( file_exists($file_path.$data->upload_file))
							unlink($file_path.$data->upload_file);
					}
				}

		        foreach($data as $key => $row)
		        {
		            if(array_key_exists($key, $this->input->post()) && $row != $this->input->post($key))
		                $update_fields[$key] = $this->input->post($key);
		        }
		        if(sizeof($update_fields))
		        {
		            $this->db->update('user', $update_fields, array('id'=>$user_id));
		            if(array_key_exists('emal', $update_fields))
		            {
		                $this->user_change_email($data->user_id, $update_fields['emal']);
		                $msg = "email changed";
		            }
		            else
		                $msg = "<span class=\"success\">info updated</span>";        
		            $data = $this->user->get_profile($user_id);
		        }
		        else
		            $msg = "no updates";
			}
			$content = $this->load->view('fe/talent/profile', array('data'=>$data, 'msg'=>$msg, 'error_msg'=>$error_msg), true);
			
			$this->load->view('fe/layout/main', array(
					'content' => $content, 
					'menu'=>$this->menu, 
					'location'=>'talent', 
					'footer'=>$this->footer, 
					'title'=>$title, 
					'keywords'=>$keywords) 
				);
		}
		else
		{
			redirect(base_url()."login");
		}
	}

	public function user_change_email($user_id, $username)
    {
        $token = md5(date('Y-m-d H-i-s'));
        $data = array(
            'token' => $token,
            'status' => 0
            );
        $this->db->update('user', $data, array('id'=>$user_id));
        $this->send_email($username, 'fe/email_templates/change_email_success', array('token'=>$token));
    }

	public function register($flag = '')
	{	
		$title = 'Optima - HR Functional Support and talent search';
		$keywords = 'optima hr functional support solutions talent search recruiting human resources organizational excellence business transitions';
		$this->lang->load('general', 'english');
		$this->menu = $this->miscellaneous->printMENU('home');
		$user_id = '';
		if(empty($flag))
		{
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			if ($this->form_validation->run('register') == FALSE)
			{
				$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
				$content = $this->load->view('fe/talent/register', array('msg'=>''), true);
			}
			else
			{
				$this->load->model('user');
				$response = $this->user->register($this->input->post());

				if(is_numeric($response))
				{
					$user_id = $response;
					$response = 'success';
					$file_path = '';
					$cv = $this->user->get_cv($user_id);
					if(!empty($cv))
						$file_path = getcwd()."/resources/cv/".$cv;

					$this->load->library(array('session', 'catsapi'));
		            $candidate_id = $this->catsapi->add_candidate(
		                '',
		                $this->input->post('first_name'),
		                '',
		                $this->input->post('last_name'),
		                $this->input->post('title'),
		                $this->input->post('phone'),
		                $this->input->post('alt_phone'),
		                '',
		               	$this->input->post('address'),
		                $this->input->post('city'),
		                $this->input->post('state'),
		                $this->input->post('zip_code'),
		                '',
		                $this->input->post('date_available'),
		                '',
		                'Created by: Website || '.
		                	'Current title: '.$this->input->post('current_title').' || '.
		                	'Technologies: '.$this->input->post('technologies').' || '.
		                	'More Info: '.$this->input->post('more_info').' || '
		                ,
		                $this->input->post('skills'),
		                $this->input->post('current_employer'),
		                '',
		                '',
		                '',
		                'website',
		                $this->input->post('email'),
		                '',
		                '',
		                '',
		                $this->input->post('desire_pay'),
		                $this->input->post('current_pay'),
		                '',
		                '',
		                $this->input->post('password'),
		                '',
		                $file_path,
		                '',
		                ''
		                );

					$results = $this->catsapi->search(
						$this->input->post('email'), 
						'candidate', 
						'yes',
						'1',
						''
						);
					$candidate_id = $results->item->id;
					$this->user->update_candidate_id($user_id, $candidate_id);
				}
				switch($response)
				{
					case 'success':
						//$this->load->library('session');
						$job_id = $this->session->userdata('job_id');

						if(!empty($job_id))
						{
							$this->session->set_userdata('user_id', $user_id);
							redirect(base_url().'talent/job/'.$job_id, 'refresh');
						}
						else
						{
							redirect(base_url().'talent/register/success', 'refresh');
						}
					break;
					case 'error_already_register':
						$content = $this->load->view('fe/talent/error_already_register', '', true);
					break;
					default:
						$content = $this->load->view('fe/talent/register', array('msg'=>$response), true);
				}
			}	
		}
		elseif($flag == 'success')
		{
			$content = $this->load->view('fe/talent/success', '', true);
		}
		$this->load->view('fe/layout/main', array(
					'content' => $content, 
					'menu'=>$this->menu, 
					'location'=>'talent', 
					'footer'=>$this->footer, 
					'title'=>$title, 
					'keywords'=>$keywords) 
				);
	}

	public function confirmation($token = '')
	{
		$title = 'Optima - HR Functional Support and talent search';
		$keywords = 'optima hr functional support solutions talent search recruiting human resources organizational excellence business transitions';
		$this->lang->load('general', 'english');
		$this->menu = $this->miscellaneous->printMENU('home');
		$this->load->model('user');		
		$response = $this->user->confirmation($token);
		switch ($response)
		{
			case 'success':
				$content = $this->load->view('fe/talent/confirmation','', true);
			break;
			case 'error_already_register':
				$content = $this->load->view('fe/talent/error_already_register','', true);
			break;
			case 'error_confirmation':
				$content = $this->load->view('fe/register/error_confirmation','', true);
			break;/*
			case 'error_no_identity':
				$content = $this->load->view('fe/register/error_no_identity','', true);
			break;*/
		}
		$this->load->view('fe/layout/main', array(
					'content' => $content, 
					'menu'=>$this->menu, 
					'location'=>'talent', 
					'footer'=>$this->footer, 
					'title'=>$title, 
					'keywords'=>$keywords) 
				);
	}

	public function username_check($str)
	{
		if ($str == 'test')
		{
			$this->form_validation->set_message('username_check', 'The %s field can not be the word "test"');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	     
   	}

   	public function send_email($to, $view = '', $parameters = '')
    {
        $this->load->library('email');
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->from('info@wipay.com', 'Wipay');
        $this->email->to($to);
        $this->email->bcc('info@mintitmedia.com');
        $this->email->subject('Email Registration');
        $this->email->message($this->load->view($view, $parameters, true));
        $this->email->send();
    }

    public function add_candidate($data)
    {
    	$this->load->library('catsapi');
    	$results = $this->catsapi->add_candidate(
    		'65093985', 
    		'name', 
    		'mid', 
    		'last', 
    		'title', 
    		'phone', 
    		'cell', 
    		'phone work'
    		);
    	if (!$results)
		{
		    printf('Error Code #%d<br />', $this->catsapi->get_error_code());
		    printf('Message: %s<br />', $this->catsapi->get_error_message());
		}

		if (!empty($results->item))
		{
		    printf("%d Results:\n\n<ul>", count($results->item));

		    /*
		    foreach ($results->item as $item)
		    {
		        printf("<li>%s</li>\n", $item->summary);
		    }
		    */
		}
    }

    public function get_candidates()
    {
    	$this->load->library('catsapi');
		$results = $this->catsapi->get_joborders('', 20);
		if (!$results)
		{
		    printf('Error Code #%d<br />', $this->catsapi->get_error_code());
		    printf('Message: %s<br />', $this->catsapi->get_error_message());
		}

		if (!empty($results->item))
		{
		    printf("%d Results:\n\n<ul>", count($results->item));
		    foreach ($results->item as $item)
		    {
		        print_r($item);
		        echo "<br /><br /><br />";
		    }
		}	
    }

    public function search($user_id = 1)
    {
    	$this->load->model('user');
    	$this->load->library('catsapi');
    	
    	$user = $this->user->get_email($user_id);
		$results = $this->catsapi->search(
			$user, 
			'candidate', 
			'yes', 
			'1', 
			''
			);
		if (!$results)
		{
		    printf('Error Code #%d<br />', $this->catsapi->get_error_code());
		    printf('Message: %s<br />', $this->catsapi->get_error_message());
		}

		if (!empty($results->item))
		{
		    printf("%d Results:\n\n<ul>", count($results->item));
		    foreach ($results->item as $item)
		    {
		        print_r($item);
		        echo "<br /><br /><br />";
		    }
		    echo "id: ".$results->item->id;
		}
	}	

	public function add_pipeline()
	{
		$this->load->library('catsapi');	
		$results = $this->catsapi->add_pipeline(
			'56032375', 
			'2028551', 
			'applied by the website', 
			'', 
			''
			);
		if (!$results)
		{
		    printf('Error Code #%d<br />', $this->catsapi->get_error_code());
		    printf('Message: %s<br />', $this->catsapi->get_error_message());
		}

		if (!empty($results->item))
		{
		    printf("%d Results:\n\n<ul>", count($results->item));
		    foreach ($results->item as $item)
		    {
		        print_r($item);
		        echo "<br /><br /><br />";
		    }
		    echo "id: ".$results->item->id;
		}
	}

   	public function clear_cache()
	{
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");
	}

/* End of file talent.php */
/* Location: ./application/controllers/talent.php */
}
