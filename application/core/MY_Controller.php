<?php


/*
 * extends codeigniter main controller
 */

class MY_Controller extends MX_Controller {
	
	protected $data = array();
    protected $viewdata;
	protected $mUser = NULL;
	protected $mSettings = NULL;
	protected $mBodyClass = 'hold-transition skin-blue sidebar-mini';
	protected $mPageTitle = '';
        
	protected $mCtrler = 'home';		// current controller
	protected $mAction = 'index';		// controller function being called

	// Config values from config/lms_config.php
	protected $mConfig = array();
	protected $mBaseUrl = array();
	
	protected $mPageAuth = array();

	
	protected $mMenu = array();
	protected $mLanguage = '';

	public function __construct() {

	    parent::__construct();

		$this->load->model('settings_model');
		$this->mCtrler = $this->router->fetch_class();
		$this->mAction = $this->router->fetch_method();

	    $this->_setup();
	}

	protected function _setup(){

		$config = $this->config->item('lms_config');
		$this->mMenu = empty($config['menu']) ? array() : $config['menu'];
		$this->mMetaData = empty($config['meta_data']) ? array() : $config['meta_data'];

		$this->mSettings = $this->settings_model->getSettings();
		$this->data['settings'] = $this->mSettings;
		$this->mLanguage = $this->mSettings->language;
		$this->lang->load('settings_lang', $this->mLanguage);


		if ( $this->ion_auth->logged_in() )
		{

			$this->mUser = $this->ion_auth->user()->row();
			$this->data['perms'] = $this->settings_model->getGroupPermissions($this->ion_auth->get_users_groups()->row()->id);

			foreach ($this->data['perms'] as $perm => $value) {
				if (strpos($perm, '-') !== false) {
					$perm = str_replace("-", "/", $perm);
					$this->mPageAuth[$perm] = $value;

				}

			}
		}
		// restrict pages
		$uri = $this->mCtrler.'/'.$this->mAction;
		
		if ( array_key_exists($uri, $this->mPageAuth) && !$this->mPageAuth[$uri] == 1 )
		{
			$page_404 = $this->router->routes['404_override'];
			$redirect_url = empty($this->mModule) ? $page_404 : $this->mModule.'/'.$page_404;
			redirect($redirect_url);
		}

		
		
	}
	// Verify user login (regardless of user group)
	protected function verify_login($redirect_url = NULL)
	{
		if ( !$this->ion_auth->logged_in() )
		{
			if ( $redirect_url==NULL )
				$redirect_url = $this->mConfig['login_url'];

			redirect($redirect_url);
		}
	}

	protected function render($view_file, $data = NULL, $login = FALSE)
		{	

			$this->data['user'] = $this->mUser;
			$this->data['body_class'] = $this->mBodyClass;
			$this->data['menu'] = $this->mMenu;
			$this->data['current_uri'] = empty($this->mModule) ? uri_string(): str_replace($this->mModule.'/', '', uri_string());


			// automatically generate page title
			if ( empty($this->mPageTitle) )
			{
				if ($this->mAction=='index')
					$this->mPageTitle = humanize($this->mCtrler);
				else
					$this->mPageTitle = humanize($this->mAction);
			}
			$this->data['ctrler'] = $this->mCtrler;
			$this->data['action'] = $this->mAction;
			$this->data['page_title'] = $this->mPageTitle;

			$this->data['page_auth'] = $this->mPageAuth;

			if ($login) {
				$this->data['body_class'] = 'hold-transition login-page';
			}
			$this->load->view('template/header', $this->data);

			if (!$login){
				$this->load->view('template/navigation', $this->data);
			}
				$this->load->view($view_file, $this->data);

			if (!$login){
				$this->load->view('template/footer', $this->data);
			}
		}

	public function send_email($to, $subject, $message, $from = null, $from_name = null, $attachment = null, $cc = null, $bcc = null)
    {
    	
        $this->load->library('email');
        $config['useragent'] = "Library Management System";
        $config['protocol'] = 'smtp';
        $config['mailtype'] = "html";
        $config['crlf'] = "\r\n";
        $config['charset']   = 'utf-8';
		$config['newline']   = "\r\n";
       
        $this->load->library('encrypt');

        $config['smtp_host'] = $this->mSettings->smtp_host;
        $config['smtp_user'] = $this->mSettings->smtp_user;
        $config['smtp_pass'] = ($this->mSettings->smtp_pass);
        $config['smtp_port'] = $this->mSettings->smtp_port;
      

        $this->email->initialize($config);

        if ($from && $from_name) {
            $this->email->from($from, $from_name);
        } elseif ($from) {
            $this->email->from($from, $this->mSettings->title);
        } else {
            $this->email->from($this->mSettings->email, $this->mSettings->title);
        }

        $this->email->to($to);
        if ($cc) {
            $this->email->cc($cc);
        }
        if ($bcc) {
            $this->email->bcc($bcc);
        }
        $this->email->subject($subject);
        $this->email->message($message);
        if ($attachment) {
            if (is_array($attachment)) {
                foreach ($attachment as $file) {
                    $this->email->attach($file);
                }
            } else {
                $this->email->attach($attachment, "inline");
            }
        }


        if ($this->email->send()) {
            // echo $this->email->print_debugger(); die();
            return true;
        } else {
            // echo $this->email->print_debugger(); die();
            return false;
        }
    }


	}

require APPPATH."core/controllers/Admin_Controller.php";
