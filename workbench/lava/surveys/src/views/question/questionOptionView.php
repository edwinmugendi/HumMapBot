<div class="row">
    <div class="col-md-12">
        <table id="idOptionHiddenTable" class="commonDisplayNone">
            <tr class="rowOption">
                <td class="optionNumber">1</td>
                <td>
                    <?php echo \Form::hidden('option_ids[]', '', array('class' => 'classOptionIds')); ?>
                    <?php echo \Form::text('option_titles[]', '', array('class' => 'classOptionTitles validate[required]', 'placeholder' => \Lang::get($view_data['package'] . '::question.view.field.title'))); ?></td>
                <td><a href="#"><i class="fa fa-trash fa-2x commonColorRed deleteOption"></i></a></td>
            </tr>
        </table>
        <table id="tableOption" class="table table-bordered table-condensed table-hover table-striped table-hover">
            <thead>
                <tr>
                    <td>#</td>
                    <td><?php echo \Lang::get($view_data['package'] . '::option.view.field.title'); ?></td>
                    <td><?php echo \Lang::get('common.view.actions.actions'); ?></td>
                </tr>
            </thead> 
            <tbody>
                <?php echo $view_data['singleOption']; ?>
            </tbody>
        </table>    
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <button id="idAddOption" class="btn btn-warning"><i class="fa fa-plus"></i>&nbsp;<?php echo \Lang::get($view_data['package'] . '::option.view.link.add'); ?></button>
    </div>
</div>
