<?php
class Admin_m extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

    public function login($user, $pssw)
    {
        if($this->input->post('email') == 'info@optima-os.com'
                && $this->input->post('password') == 'optima2013')
            return true;
        return false;   
    }
    
	public function add_file($values)
	{
		$response = '';        
        $data['date'] = date('Y-m-d H-i-s');        
        $data['name'] = $values['name'];
        $data['description'] = $values['description'];

        $file_path = 'resources/files/';
        $update_fields = array();
        $config['upload_path'] = $file_path;
        $config['allowed_types'] = 'jpeg|jpg|png|doc|docx|pdf';
        $config['max_size'] = '2200';
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('upload_file_route'))
        {
            $file_error = array('error' => $this->upload->display_errors());
            $response = $file_error['error'];
        }
        else
        {
            $file_data = array('upload_data' => $this->upload->data());
            $data['upload_file'] = $file_data['upload_data']['file_name'];
            $this->db->insert('file', $data);            
            $response = "success";
        }       
        return $response;
	}

    public function get_files($search = '')
    {
        $filter = '';
        if(!empty($search))
            $filter = ' WHERE name like "%'.$search.'%" OR description like "%'.$search.'%"';
        $sql = "SELECT id, name, description, upload_file, DATE_FORMAT(date, '%b %d, %Y') AS date FROM file ".$filter." ORDER BY date DESC";
        $query = $this->db->query($sql);
        if($query->num_rows())
            return $query->result();
        return false;
    }

    public function remove_file($id)
    {
        $sql = "select upload_file from file where id=".$id;
        $query = $this->db->query($sql);
        if($query->num_rows())
            $response =  $query->row()->upload_file;
        $sql = "delete from file where id=".$id;
        $query = $this->db->query($sql);
        return $response;
    }
}
