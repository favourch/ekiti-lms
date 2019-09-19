<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Borrow extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('borrow_model');
        $this->lang->load('circulation_lang', $this->mLanguage);
        
       
    }
/* ------------------------------------------------------------------------------- */

    function index()
    {

        $this->render('borrow/add');

    }

   /* ------------------------------------------------------------------------------- */
   /* ------------------------------------------------------------------------------- */

    function bookreturn()
    {

        $this->render('borrow/bookreturn');

    }

   /* ------------------------------------------------------------------------------- */
   /* ------------------------------------------------------------------------------- */

    function returnbook($id = NULL)
    {
        $this->form_validation->set_rules('submitok', 'Submit', 'required');
        $this->form_validation->set_rules('borrow_id', 'Submit', 'required');
        $this->form_validation->set_rules('book_id', 'Submit', 'required');
        $this->form_validation->set_rules('islost', 'Submit', 'required');
        $this->form_validation->set_rules('price', 'Submit', 'required');
        $this->form_validation->set_rules('borrow_details_id', 'Submit', 'required');

        if (($this->form_validation->run() == TRUE)) {
            $data = array();
            $where = array();
            $where['borrow_id'] = $_POST['borrow_id'];
            $where['borrow_details_id'] = $_POST['borrow_details_id'];
            $where['book_id'] = $_POST['book_id'];
            $data['fine'] = ($_POST['fine'] == '') ? NULL : $_POST['fine'];
            $data['date_return'] = date("Y-m-d H:i:s");
            if ($_POST['islost'] === 'yes') {
                $data['borrow_status'] = 'lost';
                $data['price_lost_book'] = $_POST['price'];
            }else{
                $data['borrow_status'] = 'returned';
            }

            if($this->borrow_model->update_status($where, $data)){
                $this->session->set_flashdata('message', lang('book_returned'));
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $this->session->set_flashdata('warning', lang('book_returned_not'));
                redirect($_SERVER['HTTP_REFERER']);
            }
            
        }elseif ($id !== NULL) {
            $data = array();
            $details = $this->borrow_model->GetBorrowDetailsByID($id);
            $data['data'] = $details;

            $datetime1 = date_create(date('Y-m-d'));
            $datetime2 = date_create($details->due_date);
            $interval = date_diff($datetime1, $datetime2)->format('%R%a days');


            $today = new DateTime('');
           
            $expireDate = new DateTime($details->due_date); //from db


            if($today->format("Y-m-d") > $expireDate->format("Y-m-d")) { 
                $data['expired'] = TRUE;
            }else{
                $data['expired'] = FALSE;
            }
           
            $data['interval'] = $interval;
            $this->load->model('settings_model');
            $fine = $this->settings_model->getFineValue();

            $data['fine'] = abs($interval) * ($fine->fine);
            $data['borrow_details_id'] = $id;
            $data['settings'] = $this->mSettings;
            $this->load->view('borrow/returnbook', $data);
        }else{
            redirect('panel/borrow/borrowed');
        }
        


    }

   /* ------------------------------------------------------------------------------- */
   /* ------------------------------------------------------------------------------- */

    function borrowed($status = NULL)
    {
        $this->mPageTitle = lang('borrowed_books_title');
        
        if ($status === 'pending' or $status === 'returned' or $status=== 'lost') {
            $this->data['status'] = $status;
            $this->mPageTitle = ucfirst($status). ' Books';

        }
        $this->render('borrow/index');

    }

    function add()
    {
        if (($this->input->post('items')) && ($this->input->post('member')) && ($this->input->post('due_date'))){
            
            $items = json_decode($_POST['items']);
            $member = json_decode($_POST['member']);
            $new_items = array();
            foreach ($items as $item) {
                $qty = ($item->row->qty);
                for ($i=0; $i < $qty; $i++) { 
                    $new_items[] = $item;
                }
            }
            $items = $new_items;
            $count = (count((array)$items));
            
            $due_date = $_POST['due_date'];
            $date_today = date("Y-m-d H:i:s");
            $member_id = $member->item_id;

            $data = array(
                'member_id' => $member_id,
                'date_borrow' => $date_today,
                'due_date' => $due_date,
            );
            $count_previous = $this->borrow_model->getCountLimitBooks($member_id);
            $count += $count_previous;
            if ($this->mSettings->issue_conf == 1) {
                if ($this->mSettings->issue_limit_books == 0 OR $this->mSettings->issue_limit_books == -1) {
                    $this->borrow_model->insertBorrow($data, $items);
                    $this->session->set_flashdata('message', lang('book_issued'));
                    redirect('panel/borrow');
                }else{
                    if ($count <= $this->mSettings->issue_limit_books) {
                        $this->borrow_model->insertBorrow($data, $items);
                        $this->session->set_flashdata('message', lang('book_issued'));
                        redirect('panel/borrow');
                    }else{
                        $this->session->set_flashdata('warning', sprintf(lang('book_issue_limit_exceed_books'), $count, $this->mSettings->issue_limit_books));
                        redirect('panel/borrow');
                    }
                }
                
            }elseif($this->mSettings->issue_conf == 2){
                $user_type_id = $this->borrow_model->getUserTypeIDByMemberID($member_id)->type_id;
                $config = $this->borrow_model->getIssueConfigByMemberTypeID($user_type_id);
                if ($config->issue_limit_books == 0 OR $config->issue_limit_books == -1) {
                    $this->borrow_model->insertBorrow($data, $items);
                    $this->session->set_flashdata('message', lang('book_issued'));
                    redirect('panel/borrow');
                }else{
                    if ($count <= $config->issue_limit_books) {
                        $this->borrow_model->insertBorrow($data, $items);
                        $this->session->set_flashdata('message', lang('book_issued'));
                        redirect('panel/borrow');
                    }else{
                        $this->session->set_flashdata('warning', sprintf(lang('book_issue_limit_exceed_books'), $count_previous, $config->issue_limit_books));
                        redirect('panel/borrow');
                    }
                }
            }

        }else{
            $this->session->set_flashdata('error', lang('book_issued_not'));
        }


    }

   /* ------------------------------------------------------------------------------- */

    function getBorrowedBooks($status = NULL) {
       $this->load->library('datatables');
       
        $actions = '';

        $this->datatables
            ->select('borrow_details_id as id, book_title as title, CONCAT(first_name, " ", last_name) as name, date_borrow as date_borrow, due_date as due_date, date_return as date_return, borrow_status as status')
            ->from('borrow');
            if ($status === 'returned') {
                $actions = '<a href="#$1" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-primary"><i class="fa fa-bars"></i>';

                $this->datatables->where("borrow_status = 'returned'");
            }elseif ($status === 'pending') {
                $actions = '<a href="' . site_url('panel/borrow/returnbook/$1') . '" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-primary"><i class="fa fa-bars"></i> ';

                $this->datatables->where("borrow_status = 'pending'");
            }elseif ($status === 'lost') {
                $actions = '<a href="#$1" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-primary"><i class="fa fa-bars"></i>';

                $this->datatables->where("borrow_status = 'lost'");
            }
        $this->datatables->join('users', 'borrow.member_id = users.id', 'left');
        $this->datatables->join('borrowdetails', 'borrow.borrow_id = borrowdetails.borrow_id', 'left');
        $this->datatables->join('books', ' borrowdetails.book_id =  books.id ', 'left');
        $this->datatables->join('member_types', ' member_types.type_id =  users.type_id ', 'left');
        



        $this->datatables->add_column('actions', $actions, 'id');
        $this->datatables->unset_column('id');


        echo $this->datatables->generate('json', 'ISO-8859-1');

        // echo $this->datatables->generate();
          

    }
    /* --------------------------------------------------------------------------------------------- */
     public function suggestions()
    {
        $term = $this->input->get('term', true);

        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . site_url('welcome') . "'; }, 10);</script>");
        }
        $this->load->library('lms');
        $this->load->model('books_model');
        
        $rows = $this->books_model->getProductNames($term);

        
        if ($rows) {
            foreach ($rows as $row) {
                $row->qty = 1;
                $pr[] = array('id' => $row->id, 'available_now' => (int) $row->available-1 ,'item_id' => $row->id, 'label' => $row->book_title . " (" . $row->isbn . ")", 'row' => $row);
                
                
            }
            $this->lms->send_json($pr);
        } else {
            $this->lms->send_json(array(array('id' => 0, 'label' => lang('no_match_found'), 'value' => $term)));
        }
    }

    /* --------------------------------------------------------------------------------------------- */
     public function suggestions_members()
    {
        $term = $this->input->get('term', true);

        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . site_url('welcome') . "'; }, 10);</script>");
        }
        $this->load->library('lms');
        $this->load->model('books_model');
        
        $rows = $this->borrow_model->GetBorrowDetailsByMemberID($term);
        
        if ($rows) {
            foreach ($rows as $row) {
                $pr[] = array('id' => str_replace(".", "", microtime(true)), 'item_id' => $row->id, 'label' => $row->title . " (" . $row->isbn . ")", 'row' => $row);
                
                
            }
            $this->lms->send_json($pr);
        } else {
            $this->lms->send_json(array(array('id' => 0, 'label' => lang('no_match_found'), 'value' => $term)));
        }
    }

    
    
}
