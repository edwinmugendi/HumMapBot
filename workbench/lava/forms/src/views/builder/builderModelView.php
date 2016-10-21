<?php echo '<?php'; ?>

namespace Lava\Forms;

/**
* S# <?php echo $model_name; ?>() Class
* @author Edwin Mugendi
* <?php echo $model_name; ?>
*/
class <?php echo $model_name; ?> extends \BaseModel {

//Table
protected $table = 'frm_<?php echo str_replace(' ', '_', \Str::lower($table_name)); ?>';
//View fields
public $viewFields = array(
'id' => array(1, 'text', '='),
<?php $index = 0; ?>
<?php foreach ($fields as $key => $type): ?>
    '<?php echo $key; ?>' => array(1, 'text', 'like'),
<?php endforeach; ?>
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
<?php foreach ($fields as $key => $type): ?>
    '<?php echo $key; ?>',
<?php endforeach; ?>
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

//E# <?php echo $model_name; ?>() Class