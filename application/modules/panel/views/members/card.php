<style type="text/css">
    /* =================================================================== */
.card { width: 353px; min-height: 250px; border-radius: 10px; margin: 15px auto; color: #FFF; }
.card .card_img { position: absolute; top: 0; left: 0; width: 353px; height: 206px; }
.card .front { position: relative; }
.card .back {  position: relative; }
.card .middle { display: table-cell; vertical-align: middle; width: 353px; height: 206px; }
.card .card-content { position: absolute; top: 0; left: 0; z-index: 55555; height: 206px; width: 100%; display: block; padding: 10px; text-align: center; }

@media print {
  body * {
    visibility: hidden;
  }
  .printable, .printable * {
    visibility: visible;
  }
  .printable {
    position: absolute;
    left: 0;
    top: 0;
  }
}
</style>
<script type="text/javascript">
    $('body').on('hidden.bs.modal', '.modal', function () {
      $(this).removeData('bs.modal');
    });
</script>

<!-- Modal -->
<div class="modal-dialog" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Modal Header</h4>
          </div>
            <div id="printThis" class="modal-body printable">
            
                 <div class="card">
                    <div class="front">
                        <img src="<?= base_url(); ?>assets/card.png" alt="" class="card_img">
                        <div class="card-content white-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="353px" height="206px" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <text x="5"  y="20" style="font-size:16;fill:#FFF;">
                                <!-- Usman Sher -->
                                </text>
                                <text x="185"  y="20" style="font-size:16;fill:#FFF;">
                               
                                </text>
                                <text x="5"  y="75" style="font-size:36;fill:#FFF;">
                                <?= $member->pname;?>
                                </text>
                                <text x="5"  y="105" style="font-size:16;fill:#FFF;">
                                <?= $member->borrowertype?>
                                </text>
                                <text x="5"  y="125" style="font-size:16;fill:#FFF;">
                                <?= $member->class?> <?= ($member->class != '' or !$member->section == NULL) ? $member->section : ''?>
                                </text>
                                <image xlink:href="<?= base_url() ?>assets/uploads/members/<?= $member->image; ?>" x="240" y="20" height="100" width="100" /> 

                                <image xlink:href="<?= base_url() ?>panel/books/gen_barcode/<?= $member->member_unique_id; ?>" x="110" y="50" height="230" width="230" /> 
                                <!-- <image xlink:href="<?= base_url() ?>assets/uploads/members/<?= $member->image; ?>" x="-10" y="145" height="30" width="353" />  -->
                            </svg>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    </div>
                    <div class="clearfix"></div>
                 <div class="card">

                    <div class="back">
                        <img src="<?= base_url();?>assets/card.png" alt="" class="card_img">
                        <div class="card-content">
                           <svg xmlns="http://www.w3.org/2000/svg" width="353px" height="206px" xmlns:xlink="http://www.w3.org/1999/xlink">
                                
                                <image xlink:href="<?= base_url() ?>assets/uploads/logos/<?= $profile->logo; ?>" x="60" y="0" height="180" width="180" /> 
                               <!--  <text x="5"  y="75" style="font-size:18;fill:#FFF;">
                                    <?= $profile->title;?>
                                </text> -->
                                <!-- <image xlink:href="<?= base_url() ?>assets/uploads/members/<?= $member->image; ?>" x="-10" y="145" height="30" width="353" />  -->
                            </svg>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button class="btn btn-primary" onclick="print()">Print!</button>
                <!-- <button type="button" onclick="btnPrint()" id="btnPrint" class="btn btn-primary">Print</button> -->
            </div>
        </div>
    </div>
</div>