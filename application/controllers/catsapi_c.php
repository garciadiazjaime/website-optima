<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catsapi_c extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_joborders_fe()
	{	
		$response = '';
		$is_first = true;
		$class = '';
		$sql = "SELECT joborder_id, title, company  FROM job ORDER BY updated DESC LIMIT 10";
		$query = $this->db->query($sql);		
		if($query->num_rows())
		{
			foreach($query->result() as $row)
			{				
				$class = $is_first ? 'first' : '';
				$response .= "<li class=\"".$class."\"><a href=\"".base_url()."talent/".$row->joborder_id."\" title=\"".$row->title."\"><span class=\"position_title\">".$row->title."</span><span class=\"position_location\">".$row->company."</span></a></li>";
				$is_first = false;
			}
		}
		else
		{
			$response = "A&uacuten no hay trabajos registros";
		}			
		echo $response;
	}

	public function get_joborders_talent()
	{			
		$response = '';
		$output = '';
		$job_titles = '';
		$place_list = '';

		$search = isset($_GET['search']) ? $_GET['search'] : '';
		$num = isset($_GET['num']) ? $_GET	['num'] : '0';

		$this->load->helper('text');
		$this->load->library('pagination');


		$sql = "SELECT IFNULL(count(*), 0) AS howmany  FROM job WHERE status='Active' AND public=1";
		$query = $this->db->query($sql);
		

		//$config['page_query_string'] = true;
		$config['base_url'] = base_url().'talent';
		$config['total_rows'] = $query->row()->howmany;
		$config['per_page'] = 3;
		//$config['query_string_segment'] = 'num';

		$this->pagination->initialize($config);



		$sql = "SELECT joborder_id, title, description, city, state  FROM job ORDER BY updated DESC LIMIT ".$num.", ".$config['per_page'];
		//echo $sql;
		$query = $this->db->query($sql);


		
		if($query->num_rows())
		{
			foreach($query->result() as $row)
			{	
				$description = word_limiter($row->description, 21);
 
				$job_titles .= "
					<li>
						<a href=\"".base_url()."talent/".$row->joborder_id."\" title=\"".$row->title."\">
							<em>".$row->title."</em>
							".$description."...
						</a>
					</li>";
				$place_list .= "
					<p><a href=\"".base_url()."open_jobs/".$row->joborder_id."\" title=\"".$row->title."\">".ucfirst($row->city).", ".strtoupper($row->state)."</a></a></p>
				";
			}
		}
		else
		{
			$response = "A&uacuten no hay trabajos registros";
		}			
		if(sizeof($job_titles))
		{
			$output = "
				<div class=\"column two_third first collapse\">
					<h2>Job Title</h2>
					<hr class=\"gray_line\">
					<ul class=\"jobs_list\">
						".$job_titles."
					</ul>
				</div><div  class=\"column third first collapse jobs_location\">
					<h2>Job Location</h2>
					<hr class=\"gray_line\">
					".$place_list."
				</div>
				<hr class=\"gray_line\">
				<ul id=\"pagination\">
					".$this->pagination->create_links()."					
				</ul>
			";
		}

		/*
		<li><a href=\"<?=base_url()?>talent/open_jobs/1\" title=\"Go to page 1\">1</a></li>
					<li><a href=\"<?=base_url()?>talent/open_jobs/2\" title=\"Go to page 1\">2</a></li>
					<li><a href=\"<?=base_url()?>talent/open_jobs/3\" title=\"Go to page 1\">3</a></li>
					<li><a href=\"<?=base_url()?>talent/open_jobs/4\" title=\"Go to page 1\">4</a></li>
					*/
		echo $output;
	}


/* End of file catsapi.php */
/* Location: ./application/controllers/catsapi.php */
}