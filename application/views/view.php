
 <!-- Page Content -->
    <div class="container">

        <!-- Page Header -->
        <!-- <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Books Listing
                    <small></small>
                </h1>
            </div>
        </div> -->
        <!-- /.row -->
        <!-- Projects Row -->
        <div class="row">
           <!--  <embed src="<?= base_url(); ?>files/<?= $book->digital_file; ?>" id="ssss" width="100%" height="500" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html" readonly> -->
          <iframe src="<?= base_url();?>pdf/web/viewer.html?file=<?= base_url(); ?>files/<?= $book->digital_file; ?>" width="100%" height="600px" />

            
        </div>
        <!-- /.row -->


       


      
    </div>
    <!-- /.container -->