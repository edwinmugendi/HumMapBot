<div class="x_panel">
    <div class="row">
        <div class="col-md-12">
            <h1><?php echo $view_data['controller_model']['name']; ?></h1>
            <hr>
            </div>
        </div>
    <h4 class="commonFontWeightBold">List of questions</h4>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered table-condensed table-hover table-striped table-hover">
                <thead>
                    <tr>
                        <td>#</td>
                        <td><?php echo \Lang::get($view_data['package'] . '::question.view.field.title'); ?></td>
                        <td><?php echo \Lang::get($view_data['package'] . '::question.view.field.name'); ?></td>
                        <td><?php echo \Lang::get($view_data['package'] . '::question.view.field.type'); ?></td>
                        <td><?php echo \Lang::get($view_data['package'] . '::question.view.field.error_message'); ?></td>
                        <td><?php echo \Lang::get('common.view.actions.actions'); ?></td>
                    </tr>
                </thead> 
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td><?php echo \Form::text('titles[]', '', array('placeholder' => \Lang::get($view_data['package'] . '::question.view.field.title'))) ?></td>
                        <td><?php echo \Form::text('names[]', '', array('placeholder' => \Lang::get($view_data['package'] . '::question.view.field.name'))) ?></td>
                        <td><?php echo \Form::compositeSelect('titles[]', array('' => 'Select'), '', array('class' => 'form-control')); ?></td>
                        <td><?php echo \Form::text('error_messages[]', '', array('placeholder' => \Lang::get($view_data['package'] . '::question.view.field.error_message'))) ?></td>
                        <td><a href="#"><i class="fa fa-trash fa-2x commonColorRed"></i></a></td>
                        </tr>
                    <tr>
                        <td>2</td>
                        <td><?php echo \Form::text('titles[]', '', array('placeholder' => \Lang::get($view_data['package'] . '::question.view.field.title'))) ?></td>
                        <td><?php echo \Form::text('names[]', '', array('placeholder' => \Lang::get($view_data['package'] . '::question.view.field.name'))) ?></td>
                        <td><?php echo \Form::compositeSelect('titles[]', array('' => 'Select'), '', array('class' => 'form-control')); ?></td>
                        <td><?php echo \Form::text('error_messages[]', '', array('placeholder' => \Lang::get($view_data['package'] . '::question.view.field.error_message'))) ?></td>
                        <td><a href="#"><i class="fa fa-trash fa-2x commonColorRed"></i></a></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td><?php echo \Form::text('titles[]', '', array('placeholder' => \Lang::get($view_data['package'] . '::question.view.field.title'))) ?></td>
                        <td><?php echo \Form::text('names[]', '', array('placeholder' => \Lang::get($view_data['package'] . '::question.view.field.name'))) ?></td>
                        <td><?php echo \Form::compositeSelect('titles[]', array('' => 'Select'), '', array('class' => 'form-control')); ?></td>
                        <td><?php echo \Form::text('error_messages[]', '', array('placeholder' => \Lang::get($view_data['package'] . '::question.view.field.error_message'))) ?></td>
                        <td><a href="#"><i class="fa fa-trash fa-2x commonColorRed"></i></a></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td><?php echo \Form::text('titles[]', '', array('placeholder' => \Lang::get($view_data['package'] . '::question.view.field.title'))) ?></td>
                        <td><?php echo \Form::text('names[]', '', array('placeholder' => \Lang::get($view_data['package'] . '::question.view.field.name'))) ?></td>
                        <td><?php echo \Form::compositeSelect('titles[]', array('' => 'Select'), '', array('class' => 'form-control')); ?></td>
                        <td><?php echo \Form::text('error_messages[]', '', array('placeholder' => \Lang::get($view_data['package'] . '::question.view.field.error_message'))) ?></td>
                        <td><a href="#"><i class="fa fa-trash fa-2x commonColorRed"></i></a></td>
                    </tr>
                </tbody>
                </table>    
            </div>
        </div>
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-warning"><i class="fa fa-plus"></i>&nbsp;<?php echo \Lang::get($view_data['package'] . '::question.view.link.add'); ?></button>
                    </div>
                </div>
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-primary"><?php echo \Lang::get('common.save'); ?></button>
            </div>
            </div>
</div>
