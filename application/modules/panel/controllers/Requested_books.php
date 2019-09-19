<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Requested_books extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('request_model');
        $this->lang->load('circulation', $this->mLanguage);
    }

    public function index()
    {
      $this->mPageTitle = lang('menu_requested_books');
      $this->render('requested_books/index');
    }
    
    function getRequestedBooks() {
       $this->load->library('datatables');
       $this->datatables
            ->select("requested_books.id as rbid,CONCAT(users.first_name, ' ', users.last_name) as name ,book_title, author_name, year, remarks, date, status")
            ->join('users', 'users.id=requested_books.user_id', 'left')
            ->from('requested_books');
        $this->datatables->add_column('actions', '$1____$2' ,'rbid, status');
        echo $this->datatables->generate();
    }

    function email_templates($template = NULL)
    {
        $this->mPageTitle = lang('menu_send_templates');

        $this->form_validation->set_rules('mail_body', lang('mail_message'), 'trim|required');
        $this->load->helper('file');
        $temp_path = is_dir(base_url() . 'application/views/email_templates/');

        if ($this->form_validation->run() == true) {
            if (!$template) {
                show_404();
            }
            $data = $_POST["mail_body"];
            if (write_file('./application/views/email_templates/' . $template . '.html', $data)) {
                $this->session->set_flashdata('message', lang('save_template_success'));
                redirect('panel/requested_books/email_templates#' . $template);
            } else {
                $this->session->set_flashdata('error', lang('save_template_error'));
                redirect('panel/requested_books/email_templates#' . $template);
            }
        } else {
            $this->data['request'] = file_get_contents('./application/views/email_templates/request.html');
            $this->data['request_sms'] = file_get_contents('./application/views/email_templates/request_sms.html');
            $this->render('email_templates_request');
        }
    }
    public function email_send($id, $status){
        $parse_data = array(
            'site_name' => $this->mSettings->title,
        );
        $row = $this->request_model->getEmailByRequestID($id);
        $message = file_get_contents('application/views/email_templates/request.html');
        $message = str_replace("{book_name}", $row->book_title ,$message);
        $message = str_replace("{contact_person}", $row->name ,$message);
        $message = str_replace("{status}", lang($status."_request_sent") ,$message);
        $message = str_replace("{logo}", $parse_data['site_name'] ,$message);
        $message = str_replace("{site_name}", $parse_data['site_name'] ,$message);
    
        $to = $row->email;
        $subject = lang('req_book_status_title');
        if ($this->send_email($to, $subject, $message, null, null)) {
            return TRUE;
        }else{
            return FALSE;
        }

    }
    public function sms_send($id, $status){
        $parse_data = array(
            'site_name' => $this->mSettings->title,
        );
        $row = $this->request_model->getEmailByRequestID($id);
        $message = file_get_contents('application/views/email_templates/request_sms.html');
        $message = str_replace("{book_name}", $row->book_title ,$message);
        $message = str_replace("{contact_person}", $row->name ,$message);
        $message = str_replace("{status}", lang($status."_request_sent") ,$message);
        $message = str_replace("{logo}", $parse_data['site_name'] ,$message);
        $message = str_replace("{site_name}", $parse_data['site_name'] ,$message);

        $sms_config = $this->settings_model->getSmsSettings();
        $sid = $sms_config->auth_id;
        $token = $sms_config->auth_token;
        $api_id = $sms_config->api_id;

        if ($sms_config->sms_gateway == 'twilio') {
            require APPPATH."third_party/Twilio/autoload.php";
            // Your Account SID and Auth Token from twilio.com/console
            $client = new Twilio\Rest\Client($sid, $token);
            try {
                // Use the client to do fun stuff like send text messages!
                $message = $client->messages->create(
                    // the number you'd like to send the message to
                    '+'.$row->phone,
                    array(
                        // A Twilio phone number you purchased at twilio.com/console
                        'from' => $sms_config->phone_number,
                        // the body of the text message you'd like to send
                        'body' => $message,
                    )
                );
            } catch (Exception $e) {
                return FALSE; 
            }
            if($message->sid){
                return TRUE;
            }

        }elseif ($sms_config->sms_gateway == 'clickatell') {
            $config['clickatell_username']  = $sid;
            $config['clickatell_password']  = $token;
            $config['clickatell_api_id']    = $api_id;
            $config['clickatell_from_no']   = 'CodeIgniter';
            $this->load->library('clickatell', $config);
            $sent = FALSE;
            if ($this->clickatell->send_message($row->phone, $message)) {
                return TRUE;
            }else{
                return FALSE;
            }
        }elseif ($sms_config->sms_gateway == 'nexmo') {
            // load library
            $this->load->library('nexmo', array('api_key' => $sid, 'api_secret' => $token));
            $this->nexmo->set_format('json');
            // **********************************Text Message*************************************
            $from = $sms_config->phone_number;
            $to = $row->phone;
            $messaged = array(
                'text' => $message,
            );
            $response = $this->nexmo->send_message($from, $to, $messaged);
            foreach ($response['messages'] as $i => $m) {
                switch ($m['status']) {
                case '0':
                    return TRUE;
                    break;
                default:
                    return FALSE;
                    break;
                }
            }
        }else{
            $this->session->set_flashdata('error', lang('error_request'));
            redirect('panel/requested_books');
        }
    }
    public function status_toggle($status, $id){
        $string = "";
        if ($status == 'complete') {
            $data = array(
                'status' => 3,
            );
            $this->db->where('id', $id);
            $this->db->update('requested_books', $data);
            if ($this->mSettings->email_request) {
                if ($this->email_send($id, 'ready')) {
                    $string .= lang('email_sent_true');
                }else{
                    $string .= lang('email_not_sent');
                }
            }
            if ($this->mSettings->sms_request) {
                if ($this->sms_send($id, 'ready')) {
                    $string .= lang('sms_sent');
                }else{
                    $string .= lang('sms_not_sent');
                }
            }
            $this->session->set_flashdata('message', sprintf(lang('status_marked'), lang('ready')) . $string);
            redirect('panel/requested_books/index');
        }
        if ($status == 'approve') {
            $data = array(
                'status' => 2,
            );
            $this->db->where('id', $id);
            $this->db->update('requested_books', $data);
            if ($this->mSettings->email_request) {
                if ($this->email_send($id, $status)) {
                    $string .= lang('email_sent_true');
                }else{
                    $string .= lang('email_not_sent');
                }
            }
            if ($this->mSettings->sms_request) {
                if ($this->sms_send($id, $status)) {
                    $string .= lang('sms_sent');
                }else{
                    $string .= lang('sms_not_sent');
                }
            }
            $this->session->set_flashdata('message', sprintf(lang('status_marked'), lang('approved')) . $string);
            redirect('panel/requested_books/index');
        }
        if ($status == 'reject') {
            $data = array(
                'status' => 0,
            );
            $this->db->where('id', $id);
            $this->db->update('requested_books', $data);
            if ($this->mSettings->email_request) {
                if ($this->email_send($id, $status)) {
                    $string .= lang('email_sent_true');
                }else{
                    $string .= lang('email_not_sent');
                }
            }
            if ($this->mSettings->sms_request) {
                if ($this->sms_send($id, $status)) {
                    $string .= lang('sms_sent');
                }else{
                    $string .= lang('sms_not_sent');
                }
            }
            $this->session->set_flashdata('message', sprintf(lang('status_marked'), lang('rejected'))  . $string);
            redirect('panel/requested_books/index');
        }

    }

    public function delete_records()
    {
        $days = $this->input->post('days');
        if (is_numeric($days)) {
            $this->db->query('delete from requested_books where datediff(now(), requested_books.date) > '.$days);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('message', $this->db->affected_rows() . ' ' . lang('rows_deleted_req'));
                redirect('panel/requested_books');
            }else{
                $this->session->set_flashdata('message', lang('not_deleted_req'));
                redirect('panel/requested_books');
            }
        }else{
            redirect('panel/requested_books');
        }
    }

}
?>