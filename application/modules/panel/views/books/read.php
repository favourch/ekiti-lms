

      <div class="row">
    <div class="col-md-12">

        <!-- Page Header -->
      
        <div class="row">
        
        <?php
        if (!parse_url($book->digital_file, PHP_URL_SCHEME)) {
            $book->digital_file = base_url().'files/'.$book->digital_file; 
        }
        

?>
          <iframe src="<?= base_url();?>assets/pdf/web/viewer.html?file=<?= $book->digital_file;?>" width="100%" height="600px" /></iframe>

            
        </div>
        <!-- /.row -->
</div>


       


      
    </div>
    <!-- /.container -->
    </section>