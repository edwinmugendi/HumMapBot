<tr class="singleRow" data-id="<?php echo $view_data['singleModel']['id']; ?>">
    <?php if (!array_key_exists('export', $view_data)): ?>    <td><?php echo \Form::checkbox('checked[]', $view_data['singleModel']['id'], false, array('class' => 'rowToCheck')); ?></td>
    <td>
        <a class="previewLink" href="#" data-id="<?php echo $view_data['singleModel']['id']; ?>"><i class="icon-data-arrow-right"></i></a>
    </td>
    <?php endif; ?>
    <?php if ((!array_key_exists('export', $view_data)) || ((array_key_exists('export', $view_data) && in_array($view_data['export'],array('pdf','print')))) ): ?>                  
        <?php endif; ?>
                         
                                        <td><?php echo $view_data['singleModel']['id']; ?></td>
                                                                        <td><?php echo $view_data['singleModel']['referrer_id_text']; ?></td>
                                                                        <td><?php echo $view_data['singleModel']['referee_id_text']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['referral_code']; ?></td>
                                                                        <td><?php echo $view_data['singleModel']['workflow_text']; ?></td>
                                                                        <td><?php echo $view_data['singleModel']['promotion_id_text']; ?></td>
                <?php if (!array_key_exists('export', $view_data)): ?>    <td>
        <a href="<?php echo \URL::route(camel_case($view_data['package'] . '_detailed_' . $view_data['controller']), array($view_data['singleModel']['id'])); ?>" title="<?php echo \Lang::get('common.view.actions.detailed.detailed'); ?>"><span class="icon-data-dashboard icon-data-2x text-primary"></span></a>
    </td>
    <?php endif; ?></tr>
<?php if (!array_key_exists('export', $view_data)): ?>
<tr id="hiddenRow-<?php echo $view_data['singleModel']['id']; ?>" data-id="<?php echo $view_data['singleModel']['id']; ?>" class="viewRow commonDisplayNone">
    <td></td>
    <td></td>
    <td colspan="100%">
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.id') .': '.$view_data['singleModel']['id']; ?> </div>
                                                            <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.referrer_id') .': '.$view_data['singleModel']['referrer_id_text']; ?> </div>
                                                            <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.referee_id') .': '.$view_data['singleModel']['referee_id_text']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.referral_code') .': '.$view_data['singleModel']['referral_code']; ?> </div>
                                                            <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.workflow') .': '.$view_data['singleModel']['workflow_text']; ?> </div>
                                                            <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.promotion_id') .': '.$view_data['singleModel']['promotion_id_text']; ?> </div>
                
    </td>
</tr>
<?php endif; ?>