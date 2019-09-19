<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->lang->load('home_lang', $this->mLanguage);

	}

	public function index() {
			// $this->load->model('user_model', 'users');
		$this->load->model('home_model');
		if ( $this->ion_auth->in_group(array('admin')) ){
				$this->data['count'] = array(
					'books' => $this->home_model->getTotalBooks(),
					'borrowed' => $this->home_model->getTotalBorrowedBooks(),
				);
				
				$this->data['dues'] = array(
					'due_today' => $this->home_model->getDues(),
					'due_tommorow' => $this->home_model->getDues('+ INTERVAL 1 DAY'),
				);
				$this->data['chartdata'] = array(
					'pending' => $this->home_model->getDuesCount('pending'),
					'lost' => $this->home_model->getDuesCount('lost'),
					'notreturned' => $this->home_model->getDuesCount('pending', TRUE),
					'tilldate' => $this->home_model->getDuesCount('tilldate'),
				);

				$this->data['barchart'] = $this->home_model->barChartData();

				// print_r($this->home_model->barChartData());
				$this->render('dashboard');
		}else{
			$this->data['chartdata'] = array(
				'pending' => $this->home_model->getDuesCountByID('pending'),
				'tilldate' => $this->home_model->getDuesCountByID('tilldate'),
				'returned' => $this->home_model->getDuesCountByID('returned'),
			);	
			$this->render('member/home');

		}	
	}

	function language($lang = false)
    {
        if ($this->input->get('lang')) {
            $lang = $this->input->get('lang');
        }
        //$this->load->helper('cookie');
        $folder = 'application/language/';
        $languagefiles = scandir($folder);
        if (in_array($lang, $languagefiles)) {
            if ($this->settings_model->updateSettings(array('language' => $lang))) {
            	$this->session->set_flashdata('message', lang('lang_updated') );
        		redirect($_SERVER["HTTP_REFERER"]);

            }else{
            	$this->session->set_flashdata('error', lang('lang_not_updated') );
        		redirect($_SERVER["HTTP_REFERER"]);

            }
        }
    }
    function toggle_rtl()
    {
        if ($this->settings_model->updateSettings(array('toggle_rtl' => $this->mSettings->toggle_rtl == 1 ? 0 : 1))) {
        	$this->session->set_flashdata('message', lang('lang_updated') );
    		redirect($_SERVER["HTTP_REFERER"]);
        }else{
        	$this->session->set_flashdata('error', lang('lang_not_updated') );
    		redirect($_SERVER["HTTP_REFERER"]);
        }
    }


}

/* End of file Dashboard.php */
// /* Location: ./application/controllers/Dashboard.php */