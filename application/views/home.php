<style>
.text-overflow {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
</style>
<!-- Page Content -->
    <div class="container">
        <!-- Page Header -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><?= lang('books_list_front'); ?>
                    <small></small>
                </h1>
                <div class="box">
                    <div class="box-body">
                        <form class="form-inline" action="<?= base_url();?>home/search" method="get">
                          <div class="form-group col-md-3">
                            <input name="book_title" type="text" style="width: 100%" class="form-control" id="" placeholder="<?= lang('book_title_name'); ?>">
                          </div>
                          <div class="form-group col-md-3">
                            <select class="form-control " style="width: 100%" name="author_id">
                                <option value="0" ><?= lang('select_author'); ?></option>
                                <?php foreach ($authors as $author): ?>
                                    <option value="<?= $author->id; ?>"><?= $author->author_name ?></option>
                                <?php endforeach; ?>
                            </select>  
                          </div>
                          <div class="form-group col-md-3">
                            <select class="form-control" style="width: 100%" name="category_id">
                                <option value="0" ><?= lang('select_category'); ?></option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category->id; ?>"><?= $category->category_name ?></option>
                                <?php endforeach; ?>
                            </select>  
                          </div>
                          <button type="submit" class="btn btn-default"><?= lang('search'); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
        <!-- Projects Row -->
        <div class="row">
            
            <div class="col-md-9">
                         <?php if ($books): ?>
                             <div class="col-md-12">
                                <div class="row text-center">
                                    <nav  aria-label="Page navigation">
                                        <?php echo $links; ?>
                                    </nav>
                                </div>
                            </div>
                            <?php foreach($books as $book): ?>
                                <div class="col-xs-6 col-sm-3">
                                    <div class="bookItem fadeIn animated">
                                        <a href="#">
                                            <img src="<?= base_url(); ?>assets/uploads/book_covers/<?= $book->image; ?>" class="img-responsive" alt="<?= ($book->book_title); ?>">
                                            <span class="text-overflow"><?= $book->book_title ?></span>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <div class="col-md-12">
                                <div class="row text-center">
                                    <nav  aria-label="Page navigation">
                                        <?php echo $links; ?>
                                    </nav>
                                </div>
                            </div>

                    <?php else: ?>
                        <h1 class="text-center">No Books in Database :D</h1>
                    <?php endif;?>
            </div>
            <div class="col-md-3">
                <blockquote>
                    <p><?= lang('menu_categories'); ?></p>
                </blockquote>
                <ul>
                    <?php if ($categories): ?>
                        <?php foreach ($categories as $category): ?>
                            <li><a href="<?= base_url(); ?>home/search/?category_id=<?= $category->id; ?>"><?= $category->category_name ?></a></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
                <blockquote>
                    <p><?= lang('menu_authors'); ?></p>
                </blockquote>
                <select id="authors" style="width: 100%;">
                    <option><?= lang('select_author'); ?></option>
                    <?php if ($authors): ?>
                        <?php foreach ($authors as $author): ?>
                            <option value="<?= base_url(); ?>home/search/?author_id=<?= $author->id; ?>"><?= $author->author_name ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
               
            </div>
        </div>
        <!-- /.row -->

<script type="text/javascript">
    $('#authors').select2();
    $('#authors').on('change', function() {
        var url = $(this).val();
        window.location.href=url;
    });
</script>
      