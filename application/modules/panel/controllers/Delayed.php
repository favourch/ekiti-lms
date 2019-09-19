<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delayed extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('borrow_model');
        $this->lang->load('circulation_lang', $this->mLanguage);
       
    }
    public function due_books_json(){
        $this->load->library('datatables');
        
        $check = '$1';
        $due_Date = date("Y-m-d");
        if (!$this->mSettings->notify_delayed_no_days_limit_toggle) {
            if ($this->mSettings->issue_conf == 1) {
                if (!($this->mSettings->issue_limit_days == 0 || $this->mSettings->issue_limit_days == -1)) {
                    $this->datatables
                        ->select('borrow_details_id as id, book_title as title, CONCAT(first_name, " ", last_name) as name, date_borrow as date_borrow, due_date as due_date')
                        ->from('borrow');
                    $this->datatables->join('users', 'borrow.member_id = users.id', 'left');
                    $this->datatables->join('borrowdetails', 'borrow.borrow_id = borrowdetails.borrow_id', 'left');
                    $this->datatables->join('books', ' borrowdetails.book_id =  books.id ', 'left');
                    $this->datatables->join('member_types', ' member_types.type_id =  users.type_id ', 'left');
                    $this->datatables->where('due_date <', $due_Date);
                    $this->datatables->where('borrow_status', 'pending');
                    $this->datatables->where('borrow_status', 'pending');
                    $this->datatables->add_column('checkbox', $check, 'id');
                    $this->datatables->unset_column('id');
                    echo $this->datatables->generate('json', 'ISO-8859-1');
                }else{
                    die('{"draw":0,"recordsTotal":0,"recordsFiltered":0,"data":[]}');
                }
            }
            if ($this->mSettings->issue_conf == 2) {
                $this->datatables
                    ->select('borrow_details_id as id, book_title as title, CONCAT(first_name, " ", last_name) as name, date_borrow as date_borrow, due_date as due_date')
                    ->from('borrow');
                    $this->datatables->join('users', 'borrow.member_id = users.id', 'left');
                    $this->datatables->join('borrowdetails', 'borrow.borrow_id = borrowdetails.borrow_id', 'left');
                    $this->datatables->join('books', ' borrowdetails.book_id =  books.id ', 'left');
                    $this->datatables->join('member_types', 'member_types.type_id = users.type_id ', 'left');
                    $this->datatables->where('due_date <', $due_Date);
                    $this->datatables->where('borrow_status', 'pending');
                    $this->datatables->where('member_types.issue_limit_day != -1');
                    $this->datatables->where('member_types.issue_limit_day != 0');
                    $this->datatables->add_column('checkbox', $check, 'id');
                    $this->datatables->unset_column('id');
                    echo $this->datatables->generate('json', 'ISO-8859-1');
            }
        }else{
            $this->datatables
                ->select('borrow_details_id as id, book_title as title, CONCAT(first_name, " ", last_name) as name, date_borrow as date_borrow, due_date as due_date')
                ->from('borrow');
                
            $this->datatables->join('users', 'borrow.member_id = users.id', 'left');
            $this->datatables->join('borrowdetails', 'borrow.borrow_id = borrowdetails.borrow_id', 'left');
            $this->datatables->join('books', ' borrowdetails.book_id =  books.id ', 'left');
            $this->datatables->join('member_types', ' member_types.type_id =  users.type_id ', 'left');
            $this->datatables->where('due_date <', $due_Date);
            $this->datatables->where('borrow_status', 'pending');
           
            $this->datatables->add_column('checkbox', $check, 'id');
            // $this->datatables->add_column('actions', $actions, 'id');
            $this->datatables->unset_column('id');

            echo $this->datatables->generate('json', 'ISO-8859-1');
        }

        // echo $this->datatables->generate();
    }
    function index()
    {
        $this->data['due_book'] = file_get_contents('./application/views/email_templates/due.html');
        $this->data['due_book_sms'] = file_get_contents('./application/views/email_templates/due_sms.html');
        $this->render('due_books');

    }
    function email_templates($template = "due")
    {

        $this->form_validation->set_rules('mail_body', lang('mail_message'), 'trim|required');
        $this->load->helper('file');
        $temp_path = is_dir(base_url() . 'application/views/email_templates/');

        if ($this->form_validation->run() == true) {
            $data = $_POST["mail_body"];
            if (write_file('./application/views/email_templates/' . $template . '.html', $data)) {
                $this->session->set_flashdata('message', lang('save_template_success'));
                redirect('panel/delayed/email_templates#' . $template);
            } else {
                $this->session->set_flashdata('error', lang('save_template_error'));
                redirect('panel/delayed/email_templates#' . $template);
            }
        } else {
            $this->data['due_book'] = file_get_contents('./application/views/email_templates/due.html');
            $this->data['due_book_sms'] = file_get_contents('./application/views/email_templates/due_sms.html');
            $this->render('email_templates');
        }
    }
     function notify_delayed($type = 'sms')
    {
        if (($this->input->post('val')) == '') {
            redirect('panel/delayed');    
        }
        if (($this->input->post('type')) == 'sms') {
            $type = 'sms';
        }else{
            $type = 'email';
        }
        $due_ids = $this->input->post('val');
        $parse_data = array(
            'site_name' => $this->mSettings->title,
        );
        $subject = $this->input->post('subject');
        if ($type === 'email') {
            $dues = $this->borrow_model->send_emails($due_ids, 'email');

            foreach ($dues as $key => $dues) {
                $sent = FALSE;
                $message = ($this->input->post('message') != '') ? $this->input->post('message') : file_get_contents('application/views/email_templates/due.html');
                $books = '';
                foreach ($dues as $due) {
                    $books .= '<span style="font-size: 20px">Book Title: '.$due->title.'</span><br>Date Borrow: '.$due->date_borrow . '<br><span style="color: red">Due Date: '.$due->due_date.'</span><br><br>';
                    $message = str_replace("{contact_person}", $due->name ,$message);
                }
                $message = str_replace("{books}", $books ,$message);
                $message = str_replace("{logo}", $parse_data['site_name'] ,$message);
                $message = str_replace("{site_name}", $parse_data['site_name'] ,$message);

                $to = $key;

                if ($this->send_email($to, $subject, $message, null, null)) {
                    $sent = TRUE;
                }
               
            }
        }
        else{
            $dues = $this->borrow_model->send_emails($due_ids, 'sms');
            $sms_config = $this->settings_model->getSmsSettings();
            $sid = $sms_config->auth_id;
            $token = $sms_config->auth_token;
            $api_id = $sms_config->api_id;

            if ($sms_config->sms_gateway == 'twilio') {
                require APPPATH."third_party/Twilio/autoload.php";

                // Your Account SID and Auth Token from twilio.com/console
                
                $client = new Twilio\Rest\Client($sid, $token);
                foreach ($dues as $key => $dues) {
                    $sent = FALSE;
                    $message = ($this->input->post('message') != '') ? $this->input->post('message') : file_get_contents('application/views/email_templates/due_sms.html');
                    $books = array();
                    foreach ($dues as $due) {
                        $books[] = $due->title;
                        $message = str_replace("{contact_person}", $due->name ,$message);
                    }
                    $books = implode(", ",$books);

                    $message = str_replace("{books_inline}", $books ,$message);
                    $message = str_replace("{site_name}", $parse_data['site_name'] ,$message);

                    try {
                        // Use the client to do fun stuff like send text messages!
                        $message = $client->messages->create(
                            // the number you'd like to send the message to
                            $key,
                            array(
                                // A Twilio phone number you purchased at twilio.com/console
                                'from' => $sms_config->phone_number,
                                // the body of the text message you'd like to send
                                'body' => $message,
                            )
                        );
                    } catch (Exception $e) {
                        $this->session->set_flashdata('error', $this->lang->line("email_sent_error"));
                        redirect('panel/delayed');   
                    }
                    if($message->sid){
                        $sent = TRUE;
                    }

                }
            }elseif ($sms_config->sms_gateway == 'clickatell') {
                $config['clickatell_username']  = $sid;
                $config['clickatell_password']  = $token;
                $config['clickatell_api_id']    = $api_id;
                $config['clickatell_from_no']   = 'CodeIgniter';

                $this->load->library('clickatell', $config);
                foreach ($dues as $key => $dues) {
                    $sent = FALSE;
                    $message = ($this->input->post('message') != '') ? $this->input->post('message') : file_get_contents('application/views/email_templates/due_sms.html');

                    $books = array();
                    foreach ($dues as $due) {
                        $books[] = $due->title;
                        $message = str_replace("{contact_person}", $due->name ,$message);
                    }
                    $books = implode(", ",$books);

                    $message = str_replace("{books_inline}", $books ,$message);
                    $message = str_replace("{site_name}", $parse_data['site_name'] ,$message);

                    if ($this->clickatell->send_message($key, $message)) {
                        $sent = TRUE;
                    }else{
                        $sent = FALSE;
                    }

                }
                
            }elseif ($sms_config->sms_gateway == 'nexmo') {
                // load library
                $this->load->library('nexmo', array('api_key' => $sid, 'api_secret' => $token));
                
                foreach ($dues as $key => $dues) {
                    $sent = FALSE;
                    $message = ($this->input->post('message') != '') ? $this->input->post('message') : file_get_contents('application/views/email_templates/due_sms.html');
                    
                    $books = array();
                    foreach ($dues as $due) {
                        $books[] = $due->title;
                        $message = str_replace("{contact_person}", $due->name ,$message);
                    }
                    $books = implode(", ",$books);

                    $message = str_replace("{books_inline}", $books ,$message);
                    $message = str_replace("{site_name}", $parse_data['site_name'] ,$message);
                    // set response format: xml or json, default json
                    $this->nexmo->set_format('json');
                    // **********************************Text Message*************************************
                    $from = $sms_config->phone_number;
                    $to = $key;
                    $messaged = array(
                        'text' => $message,
                    );
                    $response = $this->nexmo->send_message($from, $to, $messaged);

                    foreach ($response['messages'] as $i => $m) {
                        print_r($m);
                        switch ($m['status']) {
                        case '0':
                            $sent = TRUE;
                            break;
                        default:
                            $sent = FALSE;
                            break;
                        }
                    }
                }

            } else {
                $sent = FALSE;
            }
        }

        if ($sent == TRUE) {
            $this->session->set_flashdata('message', ($this->lang->line("email_sent") ? $this->lang->line("email_sent") : lang('sms_sent_success')) );
            redirect('panel/delayed');    
        }elseif ($sent !== TRUE or $sent !== FALSE) {
            $this->session->set_flashdata('error', $this->lang->line("email_sent_error"));
            redirect('panel/delayed');   
        }else{
            $this->session->set_flashdata('error', $this->lang->line("email_sent_error"));
            redirect('panel/delayed');   
        }
       

    }
    
}

?>
