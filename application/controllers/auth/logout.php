<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends MY_Controller {
	
    protected $title = 'Logout';
    
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
    
    //log the user out
	function index() {
		//log the user out
		$logout = $this->ion_auth->logout();

		// UI
		$this->add_success('You have been successfully logged out');
		redirect('/', 'refresh');
	}
}
