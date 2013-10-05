<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {
	
    protected $title = 'Home';
    
    public function __construct() {
        parent::__construct();
        $this->twiggy->title()->append('Auth');
        $this->twiggy->title()->append($this->title);

        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('url');
        
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ? $this->load
            ->library('mongo_db') : $this->load->database();
        
        $this->form_validation
            ->set_error_delimiters(
                $this->config
                    ->item('error_start_delimiter', 'ion_auth'),
                $this->config->item('error_end_delimiter', 'ion_auth'));
        
        $this->lang->load('auth');
        $this->load->helper('language');
    }
    
    //redirect if needed, otherwise display the user list
    public function index() {
        if (!$this->ion_auth->logged_in()) {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        } elseif (!$this->ion_auth->is_admin()) {
            //redirect them to the home page because they must be an administrator to view this
            redirect('/moderators', 'refresh');
        } 
        // the flash data error message if there is one
        $message = (validation_errors()) ? validation_errors()
            : $this->session->flashdata('message');
        $this->add_error($message);
        if ($this->ion_auth->is_admin())
        	redirect('/admin/', 'refresh');
        
        redirect('/moderators/', 'refresh');
    }
    
}
