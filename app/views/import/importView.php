<div id="idImportModal"class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . camel_case($view_data['controller'] . '_ImportPage') . '.title'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="container">
                    <?php echo \Form::hidden('package', $view_data['package'], array('id' => 'idImportPackage')); ?>
                    <?php echo \Form::hidden('controller', $view_data['controller'], array('id' => 'idImportController')); ?>
                    <div class="row bs-wizard" style="border-bottom:0;">
                        <div id="idStep1Indicator" class="col-md-4 bs-wizard-step active">
                            <div class="text-center bs-wizard-stepnum">1. <?php echo \Lang::get('common.importView.upload'); ?></div>
                            <div class="progress"><div class="progress-bar"></div></div>
                            <a href="#" class="bs-wizard-dot" data-toggle="collapse" href="#step-pane" aria-expanded="false"><span class="glyphicon" aria-hidden="true"></span></a>
                        </div>
                        <div  id="idStep2Indicator" class="col-md-4 bs-wizard-step disabled"><!-- active -->
                            <div class="text-center bs-wizard-stepnum">2. <?php echo \Lang::get('common.importView.map_data'); ?></div>
                            <div class="progress"><div class="progress-bar"></div></div>
                            <a href="#" class="bs-wizard-dot"><span class="glyphicon" aria-hidden="true"></span></a>
                        </div>
                        <div  id="idStep3Indicator" class="col-md-4 bs-wizard-step disabled"><!-- disabled -->
                            <div class="text-center bs-wizard-stepnum">3. <?php echo \Lang::get('common.importView.import'); ?></div>
                            <div class="progress"><div class="progress-bar"></div></div>
                            <a href="#" class="bs-wizard-dot"><span class="glyphicon" aria-hidden="true"></span></a>
                        </div>
                    </div>
                    <p id="idImportError" class="text text-danger" data-select-file="<?php echo \Lang::get('common.importView.select_file'); ?>"></p>
                    <div id="idImportContainer">
                        <?php echo $view_data['stepView']; ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" type="button" id="idCancelButton" class="btn btn-primary pull-left"><?php echo \Lang::get('common.importView.cancel'); ?></button>
                <button type="button" id="idBackButton" class="btn btn-primary pull-left commonDisplayNone" data-step="1" data-direction="back"><?php echo \Lang::get('common.importView.back'); ?></button>
                <button type="button" id="idNextButton" class="btn btn-primary" data-step="2" data-direction="next" data-import="<?php echo \Lang::get('common.importView.import'); ?>" data-next="<?php echo \Lang::get('common.importView.next'); ?>"><?php echo \Lang::get('common.importView.next'); ?></button>
                <button type="button" id="idImportValidOnesButton" data-step="3" class="btn btn-primary commonDisplayNone"><?php echo \Lang::get('common.importView.import_valid_ones'); ?></button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->