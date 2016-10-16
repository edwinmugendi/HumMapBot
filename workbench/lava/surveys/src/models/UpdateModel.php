<?php

namespace Lava\Surveys;

/**
 * S# UpdateModel() Class
 * @author Edwin Mugendi
 * Update Model
 */
class UpdateModel extends \BaseModel {

    //Table
    protected $table = 'svy_updates';
    //View fields
    public $viewFields = array(
        'id' => array(1, 'text', '='),
        'channel' => array(1, 'select', '='),
        'type' => array(1, 'select', '='),
        'update_id' => array(1, 'text', 'like', 1),
        'message' => array(1, 'text', '=', 1),
    );
    //Fillable fields
    protected $fillable = array(
        'id',
        'organization_id',
        'channel',
        'type',
        'update_id',
        'message',
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
    public $createRules = array(
        'type' => 'required',
        'channel' => 'required',
        'update_id' => 'required',
        'message' => 'required',
    );
    //Create validation rules
    public $updateRules = array(
        'type' => 'required',
        'channel' => 'required',
        'update_id' => 'required',
        'message' => 'required',
    );

    /**
     * S# getTypeTextAttribute() function
     * Get Type Text
     */
    public function getTypeTextAttribute() {
        return $this->attributes['type'] ? \Lang::get('surveys::update.data.type.' . $this->attributes['type']) : '';
    }

//E# getTypeTextAttribute() function
    
     /**
     * S# getChannelTextAttribute() function
     * Get Channel Text
     */
    public function getChannelTextAttribute() {
        return $this->attributes['channel'] ? \Lang::get('surveys::update.data.channel.' . $this->attributes['channel']) : '';
    }

//E# getChannelTextAttribute() function
}

//E# SurveyModel() Class