<?php

namespace Lava\Messages;

/**
 * S# MessageModel() Class
 * @author Edwin Mugendi
 * Message Model
 */
class MessageModel extends \Eloquent {

    //Table
    protected $table = 'msg_messages';
    //Fillable fields
    protected $fillable = array(
        'type',
        'code',
        'body',
        'sender_id',
        'sender',
        'recipient_id',
        'recipient',
        'sent',
        'status',
        'created_by',
        'updated_by'
    );
    protected $hidden = array(
        'status',
        'created_by',
        'updated_by',
        'deleted_at'
    );
    //Create validation rules
    public $createRules = array(
        'status' => 'required|integer',
        'created_by' => 'required|integer',
        'updated_by' => 'required|integer',
    );

}

//E# MessageModel() Class