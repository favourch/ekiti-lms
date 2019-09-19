<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		
	}
	// log the user in
	public function index()
	{
		
		//validate form input
		$this->form_validation->set_rules('identity', 'Identity', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ( $this->ion_auth->logged_in() ){
			redirect('panel/dashboard');
		}
		
		if ($this->form_validation->run() == true)
		{
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				if ($this->ion_auth->is_admin())
				{
					redirect('panel/dashboard');
				}
	
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You are now logged in!</div>');
				redirect('panel', 'refresh');
			}
			else
			{
				// if the login was un-successful
				// redirect them back to the login page
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Login Failed! Please try again.</div>');
				redirect('panel/', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{
			// the user is not logging in so display the login page
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['identity'] = array('name' => 'identity',
				'id'    => 'identity',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$this->data['password'] = array('name' => 'password',
				'id'   => 'password',
				'type' => 'password',
			);
			$this->render('login', '', TRUE);
		}
	}
	
}
