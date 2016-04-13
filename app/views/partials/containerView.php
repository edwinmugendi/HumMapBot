<div class="right_col" role="main">
    <?php echo $view_data['contentView']; ?>
    <br />
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
    
    <!--footer content-->
    <footer>
        <div class="copyright-info">
            <p class="pull-right"><?php echo \Config::get('product.name');?></p>
        </div>
        <div class="clearfix"></div>
    </footer>
    <!-- /footer content -->
</div>