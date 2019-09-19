<?php 
Class Reports_model extends CI_Model
{
    
    function countBooks() 
    { 
        return $this->db->count_all_results('books'); // Produces an integer, like 17
    }

    function countBooksBorrowed() 
    { 
        return $this->db
               ->where('borrow_status', 'pending')
               ->count_all_results('borrowdetails');
    }
    function countBooksLost() 
    { 
        return $this->db
               ->where('borrow_status', 'lost')
               ->count_all_results('borrowdetails');
    }
    function sumBookPrices() 
    { 
        $q = $this->db->query("SELECT  
            SUM(`price` * (book_copies - (SELECT Count(borrowdetails.borrow_id) FROM  borrowdetails WHERE books.id = borrowdetails.book_id AND borrow_status = 'lost'))) AS total
        FROM books");

        return $q->row();
    }
   
   

  
}
?>