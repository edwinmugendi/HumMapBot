<div id="idOptionModal"class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.modal_heading'); ?></h4>
            </div>
            <div class="modal-body">
                <?php echo \Form::hidden('option_question_id', '', array('id' => 'idOptionQuestionId')); ?>
                <?php echo \Form::hidden('option_form_id', $view_data['controller_model']['id'], array('id' => 'idOptionFormId')); ?>
                <div id="idOptionContainer" class="container">
                </div>
            </div>
            <div class="modal-footer">
                <button id="idOptionSave" type="button" class="btn btn-primary pull-left"><?php echo \Lang::get('common.save'); ?></button>
                <button data-dismiss="modal" type="button" class="btn btn-default pull-right"><?php echo \Lang::get('common.cancel'); ?></button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->