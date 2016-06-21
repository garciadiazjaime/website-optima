<?php
$config = array(
   'register' => array(
      array(
         'field'   => 'email',
         'label'   => 'email',
         'rules'   => 'trim|required|min_length[5]|max_length[45]|xss_clean|valid_email|callback_username_check'
      ),
      array(
         'field'   => 'password',
         'label'   => 'Password',
         'rules'   => 'trim|required|min_length[4]|max_length[45]'
      ),
      array(
         'field'   => 'passconf',
         'label'   => 'Password Confirmation',
         'rules'   => 'trim|required|min_length[4]|max_length[45]|matches[passconf]'
      ),
      array(
         'field'   => 'upload_file',
         'label'   => 'Upload resume',
         'rules'   => 'trim|required|min_length[5]|max_length[250]'
      ),
      array(
         'field'   => 'first_name',
         'label'   => 'Firstname',
         'rules'   => 'trim|required|min_length[2]|max_length[45]'
      ),
      array(
         'field'   => 'last_name',
         'label'   => 'Lastname',
         'rules'   => 'trim|required|min_length[2]|max_length[45]'
      ),
      /*array(
         'field'   => 'title',
         'label'   => 'Title',
         'rules'   => 'trim|required|min_length[2]|max_length[45]'
      ),
      array(
         'field'   => 'phone',
         'label'   => 'Phone number',
         'rules'   => 'trim|required|min_length[4]|max_length[20]'
      ),
      array(
         'field'   => 'address',
         'label'   => 'Address',
         'rules'   => 'trim|required|min_length[4]|max_length[140]'
      ),*/
      array(
         'field'   => 'city',
         'label'   => 'City',
         'rules'   => 'trim|required|min_length[2]|max_length[45]'
      ),
      array(
         'field'   => 'state',
         'label'   => 'State',
         'rules'   => 'trim|required|min_length[2]|max_length[45]'
      ),
      /*array(
         'field'   => 'zip_code',
         'label'   => 'Zip code',
         'rules'   => 'trim|required|min_length[2]|max_length[10]'
      ),
      array(
         'field'   => 'date_available',
         'label'   => 'Available date',
         'rules'   => 'trim|required|min_length[4]|max_length[10]'
      ),
      array(
         'field'   => 'current_employer',
         'label'   => 'Current employer',
         'rules'   => ''
      ),
      array(
         'field'   => 'current_title',
         'label'   => 'Current title',
         'rules'   => ''
      ),
      array(
         'field'   => 'skills',
         'label'   => 'Skills',
         'rules'   => ''
      ),
      array(
         'field'   => 'technologies',
         'label'   => 'Technologies',
         'rules'   => ''
      ),
      array(
         'field'   => 'technologies',
         'label'   => 'Technologies',
         'rules'   => ''
      ),
      array(
         'field'   => 'alt_phone',
         'label'   => 'Alternative Phone',
         'rules'   => ''
      ),
      array(
         'field'   => 'current_pay',
         'label'   => 'Current payment',
         'rules'   => ''
      ),
      array(
         'field'   => 'desire_pay',
         'label'   => 'Desire pay',
         'rules'   => ''
      ),
      array(
         'field'   => 'more_info',
         'label'   => 'More information',
         'rules'   => ''
      ),*/
      array(
         'field'   => 'terms',
         'label'   => 'Terms and Conditions',
         'rules'   => 'trim|required|xss_clean'
      ),
   ),
   'login' => array(
      array(
         'field'   => 'email',
         'label'   => 'Email',
         'rules'   => 'trim|required|min_length[5]|max_length[45]|xss_clean|valid_email|callback_username_check'
      ),
      array(
         'field'   => 'password',
         'label'   => 'Password',
         'rules'   => 'trim|required|min_length[4]|max_length[45]'
      )
   ),
   'forgot_password' => array(
      array(
         'field'   => 'email',
         'label'   => 'Email',
         'rules'   => 'trim|required|min_length[5]|max_length[45]|xss_clean|valid_email'
      ),
   ),
   'add_file' =>  array(
      array(
         'field'   => 'name',
         'label'   => 'Name',
         'rules'   => 'trim|required|min_length[4]|max_length[45]|xss_clean'
      ),      
      array(
         'field'   => 'description',
         'label'   => 'Description',
         'rules'   => 'trim|required|min_length[4]|max_length[200]'
      ),
      array(
         'field'   => 'upload_file',
         'label'   => 'Upload resume',
         'rules'   => 'trim|required|min_length[5]|max_length[250]'
      ),
   ),
);

/*

*/

?>
