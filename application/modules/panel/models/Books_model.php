<?php 
Class Books_model extends CI_Model
{
    public function deleteBook($id)
    {
        if ($this->db->delete('books', array('id' => $id))) {
            if ($this->db->delete('book_authors', array('book_id' => $id))) {
                if ($this->db->delete('book_categories', array('book_id' => $id))) {
                    return true;
                }
                return true;
            }
            return true;
        }
        return FALSE;
    }
    public function delete_categories($id){
        if ($this->db->delete('book_categories', array('book_id' => $id))) {
            return true;
        }   
    }
    public function delete_authors($id){
        if ($this->db->delete('book_authors', array('book_id' => $id))) {
            return true;
        }   
    }


    public function batchAddCat($string = NULL)
    {
        
        if ($q = $this->db->query("INSERT IGNORE INTO `categories`(`category_name`) VALUES ('$string')")) {
            if ($q = $this->db->query("SELECT `categories`.`id` FROM categories WHERE category_name = '$string'")) {
                if ($q->num_rows() > 0) {
                    return $q->row();
                }
            }
        }
        // print($string);
    }
    public function batchAddAuthors($string = NULL)
    {
        
        if ($q = $this->db->query("INSERT IGNORE INTO `authors`(`author_name`) VALUES ('$string')")) {
            if ($q = $this->db->query("SELECT `authors`.`id` FROM authors WHERE author_name = '$string'")) {
                if ($q->num_rows() > 0) {
                    return $q->row();
                }
            }
        }
        // print($string);
    }
    public function getProductNames($term, $limit = 5)
    {
        $q = $this->db->query("SELECT id, 
            book_copies - (SELECT Count(borrowdetails.borrow_id) FROM  borrowdetails WHERE books.id = borrowdetails.book_id AND borrow_status = 'lost') as total_quantity, 
            book_copies - (SELECT Count(borrowdetails.borrow_id) FROM borrowdetails WHERE books.id = borrowdetails.book_id AND borrow_status = 'pending') as available, book_title, isbn, price
        FROM books
        WHERE isbn LIKE '%$term%' OR
        book_title LIKE '%$term%' OR
        isbn_13 LIKE '%$term%'
        ORDER BY isbn
        LIMIT $limit");


        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }
    public function getBooksByCategoryID($id)
    {
        $q = $this->db->query('SELECT books.*,category_id,
            book_copies - (SELECT Count(borrowdetails.borrow_id) FROM  borrowdetails WHERE books.id = borrowdetails.book_id AND borrow_status = "lost") as total_quantity, 
            book_copies - (SELECT Count(borrowdetails.borrow_id) FROM borrowdetails WHERE books.id = borrowdetails.book_id AND borrow_status = "pending") as available 
            FROM books
            LEFT JOIN book_categories ON books.id=book_categories.book_id
            WHERE book_categories.category_id =
        '.$id);


        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }
    public function getBooksByAuthorID($id)
    {
        $q = $this->db->query('SELECT books.*,author_id,
            book_copies - (SELECT Count(borrowdetails.borrow_id) FROM  borrowdetails WHERE books.id = borrowdetails.book_id AND borrow_status = "lost") as total_quantity, 
            book_copies - (SELECT Count(borrowdetails.borrow_id) FROM borrowdetails WHERE books.id = borrowdetails.book_id AND borrow_status = "pending") as available 
            FROM books
            LEFT JOIN book_authors ON books.id=book_authors.book_id
            WHERE book_authors.author_id =
        '.$id);


        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function getBarcode($term = NULL, $limit = 5)
    {
        $q = $this->db->query("SELECT book_title, isbn
        FROM books
        ORDER BY isbn
        LIMIT $limit");


        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }
    public function getBookByID($id, $dig = FALSE)
    {
        $q = $this->db->get_where('books', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
     public function getBookByISBN($isbn)
    {
        $q = $this->db->where('isbn', $isbn)->or_where('isbn_13', $isbn)->get('books');
        if ($q->num_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }
    public function isPdfBook($id)
    {
        $q = $this->db->query('SELECT digital_file FROM books WHERE books.digital_file != NULL');
        if ($q->num_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }
    
    public function getBookDetByID($id)
    {
        $q = $this->db->query('SELECT books.*,(SELECT GROUP_CONCAT( DISTINCT authors.id ) FROM authors LEFT JOIN book_authors ON book_authors.author_id = authors.id WHERE book_authors.book_id =  `books`.id GROUP BY book_authors.book_id ) AS author_name, ( SELECT GROUP_CONCAT( DISTINCT categories.id ) FROM categories LEFT JOIN book_categories ON book_categories.category_id = categories.id WHERE book_categories.book_id =  `books`.id GROUP BY book_categories.book_id) AS category_name, book_copies - (SELECT Count(borrowdetails.borrow_id) FROM  borrowdetails WHERE books.id = borrowdetails.book_id AND borrow_status = "lost") as total_quantity, book_copies - (SELECT Count(borrowdetails.borrow_id) FROM borrowdetails WHERE books.id = borrowdetails.book_id AND borrow_status = "pending") as available FROM books WHERE books.id ='.$id);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
     public function findBookDetByID($id)
    {
        $q = $this->db->query('SELECT books.*,(SELECT GROUP_CONCAT( DISTINCT authors.author_name ) FROM authors LEFT JOIN book_authors ON book_authors.author_id = authors.id WHERE book_authors.book_id =  `books`.id GROUP BY book_authors.book_id ) AS author_name, ( SELECT GROUP_CONCAT( DISTINCT categories.category_name ) FROM categories LEFT JOIN book_categories ON book_categories.category_id = categories.id WHERE book_categories.book_id =  `books`.id GROUP BY book_categories.book_id) AS category_name, book_copies - (SELECT Count(borrowdetails.borrow_id) FROM  borrowdetails WHERE books.id = borrowdetails.book_id AND borrow_status = "lost") as total_quantity, book_copies - (SELECT Count(borrowdetails.borrow_id) FROM borrowdetails WHERE books.id = borrowdetails.book_id AND borrow_status = "pending") as available FROM books WHERE books.id ='.$id);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getBookDetByISBN($id)
    {
        $q = $this->db->query("SELECT books.* FROM books WHERE books.isbn = '$id' OR books.isbn_13 = '$id'");
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function add_books($books = array())
    {
        if (!empty($books)) {
            foreach ($books as $book) {
                $authors = explode('|', $book['authors']);
                $categories = explode('|', $book['categories']);
                unset($book['authors']);
                unset($book['categories']);
                $book['image'] = 'no_image.png';
                $book['date_added'] = date("Y-m-d H:i:s");
               
                if ($this->db->insert('books', $book)) {
                    $book_id = $this->db->insert_id();
                    foreach ($authors as $author) {
                        if ($author && trim($author) != '') {
                            $aut = array('book_id' => $book_id, 'author_id' => trim($author));
                            $this->db->insert('book_authors', $aut);
                        }
                    }
                    foreach ($categories as $category) {
                        if ($category && trim($category) != '') {
                            $cat = array('book_id' => $book_id, 'category_id' => trim($category));
                            $this->db->insert('book_categories', $cat);
                        }
                    }
                }
            }
            return true;
        }
        return false;
    }

    function insert_book($data, $book_categories = null, $book_authors = null) 
    { 
        

        $q = $this->db->get_where('books', array('isbn' => $data['isbn'], 'isbn_13' => $data['isbn_13']), 1);
            if ($q->num_rows() > 0) {
                return FALSE;
            } else {
                if($this->db->insert('books', $data))
                {

                    $book_id = $this->db->insert_id();
                    
                    foreach ($book_authors as $value) {
                        $this->db->insert('book_authors', array('book_id' => $book_id, 'author_id' => $value['author_id']));
                    }

                    foreach ($book_categories as $value) {
                        $this->db->insert('book_categories', array('book_id' => $book_id, 'category_id' => $value['category_id']));
                    }
                    return TRUE; 

                }
            }
       
        return False;

    }
    function update_book($book_id, $data, $book_categories = null, $book_authors = null) 
    { 
        echo '<pre>';
        print_r($data);
        print_r($book_authors);
        print_r($book_categories);
        echo $book_id;
        echo '</pre>';


        if ($book_id) {
            $this->db->where('id', $book_id);
            $this->db->update('books', $data);
                
            foreach ($book_authors as $value) {
                $this->db->insert('book_authors', array('book_id' => $book_id, 'author_id' => $value['author_id']));
            }

            foreach ($book_categories as $value) {
                $this->db->insert('book_categories', array('book_id' => $book_id, 'category_id' => $value['category_id']));
            }
                return True;
            
        }
        return False;

        // return $this->db->affected_rows() >= 1 ? TRUE : FALSE; 
    }
    public function addCat($string = NULL)
    {
        
        if ($q = $this->db->query("INSERT IGNORE INTO `categories`(`category_name`) VALUES ('$string')")) {
            return $this->db->affected_rows();
        }
        return FALSE;
        // print($string);
    }
    public function getAllCategories() {
        $this->db->order_by('category_name');
        $q = $this->db->get('categories');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
    public function deleteCategory($id) {
        $q = $this->db->get_where('book_categories', array('category_id' => $id));
        if (!($q->num_rows() > 0)) {
            if ($this->db->delete('categories', array('id' => $id))) {
                return $this->db->affected_rows();
            }
        }
        return FALSE;
    }
    
    public function updateCategory($id, $data) {
        $this->db->where('id', $id);
        if($this->db->update('categories', $data)){
            return $this->db->affected_rows();
        }
        return FALSE;
    }
    
    public function getCategoryByID($id)
    {
        $q = $this->db->get_where('categories', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
    public function addAuthor($string = NULL)
    {
        
        if ($q = $this->db->query("INSERT IGNORE INTO `authors`(`author_name`) VALUES ('$string')")) {
            return $this->db->affected_rows();
        }
        return FALSE;
        // print($string);
    }
    public function getAllAuthors() {
        $this->db->order_by('author_name');
        $q = $this->db->get('authors');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
    public function deleteAuthor($id) {
        $q = $this->db->get_where('book_authors', array('author_id' => $id));
        if (!($q->num_rows() > 0)) {
            if ($this->db->delete('authors', array('id' => $id))) {
                return $this->db->affected_rows();
            }
        }
        return FALSE;
    }
    public function getAuthorByID($id)
    {
        $q = $this->db->get_where('authors', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
    public function updateAuthor($id, $data) {

        $this->db->where('id', $id);
        if($this->db->update('authors', $data)){
            return $this->db->affected_rows();
        }
        return FALSE;

    }
    public function getBookAuthorsByPIDandName($book_id, $name)
    {
        $q = $this->db->get_where('book_authors', array('book_id' => $book_id, 'author_id' => $name), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }

        return FALSE;
    }
    public function getBookCatByPIDandName($book_id, $name)
    {
        $q = $this->db->get_where('book_categories', array('book_id' => $book_id, 'category_id' => $name), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }

        return FALSE;
    }

    public function addCategories($data)
    {
        if ($this->db->insert_batch('categories', $data)) {
            return true;
        }
        return false;
    }
     public function getCategoryByName($name)
    {
        $q = $this->db->get_where('categories', array('category_name' => $name), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function addAuthors($data)
    {
        if ($this->db->insert_batch('authors', $data)) {
            return true;
        }
        return false;
    }
     public function getAuthorByName($name)
    {
        $q = $this->db->get_where('authors', array('author_name' => $name), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
}    
?>
