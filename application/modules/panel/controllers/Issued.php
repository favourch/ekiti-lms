<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Issued extends Admin_Controller {

   public function __construct()
    {
        parent::__construct();
        $this->lang->load('circulation', $this->mLanguage);
       
    }
	public function index()
	{
		$this->mPageTitle = 'My Books';

		$this->render('member/mybooks');
	}
  public function history()
  {
    $this->mPageTitle = 'Circulation History';

    $this->render('member/history');
  }
	function getBooks() {


       $this->load->library('datatables');
      
       $userId = $this->ion_auth->get_user_id();



       $this->datatables
            ->select("books.id, image,CONCAT(book_title, '(', isbn, ')', '___', book_pub, '___', (SELECT GROUP_CONCAT( DISTINCT authors.author_name ) FROM authors LEFT JOIN book_authors ON book_authors.author_id = authors.id WHERE book_authors.book_id =  `books`.id GROUP BY book_authors.book_id )) as book_title, book_pub, price, ( SELECT GROUP_CONCAT(DISTINCT categories.category_name ) FROM categories LEFT JOIN book_categories ON book_categories.category_id = categories.id WHERE book_categories.book_id =  `books`.id GROUP BY book_categories.book_id) AS category_name, books.digital_file as digital_file,due_date, borrow_status")
            ->from('books');

            $this->datatables->join('borrowdetails', 'borrowdetails.book_id = books.id', 'left');
            $this->datatables->join('borrow', 'borrowdetails.borrow_id = borrow.borrow_id', 'left');
            $this->datatables->where('borrow.member_id', $userId);
            $this->datatables->where('borrowdetails.borrow_status', 'pending');





      
        $read = "<a href='".site_url('panel/books/read/$1')."' title='".'$2'."'>$2</a>";
        $this->datatables->add_column('read', $read, 'id, digital_file');

        $this->datatables->unset_column('books.id');
        $this->datatables->unset_column('digital_file');



        echo $this->datatables->generate();
          

    }
    function getBooksAll() {


       $this->load->library('datatables');
      
       $userId = $this->ion_auth->get_user_id();



       $this->datatables
            ->select("books.id, image,CONCAT(book_title, '(', isbn, ')', '___', book_pub, '___', (SELECT GROUP_CONCAT( DISTINCT authors.author_name ) FROM authors LEFT JOIN book_authors ON book_authors.author_id = authors.id WHERE book_authors.book_id =  `books`.id GROUP BY book_authors.book_id )) as book_title, book_pub, price, ( SELECT GROUP_CONCAT(DISTINCT categories.category_name ) FROM categories LEFT JOIN book_categories ON book_categories.category_id = categories.id WHERE book_categories.book_id =  `books`.id GROUP BY book_categories.book_id) AS category_name, books.digital_file as digital_file, due_date, borrow_status, borrowdetails.date_return as date_return")
            ->from('books');

        $this->datatables->join('borrowdetails', 'borrowdetails.book_id = books.id', 'left');
        $this->datatables->join('borrow', 'borrowdetails.borrow_id = borrow.borrow_id', 'left');
        $this->datatables->where('borrow.member_id', $userId);

      
        $read = "<a href='".site_url('admin/books/read/$1')."' title='".'$2'."'>$2</a>";
        $this->datatables->add_column('read', $read, 'id, digital_file');

        $this->datatables->unset_column('books.id');
        $this->datatables->unset_column('digital_file');



        echo $this->datatables->generate();
          

    }
}
