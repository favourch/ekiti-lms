<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Errors extends MY_Controller {

	// Override 404 error
	// Match with $route['404_override'] value from /application/config/routes.php
	public function index()
	{
		// $this->output->set_status_header('404');
		// $this->mPageTitle = '404 Page Not Found';
		$this->data['heading'] = "404 Page Not Found";
		$this->data['message'] = "";
		$this->load->view('errors/html/error_404', $this->data);
	}
	
}