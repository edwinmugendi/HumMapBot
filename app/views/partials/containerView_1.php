<?php if (trim($view_data['sideBar'])): ?>
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <?php echo $view_data['sideBar']; ?>
            </div>
            <div class="col-md-10">
                <?php echo $view_data['contentView']; ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="container">
        <?php echo $view_data['contentView']; ?>
    </div>
<?php endif; ?>
<?php if ($view_data['imageable']): ?>
    <div id="viewImageModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-path="<?php echo $view_data['uploadPath']; ?>">
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