<?php

namespace Lava\Accounts;

/**
 * S# ChatModel() Class
 * @author Edwin Mugendi
 * Chat Model
 */
class ChatModel extends \BaseModel {

    //Table
    protected $table = 'acc_chats';
    //View fields
    public $viewFields = array(
        'id' => array(1, 'text', '=', 1),
        'user_id' => array(1, 'select', '=', 1),
        'sender_id' => array(1, 'select', '=', 1),
        'recipient_id' => array(1, 'select', '=', 1),
        'message' => array(1, 'text', '=', 1),
        'in_out' => array(1, 'select', '=', 0),
        'workflow' => array(1, 'select', '=', 0),
    );
    //Fillable fields
    protected $fillable = array(
        'organization_id',
        'user_id',
        'sender_id',
        'recipient_id',
        'message',
        'in_out',
        'workflow',
        'agent',
        'ip',
        'status',
        'created_by',
        'updated_by',
    );
    protected $hidden = array();
    //Create validation rules
    public $createRules = array();
    //Create update rules
    public $updateRules = array();

    /**
     * S# getWorkflowTextAttribute() function
     * 
     * Get Workflow Text
     */
    public function getWorkflowTextAttribute() {
        return $this->attributes['workflow'] ? \Lang::get('accounts::chat.data.workflow.' . $this->attributes['workflow']) : '';
    }

//E# getWorkflowTextAttribute() function

    /**
     * S# getInOutTextAttribute() function
     * 
     * Get InOut Text
     */
    public function getInOutTextAttribute() {
        return $this->attributes['in_out'] ? \Lang::get('accounts::chat.data.in_out.' . $this->attributes['in_out']) : '';
    }

//E# getInOutTextAttribute() function
    
    /**
     * S# sender() function
     * Set one to one relationship to Sender Model
     */
    public function sender() {
        return $this->belongsTo(\Util::buildNamespace('accounts', 'user', 2), 'sender_id', 'id');
    }

//E# sender() function

    /**
     * S# getSenderIdTextAttribute() function
     * 
     * Get Sender Text
     */
    public function getSenderIdTextAttribute() {

        //Get sender model
        $sender_model = $this->sender()->first();

        //Return name
        return $sender_model->full_name;
    }

//E# getSenderIdTextAttribute() function

    /**
     * S# recipient() function
     * Set one to one relationship to Recipient Model
     */
    public function recipient() {
        return $this->belongsTo(\Util::buildNamespace('accounts', 'user', 2), 'recipient_id', 'id');
    }

//E# recipient() function

    /**
     * S# getRecipientIdTextAttribute() function
     * 
     * Get Recipient Text
     */
    public function getRecipientIdTextAttribute() {

        //Get recipient model
        $recipient_model = $this->recipient()->first();

        //Return name
        return $recipient_model->full_name;
    }

//E# getRecipientIdTextAttribute() function
}

//E# ChatModel() Class