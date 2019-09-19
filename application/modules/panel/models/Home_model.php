<?php 
Class Home_model extends CI_Model
{

    public function getTotalBooks(){
        // $this->db->where('city_id', $city_id);
        $this->db->from('books');
        return $this->db->count_all_results();
    }
    public function getTotalBorrowedBooks(){
        $this->db->where('borrow_status', 'pending');
        $this->db->from('borrowdetails');
        return $this->db->count_all_results();
    }
     public function getDues($interval = NULL)
    {
        $q = $this->db->query('SELECT `borrow`.`borrow_id` as `id`, `book_title` as `title`, CONCAT(first_name, " ", last_name) as name, `date_borrow` as `date_borrow`, `due_date` as `due_date`, `date_return` as `date_return`, `borrow_status` as `status`, CONCAT("<strong>Email:</strong> ", email, \' <br><strong>Phone:</strong> \',phone) as contacts, `price`, `books`.`id` as `book_id`, member_types.issue_limit_day FROM `borrow` LEFT JOIN `users` ON `borrow`.`member_id` = `users`.`id` LEFT JOIN `borrowdetails` ON `borrow`.`borrow_id` = `borrowdetails`.`borrow_id`  LEFT JOIN `member_types` ON `member_types`.`type_id` = `users`.`type_id` LEFT JOIN `books` ON `borrowdetails`.`book_id` = `books`.`id` 
            WHERE `due_date` = CURRENT_DATE '.$interval);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
    public function getDuesCount($status = 'tilldate', $time = NULL)
    {

        $this->db->select('borrow.borrow_id as id, book_title as title, date_borrow, due_date, date_return, email, phone, price, books.id as book_id');
        $this->db->from('borrow');
        if ($status != 'tilldate') {
            $this->db->where('borrowdetails.borrow_status',$status);
        }
        if ($time) {
           $this->db->where('due_date < NOW()', null);
        }
        $this->db->join('users', 'borrow.member_id = users.id', 'left');
        $this->db->join('borrowdetails', 'borrow.borrow_id = borrowdetails.borrow_id', 'left');
        $this->db->join('books', ' borrowdetails.book_id =  books.id ', 'left');

        return $this->db->count_all_results();


    }
    public function barChartData($limit = 6)
    {
        $this->db->from('books');

        $this->db->select('book_title as title, (SELECT Count(borrowdetails.borrow_id) FROM borrowdetails WHERE books.id = borrowdetails.book_id) as sales');
        
        $this->db->order_by("sales", "desc");
        $this->db->limit($limit);
        $q = $this->db->get(); 


        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }


    }
    public function getDuesCountByID($status = 'tilldate', $time = NULL)
    {

        $this->db->select('borrow.borrow_id as id, book_title as title, date_borrow, due_date, date_return, email, phone, price, books.id as book_id');
        $this->db->from('borrow');
        if ($status != 'tilldate') {
            $this->db->where('borrowdetails.borrow_status',$status);
        }
        $this->db->join('users', 'borrow.member_id = users.id', 'left');
        $this->db->join('borrowdetails', 'borrow.borrow_id = borrowdetails.borrow_id', 'left');
        $this->db->join('books', ' borrowdetails.book_id =  books.id ', 'left');
        $userId = $this->ion_auth->get_user_id();

        $this->db->where('member_id', $userId);
        return $this->db->count_all_results();


    }
    

  
}    
?>
