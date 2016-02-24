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
                                                                        <td><?php echo $view_data['singleModel']['merchant_id_text']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['name']; ?></td>
                                                                                    <td><?php echo $view_data['singleModel']['location_id_text']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['price_1']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['price_2']; ?></td>
                                                                        <td><?php echo $view_data['singleModel']['loyable_text']; ?></td>
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
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.name') .': '.$view_data['singleModel']['name']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.description') .': '.$view_data['singleModel']['description']; ?> </div>
                                                            <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.location_id') .': '.$view_data['singleModel']['location_id_text']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.price_1') .': '.$view_data['singleModel']['price_1']; ?> </div>
                     
                                        <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.price_2') .': '.$view_data['singleModel']['price_2']; ?> </div>
                                                            <div class="commonClearBoth"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.loyable') .': '.$view_data['singleModel']['loyable_text']; ?> </div>
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