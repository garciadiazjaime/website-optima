<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

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
		$msg = '';
		$title = 'Optima - HR Functional Support and talent search';
		$keywords = 'optima hr functional support solutions talent search recruiting human resources organizational excellence business transitions';
		
		$this->lang->load('general', 'english');
		$this->menu = $this->miscellaneous->printMENU('home');

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		if ($this->form_validation->run('login') == FALSE)
		{
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			
		}
		else
		{		
			$this->load->model('admin_m');
			$files = $this->admin_m->get_files();

			if($this->admin_m->login($this->input->post('email'), $this->input->post('password')))
			{				
				$this->load->library('session');
				$this->session->set_userdata('user_id', 'F2013');
				redirect(base_url().'admin/panel', 'refresh');
			}
			else
			{
				$msg = 'invalid login';
			}
		}
		$content = $this->load->view('be/login', array('msg'=>$msg), true);
		$this->load->view('fe/layout/main', array('content' => $content, 'menu'=>$this->menu, 'location'=>'talent', 'footer'=>$this->footer, 'title'=>$title, 'keywords'=>$keywords) );
	
	}

	public function logout()
	{

		$this->load->library('session');
		$this->session->sess_destroy();
		redirect(base_url()."admin/login");
	}

	public function panel()
	{
		$this->load->library('session');
		$user_id = $this->session->userdata('user_id');
		if(!empty($user_id) && $user_id = 'F2013')		
		{
			$msg = '';
			$title = 'Optima - HR Functional Support and talent search';
			$keywords = 'optima hr functional support solutions talent search recruiting human resources organizational excellence business transitions';
			
			$this->lang->load('general', 'english');
			$this->menu = $this->miscellaneous->printMENU('home');

			$msg = '';
			$flag = isset($_GET['msg']) ? $_GET['msg'] :'';
			if($flag == 'file_added')
				$msg = 'File added successfully';
			elseif($flag == 'file_removed')
				$msg = 'File removed successfully';

			$this->load->model('admin_m');
			$files = $this->admin_m->get_files();

			$content = $this->load->view('be/panel', array('msg'=>$msg, 'files'=>$files), true);
			$this->load->view('fe/layout/main', array('content' => $content, 'menu'=>$this->menu, 'location'=>'talent', 'footer'=>$this->footer, 'title'=>$title, 'keywords'=>$keywords) );		
		}
		else
		{
			redirect(base_url()."admin/login");
		}		
	}

	public function add_file()
	{
		$msg = '';
		$title = 'Optima - HR Functional Support and talent search';
		$keywords = 'optima hr functional support solutions talent search recruiting human resources organizational excellence business transitions';
		
		$this->lang->load('general', 'english');
		$this->menu = $this->miscellaneous->printMENU('home');

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		if ($this->form_validation->run('add_file') == FALSE)
		{
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		}
		else
		{
			$this->load->model('admin_m');
			$response = $this->admin_m->add_file($this->input->post());
			if($response == 'success')
				redirect(base_url().'admin/?msg=file_added');
			else
				$msg = $response;
		}
		$content = $this->load->view('be/add_file', array('msg'=>$msg), true);
		$this->load->view('fe/layout/main', array('content' => $content, 'menu'=>$this->menu, 'location'=>'talent', 'footer'=>$this->footer, 'title'=>$title, 'keywords'=>$keywords) );	
	}

	public function remove_file($file_id)
	{
		$this->load->model('admin_m');		
		$file = $this->admin_m->remove_file($file_id);
		if(is_file('resources/files/'.$file))
			unlink('resources/files/'.$file);
		redirect(base_url().'admin/?msg=file_removed');
	}
	
	public function clear_cache()
	{
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");
	}


/* End of file fe.php */
/* Location: ./application/controllers/fe.php */
}
