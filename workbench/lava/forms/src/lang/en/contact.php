<?php
return array(
/*
|--------------------------------------------------------------------------
| Contact Language Lines
|--------------------------------------------------------------------------
*/
'data' => array(

'workflow' => array(
'complete' => 'Complete',
'incomplete' => 'Incomplete',
)
),
'view' => array(
'menu' => 'Contact',
'field' => array(
'id' => '#',
'names' => 'Names',
'channel_chat_id' => 'Chat id',
'channel' => 'Channel',
'session_id' => 'Session id',
'workflow' => 'Status',
    'full_name' => 'Full Name',
    'age' => 'Age',
    'height' => 'Height',
    'Female' => 'Female',
    'Male' => 'Male',
    'lat' => 'Lat',
    'lng' => 'Lng',
),
'actions' => array(
'delete' => array(
'confirm' => 'Delete Contact?',
'deleteMany' => 'Deleted :count Contact',
'confirmMany' => 'Delete :count Contact?',
'delete' => 'Delete',
'cancel' => 'Cancel',
),
'undelete' => array(
'undoDelete' => 'Undo delete',
'undeleting' => 'Un deleting...',
'undeleted' => 'Un deleted :count Contact',
),
),
'link' => array(
'list' => 'Contact list',
'add' => 'Add Contact',
'found' => '{0} :count Contact | {1} :count Contact | [2,Inf] :count Contact',
)
),
'contactDetailedPage' => array(
'title' => 'Contact: :title #:id'
),
'contactListPage' => array(
'title' => 'List of Contact'
),

);
