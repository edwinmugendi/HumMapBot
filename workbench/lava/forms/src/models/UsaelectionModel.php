<?php
namespace Lava\Forms;

/**
* S# UsaelectionModel() Class
* @author Edwin Mugendi
* UsaelectionModel*/
class UsaelectionModel extends \BaseModel {

//Table
protected $table = 'frm_usaelection';
//View fields
public $viewFields = array(
'id' => array(1, 'text', '='),
    'comment' => array(1, 'text', 'like'),
    'lat' => array(1, 'text', 'like'),
    'lng' => array(1, 'text', 'like'),
'names' => array(1, 'text', 'like', 1),
'workflow' => array(1, 'select', '='),
'channel_chat_id' => array(0, 'text', '='),
'channel' => array(0, 'text', '='),
'session_id' => array(1, 'text', '='),
);
//Fillable fields
protected $fillable = array(
'id',
'organization_id',
'form_id',
'session_id',
    'comment',
    'lat',
    'lng',
'names',
'channel_chat_id',
'channel',
'workflow',
'agent',
'ip',
'status',
'created_by',
'updated_by'

);
//Appends fields
protected $appends = array(
);
//Hidden fields
protected $hidden = array();
//Create validation rules
public $createRules = array();
//Update validation rules
public $updateRules = array();

/**
* S# getWorkflowTextAttribute() function
* 
* Get Workflow Text
* 
*/
public function getWorkflowTextAttribute() {
//Set icon
$icon = ($this->attributes['workflow'] == 'complete') ? 'glyphicon-ok commonColor' : 'glyphicon-remove commonColorRed';

return '<i class="glyphicon ' . $icon . '"></i>';
}

//E# getWorkflowTextAttribute() function

}

//E# UsaelectionModel() Class