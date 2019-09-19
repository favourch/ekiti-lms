<?php 
Class Request_model extends CI_Model {

    public function delete($id){
    	$this->db->where('id', $id);
    	$this->db->delete('requested_books');
    	return TRUE;
    }

    public function returnStatus($id){
    	$q = $this->db->get_where('requested_books', array('id' => $id) ,1);
    	if ($q->num_rows() > 0) {
            return $q->row()->status;
        }
    }
    public function returnUserID($id){
    	$q = $this->db->get_where('requested_books', array('id' => $id) ,1);
    	if ($q->num_rows() > 0) {
            return $q->row()->user_id;
        }
    }
  
  	public function returnRequestData($id){
    	$q = $this->db->get_where('requested_books', array('id' => $id) ,1);
    	if ($q->num_rows() > 0) {
            return $q->row();
        }
    }

    function getEmailByRequestID($id)
    {
        $this->db->select('book_title, users.email, CONCAT(users.first_name, " ", users.last_name) as name, phone');
        $this->db->where('requested_books.id', $id);
        $this->db->join('users', 'requested_books.user_id = users.id', 'left');
        $q = $this->db->get('requested_books');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }

}
?>