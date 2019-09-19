<?php

/**
 * Base Controller for Admin module
 */
class Admin_Controller extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		// get user data if logged in
		// only login users can access Admin Panel
		$this->verify_login('panel/login');

		$this->mConfig['menu'] = array(
				'home' => array(
					'name'		=> lang('menu_home'),
					'url'		=> '',
					'icon'		=> 'fa fa-home',
				),
				
				'books' => array(
					'name'		=> lang('menu_book_title'),
					'url'		=> 'books/index',
					'icon'		=> 'fa fa-book',
					'children'  => array(
						lang('menu_book_list')			=> 'books',
						lang('menu_add_book')		=> 'books/add',
						lang('menu_authors')		=> 'books/authors',
						lang('menu_categories')	=> 'books/categories',
						lang('menu_importbooks')	=> 'books/import_csv',
						lang('menu_labelprint')	=> 'books/print_barcodes'
					)
					
				),
				
				
				'borrow' => array(
					'name'		=> lang('menu_circulation'),
					'url'		=> 'borrow/index',
					'icon'		=> 'fa fa-user',
					'children'  => array(
						lang('menu_issue_book')		=> 'borrow',
						lang('menu_return_book')		=> 'borrow/bookreturn',
						lang('menu_borrowed_books')	=> 'borrow/borrowed/pending',
						lang('menu_lost_books')		=> 'borrow/borrowed/lost',
						lang('menu_returned_book')		=> 'borrow/borrowed/returned',
					)
					
				),
				
				'delayed' => array(
					'name'		=> lang('menu_delated_title'),
					'url'		=> 'delayed/index',
					'icon'		=> 'fa fa-user',
					'children'  =>  array(
									lang('menu_notify_delayed')	=> 'delayed/index',
									lang('menu_send_templates')	=> 'delayed/email_templates',
									),
				),

				'auth' => array(
					'name'		=> lang('menu_admin_panel'),
					'url'		=> 'auth/index',
					'icon'		=> 'fa fa-cog',
					'children'  => array(
						lang('menu_admin_users')			=> 'auth',
						lang('menu_create_users')	=> 'auth/create_user',
						lang('menu_member_types')	=> 'auth/member_types',
						lang('menu_occupations')	=> 'auth/occupations'
					)
				),
				
			
				'settings' => array(
					'name'		=> lang('menu_settings_title'),
					'url'		=> 'settings/index',
					'icon'		=> 'fa fa-cogs',
					'children'  => array(
						lang('menu_settings')				=> 'settings/index',
						lang('menu_db_version')		=> 'settings/list_db',
						lang('menu_smsconfig')			=> 'settings/sms',
					)
					
				),
				'issued' => array(
					'name'		=> lang('menu_mybooks_title'),
					'url'		=> 'issued/index',
					'icon'		=> 'fa fa-book',
					'children'  => array(
						lang('menu_mybooks')		=> 'issued',
						lang('menu_circulation_history')		=> 'issued/history',
					)
					
				),
				
				'request' => array(
					'name'		=> lang('menu_requested_books'),
					'url'		=> 'request/index',
					'icon'		=> 'fa fa-book',
					'children'  => array(
						lang('menu_list_requested_books')	=> 'request/index',
						lang('menu_add_requested_books') 	=> 'request/add_requested_books',
					)
				),
				
				'requested_books' => array(
					'name'		=> lang('menu_requested_books'),
					'url'		=> 'requested_books/index',
					'icon'		=> 'fa fa-book',
					'children'  =>  array(
						lang('menu_requested_books')	=> 'requested_books/index',
						lang('menu_send_templates')	=> 'requested_books/email_templates',
					),
				),

				'reports' => array(
					'name'		=> lang('menu_reports_title'),
					'url'		=> 'reports/index',
					'icon'		=> 'fa fa-book',
					'children'  => array(
						lang('menu_qinventory')		=> 'reports/quick_inventory',
					)
					
				),
			);
	}
		protected function render($view_file, $data = NULL, $login = FALSE)
		{
			$this->mMenu = $this->mConfig['menu'];
			if ($login) {
				parent::render($view_file, $this->data, TRUE);
			}else{
				parent::render($view_file, $this->data);
			}

			
		}

	


}

