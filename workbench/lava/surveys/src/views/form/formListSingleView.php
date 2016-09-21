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
            <span class="label label-success commonFloatLeft commonMarginTop5"><?php echo \Lang::choice('media::media.view.documents', $view_data['singleModel']['image_count'], array('count' => $view_data['singleModel']['image_count'])); ?></span>
            <?php endif; ?>        </td>
        <?php endif; ?>
                         
                                        <td><?php echo $view_data['singleModel']['id']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['name']; ?></td>
                                                                        <td><?php echo $view_data['singleModel']['workflow_text']; ?></td>
                <?php if (!array_key_exists('export', $view_data)): ?>    <td>
        <a href="<?php echo \URL::route(camel_case($view_data['package'] . '_question_' . $view_data['controller']), array($view_data['singleModel']['id'])); ?>" title="<?php echo \Lang::get($view_data['package'].'::'.$view_data['controller'].'.view.actions.edit_questions.edit_questions'); ?>" class="btn btn-warning btn-xs"><i class="fa fa-question"></i> <?php echo \Lang::get($view_data['package'].'::'.$view_data['controller'].'.view.actions.edit_questions.edit_questions'); ?></a>
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
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.name') .': '.$view_data['singleModel']['name']; ?> </div>
                                                            <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.workflow') .': '.$view_data['singleModel']['workflow_text']; ?> </div>
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