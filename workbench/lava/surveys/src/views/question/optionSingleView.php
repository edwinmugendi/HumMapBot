<tr class="rowOption">
    <td class="optionNumber"><?php echo array_key_exists('single_index', $view_data) ? $view_data['single_index'] : 1; ?></td>
    <td>
        <?php echo \Form::hidden('option_ids[]', array_key_exists('single_option_id', $view_data) ? $view_data['single_option_id'] : '', array('class' => 'classOptionIds')); ?>
        <?php echo \Form::text('option_titles[]', array_key_exists('single_title', $view_data) ? $view_data['single_title'] : '', array('class' => 'classOptionTitles validate[required]', 'placeholder' => \Lang::get($view_data['package'] . '::option.view.field.title'))); ?></td>
    <td><a href="#"><i class="fa fa-trash fa-2x commonColorRed deleteOption"></i></a></td>
</tr>