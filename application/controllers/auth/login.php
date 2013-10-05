<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * The MIT License (MIT)
*
* Copyright (c) 2013 TupiLabs
*
* Permission is hereby granted, free of charge, to any person obtaining a copy of
* this software and associated documentation files (the "Software"), to deal in
* the Software without restriction, including without limitation the rights to
* use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
* the Software, and to permit persons to whom the Software is furnished to do so,
* subject to the following conditions:
*
* The above copyright notice and this permission notice shall be included in all
* copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
* FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
* COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
* IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
* CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

class Login extends MY_Controller {
	
    protected $title = 'Login';
    
    public function __construct() {
        parent::__construct();
        $this->twiggy->title()->append('Auth');
        $this->twiggy->title()->append($this->title);

        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('url');
        
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ? $this->load->library('mongo_db') : $this->load->database();
        
        $this->form_validation
            ->set_error_delimiters(
                $this->config->item('error_start_delimiter', 'ion_auth'),
                $this->config->item('error_end_delimiter', 'ion_auth'));
        
        $this->lang->load('auth');
        $this->load->helper('language');
    }
    
    //log the user in
    function index() {
        //validate form input
        $this->form_validation->set_rules('identity', 'Identity', 'required|trim|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean');
        $this->form_validation->set_rules('from', 'From', 'trim|xss_clean');
        if ($this->form_validation->run() == true) {
        	$from = $this->form_validation->set_value('from');
            //check to see if the user is logging in
            //check for "remember me"
            $remember = (bool) $this->input->post('remember');
    
            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
                //if the login is successful
                //redirect them back to the home page
                $this->session->set_flashdata('message', 'Logged in!');
                $url = '/';
                if (isset($from) && !empty($from)) 
                	$url = $url . $from;
                redirect($url, 'refresh');
            } else {
                //if the login was un-successful
                //redirect them back to the login page
                $this->session->set_flashdata('message', $this->ion_auth->errors());
				$this->add_error($this->ion_auth->errors());
                redirect('auth/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        } else {
        	$from = $this->input->get('from');
            //the user is not logging in so display the login page
            //set the flash data error message if there is one
            $message = (validation_errors()) ? validation_errors()
                : $this->session->flashdata('message');
            $this->add_error($message);
    
            $this->twiggy->set('identity', array('name' => 'identity',
                    'id' => 'identity', 'type' => 'text',
                    'value' => $this->form_validation->set_value('identity'),));
            $this->twiggy->set('password', array('name' => 'password',
                    'id' => 'password', 'type' => 'password',));
    		$this->twiggy->set('from', $from);
            $this->twiggy->display('auth/login');
        }
    }
}
