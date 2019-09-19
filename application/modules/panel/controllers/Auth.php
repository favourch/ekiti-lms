<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth', $this->mLanguage);

    	$this->upload_path = 'assets/uploads/members';
        $this->image_types = 'gif|jpg|jpeg|png|tif';
        $this->digital_file_types = 'pdf';
        $this->allowed_file_size = '10720';
        $this->load->library('upload');
        $this->lang->load('members_lang', $this->mLanguage);
        $this->load->model('members_model');


	}

	// redirect if needed, otherwise display the user list
	function index()
	{
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('panel/login', 'refresh');
		}
		elseif (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else
		{
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			//list the users
			$this->data['users'] = $this->ion_auth->users()->result();
			foreach ($this->data['users'] as $k => $user)
			{
				$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}
			$this->_render_page('auth/index', $this->data);
		}
	}


	// log the user out
	function logout()
	{
		$this->data['title'] = "Logout";

		// log the user out
		$logout = $this->ion_auth->logout();

		// redirect them to the login page
		$this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">You are now logged out!</div>');
		redirect('panel/', 'refresh');
	}

	// change password
	function change_password()
	{
		if (DEMO) {
			$this->session->set_flashdata('error', "Disabled in Demo");
            redirect("panel");
		}
		$this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
		$this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

		if (!$this->ion_auth->logged_in())
		{
			redirect('panel/login', 'refresh');
		}

		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() == false)
		{
			// display the form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$this->data['old_password'] = array(
				'name' => 'old',
				'id'   => 'old',
				'type' => 'password',
			);
			$this->data['new_password'] = array(
				'name'    => 'new',
				'id'      => 'new',
				'type'    => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
			);
			$this->data['new_password_confirm'] = array(
				'name'    => 'new_confirm',
				'id'      => 'new_confirm',
				'type'    => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
			);
			$this->data['user_id'] = array(
				'name'  => 'user_id',
				'id'    => 'user_id',
				'type'  => 'hidden',
				'value' => $user->id,
			);

			// render
			$this->_render_page('auth/change_password', $this->data);
		}
		else
		{
			$identity = $this->session->userdata('identity');

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change)
			{
				//if the password was successfully changed
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->logout();
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('panel/auth/change_password', 'refresh');
			}
		}
	}

	// forgot password
	function forgot_password()
	{
		
		// setting validation rules by checking wheather identity is username or email
		if($this->config->item('identity', 'ion_auth') != 'email' )
		{
		   $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
		}
		else
		{
		   $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
		}


		if ($this->form_validation->run() == false)
		{
			$this->data['type'] = $this->config->item('identity','ion_auth');
			// setup the input
			$this->data['identity'] = array('name' => 'identity',
				'id' => 'identity',
			);

			if ( $this->config->item('identity', 'ion_auth') != 'email' ){
				$this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
			}
			else
			{
				$this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
			}

			// set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->render('auth/forgot_password', $this->data, TRUE);
		}
		else
		{
			$identity_column = $this->config->item('identity','ion_auth');
			$identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

			if(empty($identity)) {

	            		if($this->config->item('identity', 'ion_auth') != 'email')
		            	{
		            		$this->ion_auth->set_error('forgot_password_identity_not_found');
		            	}
		            	else
		            	{
		            	   $this->ion_auth->set_error('forgot_password_email_not_found');
		            	}

		                $this->session->set_flashdata('message', $this->ion_auth->errors());
                		redirect("auth/forgot_password", 'refresh');
            		}

			// run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			if ($forgotten)
			{
				// if there were no errors
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("login", 'refresh'); //we should display a confirmation page here instead of the login page
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("auth/forgot_password", 'refresh');
			}
		}
	}

	// reset password - final step for forgotten password
	public function reset_password($code = NULL)
	{
		if (!$code)
		{
			show_404();
		}

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user)
		{
			// if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

			if ($this->form_validation->run() == false)
			{
				// display the form

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$this->data['new_password'] = array(
					'name' => 'new',
					'id'   => 'new',
					'type' => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['new_password_confirm'] = array(
					'name'    => 'new_confirm',
					'id'      => 'new_confirm',
					'type'    => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['user_id'] = array(
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->id,
				);
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;

				// render
				$this->_render_page('auth/reset_password', $this->data);
			}
			else
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id'))
				{

					// something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($code);

					show_error($this->lang->line('error_csrf'));

				}
				else
				{
					// finally change the password
					$identity = $user->{$this->config->item('identity', 'ion_auth')};

					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

					if ($change)
					{
						// if the password was successfully changed
						$this->session->set_flashdata('message', $this->ion_auth->messages());
						redirect("login", 'refresh');
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect('panel/auth/reset_password/' . $code, 'refresh');
					}
				}
			}
		}
		else
		{
			// if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}


	// activate the user
	function activate($id, $code=false)
	{
		if ($code !== false)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation)
		{
			// redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("panel/auth", 'refresh');
		}
		else
		{
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("panel/auth/forgot_password", 'refresh');
		}
	}

	// deactivate the user
	function deactivate($id = NULL)
	{

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}

		$id = (int) $id;

		// do we have the right userlevel?
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
		{
			if ($this->ion_auth->deactivate($id)) {
				$this->session->set_flashdata('message', $this->ion_auth->messages());
			}

		}

		// redirect them back to the auth page
		redirect('panel/auth', 'refresh');
		
	}

	// create a new user
	function create_user()
    {
    	$this->upload_path = 'assets/uploads/members';
        $this->image_types = 'gif|jpg|jpeg|png|tif';
        $this->digital_file_types = 'pdf';
        $this->allowed_file_size = '10720';
        $this->data['title'] = "Create User";
        $this->load->library('upload');


        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            redirect('panel/auth', 'refresh');
        }

        $tables = $this->config->item('tables','ion_auth');
        $identity_column = $this->config->item('identity','ion_auth');
        $this->data['identity_column'] = $identity_column;

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        if($identity_column!=='email')
        {
            $this->form_validation->set_rules('identity',$this->lang->line('create_user_validation_identity_label'),'required|is_unique['.$tables['users'].'.'.$identity_column.']');
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
        }
        else
        {
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
        $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() == true)
        {
            $email    = strtolower($this->input->post('email'));
            $identity = ($identity_column==='email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name'		=> $this->input->post('first_name'),
                'last_name' 		=> $this->input->post('last_name'),
                'company'  		  	=> $this->input->post('company'),
                'phone'    		 	=> $this->input->post('phone'),
                'username'  		=> $this->input->post('username'),
                'gender'     		=> $this->input->post('gender'),
				'member_unique_id' 	=> time() . getmypid(),
				'image'				=> 'no_image.png',
				'address'			=> $this->input->post('address'),
				'type_id'		=> $this->input->post('member_type'),
				'class_id'				=> $this->input->post('class'),

            );

            if (isset($_FILES['user_image'])) {

                if ($_FILES['user_image']['size'] > 0) {
                    $config['upload_path'] = $this->upload_path;
                    $config['allowed_types'] = $this->image_types;
                    $config['max_size'] = $this->allowed_file_size;
                    $config['overwrite'] = FALSE;
                    $config['max_filename'] = 25;
                    $config['encrypt_name'] = TRUE;
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('user_image')) {

                        $error = $this->upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        redirect("panel/auth/add");
                    }else{
                        $photo = $this->upload->file_name;
                        $additional_data['image'] = $photo;
                        $config = NULL;

                    }
                    
                }
            }
        }

        if ($this->form_validation->run() == true && $this->ion_auth->register($identity, $password, $email, $additional_data))
        {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("panel/auth", 'refresh');
        }
        else
        {
            // display the create user form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['first_name'] = array(
                'name'  => 'first_name',
                'id'    => 'first_name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('first_name'),
            );
            $this->data['last_name'] = array(
                'name'  => 'last_name',
                'id'    => 'last_name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('last_name'),
            );
            $this->data['identity'] = array(
                'name'  => 'identity',
                'id'    => 'identity',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('identity'),
            );
            $this->data['email'] = array(
                'name'  => 'email',
                'id'    => 'email',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('email'),
            );
            $this->data['username'] = array(
                'name'  => 'username',
                'id'    => 'username',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('username'),
            );
            $this->data['company'] = array(
                'name'  => 'company',
                'id'    => 'company',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('company'),
            );
            $this->data['phone'] = array(
                'name'  => 'phone',
                'id'    => 'phone',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('phone'),
            );
            $this->data['password'] = array(
                'name'  => 'password',
                'id'    => 'password',
                'type'  => 'password',
                'value' => $this->form_validation->set_value('password'),
            );
            $this->data['password_confirm'] = array(
                'name'  => 'password_confirm',
                'id'    => 'password_confirm',
                'type'  => 'password',
                'value' => $this->form_validation->set_value('password_confirm'),
            );
            $this->data['address'] = array(
                'name'  => 'address',
                'id'    => 'address',
                'type'  => 'textarea',
                'value' => $this->form_validation->set_value('address'),
            );
            $this->data['gender'] = array(
                'name'  => 'gender',
                'id'    => 'gender',
                'type'  => 'textarea',
                'value' => $this->form_validation->set_value('gender'),
            );

    		$this->data['member_types'] = $this->members_model->getAllMemType();


            $this->_render_page('auth/create_user', $this->data);

        }
    }

	// edit a user
	function edit_user($id)
	{

		if (DEMO) {
			$this->session->set_flashdata('error', "Disabled in Demo");
            redirect("panel");
		}
		$this->data['title'] = "Edit User";

		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
		{
			redirect('panel/auth', 'refresh');
		}

		$user = $this->ion_auth->user($id)->row();
		$groups=$this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();

		// validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
		$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
		$this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required');
		$this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required');

		if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?
			// if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			// {
			// 	show_error($this->lang->line('error_csrf'));
			// }

			// update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name'  => $this->input->post('last_name'),
					'company'    => $this->input->post('company'),
					'phone'      => $this->input->post('phone'),
					'gender'     		=> $this->input->post('gender'),
					'member_unique_id' 	=> time() . getmypid(),
					'address'			=> $this->input->post('address'),
					'type_id'		=> $this->input->post('member_type'),
					'class_id'				=> $this->input->post('class'),
				);
				if (isset($_FILES['user_image'])) {

	                if ($_FILES['user_image']['size'] > 0) {
	                    $config['upload_path'] = $this->upload_path;
	                    $config['allowed_types'] = $this->image_types;
	                    $config['max_size'] = $this->allowed_file_size;
	                    $config['overwrite'] = FALSE;
	                    $config['max_filename'] = 25;
	                    $config['encrypt_name'] = TRUE;
	                    $this->upload->initialize($config);
	                    if (!$this->upload->do_upload('user_image')) {

	                        $error = $this->upload->display_errors();
	                        $this->session->set_flashdata('error', $error);
	                        redirect("panel/auth/add");
	                    }else{
	                        $photo = $this->upload->file_name;
	                        $data['image'] = $photo;
	                        $config = NULL;

	                    }
	                    
	                }
	            }

				// update the password if it was posted
				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}



				// Only allow updating groups if user is admin
				if ($this->ion_auth->is_admin())
				{
					//Update the groups user belongs to
					$groupData = $this->input->post('groups');

					if (isset($groupData) && !empty($groupData)) {

						$this->ion_auth->remove_from_group('', $id);

						foreach ($groupData as $grp) {
							$this->ion_auth->add_to_group($grp, $id);
						}

					}
				}

			// check to see if we are updating the user
			   if($this->ion_auth->update($user->id, $data))
			    {
			    	// redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('message', $this->ion_auth->messages() );
				    if ($this->ion_auth->is_admin())
					{
						redirect('panel/auth', 'refresh');
					}
					else
					{
						redirect('panel//', 'refresh');
					}

			    }
			    else
			    {
			    	// redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('message', $this->ion_auth->errors() );
				    if ($this->ion_auth->is_admin())
					{
						redirect('panel/auth', 'refresh');
					}
					else
					{
						redirect('panel/', 'refresh');
					}

			    }

			}
		}

		// display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['user'] = $user;
		$this->data['groups'] = $groups;
		$this->data['currentGroups'] = $currentGroups;

		$this->data['first_name'] = array(
			'name'  => 'first_name',
			'id'    => 'first_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('first_name', $user->first_name),
		);
		$this->data['last_name'] = array(
			'name'  => 'last_name',
			'id'    => 'last_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('last_name', $user->last_name),
		);
		$this->data['company'] = array(
			'name'  => 'company',
			'id'    => 'company',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('company', $user->company),
		);
		$this->data['phone'] = array(
			'name'  => 'phone',
			'id'    => 'phone',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('phone', $user->phone),
		);
		$this->data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'type' => 'password'
		);
		$this->data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'type' => 'password'
		);
		$this->data['address'] = array(
            'name'  => 'address',
            'id'    => 'address',
            'type'  => 'textarea',
            'value' => $this->form_validation->set_value('address', $user->address),
        );
        $this->data['gender'] = array(
                'name'  => 'gender',
                'id'    => 'gender',
                'type'  => 'textarea',
                'value' => $this->form_validation->set_value('gender', $user->gender),
            );
        $this->data['image'] = $user->image;
    	$this->data['member_types'] = $this->members_model->getAllMemType();
        $this->data['memtype'] = $this->form_validation->set_value('member_type', $user->type_id);
        $class_id = $this->db->get_where('class', array('class_id' => $user->class_id))->result();
        $this->data['class_id'] = $this->form_validation->set_value('class', $class_id);
		$this->_render_page('auth/edit_user', $this->data);
	}

	// // create a new group
	// function groups()
	// {
	// 	$this->data['title'] = $this->lang->line('create_group_title');

	// 	if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
	// 	{
	// 		redirect('panel/auth', 'refresh');
	// 	}

	// 	// validate form input
	// 	$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash');

	// 	if ($this->form_validation->run() == TRUE)
	// 	{
	// 		$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
	// 		if($new_group_id)
	// 		{
	// 			// check to see if we are creating the group
	// 			// redirect them back to the admin page
	// 			$this->session->set_flashdata('message', $this->ion_auth->messages());
	// 			redirect("panel/auth", 'refresh');
	// 		}
	// 	}
	// 	else
	// 	{
	// 		// display the create group form
	// 		// set the flash data error message if there is one
	// 		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

	// 		$this->data['group_name'] = array(
	// 			'name'  => 'group_name',
	// 			'id'    => 'group_name',
	// 			'type'  => 'text',
	// 			'value' => $this->form_validation->set_value('group_name'),
	// 		);
	// 		$this->data['description'] = array(
	// 			'name'  => 'description',
	// 			'id'    => 'description',
	// 			'type'  => 'text',
	// 			'value' => $this->form_validation->set_value('description'),
	// 		);
	// 		$this->data['groups'] = $this->ion_auth->groups()->result();
	// 		$this->_render_page('auth/create_group', $this->data);
	// 	}
	// }

	// edit a group
	function edit_group($id)
	{
		// bail if no group id given
		if(!$id || empty($id))
		{
			redirect('panel/auth/groups', 'refresh');
		}

		$this->data['title'] = $this->lang->line('edit_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('panel/auth', 'refresh');
		}

		$group = $this->ion_auth->group($id)->row();

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');

		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{
				$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

				if($group_update)
				{
					$this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
				redirect("panel/auth/groups", 'refresh');
			}
		}

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['group'] = $group;

		$readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

		$this->data['group_name'] = array(
			'name'    => 'group_name',
			'id'      => 'group_name',
			'type'    => 'text',
			'value'   => $this->form_validation->set_value('group_name', $group->name),
			$readonly => $readonly,
		);
		$this->data['group_description'] = array(
			'name'  => 'group_description',
			'id'    => 'group_description',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_description', $group->description),
		);
		$this->_render_page('auth/edit_group', $this->data);
	}


	public function delete_user($id)
	{
		$this->ion_auth->delete_user($id);
		redirect('panel/auth');
	}
	


	function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
			$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function _render_page($view, $data=null, $returnhtml=false)//I think this makes more sense
	{

		$this->viewdata = (empty($data)) ? $this->data: $data;

		$view_html = $this->render($view, $this->viewdata, $returnhtml);

		if ($returnhtml) return $view_html;//This will return html on 3rd argument being true
	}
	/* --------------------------------------------------------------------------------------------- */
     public function suggestions()
    {
        $term = $this->input->get('term', true);

        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . site_url('panel/borrow') . "'; }, 10);</script>");
        }
        $this->load->library('lms');
        $this->load->model('members_model');
        if ($this->mSettings->issue_conf == 1) {
        	$rows = $this->members_model->getMember($term);
        }else{
        	$rows = $this->members_model->getMember2($term);
        }
        if ($rows) {
            foreach ($rows as $row) {
                $pr[] = array('id' => str_replace(".", "", microtime(true)), 'item_id' => $row->id, 'label' => $row->pname . " (" . $row->member_unique_id . ")", 'row' => $row);
                
            }
            $this->lms->send_json($pr);
        } else {
            $this->lms->send_json(array(array('id' => 0, 'label' => lang('no_match_found'), 'value' => $term)));
        }
    }

     /* ----------------------------------------------------------------------------- */
    /* --------------------------------- Member Types ------------------------------- */
    /* ----------------------------------------------------------------------------- */

    public function member_types(){
    	
        $this->data['member_types'] = $this->members_model->getAllMemType();
        $this->render('auth/member_types');
    }
      public function add_memtype(){

        $this->form_validation->set_rules('member_type', lang('memtype_name_label'), 'required');
        if ($this->mSettings->issue_conf == 2) {
	        $this->form_validation->set_rules('issue_limit_books', lang('settings_fine_limit_book'), 'required');
	        $this->form_validation->set_rules('issue_limit_days', lang('settings_fine_limit_days'), 'required');
        }
        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error',validation_errors());
            redirect('panel/auth/member_types');
        }
        else
        {
        	$data = array();
        	$data['borrowertype'] = $this->input->post('member_type');
       		if ($this->mSettings->issue_conf == 2) {
	        	$data['issue_limit_books'] = $this->input->post('issue_limit_books');
	        	$data['issue_limit_day'] = $this->input->post('issue_limit_days');
        	}
    	  	
            if ($this->members_model->addMemType($data)) {
                $this->session->set_flashdata('message',lang('add_memtype_success'));
                redirect('panel/auth/member_types');
            }else{
                $this->session->set_flashdata('error',lang('add_memtype_error'));
                redirect('panel/auth/member_types');
            }

        }
    }

    public function editMemTypeModal($id = NULL){
        if (!empty($id)) {
                $data['return_data'] = $this->members_model->getMemTypeByID($id);
                $data['issue_conf']  = $this->mSettings->issue_conf;
                $this->load->view('auth/memtype_modal', $data);
        }else{
            redirect('panel/auth/member_types');
        }
    }
    public function editMemType(){

        $this->form_validation->set_rules('borrowertype', lang('memtype_name_label'), 'required');
        $this->form_validation->set_rules('type_id', lang('memtype_name_label'), 'required');
		if ($this->mSettings->issue_conf == 2) {
	        $this->form_validation->set_rules('issue_limit_books', lang('settings_fine_limit_book'), 'required');
	        $this->form_validation->set_rules('issue_limit_days', lang('settings_fine_limit_days'), 'required');
        }

        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error',lang('error_sarcast'));
            redirect('panel/auth/member_types');
        }
        else
        {
            $data = array();
            $data['borrowertype'] = $this->input->post('borrowertype');
            if ($this->mSettings->issue_conf == 2) {
	        	$data['issue_limit_books'] = $this->input->post('issue_limit_books');
	        	$data['issue_limit_day'] = $this->input->post('issue_limit_days');
        	}
        	
            if ($this->members_model->updateMemType($this->input->post('type_id'), $data)) {
                $this->session->set_flashdata('message',lang('edit_memtype_success'));
                redirect('panel/auth/member_types');
            }else{
                $this->session->set_flashdata('error',lang('edit_memtype_error'));
                redirect('panel/auth/member_types');
            }
        }


        
    }

     /* ----------------------------------------------------------------------------- */
    /* --------------------------------- Occupations ------------------------------- */
    /* ----------------------------------------------------------------------------- */

    public function occupations(){
        $this->data['member_types'] = $this->members_model->getAllMemType();
        $this->data['occupations'] = $this->members_model->getAllOccu();
        $this->render('auth/occupations');
    }

	public function add_occu(){

        $this->form_validation->set_rules('occupation', lang('add_occu_title'), 'required');
        $this->form_validation->set_rules('member_type', lang('memtype_name_label'), 'required');


        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error',lang('error_sarcast'));
            redirect('panel/auth/occupations');
        }
        else
        {
            if ($this->members_model->addOccu($this->input->post('occupation'), $this->input->post('member_type'))) {
                $this->session->set_flashdata('message',lang('add_occu_success'));
                redirect('panel/auth/occupations');
            }else{
                $this->session->set_flashdata('error',lang('add_occu_error'));
                redirect('panel/auth/occupations');
            }
        }
    }
    
    public function view_card($id = null)
    {

        $data['member'] = $this->members_model->getMemberbyID($id);
        $data['profile'] = $this->settings_model->getSettings();
        $this->load->view('members/card', $data);
 
        //load mPDF library
    }

    public function editOccuModal($id = NULL){

        if (!empty($id)) {
        		$data['member_types'] = $this->members_model->getAllMemType();
                $data['return_data'] = $this->members_model->getOccuByID($id);
                $this->load->view('auth/occu_model', $data);
        }else{
            redirect('panel/auth/occupations');
        }
    }
    public function editOccu($id = NULL){

    	$this->form_validation->set_rules('occupation', lang('occu_name_label'), 'required');
        $this->form_validation->set_rules('member_type', lang('memtype_name_label'), 'required');
        $this->form_validation->set_rules('class_id', lang('memtype_name_label'), 'required');


        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error',lang('error_sarcast'));
            redirect('panel/auth/occupations');
        }
        else
        {
        	$data = array();
        	$data['type_id'] = $this->input->post('member_type');
        	$data['name'] = $this->input->post('occupation');

            if ($this->members_model->updateOccu($this->input->post('class_id'), $data)) {
                $this->session->set_flashdata('message',lang('edit_occu_success'));
                redirect('panel/auth/occupations');
            }else{
                $this->session->set_flashdata('error',lang('edit_occu_error'));
                redirect('panel/auth/occupations');
            }
        }

    }

  /* --------------------------------------------------------------------------------------------- */
     public function json_occu($term = NULL)
    {
        $term = $this->input->post('id', true);

        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . site_url('welcome') . "'; }, 10);</script>");
        }
        $this->load->library('lms');
        $this->load->model('members_model');
        
        $rows = $this->members_model->getOccuByMTID($term);
        if ($rows) {
        foreach ($rows as $row) {
            $pr[] = array('id' => $row->class_id, 'text' => $row->name);
            
        }
            $this->lms->send_json($pr);
        }else {
            $this->lms->send_json((array('id' => 0, 'text' => lang('no_match_found'))));
        }
    }


 /* --------------------------------------------------------------------------------------------- */
    


}
