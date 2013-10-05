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

use Respect\Validation\Validator as v;

/**
 * A CI custom controller that supports Twig/gy, has handy Ion Auth functions, error
 * handling functions and captcha functions.
 */
class MY_Controller extends CI_Controller {
    
    protected $javascript = array();
    protected $css = array();
    
    public function __construct() {
        parent::__construct();
        // Twiggy
        $this->twiggy->set('css', $this->css);
        $this->twiggy->set('javascript', $this->javascript);
        // lang locale functions
        $this->twiggy->set('lang_switch', $this->lang);
        $this->twiggy->register_function('lang');
        // CodeIgniter functions
        $this->twiggy->register_function('anchor');
        $this->twiggy->register_function('site_url');
        $this->twiggy->register_function('base_url');
        $this->twiggy->register_function('uri_string');
        $this->twiggy->register_function('validation_errors');
        $this->twiggy->register_function('form_label');
        $this->twiggy->register_function('form_button');
        $this->twiggy->register_function('form_error');
        $this->twiggy->register_function('form_open');
        $this->twiggy->register_function('form_open_multipart');
        $this->twiggy->register_function('form_input');
        $this->twiggy->register_function('form_password');
        $this->twiggy->register_function('form_hidden');
        $this->twiggy->register_function('form_dropdown');
        $this->twiggy->register_function('form_checkbox');
        $this->twiggy->register_function('form_textarea');
        $this->twiggy->register_function('form_submit');
        $this->twiggy->register_function('form_close');
        $this->twiggy->register_function('set_value');
        $this->twiggy->register_function('current_url');
        // functions
        $this->twiggy->register_function('print_date');
        $this->twiggy->register_function('print_room_name');
        $this->twiggy->register_function('print_room_price');
        $this->twiggy->register_function('print_room_description');
        $this->twiggy->register_function('money_format');
        // extra
        $this->twiggy->register_function('count');
        $this->twiggy->register_function('trim');
        $this->twiggy->register_function('print_r');
        $this->twiggy->register_function('var_dump');
        $this->twiggy->register_function('rawurlencode');
        $this->twiggy->register_function('parse_expression');
        $this->twiggy->register_function('preg_match');
        $this->twiggy->register_function('urldecode');
        $this->twiggy->register_function('highlight_word');
        
        $this->twiggy->title()->append('Speak Like A Brazilian'); // TODO get it from config
        $this->twiggy->set('errors', $this->session->flashdata('errors'));
        $this->twiggy->set('warning', $this->session->flashdata('warning'));
        $this->twiggy->set('success', $this->session->flashdata('success'));
        $this->twiggy->set('message', $this->session->flashdata('message'));
        
        # Form validation, flatstrap
        $this->form_validation->set_error_delimiters('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading">Validation errors found</h4><p>', '</p></div>');
        
        # Ion Auth
        $this->load->library('ion_auth');
        $this->lang->load('auth');
        $this->load->helper('language');
        $this->twiggy->set('is_logged_in', $this->ion_auth->logged_in());
        $this->twiggy->set('is_admin', $this->ion_auth->is_admin());
    }
    
    // ------------------------------------------------------------------------
    // Error handling functions
    // ------------------------------------------------------------------------
    
    function add_error($errors) {
        $this->session->set_flashdata('errors', $errors);
        $this->twiggy->set('errors', $this->session->flashdata('errors'));
    }
    
    function add_warning($messages) {
        $this->session->set_flashdata('warning', $messages);
        $this->twiggy->set('warning', $this->session->flashdata('warning'));
    }
    
    function add_success($messages) {
        $this->session->set_flashdata('success', $messages);
        $this->twiggy->set('success', $this->session->flashdata('success'));
    }
    
    // ------------------------------------------------------------------------
    // Auth methods
    // ------------------------------------------------------------------------
    function logged_in() {
        if (!$this->ion_auth->logged_in()) {
            $this->add_warning('You must log in first');
            $from = $this->uri->uri_string();
            redirect('auth/login?from=' . $from, 'refresh');
        }
    }
    
    function is_admin() {
    	return $this->logged_in() && $this->ion_auth->is_admin();
    }
    
    function is_moderator() {
    	return 
   			$this->ion_auth->is_admin() || 
   			$this->ion_auth->in_group('moderators');
    }
    
    function check_moderator() {
    	$this->logged_in();
    	
    	if (!$this->is_moderator()) {
    		$this->add_warning('Not authorized');
    		redirect('/');
    	}
    }
    
    function get_user_id() {
        return $this->ion_auth->get_user_id(); // TBD: add auth
    }
    
    // ------------------------------------------------------------------------
    // Captcha functions
    // ------------------------------------------------------------------------
    /**
     * Create CAPTCHA image to verify user as a human
     * @access  private
     * @return	string
     */
    function _create_captcha() {
    	return img( array('src'=>site_url('captcha'), 'id'=>'captcha'), TRUE);
    }
    
    /**
     * Callback function. Check if SECUREIMAGE CAPTCHA test is passed.
     * @access  private
     * @param	string $imagecode
     * @return	bool
     */
    function _check_captcha($imagecode) {
    	$this->load->library('securimage');
    	if(!$this->securimage->check($imagecode)) {
    		$this->form_validation->set_message('_check_captcha', "Wrong confirmation code");
    		return FALSE;
    	}
    	return TRUE;
    }
    
    // ------------------------------------------------------------------------
    // E-mail functions
    // ------------------------------------------------------------------------
    
    /**
     * Send email message of given type (activate, forgot_password, etc.)
     * @access  private
     * @param	string
     * @param	string
     * @param	array
     * @return	void
     */
    function _send_email($html, $txt, &$data) {
    	if (!v::notEmpty()->key('name')->validate($data))
    		throw new InvalidArgumentException('Missing sender name');
    	if (!v::notEmpty()->key('from')->validate($data))
    		throw new InvalidArgumentException('Missing sender e-mail');
    	if (!v::notEmpty()->key('to')->validate($data))
    		throw new InvalidArgumentException('Missing destination e-mail');
    	if (!v::notEmpty()->key('subject')->validate($data))
    		throw new InvalidArgumentException('Missing e-mail subject');
    	if (!isset($this->email))
    		$this->load->library('email');
    	$this->email->set_newline("\n");
    	$this->email->from($data['from'], $data['name']);
    	$this->email->reply_to($data['from'], $data['name']);
    	$this->email->to($data['to']);
    	$this->email->subject($data['subject']);
    	$this->email->message($this->load->view('email/'.$html, $data, TRUE));
    	$this->email->set_alt_message($this->load->view('email/'.$txt, $data, TRUE));
    	$this->email->send();
    }
}
