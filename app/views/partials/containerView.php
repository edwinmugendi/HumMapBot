<?php if (trim($viewData['sideBar'])): ?>
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <?php echo $viewData['sideBar']; ?>
            </div>
            <div class="col-md-10">
                <?php echo $viewData['contentView']; ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="container">
        <?php echo $viewData['contentView']; ?>
    </div>
<?php endif; ?>
<?php if ($viewData['imageable']): ?>
    <div id="viewImageModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-path="<?php echo $viewData['uploadPath']; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myLargeModalLabel"> <?php echo \Lang::get('media::media.view.original_image'); ?> </h4>
                </div>
                <div class="modal-body">
                    <img id="viewImageModalImage" class="img-responsive" >
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>