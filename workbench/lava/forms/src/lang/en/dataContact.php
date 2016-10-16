<?php
return array(
/*
|--------------------------------------------------------------------------
| Data Contact Language Lines
|--------------------------------------------------------------------------
*/
'data' => array(

'workflow' => array(
'y' => 'Yes',
'n' => 'No',
)
),
'view' => array(
'menu' => 'Data Contact',
'field' => array(
'id' => '#',
'names' => 'Names',
'channel_chat_id' => 'Chat id',
'channel' => 'Channel',
'session_id' => 'Session id',
'workflow' => 'Status',
    'full_name' => 'full name',
    'age' => 'age',
    'height' => 'height',
    'gender' => 'gender',
    'latitude' => 'latitude',
    'longitude' => 'longitude',
),
'actions' => array(
'delete' => array(
'confirm' => 'Delete Data Contact?',
'deleteMany' => 'Deleted :count Data Contact',
'confirmMany' => 'Delete :count Data Contact?',
'delete' => 'Delete',
'cancel' => 'Cancel',
),
'undelete' => array(
'undoDelete' => 'Undo delete',
'undeleting' => 'Un deleting...',
'undeleted' => 'Un deleted :count Data Contact',
),
),
'link' => array(
'list' => 'Data Contact list',
'add' => 'Add Data Contact',
'found' => '{0} :count Data Contact | {1} :count Data Contact | [2,Inf] :count Data Contact',
)
),
'dataContactDetailedPage' => array(
'title' => 'Data Contact: :title #:id'
),
'dataContactListPage' => array(
'title' => 'List of Data Contact'
),

);
