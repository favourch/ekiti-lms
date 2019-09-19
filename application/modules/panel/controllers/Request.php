<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('request_model');
        $this->lang->load('circulation', $this->mLanguage);
    }
    public function index()
    {
      $this->mPageTitle = lang('menu_list_requested_books');
      $this->render('member/request');
    }
    public function add_requested_books()
    {

      $this->form_validation->set_rules('book_title', lang('request_book_title'), 'required');
      $this->form_validation->set_rules('author_name', lang('request_author_name'), 'required');
      $this->form_validation->set_rules('copyright_year', lang('request_year'), 'required');
      if ($this->form_validation->run() == true) {
            $data = array(
                'book_title' => $this->input->post('book_title'),
                'year' => $this->input->post('copyright_year'),
                'author_name' => $this->input->post('author_name'),
                'remarks' => $this->input->post('remarks'),
                'date'   => date('Y-m-d'),
                'status' => 1,
                'user_id' => $this->ion_auth->get_user_id(),
            );
            if($this->db->insert('requested_books', $data)){
                $this->session->set_flashdata('message', lang('request_submitted'));
                redirect("panel/request/index");
            }else{
                $this->session->set_flashdata('error', lang('request_not_submitted'));
                redirect("panel/request/index");
            }
      }else{
      $this->mPageTitle = lang('menu_add_requested_books');

          $this->render('member/add_request');
      }
      
    }
    function getRequestedBooks() {
       $this->load->library('datatables');
       $userId = $this->ion_auth->get_user_id();
       $this->datatables
            ->select("id, book_title, author_name, year, remarks, date, status")
            ->where('user_id', $userId)
            ->from('requested_books');
        $this->datatables->add_column('actions', '<a class="btn btn-info" href="'.base_url().'panel/request/edit_request/$1"><i class="fa fa-edit"></i></a><a class="btn btn-danger" href="'.base_url().'panel/request/delete_request/$1"><i class="fa fa-trash"></i></a>', 'id');
        echo $this->datatables->generate();
    }
    public function delete_request($id){
        $status = $this->request_model->returnStatus($id);
        $user_id = $this->request_model->returnUserID($id);
        if ($status != 1) {
            $this->session->set_flashdata('error', lang('pending_delete'));
            redirect("panel/request/index");
        }
        if (!($user_id == $this->ion_auth->get_user_id())) {
            $this->session->set_flashdata('error', lang('pending_user_delete'));
            redirect("panel/request/index");
        }
        $this->db->where('id', $id);
        $this->db->delete('requested_books');
        $this->session->set_flashdata('message', lang('deleted_request'));
        redirect("panel/request/index");
    }

    public function edit_request($id){
        $this->mPageTitle = lang('menu_edit_request');

        $status = $this->request_model->returnStatus($id);
        $user_id = $this->request_model->returnUserID($id);
        if ($status != 1) {
            $this->session->set_flashdata('error', lang('pending_update'));
            redirect("panel/request/index");
        }
        if (!($user_id == $this->ion_auth->get_user_id())) {
            $this->session->set_flashdata('error', lang('pending_user_update'));
            redirect("panel/request/index");
        }
        $this->form_validation->set_rules('book_title', lang('request_book_title'), 'required');
        $this->form_validation->set_rules('author_name', lang('request_author_name'), 'required');
        $this->form_validation->set_rules('copyright_year', lang('request_year'), 'required');
        if ($this->form_validation->run() == true) {
            $data = array(
                'book_title' => $this->input->post('book_title'),
                'year' => $this->input->post('copyright_year'),
                'author_name' => $this->input->post('author_name'),
                'remarks' => $this->input->post('remarks'),
            );
            $this->db->where('id', $id);
            if($this->db->update('requested_books', $data)){
                $this->session->set_flashdata('message', lang('updated_request'));
                redirect("panel/request/index");
            }else{
                $this->session->set_flashdata('error', lang('not_updated_request'));
                redirect("panel/request/index");
            }
            
        }else{

            $this->data['request'] = $this->request_model->returnRequestData($id);
            $this->render('member/edit_request');
        }
        
    }
}
?>