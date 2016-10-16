<?php
return array(
/*
|--------------------------------------------------------------------------
| Testing Language Lines
|--------------------------------------------------------------------------
*/
'data' => array(

'workflow' => array(
'y' => 'Yes',
'n' => 'No',
)
),
'view' => array(
'menu' => 'Testing',
'field' => array(
'id' => '#',
'names' => 'Names',
'channel_chat_id' => 'Chat id',
'channel' => 'Channel',
'session_id' => 'Session id',
'workflow' => 'Status',
),
'actions' => array(
'delete' => array(
'confirm' => 'Delete Testing?',
'deleteMany' => 'Deleted :count Testing',
'confirmMany' => 'Delete :count Testing?',
'delete' => 'Delete',
'cancel' => 'Cancel',
),
'undelete' => array(
'undoDelete' => 'Undo delete',
'undeleting' => 'Un deleting...',
'undeleted' => 'Un deleted :count Testing',
),
),
'link' => array(
'list' => 'Testing list',
'add' => 'Add Testing',
'found' => '{0} :count Testing | {1} :count Testing | [2,Inf] :count Testing',
)
),
'testingDetailedPage' => array(
'title' => 'Testing: :title #:id'
),
'testingListPage' => array(
'title' => 'List of Testing'
),

);
