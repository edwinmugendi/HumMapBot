<tr class="singleRow" data-id="<?php echo $view_data['singleModel']['id']; ?>">
    <?php if (!array_key_exists('export', $view_data)): ?>    <td><?php echo \Form::checkbox('checked[]', $view_data['singleModel']['id'], false, array('class' => 'rowToCheck')); ?></td>
    <td>
        <a class="previewLink" href="#" data-id="<?php echo $view_data['singleModel']['id']; ?>"><i class="icon-data-arrow-right"></i></a>
    </td>
    <?php endif; ?>
    <?php if ((!array_key_exists('export', $view_data)) || ((array_key_exists('export', $view_data) && in_array($view_data['export'],array('pdf','print')))) ): ?>                  
            <td>
            <?php if ($view_data['singleModel']['image_count']): ?>            <a  title="<?php echo \Lang::get('media::media.view.view_image'); ?>" data-toggle="modal" href="#" data-url="<?php echo $view_data['singleModel']['main_url']; ?>" class="viewImage">
                <img src="<?php echo $view_data['singleModel']['thumbnail_url']; ?>">
            </a>
            <br>
            <span class="label label-success"><?php echo \Lang::choice('media::media.view.documents', $view_data['singleModel']['image_count'], array('count' => $view_data['singleModel']['image_count'])); ?></span>
            <?php endif; ?>        </td>
        <?php endif; ?>
                         
                                        <td><?php echo $view_data['singleModel']['id']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['name']; ?></td>
                                                                        <td><?php echo $view_data['singleModel']['workflow_text']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['reg_no']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['tax_id']; ?></td>
                                                                     
                                        <td><?php echo $view_data['singleModel']['phone']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['email']; ?></td>
                                                                        <td><?php echo $view_data['singleModel']['country_id_text']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['province']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['city']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['street']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['postal_code']; ?></td>
                                                                        <td><?php echo $view_data['singleModel']['timezone_id_text']; ?></td>
                                                                        <td><?php echo $view_data['singleModel']['currency_id_text']; ?></td>
                                                                        <td><?php echo $view_data['singleModel']['date_format_text']; ?></td>
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
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.name') .': '.$view_data['singleModel']['name']; ?> </div>
                                                            <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.workflow') .': '.$view_data['singleModel']['workflow_text']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.reg_no') .': '.$view_data['singleModel']['reg_no']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.tax_id') .': '.$view_data['singleModel']['tax_id']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.vision') .': '.$view_data['singleModel']['vision']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.mission') .': '.$view_data['singleModel']['mission']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.about') .': '.$view_data['singleModel']['about']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.phone') .': '.$view_data['singleModel']['phone']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.email') .': '.$view_data['singleModel']['email']; ?> </div>
                                                            <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.country_id') .': '.$view_data['singleModel']['country_id_text']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.province') .': '.$view_data['singleModel']['province']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.city') .': '.$view_data['singleModel']['city']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.street') .': '.$view_data['singleModel']['street']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.postal_code') .': '.$view_data['singleModel']['postal_code']; ?> </div>
                                                            <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.timezone_id') .': '.$view_data['singleModel']['timezone_id_text']; ?> </div>
                                                            <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.currency_id') .': '.$view_data['singleModel']['currency_id_text']; ?> </div>
                                                            <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.date_format') .': '.$view_data['singleModel']['date_format_text']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.website') .': '.$view_data['singleModel']['website']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.facebook') .': '.$view_data['singleModel']['facebook']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.twitter') .': '.$view_data['singleModel']['twitter']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.bank_name') .': '.$view_data['singleModel']['bank_name']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.bank_sort_code') .': '.$view_data['singleModel']['bank_sort_code']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.bank_account_name') .': '.$view_data['singleModel']['bank_account_name']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.bank_account_number') .': '.$view_data['singleModel']['bank_account_number']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.bank_postal_code') .': '.$view_data['singleModel']['bank_postal_code']; ?> </div>
                            <?php if ($view_data['singleModel']['image_count']): ?>            <div class="commonClearBoth">
                <?php echo \Lang::get('media::media.view.image'); ?> 
                <a  title="<?php echo \Lang::get('media::media.view.view_image'); ?>" data-toggle="modal" href="#" data-url="<?php echo $view_data['singleModel']['main_url']; ?>" class="viewImage">
                    <img src="<?php echo $view_data['singleModel']['thumbnail_url']; ?>">
                </a>   
                <a title="<?php echo \Lang::get('media::media.view.view_image'); ?>" data-toggle="modal" href="#" data-image="<?php echo $view_data['singleModel']['media'][0]['name']; ?>" class="viewImage"><i class="icon-data-enlarge icon-data-2x text-danger"></i></a> &nbsp;
                <a title="<?php echo \Lang::get('media::media.view.download_image'); ?>" href="<?php echo URL::route('mediaDownload', array('image' => $view_data['singleModel']['media'][0]['name'])); ?>" target="_blank"><i class="icon-data-download icon-data-2x text-danger"></i></a> &nbsp;
            </div>
            <?php endif; ?>        
    </td>
</tr>
<?php endif; ?>