<tr class="singleRow" data-id="<?php echo $view_data['singleModel']['id']; ?>">
    <?php if (!array_key_exists('export', $view_data)): ?>    <td><?php echo \Form::checkbox('checked[]', $view_data['singleModel']['id'], false, array('class' => 'rowToCheck')); ?></td>
    <td>
        <a class="previewLink" href="#" data-id="<?php echo $view_data['singleModel']['id']; ?>"><i class="icon-data-arrow-right"></i></a>
    </td>
    <?php endif; ?>
    <?php if ((!array_key_exists('export', $view_data)) || ((array_key_exists('export', $view_data) && in_array($view_data['export'],array('pdf','print')))) ): ?>                  
        <?php endif; ?>
                         
                                        <td><?php echo $view_data['singleModel']['id']; ?></td>
                                                                        <td><?php echo $view_data['singleModel']['merchant_id_text']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['first_name']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['last_name']; ?></td>
                                                                        <td><?php echo $view_data['singleModel']['role_id_text']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['email']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['phone']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['vehicle_id']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['card_id']; ?></td>
                                                                                 
                                        <td><?php echo $view_data['singleModel']['address']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['postal code']; ?></td>
                                                                                                                <?php if (!array_key_exists('export', $view_data)): ?>    <td>
        <a href="<?php echo \URL::route(camel_case($view_data['package'] . '_detailed_' . $view_data['controller']), array($view_data['singleModel']['id'])); ?>" title="<?php echo \Lang::get('common.view.actions.detailed.detailed'); ?>"><span class="icon-data-dashboard icon-data-2x text-primary"></span></a>
        <a href="<?php echo \URL::route(camel_case($view_data['package'] . '_post_' . $view_data['controller']), array($view_data['singleModel']['id'])); ?>" title="<?php echo \Lang::get('common.view.actions.edit.edit'); ?>"><span class="icon-data-edit icon-data-2x text-primary"></span></a>
        <a href="#" data-id="<?php echo $view_data['singleModel']['id']; ?>"  data-ids="<?php echo $view_data['singleModel']['id']; ?>" class="deleteRow" title="<?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.actions.delete.delete'); ?>"><span class="icon-data-delete icon-data-2x text-danger"></span></a>
    </td>
    <?php endif; ?></tr>
<?php if (!array_key_exists('export', $view_data)): ?>
<tr id="hiddenRow-<?php echo $view_data['singleModel']['id']; ?>" data-id="<?php echo $view_data['singleModel']['id']; ?>" class="viewRow commonDisplayNone">
    <td></td>
    <td></td>
    <td colspan="100%">
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.id') .': '.$view_data['singleModel']['id']; ?> </div>
                                                            <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.merchant_id') .': '.$view_data['singleModel']['merchant_id_text']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.first_name') .': '.$view_data['singleModel']['first_name']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.last_name') .': '.$view_data['singleModel']['last_name']; ?> </div>
                                                            <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.role_id') .': '.$view_data['singleModel']['role_id_text']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.email') .': '.$view_data['singleModel']['email']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.phone') .': '.$view_data['singleModel']['phone']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.vehicle_id') .': '.$view_data['singleModel']['vehicle_id']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.card_id') .': '.$view_data['singleModel']['card_id']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.dob') .': '.$view_data['singleModel']['dob']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.gender') .': '.$view_data['singleModel']['gender']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.lat') .': '.$view_data['singleModel']['lat']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.lng') .': '.$view_data['singleModel']['lng']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.address') .': '.$view_data['singleModel']['address']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.postal code') .': '.$view_data['singleModel']['postal code']; ?> </div>
                                                            <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.notify_sms') .': '.$view_data['singleModel']['notify_sms_text']; ?> </div>
                                                            <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.notify_email') .': '.$view_data['singleModel']['notify_email_text']; ?> </div>
                                                            <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.notify_push') .': '.$view_data['singleModel']['notify_push_text']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.device_token') .': '.$view_data['singleModel']['device_token']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.fb_uid') .': '.$view_data['singleModel']['fb_uid']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.stripe_id') .': '.$view_data['singleModel']['stripe_id']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.os') .': '.$view_data['singleModel']['os']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.app_version') .': '.$view_data['singleModel']['app_version']; ?> </div>
                
    </td>
</tr>
<?php endif; ?>