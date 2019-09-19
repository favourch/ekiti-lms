<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| LMS Configuration
| -------------------------------------------------------------------------
| This file lets you define default values to be passed into views 
| when calling MY_Controller's render() function. 
| 
*/

$config['lms_config'] = array(

	// Site name
	'site_name' => 'LMS',

	// Default page title prefix
	'page_title_prefix' => '',

	// Default page title
	'page_title' => '',

	// Default meta data
	'meta_data'	=> array(
		'author'		=> 'Usman Sher',
		'description'	=> 'A very Flexible & Extensible Library Management System',
		'keywords'		=> ''
	),

	// Menu items
	'menu' => array(
		'home' => array(
			'name'		=> 'Home',
			'url'		=> '',
			'icon'		=> 'fa fa-home',
		),
		
		'books' => array(
			'name'		=> 'Books',
			'url'		=> 'books/index',
			'icon'		=> 'fa fa-book',
			'children'  => array(
				'List'			=> 'books',
				'Add Book'		=> 'books/add',
				'Authors'		=> 'books/authors',
				'Categories'	=> 'books/categories',
				'Import CSV'	=> 'books/import_csv',
				'Label/Barcode Print'	=> 'books/print_barcodes'
			)
			
		),
		
		
		'borrow' => array(
			'name'		=> 'Circulation',
			'url'		=> 'borrow/index',
			'icon'		=> 'fa fa-user',
			'children'  => array(
				'Issue Book(s)'		=> 'borrow',
				'Return Book(s)'		=> 'borrow/bookreturn',
				'Borrowed Books'	=> 'borrow/borrowed/pending',
				'Lost Books'		=> 'borrow/borrowed/lost',
				'Returned Book'		=> 'borrow/borrowed/returned',
			)
			
		),
		
		'delayed' => array(
			'name'		=> 'Notify Delayed Members',
			'url'		=> 'delayed/index',
			'icon'		=> 'fa fa-user',
			'children'  =>  array(
							'Notify'	=> 'delayed/index',
							'Email/SMS Templates'	=> 'delayed/email_templates',
							),
		),

		'auth' => array(
			'name'		=> 'Admin Panel',
			'url'		=> 'auth/index',
			'icon'		=> 'fa fa-cog',
			'children'  => array(
				'Users'			=> 'auth',
				'Create User'	=> 'auth/create_user',
				'Member Type'	=> 'auth/member_types',
				'Occupations'	=> 'auth/occupations'
			)
		),
		
	
		'settings' => array(
			'name'		=> 'Settings',
			'url'		=> 'settings/index',
			'icon'		=> 'fa fa-cogs',
			'children'  => array(
				'Settings'				=> 'settings/index',
				'Database Versions'		=> 'settings/list_db',
				'SMS Config'			=> 'settings/sms',
			)
			
		),
		'issued' => array(
			'name'		=> 'My Books',
			'url'		=> 'issued/index',
			'icon'		=> 'fa fa-book',
			'children'  => array(
				'My Books'		=> 'issued',
				'Circulation History'		=> 'issued/history',
			)
			
		),
		'Reports' => array(
			'name'		=> 'Reports',
			'url'		=> 'reports/index',
			'icon'		=> 'fa fa-book',
			'children'  => array(
				'Quick Inventory'		=> 'reports/quick_inventory',
			)
			
		),
	),

	// Login page
	'login_url' => 'panel/login',

	
	// AdminLTE settings
	'adminlte' => array(
		'body_class' => array(
			'webmaster'	=> 'skin-red',
			'admin'		=> 'skin-purple',
			'member'	=> 'skin-black',
			// 'staff'		=> 'skin-blue',
		)
	),

	
);

/*
| -------------------------------------------------------------------------
| Override values from /application/config/config.php
| -------------------------------------------------------------------------
*/
$config['sess_cookie_name'] = 'ci_session_admin';
