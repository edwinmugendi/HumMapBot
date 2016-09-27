<tr class="rowQuestion">
    <td class="questionNumber"><?php echo array_key_exists('single_index', $view_data) ? $view_data['single_index'] : 1; ?></td>
    <td>
        <?php echo \Form::text('question_ids[]', array_key_exists('single_question_id', $view_data) ? $view_data['single_question_id'] : ''); ?>
        <?php echo \Form::text('titles[]', array_key_exists('single_title', $view_data) ? $view_data['single_title'] : '', array('class' => 'validate[required]', 'placeholder' => \Lang::get($view_data['package'] . '::question.view.field.title'))); ?></td>
    <td><?php echo \Form::text('names[]', array_key_exists('single_name', $view_data) ? $view_data['single_name'] : '', array('class' => 'validate[required]', 'placeholder' => \Lang::get($view_data['package'] . '::question.view.field.name'))); ?></td>
    <td><?php echo \Form::compositeSelect('types[]', $view_data['dataSource']['type'], array_key_exists('single_type', $view_data) ? $view_data['single_type'] : '', array('class' => 'form-control validate[required]')); ?></td>
    <td><?php echo \Form::text('error_messages[]', array_key_exists('single_error_message', $view_data) ? $view_data['single_error_message'] : '', array('class' => 'validate[required]', 'placeholder' => \Lang::get($view_data['package'] . '::question.view.field.error_message'))); ?></td>
    <td><a href="#"><i class="fa fa-trash fa-2x commonColorRed deleteQuestion"></i></a></td>
</tr>