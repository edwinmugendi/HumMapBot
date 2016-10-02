<tr class="singleRow" data-id="<?php echo $view_data['singleModel']['id']; ?>">
    <?php if (!array_key_exists('export', $view_data)): ?>    <td><?php echo \Form::checkbox('checked[]', $view_data['singleModel']['id'], false, array('class' => 'rowToCheck')); ?></td>
    <td>
        <a class="previewLink" href="#" data-id="<?php echo $view_data['singleModel']['id']; ?>"><i class="icon-data-arrow-right"></i></a>
    </td>
    <?php endif; ?>
    <?php if ((!array_key_exists('export', $view_data)) || ((array_key_exists('export', $view_data) && in_array($view_data['export'],array('pdf','print')))) ): ?>                  
        <?php endif; ?>
                         
                                        <td><?php echo $view_data['singleModel']['id']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['full_name']; ?></td>
                                                                        <td><?php echo $view_data['singleModel']['form_id_text']; ?></td>
                                                                        <td><?php echo $view_data['singleModel']['channel_text']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['next_question']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['total_questions']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['channel_chat_id']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['actual_form_id']; ?></td>
                <?php if (!array_key_exists('export', $view_data)): ?>    <td>
        <a href="<?php echo \URL::route(camel_case($view_data['package'] . '_detailed_' . $view_data['controller']), array($view_data['singleModel']['id'])); ?>" title="<?php echo \Lang::get('common.view.actions.detailed.detailed'); ?>" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> <?php echo \Lang::get('common.view.actions.detailed.view'); ?></a>
        <a href="<?php echo \URL::route(camel_case($view_data['package'] . '_post_' . $view_data['controller']), array($view_data['singleModel']['id'])); ?>" title="<?php echo \Lang::get('common.view.actions.edit.edit'); ?>"  class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> <?php echo \Lang::get('common.view.actions.edit.edit'); ?></a>
        <a href="#" data-id="<?php echo $view_data['singleModel']['id']; ?>"  data-ids="<?php echo $view_data['singleModel']['id']; ?>" class="deleteRow btn btn-danger btn-xs" title="<?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.actions.delete.delete'); ?>"><i class="fa fa-trash-o"></i> <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.actions.delete.delete'); ?></a>
    </td>
    <?php endif; ?></tr>
<?php if (!array_key_exists('export', $view_data)): ?>
<tr id="hiddenRow-<?php echo $view_data['singleModel']['id']; ?>" data-id="<?php echo $view_data['singleModel']['id']; ?>" class="viewRow commonDisplayNone">
    <td></td>
    <td></td>
    <td colspan="100%">
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.id') .': '.$view_data['singleModel']['id']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.full_name') .': '.$view_data['singleModel']['full_name']; ?> </div>
                                                            <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.form_id') .': '.$view_data['singleModel']['form_id_text']; ?> </div>
                                                            <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.channel') .': '.$view_data['singleModel']['channel_text']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.next_question') .': '.$view_data['singleModel']['next_question']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.total_questions') .': '.$view_data['singleModel']['total_questions']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.channel_chat_id') .': '.$view_data['singleModel']['channel_chat_id']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.actual_form_id') .': '.$view_data['singleModel']['actual_form_id']; ?> </div>
                
    </td>
</tr>
<?php endif; ?>