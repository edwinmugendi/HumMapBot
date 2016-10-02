<?php

namespace Lava\Forms;

/**
 * S# ContactModel() Class
 * @author Edwin Mugendi
 * Contact Model
 */
class ContactModel extends \BaseModel {

    //Table
    protected $table = 'frm_contacts';
    //View fields
    public $viewFields = array(
        'id' => array(1, 'text', '='),
        'names' => array(1, 'text', 'like', 1),
        'full_name' => array(1, 'text', 'like', 1),
        'age' => array(1, 'text', '=', 1),
        'phone' => array(1, 'text', '=', 1),
        'height' => array(1, 'text', '=', 1),
        'gender' => array(1, 'select', '='),
        'latitude' => array(1, 'text', '='),
        'longitude' => array(1, 'text', '='),
        'food_chicken' => array(1, 'select', '='),
        'food_fish' => array(1, 'select', '='),
        'session_id' => array(1, 'text', '=', 1),
        'workflow' => array(1, 'select', '='),
        'channel_chat_id' => array(0, 'text', '='),
        'channel' => array(0, 'text', '='),
    );
    //Fillable fields
    protected $fillable = array(
        'id',
        'organization_id',
        'form_id',
        'session_id',
        'full_name',
        'age',
        'phone',
        'gender',
        'height',
        'latitude',
        'longitude',
        'food_chicken',
        'food_fish',
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
     * S# getGenderTextAttribute() function
     * Get Gender Text
     */
    public function getGenderTextAttribute() {
        return $this->attributes['gender'] ? \Lang::get('surveys::question.data.gender.' . $this->attributes['gender']) : '';
    }

//E# getGenderTextAttribute() function

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

    /**
     * S# getFoodChickenTextAttribute() function
     * Get FoodChicken Text
     */
    public function getFoodChickenTextAttribute() {
        //Set icon
        $icon = ($this->attributes['food_chicken'] == 'y') ? 'glyphicon-ok commonColor' : 'glyphicon-remove commonColorRed';

        return '<i class="glyphicon ' . $icon . '"></i>';
    }

//E# getFoodChickenTextAttribute() function

    /**
     * S# getFoodFishTextAttribute() function
     * 
     * Get FoodFish Text
     * 
     */
    public function getFoodFishTextAttribute() {
        //Set icon
        $icon = ($this->attributes['food_fish'] == 'y') ? 'glyphicon-ok commonColor' : 'glyphicon-remove commonColorRed';

        return '<i class="glyphicon ' . $icon . '"></i>';
    }

//E# getFoodFishTextAttribute() function
}

//E# SurveyModel() Class