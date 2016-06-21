<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fe extends CI_Controller {

	var $menu = '';
	var $location = '';
	var $title = '';
	var $keywords = '';
	var $footer='';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('miscellaneous');
	}

	public function index()
	{	
		$title = 'Optima - Talent Search';
		$keywords = 'optima hr functional support solutions talent search recruiting human resources organizational excellence business transitions';
		
		$this->lang->load('general', 'english');
		$this->menu = $this->miscellaneous->printMENU('home');

		$this->load->model('catsapi_m');
		$jobs = $this->catsapi_m->get_joborders_home();		

		$content = $this->load->view('fe/home', array('jobs'=>$jobs), true);
		$this->load->view('fe/layout/main', array('content' => $content, 'menu'=>$this->menu, 'location'=>'home', 'footer'=>$this->footer, 'title'=>$title, 'keywords'=>$keywords) );
	
	}
	public function about()
	{
		$title = 'About Us - Optima';
		$keywords = 'optima hr functional support solutions talent search recruiting human resources organizational excellence business transitions strategic partner upgrade talent management systems';
		
		$this->lang->load('general', 'english');
		$this->menu = $this->miscellaneous->printMENU('about_us');
		$content = $this->load->view('fe/about_us', '', true);
		$this->load->view('fe/layout/main', array('content' => $content, 'menu'=>$this->menu, 'location'=>'about', 'footer'=>$this->footer, 'title'=>$title, 'keywords'=>$keywords) );
	}

	public function services()
	{
		$title = 'Our Services - Optima';
		$keywords = 'optima services hr functional support solutions talent search recruiting human resources organizational excellence business transitions';
		
		$this->lang->load('general', 'english');
		$this->menu = $this->miscellaneous->printMENU('services');
		$content = $this->load->view('fe/services', '', true);
		$this->load->view('fe/layout/main', array('content' => $content, 'menu'=>$this->menu, 'location'=>'services', 'footer'=>$this->footer, 'title'=>$title, 'keywords'=>$keywords) );
	}

	public function talent($num = 0, $search = '')
	{	
		$title = 'Find Talent - Optima';
		$keywords = 'optima hr functional support solutions talent search recruiting human resources organizational excellence business transitions';
	
		$this->lang->load('general', 'english');
		$this->menu = $this->miscellaneous->printMENU('talent');

		$this->load->model('catsapi_m');		
		$jobs = $this->catsapi_m->get_joborders_talent($num, $search);		

		$content = $this->load->view('fe/talent', array('num'=>$num, 'jobs'=>$jobs), true);
        $this->load->view('fe/layout/main', array('content' => $content, 'menu'=>$this->menu, 'location'=>'talent', 'title'=>$title, 'keywords'=>$keywords) );
	}

	public function view_job($id = 0)
	{
		$msg = '';
		$title = 'Find Talent - Optima';
		$keywords = 'optima hr functional support solutions talent search recruiting human resources organizational excellence business transitions';
	
		$this->lang->load('general', 'english');
		$this->menu = $this->miscellaneous->printMENU('talent');

		$this->load->model('catsapi_m');		
		$job = $this->catsapi_m->get_job($id);

		$this->load->library('session');
		$job_id = $this->session->userdata('job_id');
		$user_id = $this->session->userdata('user_id');
		if(!empty($user_id) && !empty($job_id))
		{
			$msg = "Thanks now you are logged so please click on 'apply job' again in order to complete your application.";
		}

		$content = $this->load->view('fe/talent/job', array('job'=>$job, 'msg'=>$msg), true);
        $this->load->view('fe/layout/main', array('content' => $content, 'menu'=>$this->menu, 'location'=>'talent', 'title'=>$title, 'keywords'=>$keywords) );

	}

	public function job_apply($job_id = 0)
	{
		$title = 'Find Talent - Optima';
		$keywords = 'optima hr functional support solutions talent search recruiting human resources organizational excellence business transitions';
	
		$this->lang->load('general', 'english');
		$this->menu = $this->miscellaneous->printMENU('talent');

		$this->load->model('user');
		$this->load->library(array('session', 'catsapi'));
		$user_id = $this->session->userdata('user_id');
		if(is_numeric($user_id) and $job_id > 0)
		{
			
			if($this->user->job_apply($user_id, $job_id))
			{
				$candidate_id = $this->user->get_candidate_id($user_id);
				$this->catsapi->add_pipeline(
					$candidate_id, 
					$job_id, 
					'applied by the website', 
					'', 
					''
					);
				$this->session->unset_userdata('job_id');
				redirect(base_url().'thanks');
			}
			else
				redirect(base_url().'error');
		}
		else
		{
			$this->session->set_userdata('job_id', $job_id);
			redirect(base_url().'login/');
		}
			
	}

	public function template($flag = '')
	{
		$title = 'Find Talent - Optima';
		$keywords = 'optima hr functional support solutions talent search recruiting human resources organizational excellence business transitions';
	
		$this->lang->load('general', 'english');
		$this->menu = $this->miscellaneous->printMENU('talent');
		switch ($flag) {
			case 'thanks':
				$content = $this->load->view('fe/template/thanks', '', true);
			break;
			case 'create_account':
				$content = $this->load->view('fe/template/create_account', '', true);
			break;
			case 'email_change':
				$this->load->view('fe/email_templates/change_email_success', array('token'=>'1234'));
				return true;
			break;
			case 'email_confirmation':				
				$this->load->view('fe/email_templates/register_confirmation', '');
				return true;
			break;
			case 'email_success':				
				$this->load->view('fe/email_templates/register_success', array('token'=>'1234'));
				return true;
			break;
			default:
				$content = $this->load->view('fe/template/error', '', true);
			break;
		}
		$this->load->view('fe/layout/main', array('content' => $content, 'menu'=>$this->menu, 'location'=>'experience', 'title'=>$title, 'keywords'=>$keywords) );
	}


	public function experiencing_optima()
	{
		$title = 'Experiencing Optima - Optima';
		$keywords = 'optima hr functional support solutions talent search recruiting human resources organizational excellence business transitions success stories testimonials';
			
		$this->lang->load('general', 'english');
		$this->menu = $this->miscellaneous->printMENU('experiencing_optima');
		$content = $this->load->view('fe/experience', '', true);
        $this->load->view('fe/layout/main', array('content' => $content, 'menu'=>$this->menu, 'location'=>'experience', 'title'=>$title, 'keywords'=>$keywords) );
	}	

	public function contact()
	{
		$title = 'Contact Us - Optima';
		$keywords = 'optima hr functional support solutions talent search recruiting human resources organizational excellence business transitions call us questions';
		
		$this->lang->load('general', 'english');
		$this->menu = $this->miscellaneous->printMENU('contact');
		$content = $this->load->view('fe/contact', '', true);
        $this->load->view('fe/layout/main', array('content' => $content, 'menu'=>$this->menu, 'location'=>'contact', 'title'=>$title, 'keywords'=>$keywords) );
	}

	public function forgot_password()
	{
		$msg = '';
		$title = 'Contact Us - Optima';
		$keywords = 'optima hr functional support solutions talent search recruiting human resources organizational excellence business transitions call us questions';
		
		$this->lang->load('general', 'english');
		$this->menu = $this->miscellaneous->printMENU('talent');
		

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');		
		if ($this->form_validation->run('forgot_password') == FALSE)
		{
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		}
		else
		{		
			$this->load->model('user');
			if($this->user->recover_password($this->input->post('email')))				
				$msg = '<span class="success"> We have sent your password by email.</span>';
			else
				$msg = 'Sorry we couldn\'t send you an email, please try later';
		}
		$content = $this->load->view('fe/forgot_password', array('msg'=>$msg), true);
        $this->load->view('fe/layout/main', array('content' => $content, 'menu'=>$this->menu, 'location'=>'talent', 'title'=>$title, 'keywords'=>$keywords) );
	}

	public function knowledge_sharing()
	{
		$title = 'Knowledge Sharing - Optima';
		$keywords = 'optima hr functional support solutions talent search recruiting human resources organizational excellence business transitions call us questions';
		
		$this->lang->load('general', 'english');
		$this->menu = $this->miscellaneous->printMENU('contact');

		$search = isset($_GET['search']) ? $_GET['search'] : '';
		$this->load->model('admin_m');
		$files = $this->admin_m->get_files($search);

		$content = $this->load->view('fe/knowledge_sharing', array('files'=>$files, 'search'=>$search), true);
        $this->load->view('fe/layout/main', array('content' => $content, 'menu'=>$this->menu, 'location'=>'contact', 'title'=>$title, 'keywords'=>$keywords) );
	}


/* End of file fe.php */
/* Location: ./application/controllers/fe.php */
}
