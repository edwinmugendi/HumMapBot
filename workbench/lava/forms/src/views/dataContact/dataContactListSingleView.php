<tr class="singleRow" data-id="<?php echo $view_data['singleModel']['id']; ?>">
    <?php if (!array_key_exists('export', $view_data)): ?>        <td>
        <a class="previewLink" href="#" data-id="<?php echo $view_data['singleModel']['id']; ?>"><i class="icon-data-arrow-right"></i></a>
    </td>
    <?php endif; ?>
    <?php if ((!array_key_exists('export', $view_data)) || ((array_key_exists('export', $view_data) && in_array($view_data['export'],array('pdf','print')))) ): ?>                  
            <td>
            <?php if ($view_data['singleModel']['image_count']): ?>            <a  title="<?php echo \Lang::get('media::media.view.view_image'); ?>" data-toggle="modal" href="#" data-url="<?php echo $view_data['singleModel']['main_url']; ?>" class="viewImage">
                <img src="<?php echo $view_data['singleModel']['thumbnail_url']; ?>">
            </a>
            <br>
            <span class="label label-success commonFloatLeft commonMarginTop5"><?php echo \Lang::choice('media::media.view.documents', $view_data['singleModel']['image_count'], array('count' => $view_data['singleModel']['image_count'])); ?></span>
            <?php endif; ?>        </td>
        <?php endif; ?>
                         
                                        <td><?php echo $view_data['singleModel']['id']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['full_name']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['age']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['height']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['lat']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['lng']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['male']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['female']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['names']; ?></td>
                                                                        <td><?php echo $view_data['singleModel']['workflow_text']; ?></td>
                                                         
                                        <td><?php echo $view_data['singleModel']['session_id']; ?></td>
                <?php if (!array_key_exists('export', $view_data)): ?>    <td>
        <a href="<?php echo \URL::route(camel_case($view_data['package'] . '_detailed_' . $view_data['controller']), array($view_data['singleModel']['id'])); ?>" title="<?php echo \Lang::get('common.view.actions.detailed.detailed'); ?>" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> <?php echo \Lang::get('common.view.actions.detailed.view'); ?></a>
            </td>
    <?php endif; ?></tr>
<?php if (!array_key_exists('export', $view_data)): ?>
<tr id="hiddenRow-<?php echo $view_data['singleModel']['id']; ?>" data-id="<?php echo $view_data['singleModel']['id']; ?>" class="viewRow commonDisplayNone">
    <td></td>
    <td></td>
    <td colspan="100%">
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.id') .': '.$view_data['singleModel']['id']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.full_name') .': '.$view_data['singleModel']['full_name']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.age') .': '.$view_data['singleModel']['age']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.height') .': '.$view_data['singleModel']['height']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.lat') .': '.$view_data['singleModel']['lat']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.lng') .': '.$view_data['singleModel']['lng']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.male') .': '.$view_data['singleModel']['male']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.female') .': '.$view_data['singleModel']['female']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.names') .': '.$view_data['singleModel']['names']; ?> </div>
                                                            <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.workflow') .': '.$view_data['singleModel']['workflow_text']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.channel_chat_id') .': '.$view_data['singleModel']['channel_chat_id']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.channel') .': '.$view_data['singleModel']['channel']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.session_id') .': '.$view_data['singleModel']['session_id']; ?> </div>
                            <?php if ($view_data['singleModel']['image_count']): ?>            <div class="commonClearBoth commonFloatLeft">
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