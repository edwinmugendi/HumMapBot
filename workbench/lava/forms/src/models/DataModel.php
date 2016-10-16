<?php
namespace Lava\Forms;

/**
* S# DataModel() Class
* @author Edwin Mugendi
* DataModel*/
class DataModel extends \BaseModel {

//Table
protected $table = 'frm_data';
//View fields
public $viewFields = array(
'id' => array(1, 'text', '='),
    'full_name' => array(1, 'text', 'like'),
    'age' => array(1, 'text', 'like'),
    'height' => array(1, 'text', 'like'),
    'gender' => array(1, 'text', 'like'),
    'latitude' => array(1, 'text', 'like'),
    'longitude' => array(1, 'text', 'like'),
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
    'full_name',
    'age',
    'height',
    'gender',
    'latitude',
    'longitude',
'names',
'channel_chat_id',
'channel',
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
$icon = ($this->attributes['workflow'] == 'y') ? 'glyphicon-ok commonColor' : 'glyphicon-remove commonColorRed';

return '<i class="glyphicon ' . $icon . '"></i>';
}

//E# getWorkflowTextAttribute() function

}

//E# DataModel() Class