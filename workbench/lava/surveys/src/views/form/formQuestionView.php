<div id="questionView" class="x_panel">
    <div class="row">
        <div class="col-md-12">
            <h1><?php echo $view_data['controller_model']['name']; ?></h1>
            <hr>
        </div>
    </div>
    <?php echo \Form::open(array('route' => 'surveysPostFormQuestion', 'method' => 'post')); ?>
    <?php echo \Form::hidden('form_id', $view_data['controller_model']['id']); ?>
    <h4 class="commonFontWeightBold"><?php echo \Lang::get($view_data['package'] . '::question.view.questions_list'); ?></h4>
    <div class="row">
        <div class="col-md-12">
            <table id="idHiddenTable" class="commonDisplayNone">
                <tr class="rowQuestion">
                    <td class="questionNumber">1</td>
                    <td>
                        <?php echo \Form::text('question_ids[]'); ?>
                        <?php echo \Form::text('titles[]', '', array('class' => 'validate[required]', 'placeholder' => \Lang::get($view_data['package'] . '::question.view.field.title'))); ?></td>
                    <td><?php echo \Form::text('names[]', '', array('class' => 'validate[required]', 'placeholder' => \Lang::get($view_data['package'] . '::question.view.field.name'))); ?></td>
                    <td><?php echo \Form::compositeSelect('types[]', $view_data['dataSource']['type'], '', array('class' => 'form-control validate[required]')); ?></td>
                    <td><?php echo \Form::text('error_messages[]', '', array('class' => 'validate[required]', 'placeholder' => \Lang::get($view_data['package'] . '::question.view.field.error_message'))); ?></td>
                    <td><a href="#"><i class="fa fa-trash fa-2x commonColorRed deleteQuestion"></i></a></td>
                </tr>
            </table>
            <table id="tableQuestion" class="table table-bordered table-condensed table-hover table-striped table-hover">
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

                </tbody>
            </table>    
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button id="idAddQuestion" class="btn btn-warning"><i class="fa fa-plus"></i>&nbsp;<?php echo \Lang::get($view_data['package'] . '::question.view.link.add'); ?></button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-primary"><?php echo \Lang::get('common.save'); ?></button>
        </div>
    </div>
    <?php echo \Form::close(); ?>
</div>
