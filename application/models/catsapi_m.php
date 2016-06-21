<?php
class Catsapi_m extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_job($id)
	{
		$response = '';
		$sql = "
			SELECT 
				joborder_id,
				title,
				company,
				city,
				state,
				salary,
				description,
				DATE_FORMAT(updated, '%M %e') as date
			FROM job 
			WHERE joborder_id = ".$id;
		$query = $this->db->query($sql);		
		if($query->num_rows())
		{			
			return $query->row();
		}
		return FALSE;
	}

	public function get_joborders_home()
	{			
		$sql = "
			SELECT 
				joborder_id,
				title,
				company,
				city,
				state
			FROM job 
			WHERE status='Active' 
				AND public=1
			ORDER BY updated DESC
			LIMIT 10
				";		
		$query = $this->db->query($sql);		
		if($query->num_rows())
			return $query->result();		
		return '';
	}

	public function get_joborders_talent($num = 0, $search = '')
	{			
		$response = '';
		$output = '';
		$job_info = '';
		$pagination = '';		
		$filter = '';
		
		$this->load->helper('text');
		$this->load->library('pagination');

		if(!empty($search))
			$filter = " AND (title LIKE '%".$search."%' 
				OR company LIKE '%".$search."%' 
				OR city LIKE '%".$search."%' 
				OR state LIKE '%".$search."%' 
				OR salary LIKE '%".$search."%' 
				OR description LIKE '%".$search."%')";

		$sql = "
			SELECT 
				IFNULL(count(*), 0) AS howmany  
			FROM job 
			WHERE status='Active' 
				AND public=1 
				".$filter;
		
		$query = $this->db->query($sql);
		
		//$config['page_query_string'] = true;
		//$config['query_string_segment'] = 'num';

		$config['uri_segment'] = 2;
		$config['base_url'] = base_url().'talent';
		$config['total_rows'] = $query->row()->howmany;
		$config['per_page'] = 10;
		

		$this->pagination->initialize($config);

		$sql = "
			SELECT 
				joborder_id, 
				title, 
				description, 
				city, 
				state  
			FROM job 
			WHERE 
				status='Active' 
				AND public=1 
				".$filter." 
			ORDER BY updated DESC 
			LIMIT ".$num.", ".$config['per_page'];
		//echo $sql;
		$query = $this->db->query($sql);
		
		if($query->num_rows())
		{
			foreach($query->result() as $row)
			{	
				$description = $this->stripHTMLtags($row->description);
				$description = word_limiter($description, 21);

				$job_info[] = array(
						'job_id' => $row->joborder_id,
						'title' => $row->title,
						'description' => $description,
						'city' => $row->city,
						'state' => $row->state
					);
			}
		}
				
		$response = array(
			'job_info'=>$job_info,			
			'pagination' => $this->pagination->create_links()
			);
		return $response;
	}

	private function stripHTMLtags($str)
	{
		$t = preg_replace('/<[^<|>]+?>/', '', htmlspecialchars_decode($str));
		$t = preg_replace('/\\\n/', '', htmlspecialchars_decode($t));
		$t = htmlentities($t, ENT_QUOTES, "UTF-8");
		return $t;
	}
}