<?php 
Class Members_model extends CI_Model
{
   
    public function getMemberbyID($id)
    {

        $q = $this->db->query("SELECT id, CONCAT(first_name, ' ' ,last_name) as pname, member_unique_id, phone, email, class.name as class, borrowertype, section, image
        FROM users
        LEFT JOIN member_types ON member_types.type_id = users.type_id
        LEFT JOIN class ON class.class_id = users.class_id
        WHERE id = '$id'");
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

     public function getMember($term, $limit = 5)
    {
        $q = $this->db->query("SELECT 
            u.id as id, CONCAT(first_name, ' ' ,last_name) as pname, member_unique_id, phone, email, class.name, borrowertype, section, image, 
            GROUP_CONCAT(g.name) groupname 
        FROM 
            users_groups ug   
            INNER JOIN users u ON u.id = ug.user_id   
            INNER JOIN groups g ON g.id = ug.group_id 
            LEFT JOIN member_types ON member_types.type_id = u.type_id
            LEFT JOIN class ON class.class_id = u.class_id

        WHERE (g.name = 'members') AND
                (first_name LIKE '%$term%' OR
                last_name LIKE '%$term%' OR
                CONCAT(first_name, ' ' ,last_name) LIKE '%$term%' OR
                member_unique_id LIKE '%$term%')

        GROUP BY 
        u.id
        LIMIT $limit");


        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }
    public function getMember2($term, $limit = 5)
    {
        $q = $this->db->query("SELECT 
            u.id as id, CONCAT(first_name, ' ' ,last_name) as pname, member_unique_id, phone, email, class.name, borrowertype, section, image, member_types.type_id, member_types.issue_limit_books, member_types.issue_limit_day,
            GROUP_CONCAT(g.name) groupname 
        FROM 
            users_groups ug   
            INNER JOIN users u ON u.id = ug.user_id   
            INNER JOIN groups g ON g.id = ug.group_id 
            LEFT JOIN member_types ON member_types.type_id = u.type_id
            LEFT JOIN class ON class.class_id = u.class_id

        WHERE (g.name = 'members') AND
                (first_name LIKE '%$term%' OR
                last_name LIKE '%$term%' OR
                CONCAT(first_name, ' ' ,last_name) LIKE '%$term%' OR
                member_unique_id LIKE '%$term%')

        GROUP BY 
        u.id
        LIMIT $limit");


        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }
    function get_sections()
    {
        // $session_data = $this->session->userdata('logged_in');
        $this->db->select('section_name');
        $query = $this->db->get('section');
        if ($query->num_rows() > 0)
        {
            $data = array();
            foreach ($query->result_array() as $row)
            {
                $data[$row['section_name']] = $row['section_name']; 
            }
        }
        $query->free_result();
        return $data;       
    }
    public function getAllMemType() {
        $this->db->order_by('type_id');
        $q = $this->db->get('member_types');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
    public function addMemType($data = NULL)
    {
        $q = $this->db->insert('member_types', $data);
        if ($this->db->affected_rows() > 0) {
            return ($this->db->insert_id());
        }else{
            return FALSE;
        }
    }
     public function deleteMemType($id) {
        if ($this->db->delete('member_types', array('type_id' => $id))) {
            return $this->db->affected_rows();
        }
        return FALSE;
    }
    
    public function updateMemType($id, $data) {
        $this->db->where('type_id', $id);
        if($this->db->update('member_types', $data)){
            return $this->db->affected_rows();
        }
        return FALSE;
    }
    
    public function getMemTypeByID($id)
    {
        $q = $this->db->get_where('member_types', array('type_id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }


    public function getAllOccu() {
        $this->db->select('class_id, name, borrowertype');
        $this->db->join('member_types', ' member_types.type_id =  class.type_id ', 'left');
        $q = $this->db->get('class');

        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
    public function addOccu($string = NULL, $type = NULL)
    {
        
        if ($q = $this->db->query("INSERT IGNORE INTO `class`(`name`, `type_id`) VALUES ('$string', '$type')")) {
            return $this->db->affected_rows();
        }
        return FALSE;
        // print($string);
    }
    public function deleteOccu($id) {
        if ($this->db->delete('class', array('class_id' => $id))) {
            return $this->db->affected_rows();
        }
        return FALSE;
        

    }
    public function getOccuByID($id)
    {
        $q = $this->db->get_where('class', array('class_id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
    public function getOccuByMTID($id)
    {
        $this->db->where('type_id', $id);
        $q = $this->db->get('class');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
    public function updateOccu($id, $data) {

        $this->db->where('class_id', $id);
        if($this->db->update('class', $data)){
            return $this->db->affected_rows();
        }
        return FALSE;

    }

}    
?>
