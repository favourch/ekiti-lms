<?php 
Class Borrow_model extends CI_Model
{
    
    function insertBorrow($data = null, $books = null) 
    { 
        // echo '<pre>';
        // print_r($data);
        // print_r($book_authors);
        // print_r($book_categories);
        // echo '</pre>';
        
        if ($data AND $books) {
            if($this->db->insert('borrow', $data)) {
                $borrow_id = $this->db->insert_id();
                foreach ($books as $value) {
                    $this->db->insert('borrowdetails', array('book_id' => $value->row->id, 'borrow_id' => $borrow_id, 'borrow_status' => 'pending'));
                }
            }
        }
        
       
        return False;

        // return $this->db->affected_rows() >= 1 ? TRUE : FALSE; 
    }
    public function GetBorrowDetailsByID($id)
    {

        $this->db->select('borrow.borrow_id as id, book_title as title, CONCAT(first_name, " ", last_name) as name, date_borrow as date_borrow, due_date as due_date, date_return as date_return, borrow_status as status, email, phone, price, books.id as book_id, member_types.issue_limit_day');
        $this->db->where('borrowdetails.borrow_details_id = '.$id);
        $this->db->join('users', 'borrow.member_id = users.id', 'left');
        $this->db->join('borrowdetails', 'borrow.borrow_id = borrowdetails.borrow_id', 'left');
        $this->db->join('books', ' borrowdetails.book_id =  books.id ', 'left');
        $this->db->join('member_types', ' member_types.type_id =  users.type_id ', 'left');
        $q = $this->db->get('borrow');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
     public function GetBorrowDetailsByMemberID($id)
    {

        $this->db->select('borrow.borrow_id as id, book_title as title, CONCAT(first_name, " ", last_name) as name, date_borrow as date_borrow, due_date as due_date, date_return as date_return, borrow_status as status, email, phone, price, books.id as book_id, books.isbn as isbn, borrowdetails.borrow_details_id as borrowdetails_tid');
        $this->db->where('users.member_unique_id', $id);
        $this->db->where('borrowdetails.borrow_status = "pending"');
        $this->db->join('users', 'borrow.member_id = users.id', 'left');
        $this->db->join('borrowdetails', 'borrow.borrow_id = borrowdetails.borrow_id', 'left');
        $this->db->join('books', ' borrowdetails.book_id =  books.id ', 'left');
        $q = $this->db->get('borrow');
        $data = array();
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return ($data);
        }
        return FALSE;
    }
    public function getCountLimitBooks($id = NULL)
    {

        $this->db->select('COUNT(borrowdetails.borrow_details_id) as count');
        $this->db->where('borrow.member_id', $id);
        $this->db->where('borrowdetails.borrow_status = "pending"');
        $this->db->join('borrowdetails', 'borrow.borrow_id = borrowdetails.borrow_id', 'left');
        $q = $this->db->get('borrow');
        if ($q->num_rows() > 0) {
            return ($q->row()->count);
        }
        return FALSE;
    }

    function update_status($where, $data) 
    { 
        echo '<pre>';
        print_r($data);
        echo '</pre>';


        if ($where) {
            $this->db->where($where);
            $this->db->update('borrowdetails', $data);
                
            return True;
            
        }
        return False;

        // return $this->db->affected_rows() >= 1 ? TRUE : FALSE; 
    }

    function send_emails($due_ids = NULL, $type = 'email')
    {
        $dues = array();

        foreach ($due_ids as $due_id) {
            // echo $due_id;
            $this->db->select('book_title as title, users.email as email, CONCAT(first_name, " ", last_name) as name, date_borrow as date_borrow, due_date as due_date, users.phone as phone');
            $this->db->join('users', 'borrow.member_id = users.id', 'left');
            $this->db->join('borrowdetails', 'borrow.borrow_id = borrowdetails.borrow_id', 'left');
            $this->db->join('books', ' borrowdetails.book_id =  books.id ', 'left');
            $this->db->where('borrow_details_id', $due_id);
            $q = $this->db->get('borrow');
            if ($q->num_rows() > 0) {
                $results = TRUE;
                if ($type == 'email') {
                    $id = $q->row()->email;
                }else{
                    $id = $q->row()->phone;
                }
                $dues[$id][] = $q->row();
            }
        }
        if ($results) {
            return ($dues);
        }else{
            return FALSE;
        }

    }
    public function getIssueConfigByMemberTypeID($id)
    {

        $this->db->select('issue_limit_books, issue_limit_day');
        $this->db->where('type_id', $id);
        $q = $this->db->get('member_types');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
    public function getUserTypeIDByMemberID($id)
    {

        $this->db->select('type_id');
        $this->db->where('id', $id);
        $q = $this->db->get('users');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
    
  
}
?>