<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catsapi extends CI_Controller {


    const CATSAPI_DOMAIN = 'catsone.com';
    const CATSAPI_TIMEOUT = 90;

    private $_transaction_code = '58b924224f96db5c9cc8fb5e642e8725';
    private $_company_id = 'optimaorganizationalsolutions';
    private $_error_code;
    private $_error_message;
    private $_enable_ssl = false;
    

    public function __contruct()
    {
        parent::__contruct();
    }
    
     /**
     * Private method used to facilitate the transmission of a function call
     * to the CATS server and to process the XML response.
     * @param string CATS API Function
     *
     * @return simplexml_object
     */
    private function _do($func, $post_data = '')
    {
        $url = $this->_get_base_url($func);

        $post_data = $this->_getArray($post_data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::CATSAPI_TIMEOUT);
        curl_setopt($ch, CURLOPT_TIMEOUT, self::CATSAPI_TIMEOUT);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));

        $response = curl_exec($ch);
        $error = curl_error($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        if (!empty($error))
        {
            $this->_error_message = $error;
            $this->_error_code = $info['http_code'];
            return false;
        }

        if (!preg_match('/^<\?xml/', $response))
        {
            $this->_error_code = 404;
            $this->_error_message = 'unimplemented API function';
            return false;
        }

        $xml = @simplexml_load_string($response);

        if (!$xml)
        {
            $this->_error_code = 500;
            $this->_error_message = 'bad xml response';
            return false;
        }

        if ($xml['success'] != 'true')
        {
            $this->_error_code = intval($xml->error['code']);
            $this->_error_message = trim($xml->error);
            return false;
        }

        return $xml;
    }

    private function _getArray($str)
    {
        $ret = array();

        $ex = explode('&', $str);

        foreach ($ex as $e)
        {
            $bits = explode('=', $e);

            if (!isset($bits[1]))
            {
                $bits[1] = '';
            }

            $ret[urldecode($bits[0])] = urldecode($bits[1]);
        }

        return $ret;
    }

    /**
     * Returns the most recent request's HTTP 1.1 status code response
     *
     * @return integer
     */
    public function get_error_code()
    {
        return $this->_error_code !== null ? $this->_error_code : 200;
    }

    /**
     * Returns the plain text explination of the most recent error.
     *
     * @return string
     */
    public function get_error_message()
    {
        return $this->_error_message !== null ? $this->_error_message : '';
    }

    /**
     * Returns the base URL string used in every API request.
     *
     * @return string
     */
    private function _get_base_url($func)
    {
        return sprintf('http%s://%s.%s/api/%s.php?subdomain=%s&transaction_code=%s',
            $this->_enable_ssl ? 's' : '',
            $this->_company_id,
            self::CATSAPI_DOMAIN,
            $func,
            urlencode($this->_company_id),
            urlencode($this->_transaction_code)
        );
    }


                            
    
    /**
     * Replaces an attachment. New attachment file must be the same file type (i.e. .doc) as the original.
     *
     * @param string $guid  (required)
     * @param string $file (full path to local file) 
     * @return array
     */
    public function update_attachment($guid, $file = '')
    {
        $post_data = sprintf('&guid=%s&file=%s',
            urlencode(strval($guid)),
            !empty($file) ? '@' . urlencode(strval($file)) : ''
        );
        $return = $this->_do('update_attachment', $post_data);
        return $return;
    }

                
    
    /**
     * Deletes a company record and all child job orders, job order pipelines, contacts, attachments and activities.
     *
     * @param number $id  (required)
     * @return integer
     */
    public function delete_company($id)
    {
        $post_data = sprintf('&id=%s',
            urlencode(strval($id))
        );
        $return = $this->_do('delete_company', $post_data);
        return intval($return['id']);
    }

    
    
    /**
     * Retrieves a list of available tags. Note: tags with no parentID are categories,
        and should not be attached directly to data items
     *
     * @return array
     */
    public function get_tags()
    {
        $return = $this->_do('get_tags');
        return $return;
    }

                                                                                                                                    
    
    /**
     * Retrieves a list of joborders.
     *
     * @param string $search 
     * @param number $rows_per_page 
     * @param number $page_number 
     * @param string $sort 
     * @param string $sort_direction 
     * @param string $display_column 
     * @param string $list 
     * @param string $filter 
     * @return array
     */
    public function get_joborders($search = '', $rows_per_page = '', $page_number = '', $sort = '', $sort_direction = '', 
        $display_column = '', $list = '', $filter = '')
    {
        $post_data = sprintf('&search=%s&rows_per_page=%s&page_number=%s&sort=%s&sort_direction=%s'
            . '&display_column=%s&list=%s&filter=%s',
            urlencode(strval($search)),
            urlencode(strval($rows_per_page)),
            urlencode(strval($page_number)),
            urlencode(strval($sort)),
            urlencode(strval($sort_direction)),
            urlencode(strval($display_column)),
            urlencode(strval($list)),
            urlencode(strval($filter))
        );
        $return = $this->_do('get_joborders', $post_data);
        return $return;
    }

                
    
    /**
     * Retrieves all applications with questions and answers for a given candidate. Returns an application for each job order the candidate has applied to through the careers website functionality.
     *
     * @param number $id  (required)
     * @return array
     */
    public function get_applications($id)
    {
        $post_data = sprintf('&id=%s',
            urlencode(strval($id))
        );
        $return = $this->_do('get_applications', $post_data);
        return $return;
    }

                                                                                                                        
    
    /**
     * Retrieves a list of lists.
     *
     * @param string $search 
     * @param number $rows_per_page 
     * @param number $page_number 
     * @param string $sort 
     * @param string $sort_direction 
     * @param string $display_column 
     * @param string $filter 
     * @return array
     */
    public function get_lists($search = '', $rows_per_page = '', $page_number = '', $sort = '', $sort_direction = '', 
        $display_column = '', $filter = '')
    {
        $post_data = sprintf('&search=%s&rows_per_page=%s&page_number=%s&sort=%s&sort_direction=%s'
            . '&display_column=%s&filter=%s',
            urlencode(strval($search)),
            urlencode(strval($rows_per_page)),
            urlencode(strval($page_number)),
            urlencode(strval($sort)),
            urlencode(strval($sort_direction)),
            urlencode(strval($display_column)),
            urlencode(strval($filter))
        );
        $return = $this->_do('get_lists', $post_data);
        return $return;
    }

                
    
    /**
     * Retrieves metadata and XHTML version of the most recent resume for a candidate.
     *
     * @param string $id  (required)
     * @return array
     */
    public function get_magic_preview($id)
    {
        $post_data = sprintf('&id=%s',
            urlencode(strval($id))
        );
        $return = $this->_do('get_magic_preview', $post_data);
        return $return;
    }

                                                                
    
    /**
     * Adds an activity log to a candidate or contact record. The activity can optionally be linked to include a job order (if applicable).
     *
     * @param string $data_type  (required)
     * @param string $id  (required)
     * @param string $type 
     * @param string $notes  (required)
     * @param string $joborder_id 
     * @return array
     */
    public function add_activity($data_type, $id, $type = '', $notes, $joborder_id = '')
    {
        $post_data = sprintf('&data_type=%s&id=%s&type=%s&notes=%s&joborder_id=%s',
            urlencode(strval($data_type)),
            urlencode(strval($id)),
            urlencode(strval($type)),
            urlencode(strval($notes)),
            urlencode(strval($joborder_id))
        );
        $return = $this->_do('add_activity', $post_data);
        return $return;
    }

                                        
    
    /**
     * Removes one or more tags from one or more data items of the specified data item type.
        If an item does not have a specified tag, no action is taken and no error is generated.
     *
     * @param string $data_item_type  (required)
     * @param array $data_item_ids  (required)
     * @param array $tag_ids  (required)
     * @return integer
     */
    public function detach_tags($data_item_type, $data_item_ids, $tag_ids)
    {
        $post_data = sprintf('&data_item_type=%s&data_item_ids=%s&tag_ids=%s',
            urlencode(strval($data_item_type)),
            urlencode(strval($data_item_ids)),
            urlencode(strval($tag_ids))
        );
        $return = $this->_do('detach_tags', $post_data);
        return intval($return['id']);
    }

                                                                                                                        
    
    /**
     * Retrieves a list of pipelines.
     *
     * @param string $search 
     * @param number $rows_per_page 
     * @param number $page_number 
     * @param string $sort 
     * @param string $sort_direction 
     * @param string $display_column 
     * @param string $filter 
     * @return array
     */
    public function get_pipelines($search = '', $rows_per_page = '', $page_number = '', $sort = '', $sort_direction = '', 
        $display_column = '', $filter = '')
    {
        $post_data = sprintf('&search=%s&rows_per_page=%s&page_number=%s&sort=%s&sort_direction=%s'
            . '&display_column=%s&filter=%s',
            urlencode(strval($search)),
            urlencode(strval($rows_per_page)),
            urlencode(strval($page_number)),
            urlencode(strval($sort)),
            urlencode(strval($sort_direction)),
            urlencode(strval($display_column)),
            urlencode(strval($filter))
        );
        $return = $this->_do('get_pipelines', $post_data);
        return $return;
    }

                                                                                                                        
    
    /**
     * Retrieves a list of recent career portal applicants (not all candidates), like the "Website Applicants" view of the Candidates tab.
     *
     * @param string $search 
     * @param number $rows_per_page 
     * @param number $page_number 
     * @param string $sort 
     * @param string $sort_direction 
     * @param string $display_column 
     * @param string $filter 
     * @return array
     */
    public function get_applicants($search = '', $rows_per_page = '', $page_number = '', $sort = '', $sort_direction = '', 
        $display_column = '', $filter = '')
    {
        $post_data = sprintf('&search=%s&rows_per_page=%s&page_number=%s&sort=%s&sort_direction=%s'
            . '&display_column=%s&filter=%s',
            urlencode(strval($search)),
            urlencode(strval($rows_per_page)),
            urlencode(strval($page_number)),
            urlencode(strval($sort)),
            urlencode(strval($sort_direction)),
            urlencode(strval($display_column)),
            urlencode(strval($filter))
        );
        $return = $this->_do('get_applicants', $post_data);
        return $return;
    }

                                                                                                                                    
    
    /**
     * Retrieves a list of contacts.
     *
     * @param string $search 
     * @param number $rows_per_page 
     * @param number $page_number 
     * @param string $sort 
     * @param string $sort_direction 
     * @param string $display_column 
     * @param string $list 
     * @param string $filter 
     * @return array
     */
    public function get_contacts($search = '', $rows_per_page = '', $page_number = '', $sort = '', $sort_direction = '', 
        $display_column = '', $list = '', $filter = '')
    {
        $post_data = sprintf('&search=%s&rows_per_page=%s&page_number=%s&sort=%s&sort_direction=%s'
            . '&display_column=%s&list=%s&filter=%s',
            urlencode(strval($search)),
            urlencode(strval($rows_per_page)),
            urlencode(strval($page_number)),
            urlencode(strval($sort)),
            urlencode(strval($sort_direction)),
            urlencode(strval($display_column)),
            urlencode(strval($list)),
            urlencode(strval($filter))
        );
        $return = $this->_do('get_contacts', $post_data);
        return $return;
    }

                                                    
    
    /**
     * Adds a quick note to a company or job order record.
     *
     * @param string $data_type  (required)
     * @param string $id  (required)
     * @param string $notes  (required)
     * @param string $date 
     * @return array
     */
    public function add_quick_note($data_type, $id, $notes, $date = '')
    {
        $post_data = sprintf('&data_type=%s&id=%s&notes=%s&date=%s',
            urlencode(strval($data_type)),
            urlencode(strval($id)),
            urlencode(strval($notes)),
            urlencode(strval($date))
        );
        $return = $this->_do('add_quick_note', $post_data);
        return $return;
    }

                            
    
    /**
     * Retrieves one or more joborders.
     *
     * @param number $id  (required)
     * @param string $result 
     * @return array
     */
    public function get_joborder($id, $result = '')
    {
        $post_data = sprintf('&id=%s&result=%s',
            urlencode(strval($id)),
            urlencode(strval($result))
        );
        $return = $this->_do('get_joborder', $post_data);
        return $return;
    }

                                                    
    
    /**
     * Retrieves a set of open job orders marked as public.
     *
     * @param string $keywords 
     * @param string $result 
     * @param number $max_results 
     * @param number $offset 
     * @return array
     */
    public function get_public_joborders($keywords = '', $result = '', $max_results = '', $offset = '')
    {
        $post_data = sprintf('&keywords=%s&result=%s&max_results=%s&offset=%s',
            urlencode(strval($keywords)),
            urlencode(strval($result)),
            urlencode(strval($max_results)),
            urlencode(strval($offset))
        );
        $return = $this->_do('get_public_joborders', $post_data);
        return $return;
    }

                                                                
    
    /**
     * Sets a candidate's status in a joborder pipeline.
     *
     * @param string $data_type  (required)
     * @param number $id  (required)
     * @param string $status  (required)
     * @param string $no_activity 
     * @param string $triggers 
     * @return integer
     */
    public function set_status($data_type, $id, $status, $no_activity = '', $triggers = '')
    {
        $post_data = sprintf('&data_type=%s&id=%s&status=%s&no_activity=%s&triggers=%s',
            urlencode(strval($data_type)),
            urlencode(strval($id)),
            urlencode(strval($status)),
            urlencode(strval($no_activity)),
            urlencode(strval($triggers))
        );
        $return = $this->_do('set_status', $post_data);
        return intval($return['id']);
    }

                                        
    
    /**
     * Retrieves the specified applications with their questions and metadata for a given joborder.
     *
     * @param number $id 
     * @param boolean $form 
     * @param boolean $php 
     * @return array
     */
    public function get_joborder_applications($id = '', $form = '', $php = '')
    {
        $post_data = sprintf('&id=%s&form=%s&php=%s',
            urlencode(strval($id)),
            empty($form) ? 'no' : 'yes',
            empty($php) ? 'no' : 'yes'
        );
        $return = $this->_do('get_joborder_applications', $post_data);
        return $return;
    }

                                                                                                                                                                                                                                                                                                                                                                                                                                        
    
    /**
     * Adds a candidate record.
     *
     * @param string $candidate_id 
     * @param string $first_name 
     * @param string $middle_name 
     * @param string $last_name 
     * @param string $title 
     * @param string $phone_home 
     * @param string $phone_cell 
     * @param string $phone_work 
     * @param string $address 
     * @param string $city 
     * @param string $state 
     * @param string $zip 
     * @param string $source 
     * @param integer $date_available (timestamp - number of seconds since epoch) 
     * @param boolean $can_relocate 
     * @param string $notes 
     * @param string $key_skills 
     * @param string $current_employer 
     * @param integer $date_created (timestamp - number of seconds since epoch) 
     * @param integer $date_modified (timestamp - number of seconds since epoch) 
     * @param integer $owner 
     * @param integer $entered_by 
     * @param string $email1 
     * @param string $email2 
     * @param string $web_site 
     * @param boolean $is_hot 
     * @param string $desired_pay 
     * @param string $current_pay 
     * @param boolean $is_active 
     * @param string $best_time_to_call 
     * @param string $password 
     * @param country $country_id 
     * @param string $resume (full path to local file) 
     * @param boolean $parse_resume 
     * @param string $on_duplicate 
     * @return integer
     */
    public function add_candidate($candidate_id = '', $first_name = '', $middle_name = '', $last_name = '', $title = '', 
        $phone_home = '', $phone_cell = '', $phone_work = '', $address = '', $city = '', $state = '', 
        $zip = '', $source = '', $date_available = '', $can_relocate = '', $notes = '', $key_skills = '', 
        $current_employer = '', $date_created = '', $date_modified = '', $owner = '', $entered_by = '', $email1 = '', 
        $email2 = '', $web_site = '', $is_hot = '', $desired_pay = '', $current_pay = '', $is_active = '', 
        $best_time_to_call = '', $password = '', $country_id = '', $resume = '', $parse_resume = '', $on_duplicate = '')
    {
        $post_data = sprintf('&candidate_id=%s&first_name=%s&middle_name=%s&last_name=%s&title=%s'
            . '&phone_home=%s&phone_cell=%s&phone_work=%s&address=%s&city=%s&state=%s'
            . '&zip=%s&source=%s&date_available=%s&can_relocate=%s&notes=%s&key_skills=%s'
            . '&current_employer=%s&date_created=%s&date_modified=%s&owner=%s&entered_by=%s&email1=%s'
            . '&email2=%s&web_site=%s&is_hot=%s&desired_pay=%s&current_pay=%s&is_active=%s'
            . '&best_time_to_call=%s&password=%s&country_id=%s&resume=%s&parse_resume=%s&on_duplicate=%s',
            urlencode(strval($candidate_id)),
            urlencode(strval($first_name)),
            urlencode(strval($middle_name)),
            urlencode(strval($last_name)),
            urlencode(strval($title)),
            urlencode(strval($phone_home)),
            urlencode(strval($phone_cell)),
            urlencode(strval($phone_work)),
            urlencode(strval($address)),
            urlencode(strval($city)),
            urlencode(strval($state)),
            urlencode(strval($zip)),
            urlencode(strval($source)),
            urlencode(strval($date_available)),
            empty($can_relocate) ? 'no' : 'yes',
            urlencode(strval($notes)),
            urlencode(strval($key_skills)),
            urlencode(strval($current_employer)),
            urlencode(strval($date_created)),
            urlencode(strval($date_modified)),
            urlencode(strval($owner)),
            urlencode(strval($entered_by)),
            urlencode(strval($email1)),
            urlencode(strval($email2)),
            urlencode(strval($web_site)),
            empty($is_hot) ? 'no' : 'yes',
            urlencode(strval($desired_pay)),
            urlencode(strval($current_pay)),
            empty($is_active) ? 'no' : 'yes',
            urlencode(strval($best_time_to_call)),
            urlencode(strval($password)),
            urlencode(strval($country_id)),
            !empty($resume) ? '@' . urlencode(strval($resume)) : '',
            empty($parse_resume) ? 'no' : 'yes',
            urlencode(strval($on_duplicate))
        );
        $return = $this->_do('add_candidate', $post_data);
        return intval($return['id']);
    }

                
    
    /**
     * Retrieves a list of available columns for a data item type.
     *
     * @param string $data_type  (required)
     * @return array
     */
    public function get_columns($data_type)
    {
        $post_data = sprintf('&data_type=%s',
            urlencode(strval($data_type))
        );
        $return = $this->_do('get_columns', $post_data);
        return $return;
    }

                                                                                                                                                                                                                                                                                                                                        
    
    /**
     * Adds a joborder record.
     *
     * @param string $joborder_id 
     * @param integer $recruiter 
     * @param number $contact_id 
     * @param number $company_id 
     * @param integer $entered_by 
     * @param integer $owner 
     * @param string $client_job_id 
     * @param string $title  (required)
     * @param string $description 
     * @param string $notes 
     * @param string $type 
     * @param string $duration 
     * @param string $rate_max 
     * @param string $salary 
     * @param string $status 
     * @param boolean $is_hot 
     * @param number $openings 
     * @param string $city 
     * @param string $state 
     * @param string $zip 
     * @param integer $start_date (timestamp - number of seconds since epoch) 
     * @param integer $date_created (timestamp - number of seconds since epoch) 
     * @param string $company_department_id 
     * @param integer $sourcer_id 
     * @param number $openings_available 
     * @param country $country_id 
     * @param string $category 
     * @return integer
     */
    public function add_joborder($joborder_id = '', $recruiter = '', $contact_id = '', $company_id = '', $entered_by = '', 
        $owner = '', $client_job_id = '', $title, $description = '', $notes = '', $type = '', 
        $duration = '', $rate_max = '', $salary = '', $status = '', $is_hot = '', $openings = '', 
        $city = '', $state = '', $zip = '', $start_date = '', $date_created = '', $company_department_id = '', 
        $sourcer_id = '', $openings_available = '', $country_id = '', $category = '')
    {
        $post_data = sprintf('&joborder_id=%s&recruiter=%s&contact_id=%s&company_id=%s&entered_by=%s'
            . '&owner=%s&client_job_id=%s&title=%s&description=%s&notes=%s&type=%s'
            . '&duration=%s&rate_max=%s&salary=%s&status=%s&is_hot=%s&openings=%s'
            . '&city=%s&state=%s&zip=%s&start_date=%s&date_created=%s&company_department_id=%s'
            . '&sourcer_id=%s&openings_available=%s&country_id=%s&category=%s',
            urlencode(strval($joborder_id)),
            urlencode(strval($recruiter)),
            urlencode(strval($contact_id)),
            urlencode(strval($company_id)),
            urlencode(strval($entered_by)),
            urlencode(strval($owner)),
            urlencode(strval($client_job_id)),
            urlencode(strval($title)),
            urlencode(strval($description)),
            urlencode(strval($notes)),
            urlencode(strval($type)),
            urlencode(strval($duration)),
            urlencode(strval($rate_max)),
            urlencode(strval($salary)),
            urlencode(strval($status)),
            empty($is_hot) ? 'no' : 'yes',
            urlencode(strval($openings)),
            urlencode(strval($city)),
            urlencode(strval($state)),
            urlencode(strval($zip)),
            urlencode(strval($start_date)),
            urlencode(strval($date_created)),
            urlencode(strval($company_department_id)),
            urlencode(strval($sourcer_id)),
            urlencode(strval($openings_available)),
            urlencode(strval($country_id)),
            urlencode(strval($category))
        );
        $return = $this->_do('add_joborder', $post_data);
        return intval($return['id']);
    }

                                                                                                                                                                                                                                                                                                                                                                
    
    /**
     * Updates a job order.
     *
     * @param string $id  (required)
     * @param string $file (full path to local file) 
     * @param string $joborder_id 
     * @param integer $recruiter 
     * @param number $contact_id 
     * @param number $company_id 
     * @param integer $entered_by 
     * @param integer $owner 
     * @param string $client_job_id 
     * @param string $title  (required)
     * @param string $description 
     * @param string $notes 
     * @param string $type 
     * @param string $duration 
     * @param string $rate_max 
     * @param string $salary 
     * @param string $status 
     * @param boolean $is_hot 
     * @param number $openings 
     * @param string $city 
     * @param string $state 
     * @param string $zip 
     * @param integer $start_date (timestamp - number of seconds since epoch) 
     * @param integer $date_created (timestamp - number of seconds since epoch) 
     * @param string $company_department_id 
     * @param integer $sourcer_id 
     * @param number $openings_available 
     * @param country $country_id 
     * @param string $category 
     * @return integer
     */
    public function update_joborder($id, $file = '', $joborder_id = '', $recruiter = '', $contact_id = '', 
        $company_id = '', $entered_by = '', $owner = '', $client_job_id = '', $title, $description = '', 
        $notes = '', $type = '', $duration = '', $rate_max = '', $salary = '', $status = '', 
        $is_hot = '', $openings = '', $city = '', $state = '', $zip = '', $start_date = '', 
        $date_created = '', $company_department_id = '', $sourcer_id = '', $openings_available = '', $country_id = '', $category = '')
    {
        $post_data = sprintf('&id=%s&file=%s&joborder_id=%s&recruiter=%s&contact_id=%s'
            . '&company_id=%s&entered_by=%s&owner=%s&client_job_id=%s&title=%s&description=%s'
            . '&notes=%s&type=%s&duration=%s&rate_max=%s&salary=%s&status=%s'
            . '&is_hot=%s&openings=%s&city=%s&state=%s&zip=%s&start_date=%s'
            . '&date_created=%s&company_department_id=%s&sourcer_id=%s&openings_available=%s&country_id=%s&category=%s',
            urlencode(strval($id)),
            !empty($file) ? '@' . urlencode(strval($file)) : '',
            urlencode(strval($joborder_id)),
            urlencode(strval($recruiter)),
            urlencode(strval($contact_id)),
            urlencode(strval($company_id)),
            urlencode(strval($entered_by)),
            urlencode(strval($owner)),
            urlencode(strval($client_job_id)),
            urlencode(strval($title)),
            urlencode(strval($description)),
            urlencode(strval($notes)),
            urlencode(strval($type)),
            urlencode(strval($duration)),
            urlencode(strval($rate_max)),
            urlencode(strval($salary)),
            urlencode(strval($status)),
            empty($is_hot) ? 'no' : 'yes',
            urlencode(strval($openings)),
            urlencode(strval($city)),
            urlencode(strval($state)),
            urlencode(strval($zip)),
            urlencode(strval($start_date)),
            urlencode(strval($date_created)),
            urlencode(strval($company_department_id)),
            urlencode(strval($sourcer_id)),
            urlencode(strval($openings_available)),
            urlencode(strval($country_id)),
            urlencode(strval($category))
        );
        $return = $this->_do('update_joborder', $post_data);
        return intval($return['id']);
    }

                                                                                                                                                    
    
    /**
     * Adds an email activity.
     *
     * @param string $from  (required)
     * @param string $data_type  (required)
     * @param string $id  (required)
     * @param string $message  (required)
     * @param string $subject  (required)
     * @param integer $date_created (timestamp - number of seconds since epoch) 
     * @param string $file1 (full path to local file) 
     * @param string $file2 (full path to local file) 
     * @param string $file3 (full path to local file) 
     * @param string $file4 (full path to local file) 
     * @param string $file5 (full path to local file) 
     * @param boolean $is_resume 
     * @return integer
     */
    public function add_email_activity($from, $data_type, $id, $message, $subject, 
        $date_created = '', $file1 = '', $file2 = '', $file3 = '', $file4 = '', $file5 = '', 
        $is_resume = '')
    {
        $post_data = sprintf('&from=%s&data_type=%s&id=%s&message=%s&subject=%s'
            . '&date_created=%s&file1=%s&file2=%s&file3=%s&file4=%s&file5=%s'
            . '&is_resume=%s',
            urlencode(strval($from)),
            urlencode(strval($data_type)),
            urlencode(strval($id)),
            urlencode(strval($message)),
            urlencode(strval($subject)),
            urlencode(strval($date_created)),
            !empty($file1) ? '@' . urlencode(strval($file1)) : '',
            !empty($file2) ? '@' . urlencode(strval($file2)) : '',
            !empty($file3) ? '@' . urlencode(strval($file3)) : '',
            !empty($file4) ? '@' . urlencode(strval($file4)) : '',
            !empty($file5) ? '@' . urlencode(strval($file5)) : '',
            empty($is_resume) ? 'no' : 'yes'
        );
        $return = $this->_do('add_email_activity', $post_data);
        return intval($return['id']);
    }

                                                                                                                                                                                                                                                                                                                                                                                                                                        
    
    /**
     * Updates a candidate.
     *
     * @param string $id  (required)
     * @param string $file (full path to local file) 
     * @param boolean $is_resume 
     * @param string $candidate_id 
     * @param string $first_name 
     * @param string $middle_name 
     * @param string $last_name 
     * @param string $title 
     * @param string $phone_home 
     * @param string $phone_cell 
     * @param string $phone_work 
     * @param string $address 
     * @param string $city 
     * @param string $state 
     * @param string $zip 
     * @param string $source 
     * @param integer $date_available (timestamp - number of seconds since epoch) 
     * @param boolean $can_relocate 
     * @param string $notes 
     * @param string $key_skills 
     * @param string $current_employer 
     * @param integer $date_created (timestamp - number of seconds since epoch) 
     * @param integer $date_modified (timestamp - number of seconds since epoch) 
     * @param integer $owner 
     * @param integer $entered_by 
     * @param string $email1 
     * @param string $email2 
     * @param string $web_site 
     * @param boolean $is_hot 
     * @param string $desired_pay 
     * @param string $current_pay 
     * @param boolean $is_active 
     * @param string $best_time_to_call 
     * @param string $password 
     * @param country $country_id 
     * @return integer
     */
    public function update_candidate($id, $file = '', $is_resume = '', $candidate_id = '', $first_name = '', 
        $middle_name = '', $last_name = '', $title = '', $phone_home = '', $phone_cell = '', $phone_work = '', 
        $address = '', $city = '', $state = '', $zip = '', $source = '', $date_available = '', 
        $can_relocate = '', $notes = '', $key_skills = '', $current_employer = '', $date_created = '', $date_modified = '', 
        $owner = '', $entered_by = '', $email1 = '', $email2 = '', $web_site = '', $is_hot = '', 
        $desired_pay = '', $current_pay = '', $is_active = '', $best_time_to_call = '', $password = '', $country_id = '')
    {
        $post_data = sprintf('&id=%s&file=%s&is_resume=%s&candidate_id=%s&first_name=%s'
            . '&middle_name=%s&last_name=%s&title=%s&phone_home=%s&phone_cell=%s&phone_work=%s'
            . '&address=%s&city=%s&state=%s&zip=%s&source=%s&date_available=%s'
            . '&can_relocate=%s&notes=%s&key_skills=%s&current_employer=%s&date_created=%s&date_modified=%s'
            . '&owner=%s&entered_by=%s&email1=%s&email2=%s&web_site=%s&is_hot=%s'
            . '&desired_pay=%s&current_pay=%s&is_active=%s&best_time_to_call=%s&password=%s&country_id=%s',
            urlencode(strval($id)),
            !empty($file) ? '@' . urlencode(strval($file)) : '',
            empty($is_resume) ? 'no' : 'yes',
            urlencode(strval($candidate_id)),
            urlencode(strval($first_name)),
            urlencode(strval($middle_name)),
            urlencode(strval($last_name)),
            urlencode(strval($title)),
            urlencode(strval($phone_home)),
            urlencode(strval($phone_cell)),
            urlencode(strval($phone_work)),
            urlencode(strval($address)),
            urlencode(strval($city)),
            urlencode(strval($state)),
            urlencode(strval($zip)),
            urlencode(strval($source)),
            urlencode(strval($date_available)),
            empty($can_relocate) ? 'no' : 'yes',
            urlencode(strval($notes)),
            urlencode(strval($key_skills)),
            urlencode(strval($current_employer)),
            urlencode(strval($date_created)),
            urlencode(strval($date_modified)),
            urlencode(strval($owner)),
            urlencode(strval($entered_by)),
            urlencode(strval($email1)),
            urlencode(strval($email2)),
            urlencode(strval($web_site)),
            empty($is_hot) ? 'no' : 'yes',
            urlencode(strval($desired_pay)),
            urlencode(strval($current_pay)),
            empty($is_active) ? 'no' : 'yes',
            urlencode(strval($best_time_to_call)),
            urlencode(strval($password)),
            urlencode(strval($country_id))
        );
        $return = $this->_do('update_candidate', $post_data);
        return intval($return['id']);
    }

                                                                
    
    /**
     * Adds a candidate to a job order pipeline and returns the pipeline ID. Optionally adds an activity log, sets the status and star rating if parameters are provided.
     *
     * @param number $candidate_id  (required)
     * @param number $joborder_id  (required)
     * @param string $status 
     * @param string $no_activity 
     * @param string $stars 
     * @return integer
     */
    public function add_pipeline($candidate_id, $joborder_id, $status = '', $no_activity = '', $stars = '')
    {
        $post_data = sprintf('&candidate_id=%s&joborder_id=%s&status=%s&no_activity=%s&stars=%s',
            urlencode(strval($candidate_id)),
            urlencode(strval($joborder_id)),
            urlencode(strval($status)),
            urlencode(strval($no_activity)),
            urlencode(strval($stars))
        );
        $return = $this->_do('add_pipeline', $post_data);
        return intval($return['id']);
    }

                                        
    
    /**
     * Retrieves data for a candidate who has previously registered through a career portal. Validates their credentials, returns jobs they've applied to, and metadata.
     *
     * @param string $email  (required)
     * @param string $password  (required)
     * @param string $hash 
     * @return array
     */
    public function portal_login($email, $password, $hash = '')
    {
        $post_data = sprintf('&email=%s&password=%s&hash=%s',
            urlencode(strval($email)),
            urlencode(strval($password)),
            urlencode(strval($hash))
        );
        $return = $this->_do('portal_login', $post_data);
        return $return;
    }

                                                                                                                                                                                                                                                                                                                
    
    /**
     * Updates a contact.
     *
     * @param string $id  (required)
     * @param string $file (full path to local file) 
     * @param string $first_name  (required)
     * @param string $last_name  (required)
     * @param string $title 
     * @param string $email1 
     * @param string $email2 
     * @param string $phone_work 
     * @param string $phone_cell 
     * @param string $phone_other 
     * @param string $address 
     * @param string $city 
     * @param string $state 
     * @param string $zip 
     * @param boolean $is_hot 
     * @param string $notes 
     * @param integer $entered_by 
     * @param integer $owner 
     * @param integer $date_created (timestamp - number of seconds since epoch) 
     * @param integer $date_modified (timestamp - number of seconds since epoch) 
     * @param boolean $left_company 
     * @param integer $company_id 
     * @param integer $company_department_id 
     * @param contact $reports_to 
     * @param country $country_id 
     * @return integer
     */
    public function update_contact($id, $file = '', $first_name, $last_name, $title = '', 
        $email1 = '', $email2 = '', $phone_work = '', $phone_cell = '', $phone_other = '', $address = '', 
        $city = '', $state = '', $zip = '', $is_hot = '', $notes = '', $entered_by = '', 
        $owner = '', $date_created = '', $date_modified = '', $left_company = '', $company_id = '', $company_department_id = '', 
        $reports_to = '', $country_id = '')
    {
        $post_data = sprintf('&id=%s&file=%s&first_name=%s&last_name=%s&title=%s'
            . '&email1=%s&email2=%s&phone_work=%s&phone_cell=%s&phone_other=%s&address=%s'
            . '&city=%s&state=%s&zip=%s&is_hot=%s&notes=%s&entered_by=%s'
            . '&owner=%s&date_created=%s&date_modified=%s&left_company=%s&company_id=%s&company_department_id=%s'
            . '&reports_to=%s&country_id=%s',
            urlencode(strval($id)),
            !empty($file) ? '@' . urlencode(strval($file)) : '',
            urlencode(strval($first_name)),
            urlencode(strval($last_name)),
            urlencode(strval($title)),
            urlencode(strval($email1)),
            urlencode(strval($email2)),
            urlencode(strval($phone_work)),
            urlencode(strval($phone_cell)),
            urlencode(strval($phone_other)),
            urlencode(strval($address)),
            urlencode(strval($city)),
            urlencode(strval($state)),
            urlencode(strval($zip)),
            empty($is_hot) ? 'no' : 'yes',
            urlencode(strval($notes)),
            urlencode(strval($entered_by)),
            urlencode(strval($owner)),
            urlencode(strval($date_created)),
            urlencode(strval($date_modified)),
            empty($left_company) ? 'no' : 'yes',
            urlencode(strval($company_id)),
            urlencode(strval($company_department_id)),
            urlencode(strval($reports_to)),
            urlencode(strval($country_id))
        );
        $return = $this->_do('update_contact', $post_data);
        return intval($return['id']);
    }

    
    
    /**
     * Used to retrieve a backup of the site, intended for use by scripts. If a backup has been created within the last 24 hours, an HTTP redirect will be returned for the backup download URL. Otherwise, a backup will be started, and the text 'started' will be returned to indicate this. Subsequent calls will return 'running' until the backup finishes, in which case a redirect will be returned to the client for the backup file.
     *
     * @return array
     */
    public function get_backup()
    {
        $return = $this->_do('get_backup');
        return $return;
    }

                                                                                                                                                                                                                                                    
    
    /**
     * Updates a company.
     *
     * @param string $id  (required)
     * @param string $file (full path to local file) 
     * @param string $company_id 
     * @param string $name  (required)
     * @param string $address 
     * @param string $city 
     * @param string $state 
     * @param string $zip 
     * @param 40 $phone1 
     * @param 40 $phone2 
     * @param string $url 
     * @param string $key_technologies 
     * @param string $notes 
     * @param integer $entered_by 
     * @param integer $owner 
     * @param integer $date_created (timestamp - number of seconds since epoch) 
     * @param integer $date_modified (timestamp - number of seconds since epoch) 
     * @param boolean $is_hot 
     * @param string $fax_number 
     * @param country $country_id 
     * @return integer
     */
    public function update_company($id, $file = '', $company_id = '', $name, $address = '', 
        $city = '', $state = '', $zip = '', $phone1 = '', $phone2 = '', $url = '', 
        $key_technologies = '', $notes = '', $entered_by = '', $owner = '', $date_created = '', $date_modified = '', 
        $is_hot = '', $fax_number = '', $country_id = '')
    {
        $post_data = sprintf('&id=%s&file=%s&company_id=%s&name=%s&address=%s'
            . '&city=%s&state=%s&zip=%s&phone1=%s&phone2=%s&url=%s'
            . '&key_technologies=%s&notes=%s&entered_by=%s&owner=%s&date_created=%s&date_modified=%s'
            . '&is_hot=%s&fax_number=%s&country_id=%s',
            urlencode(strval($id)),
            !empty($file) ? '@' . urlencode(strval($file)) : '',
            urlencode(strval($company_id)),
            urlencode(strval($name)),
            urlencode(strval($address)),
            urlencode(strval($city)),
            urlencode(strval($state)),
            urlencode(strval($zip)),
            urlencode(strval($phone1)),
            urlencode(strval($phone2)),
            urlencode(strval($url)),
            urlencode(strval($key_technologies)),
            urlencode(strval($notes)),
            urlencode(strval($entered_by)),
            urlencode(strval($owner)),
            urlencode(strval($date_created)),
            urlencode(strval($date_modified)),
            empty($is_hot) ? 'no' : 'yes',
            urlencode(strval($fax_number)),
            urlencode(strval($country_id))
        );
        $return = $this->_do('update_company', $post_data);
        return intval($return['id']);
    }

                                                                                                                                                                                                    
    
    /**
     * Updates candidate data for a registered candidate on the careers website portal.
     *
     * @param number $id  (required)
     * @param string $file (full path to local file) 
     * @param string $first_name  (required)
     * @param string $middle_name 
     * @param string $last_name  (required)
     * @param string $address 
     * @param string $city 
     * @param string $state 
     * @param string $post_code 
     * @param string $email  (required)
     * @param string $password 
     * @param string $title 
     * @param string $phone_home 
     * @param string $phone_work 
     * @param string $phone_cell 
     * @param string $website 
     * @return integer
     */
    public function portal_profile_update($id, $file = '', $first_name, $middle_name = '', $last_name, 
        $address = '', $city = '', $state = '', $post_code = '', $email, $password = '', 
        $title = '', $phone_home = '', $phone_work = '', $phone_cell = '', $website = '')
    {
        $post_data = sprintf('&id=%s&file=%s&first_name=%s&middle_name=%s&last_name=%s'
            . '&address=%s&city=%s&state=%s&post_code=%s&email=%s&password=%s'
            . '&title=%s&phone_home=%s&phone_work=%s&phone_cell=%s&website=%s',
            urlencode(strval($id)),
            !empty($file) ? '@' . urlencode(strval($file)) : '',
            urlencode(strval($first_name)),
            urlencode(strval($middle_name)),
            urlencode(strval($last_name)),
            urlencode(strval($address)),
            urlencode(strval($city)),
            urlencode(strval($state)),
            urlencode(strval($post_code)),
            urlencode(strval($email)),
            urlencode(strval($password)),
            urlencode(strval($title)),
            urlencode(strval($phone_home)),
            urlencode(strval($phone_work)),
            urlencode(strval($phone_cell)),
            urlencode(strval($website))
        );
        $return = $this->_do('portal_profile_update', $post_data);
        return intval($return['item']);
    }

                
    
    /**
     * Retrieves meta-data about an attachment using its globally unique identifier (guid).
     *
     * @param string $guid  (required)
     * @return array
     */
    public function get_attachment($guid)
    {
        $post_data = sprintf('&guid=%s',
            urlencode(strval($guid))
        );
        $return = $this->_do('get_attachment', $post_data);
        return $return;
    }

                
    
    /**
     * Deletes a job order record and all child contacts, attachments and pipelines.
     *
     * @param number $id  (required)
     * @return integer
     */
    public function delete_joborder($id)
    {
        $post_data = sprintf('&id=%s',
            urlencode(strval($id))
        );
        $return = $this->_do('delete_joborder', $post_data);
        return intval($return['id']);
    }

                            
    
    /**
     * Retrieves one or more candidates.
     *
     * @param number $id  (required)
     * @param string $result 
     * @return array
     */
    public function get_candidate($id, $result = '')
    {
        $post_data = sprintf('&id=%s&result=%s',
            urlencode(strval($id)),
            urlencode(strval($result))
        );
        $return = $this->_do('get_candidate', $post_data);
        return $return;
    }

                
    
    /**
     * When provided with the responses from get_joborder_applications, this function performs all necessary legwork for processing a candidate's application to a job order: adding the candidate record, adding the candidate to the pipeline, processing any application triggers, processing workflow triggers, adding attachments, adding activity logs, storing application responses and sending email notifications to the new applicant,the joborder owner or anyone else specified (if enabled). Because the questions are dynamic, they can't be specified here as parameters. Each question in get_joborder_applications has an id attribute which should be provided to this function as a parameter with the user input value.
     *
     * @param number $id 
     * @return integer
     */
    public function apply_joborder($id = '')
    {
        $post_data = sprintf('&id=%s',
            urlencode(strval($id))
        );
        $return = $this->_do('apply_joborder', $post_data);
        return intval($return['id']);
    }

                                                                                                                                                
    
    /**
     * Retrieves a list of candidates.
     *
     * @param string $search 
     * @param number $rows_per_page 
     * @param number $page_number 
     * @param string $sort 
     * @param string $sort_direction 
     * @param string $display_column 
     * @param string $filter 
     * @param string $list 
     * @param boolean $export_csv 
     * @return array
     */
    public function get_candidates($search = '', $rows_per_page = '', $page_number = '', $sort = '', $sort_direction = '', 
        $display_column = '', $filter = '', $list = '', $export_csv = '')
    {
        $post_data = sprintf('&search=%s&rows_per_page=%s&page_number=%s&sort=%s&sort_direction=%s'
            . '&display_column=%s&filter=%s&list=%s&export_csv=%s',
            urlencode(strval($search)),
            urlencode(strval($rows_per_page)),
            urlencode(strval($page_number)),
            urlencode(strval($sort)),
            urlencode(strval($sort_direction)),
            urlencode(strval($display_column)),
            urlencode(strval($filter)),
            urlencode(strval($list)),
            empty($export_csv) ? 'no' : 'yes'
        );
        $return = $this->_do('get_candidates', $post_data);
        return $return;
    }

                                                                                                                        
    
    /**
     * Retrieves a subset of tasks.
     *
     * @param string $search 
     * @param number $rows_per_page 
     * @param number $page_number 
     * @param string $sort 
     * @param string $sort_direction 
     * @param string $display_column 
     * @param string $filter 
     * @return array
     */
    public function get_tasks($search = '', $rows_per_page = '', $page_number = '', $sort = '', $sort_direction = '', 
        $display_column = '', $filter = '')
    {
        $post_data = sprintf('&search=%s&rows_per_page=%s&page_number=%s&sort=%s&sort_direction=%s'
            . '&display_column=%s&filter=%s',
            urlencode(strval($search)),
            urlencode(strval($rows_per_page)),
            urlencode(strval($page_number)),
            urlencode(strval($sort)),
            urlencode(strval($sort_direction)),
            urlencode(strval($display_column)),
            urlencode(strval($filter))
        );
        $return = $this->_do('get_tasks', $post_data);
        return $return;
    }

                                                                                                
    
    /**
     * Returns search results for candidates, contacts, joborders, and companies.
     *
     * @param string $keywords  (required)
     * @param string $data_type 
     * @param boolean $is_email 
     * @param number $max_results 
     * @param number $offset 
     * @return array
     */
    public function search($keywords, $data_type = '', $is_email = '', $max_results = '', $offset = '')
    {
        $post_data = sprintf('&keywords=%s&data_type=%s&is_email=%s&max_results=%s&offset=%s',
            urlencode(strval($keywords)),
            urlencode(strval($data_type)),
            empty($is_email) ? 'no' : 'yes',
            urlencode(strval($max_results)),
            urlencode(strval($offset))
        );
        $return = $this->_do('search', $post_data);
        return $return;
    }

                            
    
    /**
     * Retrieves one or more contacts.
     *
     * @param number $id  (required)
     * @param string $result 
     * @return array
     */
    public function get_contact($id, $result = '')
    {
        $post_data = sprintf('&id=%s&result=%s',
            urlencode(strval($id)),
            urlencode(strval($result))
        );
        $return = $this->_do('get_contact', $post_data);
        return $return;
    }

                
    
    /**
     * Deletes one or more contact records.
     *
     * @param number $id  (required)
     * @return integer
     */
    public function delete_contact($id)
    {
        $post_data = sprintf('&id=%s',
            urlencode(strval($id))
        );
        $return = $this->_do('delete_contact', $post_data);
        return intval($return['id']);
    }

                
    
    /**
     * Retrieves workflow statuses.
     *
     * @param string $data_type 
     * @return array
     */
    public function get_statuses($data_type = '')
    {
        $post_data = sprintf('&data_type=%s',
            urlencode(strval($data_type))
        );
        $return = $this->_do('get_statuses', $post_data);
        return $return;
    }

                                        
    
    /**
     * Attaches one or more tags to one or more data items of the specified data item type.
     *
     * @param string $data_item_type  (required)
     * @param array $data_item_ids  (required)
     * @param array $tag_ids  (required)
     * @return integer
     */
    public function attach_tags($data_item_type, $data_item_ids, $tag_ids)
    {
        $post_data = sprintf('&data_item_type=%s&data_item_ids=%s&tag_ids=%s',
            urlencode(strval($data_item_type)),
            urlencode(strval($data_item_ids)),
            urlencode(strval($tag_ids))
        );
        $return = $this->_do('attach_tags', $post_data);
        return intval($return['id']);
    }

                                                                                                                                                                                                                                        
    
    /**
     * Adds a company record.
     *
     * @param string $company_id 
     * @param string $name  (required)
     * @param string $address 
     * @param string $city 
     * @param string $state 
     * @param string $zip 
     * @param 40 $phone1 
     * @param 40 $phone2 
     * @param string $url 
     * @param string $key_technologies 
     * @param string $notes 
     * @param integer $entered_by 
     * @param integer $owner 
     * @param integer $date_created (timestamp - number of seconds since epoch) 
     * @param integer $date_modified (timestamp - number of seconds since epoch) 
     * @param boolean $is_hot 
     * @param string $fax_number 
     * @param country $country_id 
     * @param string $on_duplicate 
     * @return integer
     */
    public function add_company($company_id = '', $name, $address = '', $city = '', $state = '', 
        $zip = '', $phone1 = '', $phone2 = '', $url = '', $key_technologies = '', $notes = '', 
        $entered_by = '', $owner = '', $date_created = '', $date_modified = '', $is_hot = '', $fax_number = '', 
        $country_id = '', $on_duplicate = '')
    {
        $post_data = sprintf('&company_id=%s&name=%s&address=%s&city=%s&state=%s'
            . '&zip=%s&phone1=%s&phone2=%s&url=%s&key_technologies=%s&notes=%s'
            . '&entered_by=%s&owner=%s&date_created=%s&date_modified=%s&is_hot=%s&fax_number=%s'
            . '&country_id=%s&on_duplicate=%s',
            urlencode(strval($company_id)),
            urlencode(strval($name)),
            urlencode(strval($address)),
            urlencode(strval($city)),
            urlencode(strval($state)),
            urlencode(strval($zip)),
            urlencode(strval($phone1)),
            urlencode(strval($phone2)),
            urlencode(strval($url)),
            urlencode(strval($key_technologies)),
            urlencode(strval($notes)),
            urlencode(strval($entered_by)),
            urlencode(strval($owner)),
            urlencode(strval($date_created)),
            urlencode(strval($date_modified)),
            empty($is_hot) ? 'no' : 'yes',
            urlencode(strval($fax_number)),
            urlencode(strval($country_id)),
            urlencode(strval($on_duplicate))
        );
        $return = $this->_do('add_company', $post_data);
        return intval($return['id']);
    }

                                                                                                                        
    
    /**
     * Retrieves a subset of activities, similar to the activities's tab in the CATS software.
     *
     * @param string $search 
     * @param number $rows_per_page 
     * @param number $page_number 
     * @param string $sort 
     * @param string $sort_direction 
     * @param string $display_column 
     * @param string $filter 
     * @return array
     */
    public function get_activities($search = '', $rows_per_page = '', $page_number = '', $sort = '', $sort_direction = '', 
        $display_column = '', $filter = '')
    {
        $post_data = sprintf('&search=%s&rows_per_page=%s&page_number=%s&sort=%s&sort_direction=%s'
            . '&display_column=%s&filter=%s',
            urlencode(strval($search)),
            urlencode(strval($rows_per_page)),
            urlencode(strval($page_number)),
            urlencode(strval($sort)),
            urlencode(strval($sort_direction)),
            urlencode(strval($display_column)),
            urlencode(strval($filter))
        );
        $return = $this->_do('get_activities', $post_data);
        return $return;
    }

                                                    
    
    /**
     * Adds an attachment to a candidate, contact, or joborder.
     *
     * @param string $data_type  (required)
     * @param string $id  (required)
     * @param string $file (full path to local file) 
     * @param boolean $is_resume 
     * @return array
     */
    public function add_attachment($data_type, $id, $file = '', $is_resume = '')
    {
        $post_data = sprintf('&data_type=%s&id=%s&file=%s&is_resume=%s',
            urlencode(strval($data_type)),
            urlencode(strval($id)),
            !empty($file) ? '@' . urlencode(strval($file)) : '',
            empty($is_resume) ? 'no' : 'yes'
        );
        $return = $this->_do('add_attachment', $post_data);
        return $return;
    }

                                                                                                                                    
    
    /**
     * Retrieves a list of companies.
     *
     * @param string $search 
     * @param number $rows_per_page 
     * @param number $page_number 
     * @param string $sort 
     * @param string $sort_direction 
     * @param string $display_column 
     * @param string $list 
     * @param string $filter 
     * @return array
     */
    public function get_companies($search = '', $rows_per_page = '', $page_number = '', $sort = '', $sort_direction = '', 
        $display_column = '', $list = '', $filter = '')
    {
        $post_data = sprintf('&search=%s&rows_per_page=%s&page_number=%s&sort=%s&sort_direction=%s'
            . '&display_column=%s&list=%s&filter=%s',
            urlencode(strval($search)),
            urlencode(strval($rows_per_page)),
            urlencode(strval($page_number)),
            urlencode(strval($sort)),
            urlencode(strval($sort_direction)),
            urlencode(strval($display_column)),
            urlencode(strval($list)),
            urlencode(strval($filter))
        );
        $return = $this->_do('get_companies', $post_data);
        return $return;
    }

                                                                                                                                                                                                                                                                                                    
    
    /**
     * Adds a contact record.
     *
     * @param string $first_name  (required)
     * @param string $last_name  (required)
     * @param string $title 
     * @param string $email1 
     * @param string $email2 
     * @param string $phone_work 
     * @param string $phone_cell 
     * @param string $phone_other 
     * @param string $address 
     * @param string $city 
     * @param string $state 
     * @param string $zip 
     * @param boolean $is_hot 
     * @param string $notes 
     * @param integer $entered_by 
     * @param integer $owner 
     * @param integer $date_created (timestamp - number of seconds since epoch) 
     * @param integer $date_modified (timestamp - number of seconds since epoch) 
     * @param boolean $left_company 
     * @param integer $company_id 
     * @param integer $company_department_id 
     * @param contact $reports_to 
     * @param country $country_id 
     * @param string $on_duplicate 
     * @return integer
     */
    public function add_contact($first_name, $last_name, $title = '', $email1 = '', $email2 = '', 
        $phone_work = '', $phone_cell = '', $phone_other = '', $address = '', $city = '', $state = '', 
        $zip = '', $is_hot = '', $notes = '', $entered_by = '', $owner = '', $date_created = '', 
        $date_modified = '', $left_company = '', $company_id = '', $company_department_id = '', $reports_to = '', $country_id = '', 
        $on_duplicate = '')
    {
        $post_data = sprintf('&first_name=%s&last_name=%s&title=%s&email1=%s&email2=%s'
            . '&phone_work=%s&phone_cell=%s&phone_other=%s&address=%s&city=%s&state=%s'
            . '&zip=%s&is_hot=%s&notes=%s&entered_by=%s&owner=%s&date_created=%s'
            . '&date_modified=%s&left_company=%s&company_id=%s&company_department_id=%s&reports_to=%s&country_id=%s'
            . '&on_duplicate=%s',
            urlencode(strval($first_name)),
            urlencode(strval($last_name)),
            urlencode(strval($title)),
            urlencode(strval($email1)),
            urlencode(strval($email2)),
            urlencode(strval($phone_work)),
            urlencode(strval($phone_cell)),
            urlencode(strval($phone_other)),
            urlencode(strval($address)),
            urlencode(strval($city)),
            urlencode(strval($state)),
            urlencode(strval($zip)),
            empty($is_hot) ? 'no' : 'yes',
            urlencode(strval($notes)),
            urlencode(strval($entered_by)),
            urlencode(strval($owner)),
            urlencode(strval($date_created)),
            urlencode(strval($date_modified)),
            empty($left_company) ? 'no' : 'yes',
            urlencode(strval($company_id)),
            urlencode(strval($company_department_id)),
            urlencode(strval($reports_to)),
            urlencode(strval($country_id)),
            urlencode(strval($on_duplicate))
        );
        $return = $this->_do('add_contact', $post_data);
        return intval($return['id']);
    }

                            
    
    /**
     * Retrieves one or more companies.
     *
     * @param number $id  (required)
     * @param string $result 
     * @return array
     */
    public function get_company($id, $result = '')
    {
        $post_data = sprintf('&id=%s&result=%s',
            urlencode(strval($id)),
            urlencode(strval($result))
        );
        $return = $this->_do('get_company', $post_data);
        return $return;
    }

                            
    
    /**
     * Retrieves meta-data about all files attached to a record (50 limit) ordered newest to oldest.
     *
     * @param string $data_type  (required)
     * @param string $id  (required)
     * @return array
     */
    public function get_attachments($data_type, $id)
    {
        $post_data = sprintf('&data_type=%s&id=%s',
            urlencode(strval($data_type)),
            urlencode(strval($id))
        );
        $return = $this->_do('get_attachments', $post_data);
        return $return;
    }

                
    
    /**
     * Sends an email containing a candidate's password to their email address.
     *
     * @param string $email  (required)
     * @return integer
     */
    public function portal_forgot_password($email)
    {
        $post_data = sprintf('&email=%s',
            urlencode(strval($email))
        );
        $return = $this->_do('portal_forgot_password', $post_data);
        return intval($return['id']);
    }

                
    
    /**
     * Deletes one or more candidate records.
     *
     * @param string $id  (required)
     * @return integer
     */
    public function delete_candidate($id)
    {
        $post_data = sprintf('&id=%s',
            urlencode(strval($id))
        );
        $return = $this->_do('delete_candidate', $post_data);
        return intval($return['id']);
    }

                            
    
    /**
     * Retrieves meta-data about the most recent resume attachment for a single record.
     *
     * @param string $data_type  (required)
     * @param string $id  (required)
     * @return array
     */
    public function get_resume($data_type, $id)
    {
        $post_data = sprintf('&data_type=%s&id=%s',
            urlencode(strval($data_type)),
            urlencode(strval($id))
        );
        $return = $this->_do('get_resume', $post_data);
        return $return;
    }

}