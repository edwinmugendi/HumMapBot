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
                                                                        <td><?php echo $view_data['singleModel']['workflow_text']; ?></td>
                                                                        <td><?php echo $view_data['singleModel']['merchant_id_text']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['name']; ?></td>
                                             
                                        <td><?php echo $view_data['singleModel']['phone']; ?></td>
                                                                                                                                                                     
                                        <td><?php echo $view_data['singleModel']['loyalty_stamps']; ?></td>
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
                                                            <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.workflow') .': '.$view_data['singleModel']['workflow_text']; ?> </div>
                                                            <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.merchant_id') .': '.$view_data['singleModel']['merchant_id_text']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.name') .': '.$view_data['singleModel']['name']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.about') .': '.$view_data['singleModel']['about']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.phone') .': '.$view_data['singleModel']['phone']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.email') .': '.$view_data['singleModel']['email']; ?> </div>
                                                            <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.country_id') .': '.$view_data['singleModel']['country_id_text']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.province') .': '.$view_data['singleModel']['province']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.city') .': '.$view_data['singleModel']['city']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.street') .': '.$view_data['singleModel']['street']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.postal_code') .': '.$view_data['singleModel']['postal_code']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.lat') .': '.$view_data['singleModel']['lat']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.lng') .': '.$view_data['singleModel']['lng']; ?> </div>
                                                            <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.timezone_id') .': '.$view_data['singleModel']['timezone_id_text']; ?> </div>
                                                            <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.currency_id') .': '.$view_data['singleModel']['currency_id_text']; ?> </div>
                                                            <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.date_format') .': '.$view_data['singleModel']['date_format_text']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.loyalty_stamps') .': '.$view_data['singleModel']['loyalty_stamps']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.surcharge') .': '.$view_data['singleModel']['surcharge']; ?> </div>
                                                            <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.is_monday_open') .': '.$view_data['singleModel']['is_monday_open_text']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.monday_opens_at') .': '.$view_data['singleModel']['monday_opens_at']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.monday_closes_at') .': '.$view_data['singleModel']['monday_closes_at']; ?> </div>
                                                            <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.is_tuesday_open') .': '.$view_data['singleModel']['is_tuesday_open_text']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.tuesday_opens_at') .': '.$view_data['singleModel']['tuesday_opens_at']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.tuesday_closes_at') .': '.$view_data['singleModel']['tuesday_closes_at']; ?> </div>
                                                            <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.is_wednesday_open') .': '.$view_data['singleModel']['is_wednesday_open_text']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.wednesday_opens_at') .': '.$view_data['singleModel']['wednesday_opens_at']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.wednesday_closes_at') .': '.$view_data['singleModel']['wednesday_closes_at']; ?> </div>
                                                            <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.is_thursday_open') .': '.$view_data['singleModel']['is_thursday_open_text']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.thursday_opens_at') .': '.$view_data['singleModel']['thursday_opens_at']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.thursday_closes_at') .': '.$view_data['singleModel']['thursday_closes_at']; ?> </div>
                                                            <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.is_friday_open') .': '.$view_data['singleModel']['is_friday_open_text']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.friday_opens_at') .': '.$view_data['singleModel']['friday_opens_at']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.friday_closes_at') .': '.$view_data['singleModel']['friday_closes_at']; ?> </div>
                                                            <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.is_saturday_open') .': '.$view_data['singleModel']['is_saturday_open_text']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.saturday_opens_at') .': '.$view_data['singleModel']['saturday_opens_at']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.saturday_closes_at') .': '.$view_data['singleModel']['saturday_closes_at']; ?> </div>
                                                            <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.is_sunday_open') .': '.$view_data['singleModel']['is_sunday_open_text']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.sunday_opens_at') .': '.$view_data['singleModel']['sunday_opens_at']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.sunday_closes_at') .': '.$view_data['singleModel']['sunday_closes_at']; ?> </div>
                                                            <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.is_holiday_open') .': '.$view_data['singleModel']['is_holiday_open_text']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.holiday_opens_at') .': '.$view_data['singleModel']['holiday_opens_at']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.holiday_closes_at') .': '.$view_data['singleModel']['holiday_closes_at']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.website') .': '.$view_data['singleModel']['website']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.facebook') .': '.$view_data['singleModel']['facebook']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.twitter') .': '.$view_data['singleModel']['twitter']; ?> </div>
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