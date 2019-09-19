<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Settings extends Admin_Controller {

    private $mLatestSqlFile;
    private $mBackupSqlFiles;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('settings_model');
        $this->upload_path = 'assets/uploads/logos';
        $this->upload_path_favicon = 'assets/uploads/logos/favicons';
        $this->image_types = 'jpg|jpeg|png';
        $this->allowed_file_size = 1024;

        $sql_path = FCPATH.'sql';
        $files = preg_grep("/.(.sql)$/", scandir($sql_path.'/backup', SCANDIR_SORT_DESCENDING));
        $this->mBackupSqlFiles = $files;
        $this->mLatestSqlFile = $sql_path.'/latest.sql';

        $this->mPageTitle = 'Utilities';
        $this->data['backup_sql_files'] = $this->mBackupSqlFiles;
        $this->data['latest_sql_file'] = $this->mLatestSqlFile;
    }

    public function index()
    {
        
        $this->form_validation->set_rules('name', 'Title', 'required');
        
        $this->load->library('upload');
        if ($this->form_validation->run() == true) {
            echo $books_custom_fields = implode(',', $_POST['books_custom_fields']);
            $data = array(
                'title'                                 => $this->input->post('name'),
                'fine'                                  => $this->input->post('fine'),
                'currency'                              => $this->input->post('currency'),
                'email'                                 => $this->input->post('email'),
                'address'                               => $this->input->post('address'),
                'phone'                                 => $this->input->post('phone'),
                'terms_conditions'                      => $this->input->post('condition'),
                'smtp_user'                             => $this->input->post('smtp_user'),
                'smtp_host'                             => $this->input->post('smtp_host'),
                'smtp_port'                             => $this->input->post('smtp_port'),
                'issue_conf'                            => $this->input->post('issue_conf'),
                'issue_limit_books'                     => $this->input->post('issue_limit_books'),
                'notify_delayed_no_days_limit_toggle'   => $this->input->post('notify_delayed_no_days_limit_toggle'),
                'issue_limit_days_extendable'           => $this->input->post('issue_limit_days_extendable'),
                'issue_limit_days'                      => $this->input->post('issue_limit_days'),
                'books_custom_fields'                   => $books_custom_fields,
                'email_request'                         => $this->input->post('email_request'),
                'sms_request'                           => $this->input->post('sms_request'),
            );

            if ($this->input->post('smtp_pass') != '') {
                $data['smtp_pass'] = $this->input->post('smtp_pass');
            }

            if (isset($_FILES['logo'])) {

                if ($_FILES['logo']['size'] > 0) {
                    $config['upload_path'] = $this->upload_path;
                    $config['allowed_types'] = $this->image_types;
                    $config['max_size'] = $this->allowed_file_size;
                    $config['overwrite'] = FALSE;
                    $config['max_filename'] = 25;
                    $config['encrypt_name'] = TRUE;
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('logo')) {

                        $error = $this->upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        redirect("panel/settings");
                    }else{
                        $photo = $this->upload->file_name;
                        $data['logo'] = $photo;
                        $config = NULL;

                    }
                    
                }
            }
            if (isset($_FILES['favicon'])) {

                if ($_FILES['favicon']['size'] > 0) {
                    $config['upload_path'] = $this->upload_path_favicon;
                    $config['allowed_types'] = 'ico';
                    $config['max_size'] = $this->allowed_file_size;
                    $config['overwrite'] = FALSE;
                    $config['max_filename'] = 25;
                    $config['encrypt_name'] = TRUE;
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('favicon')) {
                        $error = $this->upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        redirect("panel/settings");
                    }else{
                        $photo = $this->upload->file_name;
                        $data['favicon'] = $photo;
                        $config = NULL;

                    }
                    
                }
            }

        }

        if (($this->form_validation->run() == TRUE) && $this->settings_model->updateSettings($data)) {
            $this->session->set_flashdata('message','Settings Updated Successfully');
            redirect('panel/settings');
        } else {
            $this->render('settings');
        }
        
    }
    
    
    function sms()
    {
        $this->form_validation->set_rules('auth_id', 'Title', 'required');

        if ($this->form_validation->run() == true) {
            $data = array(
                'sms_gateway' => $this->input->post('sms_gateway'),
                'auth_id' => $this->input->post('auth_id'),
                'auth_token' => $this->input->post('auth_token'),
                'phone_number' => $this->input->post('phone_number'),
                'api_id' => $this->input->post('api_id'),
                
            );

        }

        if (($this->form_validation->run() == TRUE) && $this->settings_model->updateSmsSettings($data)) {
            $this->session->set_flashdata('message','Settings Updated Successfully');
            redirect('panel/settings/sms');
        } else {
            $this->data['sms_config'] = $this->settings_model->getSmsSettings();
            $this->render('sms_settings');
        }
           
        
    }

    // List out saved versions of database
    public function list_db()

    {
        if (DEMO) {
            $this->session->set_flashdata('error', "Disabled in Demo");
            redirect("panel");
        }
        $this->render('util/list_db');
    }

    // Backup current database version
    public function backup_db()
    {
        if (DEMO) {
            $this->session->set_flashdata('error', "Disabled in Demo");
            redirect("panel");
        }
        $this->load->dbutil();
        $this->load->helper('file');

        // Options: http://www.codeigniter.com/user_guide/database/utilities.html?highlight=csv#setting-backup-preferences
        $prefs = array('format' => 'txt');
        $backup = $this->dbutil->backup($prefs);
        $file_path_1 = FCPATH.'sql/backup/'.date('Y-m-d_H-i-s').'.sql';
        $result_1 = write_file($file_path_1, $backup);
        
        // overwrite latest.sql
        $save_latest = $this->input->get('save_latest');
        if ( !empty($save_latest) )
        {
            $file_path_2 = FCPATH.'sql/latest.sql';
            $result_2 = write_file($file_path_2, $backup);  
        }

        redirect('panel/settings/list_db');
    }

    // Restore specific version of database
    public function restore_db($file)
    {
        if (DEMO) {
            $this->session->set_flashdata('error', "Disabled in Demo");
            redirect("panel");
        }
        $path = '';
        if ($file=='latest')
            $path = FCPATH.'sql/latest.sql';
        else if ( in_array($file, $this->mBackupSqlFiles) )
            $path = FCPATH.'sql/backup/'.$file;

        // proceed to execute SQL queries
        if ( !empty($path) && file_exists($path) )
        {
            //$sql = file_get_contents($path);
            //$this->db->query($sql);
            $username = $this->db->username;
            $password = $this->db->password;
            $database = $this->db->database;
            exec("mysql -u $username -p$password --default-character-set=utf8 --database $database < $path");
        }

        redirect('panel/settings/list_db');
    }

    // Remove specific database version
    public function remove_db($file)
    {   
        if (DEMO) {
            $this->session->set_flashdata('error', "Disabled in Demo");
            redirect("panel");
        }
        if ( in_array($file, $this->mBackupSqlFiles) )
        {
            $path = FCPATH.'sql/backup/'.$file;

            $this->load->helper('file');
            unlink($path);
            $result = delete_files($path);
        }

        redirect('panel/settings/list_db');
    }

}