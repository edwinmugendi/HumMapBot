<tr class="singleRow" data-id="<?php echo '<?php echo $view_data[\'singleModel\'][\'id\']; ?>' ?>">
    <?php echo '<?php if (!array_key_exists(\'export\', $view_data)): ?>'; ?>
    <td><?php echo '<?php echo \Form::checkbox(\'checked[]\', $view_data[\'singleModel\'][\'id\'], false, array(\'class\' => \'rowToCheck\')); ?>'; ?></td>
    <td>
        <a class="previewLink" href="#" data-id="<?php echo '<?php echo $view_data[\'singleModel\'][\'id\']; ?>'; ?>"><i class="icon-data-arrow-right"></i></a>
    </td>
    <?php echo '<?php endif; ?>'; ?>

    <?php echo '<?php if ((!array_key_exists(\'export\', $view_data)) || ((array_key_exists(\'export\', $view_data) && in_array($view_data[\'export\'],array(\'pdf\',\'print\')))) ): ?>'; ?>                  
    <?php if ($imageable): ?>
        <td>
            <?php echo '<?php if (count($view_data[\'singleModel\'][\'media\'])): ?>'; ?>
            <a  title="<?php echo '<?php echo \Lang::get(\'media::media.view.view_image\'); ?>'; ?>" data-toggle="modal" href="#" data-image="<?php echo '<?php echo $view_data[\'singleModel\'][\'media\'][0][\'name\']; ?>'; ?>" class="viewImage">
                <img src="<?php echo '<?php echo $view_data[\'uploadPath\'] . \'/thumbnails/\' . $view_data[\'singleModel\'][\'media\'][0][\'name\']; ?>'; ?>">
            </a>
            <?php echo '<?php endif; ?>'; ?>
        </td>
    <?php endif; ?>
    <?php echo '<?php endif; ?>'; ?>

    <?php foreach ($fields as $field => $field_info): ?>
        <?php if ($field_info[0]): ?>
            <?php if ($field_info[1] == 'select'): ?>
                <?php $value = $field . '_text'; ?>
            <?php else: ?> 
                <?php $value = $field; ?>
            <?php endif; ?>
            <td><?php echo '<?php echo $view_data[\'singleModel\'][\'' . $value . '\']; ?>' ?></td>
        <?php endif; ?>
    <?php endforeach; ?>
    <?php echo '<?php if (!array_key_exists(\'export\', $view_data)): ?>'; ?>
    <td>
        <a href="<?php echo '<?php echo \URL::route(camel_case($view_data[\'package\'] . \'_detailed_\' . $view_data[\'controller\']), array($view_data[\'singleModel\'][\'id\'])); ?>' ?>" title="<?php echo '<?php echo \Lang::get(\'common.view.actions.detailed.detailed\'); ?>' ?>"><span class="icon-data-dashboard icon-data-2x text-primary"></span></a>
        <a href="<?php echo '<?php echo \URL::route(camel_case($view_data[\'package\'] . \'_post_\' . $view_data[\'controller\']), array($view_data[\'singleModel\'][\'id\'])); ?>' ?>" title="<?php echo '<?php echo \Lang::get(\'common.view.actions.edit.edit\'); ?>' ?>"><span class="icon-data-edit icon-data-2x text-primary"></span></a>
        <a href="#" data-id="<?php echo '<?php echo $view_data[\'singleModel\'][\'id\']; ?>' ?>"  data-ids="<?php echo '<?php echo $view_data[\'singleModel\'][\'id\']; ?>'; ?>" class="deleteRow" title="<?php echo '<?php echo \Lang::get($view_data[\'package\'] . \'::\' . $view_data[\'controller\'] . \'.view.actions.delete.delete\'); ?>'; ?>"><span class="icon-data-delete icon-data-2x text-danger"></span></a>
    </td>
    <?php echo '<?php endif; ?>'; ?>
</tr>
<?php echo '<?php if (!array_key_exists(\'export\', $view_data)): ?>'; ?>

<tr id="hiddenRow-<?php echo '<?php echo $view_data[\'singleModel\'][\'id\']; ?>' ?>" data-id="<?php echo '<?php echo $view_data[\'singleModel\'][\'id\']; ?>'; ?>" class="viewRow commonDisplayNone">
    <td></td>
    <td></td>
    <td colspan="100%">
        <?php foreach ($fields as $field => $field_info): ?>
            <?php if ($field_info[1] == 'select'): ?>
                <?php $value = $field . '_text'; ?>
            <?php else: ?> 
                <?php $value = $field; ?>
            <?php endif; ?>
            <div class="commonClearBoth"><?php echo '<?php echo \Lang::get($view_data[\'package\'] . \'::\' . $view_data[\'controller\'] . \'.view.field.' . $field . '\') .\': \'.$view_data[\'singleModel\'][\'' . $value . '\']; ?>'; ?> </div>
        <?php endforeach; ?>
        <?php if ($imageable): ?>
            <?php echo '<?php if (count($view_data[\'singleModel\'][\'media\'])): ?>'; ?>
            <div class="commonClearBoth">
                <?php echo '<?php echo \Lang::get(\'media::media.view.image\'); ?>'; ?> 
                <a  title="<?php echo '<?php echo \Lang::get(\'media::media.view.view_image\'); ?>'; ?>" data-toggle="modal" href="#" data-image="<?php echo '<?php echo $view_data[\'singleModel\'][\'media\'][0][\'name\']; ?>'; ?>" class="viewImage">
                    <img src="<?php echo '<?php echo $view_data[\'uploadPath\'] . \'/thumbnails/\' . $view_data[\'singleModel\'][\'media\'][0][\'name\']; ?>'; ?>">
                </a>   
                <a title="<?php echo '<?php echo \Lang::get(\'media::media.view.view_image\'); ?>'; ?>" data-toggle="modal" href="#" data-image="<?php echo '<?php echo $view_data[\'singleModel\'][\'media\'][0][\'name\']; ?>'; ?>" class="viewImage"><i class="icon-data-enlarge icon-data-2x text-danger"></i></a> &nbsp;
                <a title="<?php echo '<?php echo \Lang::get(\'media::media.view.download_image\'); ?>'; ?>" href="<?php echo '<?php echo URL::route(\'mediaDownload\', array(\'image\' => $view_data[\'singleModel\'][\'media\'][0][\'name\'])); ?>'; ?>" target="_blank"><i class="icon-data-download icon-data-2x text-danger"></i></a> &nbsp;
            </div>
            <?php echo '<?php endif; ?>'; ?>
        <?php endif; ?>

    </td>
</tr>
<?php echo '<?php endif; ?>'; ?>
