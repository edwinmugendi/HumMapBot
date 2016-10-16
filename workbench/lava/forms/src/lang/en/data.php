<?php
return array(
/*
|--------------------------------------------------------------------------
| Data Language Lines
|--------------------------------------------------------------------------
*/
'data' => array(

'workflow' => array(
'y' => 'Yes',
'n' => 'No',
)
),
'view' => array(
'menu' => 'Data',
'field' => array(
'id' => '#',
'names' => 'Names',
'channel_chat_id' => 'Chat id',
'channel' => 'Channel',
'session_id' => 'Session id',
    'full_name' => 'full name',
    'age' => 'age',
    'height' => 'height',
    'gender' => 'gender',
    'latitude' => 'latitude',
    'longitude' => 'longitude',
),
'actions' => array(
'delete' => array(
'confirm' => 'Delete Data?',
'deleteMany' => 'Deleted :count Data',
'confirmMany' => 'Delete :count Data?',
'delete' => 'Delete',
'cancel' => 'Cancel',
),
'undelete' => array(
'undoDelete' => 'Undo delete',
'undeleting' => 'Un deleting...',
'undeleted' => 'Un deleted :count Data',
),
),
'link' => array(
'list' => 'Data list',
'add' => 'Add Data',
'found' => '{0} :count Data | {1} :count Data | [2,Inf] :count Data',
)
),
'dataDetailedPage' => array(
'title' => 'Data: :title #:id'
),
'dataListPage' => array(
'title' => 'List of Data'
),

);
