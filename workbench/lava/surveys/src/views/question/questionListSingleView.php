<tr class="singleRow" data-id="<?php echo $view_data['singleModel']['id']; ?>">
    <?php if (!array_key_exists('export', $view_data)): ?>            <td><?php echo \Form::checkbox('checked[]', $view_data['singleModel']['id'], false, array('class' => 'rowToCheck')); ?></td>
        <td>
        <a class="previewLink" href="#" data-id="<?php echo $view_data['singleModel']['id']; ?>"><i class="icon-data-arrow-right"></i></a>
    </td>
    <?php endif; ?>
    <?php if ((!array_key_exists('export', $view_data)) || ((array_key_exists('export', $view_data) && in_array($view_data['export'],array('pdf','print')))) ): ?>                  
        <?php endif; ?>
                         
                                        <td><?php echo $view_data['singleModel']['id']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['title']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['name']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['regex']; ?></td>
                                                                        <td><?php echo $view_data['singleModel']['type_text']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['error_message']; ?></td>
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
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.title') .': '.$view_data['singleModel']['title']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.name') .': '.$view_data['singleModel']['name']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.regex') .': '.$view_data['singleModel']['regex']; ?> </div>
                                                            <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.type') .': '.$view_data['singleModel']['type_text']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.error_message') .': '.$view_data['singleModel']['error_message']; ?> </div>
                
    </td>
</tr>
<?php endif; ?>