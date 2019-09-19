<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->load->model('reports_model');
        $this->lang->load('reports_lang', $this->mLanguage);
        $this->load->library('lms');

	}
/* ------------------------------------------------------------------------------- */

    function index()
    {
       
    }

    function quick_inventory($pdf = NULL)
    {

        $this->data['books_count'] = $this->reports_model->countBooks();
        $this->data['countBooksBorrowed'] = $this->reports_model->countBooksBorrowed();
        $this->data['countBooksLost'] = $this->reports_model->countBooksLost();
        $this->data['countBooksLost'] = $this->reports_model->countBooksLost();
        $this->data['sumBookPrices'] = $this->reports_model->sumBookPrices()->total;
        $this->data['sumMembers'] = count($this->ion_auth->users('2')->result()); // Pass groups array as params
        $html = $this->render('reports/quick_inventory');

        
        if ($pdf) {
            ini_set('memory_limit','32M'); // boost the memory limit if it's low 😉
            $html = $this->load->view('reports/quick_inventory', $this->data, true); // render the view into HTML
             
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822)); // Add a footer for good measure 😉
            // $pdf->showImageErrors = true;
            $stylesheet = file_get_contents('assets/bootstrap/css/bootstrap.min.css');
            $stylesheet .= file_get_contents('assets/dist/css/AdminLTE.min.css');
            
            $pdf->WriteHTML($stylesheet, 1); // write the HTML into the PDF
            $pdf->WriteHTML($html); // write the HTML into the PDF
            $pdf->Output($pdfFilePath, 'I'); // save to file because we can
        }
            
        // print_r($this->data);
         
 
    }
	
}
