<?php echo '<?php'; ?>

return array(
/*
|--------------------------------------------------------------------------
| <?php echo $table_name_title = \Str::title(str_replace('_', ' ', $table_name)); ?> Language Lines
|--------------------------------------------------------------------------
*/
'data' => array(

'workflow' => array(
'complete' => 'Complete',
'incomplete' => 'Incomplete',
)
),
'view' => array(
'menu' => '<?php echo $table_name_title; ?>',
'field' => array(
'id' => '#',
'names' => 'Names',
'channel_chat_id' => 'Chat id',
'channel' => 'Channel',
'session_id' => 'Session id',
'workflow' => 'Status',
<?php foreach ($fields as $key => $type): ?>
    '<?php echo $key; ?>' => '<?php echo \Str::title(str_replace('_', ' ', $key)); ?>',
<?php endforeach; ?>
),
'actions' => array(
'delete' => array(
'confirm' => 'Delete <?php echo $table_name_title; ?>?',
'deleteMany' => 'Deleted :count <?php echo $table_name_title; ?>',
'confirmMany' => 'Delete :count <?php echo $table_name_title; ?>?',
'delete' => 'Delete',
'cancel' => 'Cancel',
),
'undelete' => array(
'undoDelete' => 'Undo delete',
'undeleting' => 'Un deleting...',
'undeleted' => 'Un deleted :count <?php echo $table_name_title; ?>',
),
),
'link' => array(
'list' => '<?php echo $table_name_title; ?> list',
'add' => 'Add <?php echo $table_name_title; ?>',
'found' => '{0} :count <?php echo $table_name_title; ?> | {1} :count <?php echo $table_name_title; ?> | [2,Inf] :count <?php echo $table_name_title; ?>',
)
),
'<?php echo $table_name_camel = camel_case($table_name); ?>DetailedPage' => array(
'title' => '<?php echo $table_name_title; ?>: :title #:id'
),
'<?php echo $table_name_camel; ?>ListPage' => array(
'title' => 'List of <?php echo $table_name_title; ?>'
),

);
