<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Update extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		date_default_timezone_set('America/Los_Angeles');
	}

	public function get_data()
	{	
		$response = '';
		$data = array();
		$this->load->library('catsapi');
		$result = $this->catsapi->get_joborders('', 20);		
		$count = 0;
		foreach($result as $row)
		{
			$job = $this->catsapi->get_joborder($row->item_id, 'normal');
			$sql = "SELECT id FROM job WHERE joborder_id = ".$job->result->joborder_id;			
			$query = $this->db->query($sql);			
			if(!$query->num_rows())
			{
				$tmp = explode('-', (string)$row->updated);
				$updated = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
				$data = array(
					'joborder_id'	=> (int)$job->result->joborder_id,
					'title'			=> (string)$job->result->title,
					'company'		=> (string)$row->company,
					'city'			=> (string)$job->result->city,
					'state'			=> (string)$job->result->state,
					'salary'		=> (string)$job->result->salary,
					'description'	=> $this->db->escape((string)$job->result->description),
					'status'		=> (string)$job->result->status,
					'public'		=> (int)$job->result->public,
					'updated'		=> $updated,
					'date_reg'		=> date('Y-m-d H-i-s')
					);
				if($this->db->insert('job', $data)) $count++;
			}												
		}
		$response = ($count == 1) ? " Job added to the DB" : " Jobs added to the DB";
		$response =  $count.$response;
		echo $response;
		//$this->send_mail($response);
	}

	public function send_mail($data)
	{
		mail('garciadiazjaime@gmail.com', 'Optima Cron '.date('Y-m-d H-i-s'), $data);
	}

	

/* End of file update.php */
/* Location: ./application/controllers/update.php */
}
