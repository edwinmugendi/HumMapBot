<?php

namespace Lava\Surveys;

/**
 * S# TelegramController() function
 * Telegram controller
 * @author Edwin Mugendi
 */
class TelegramController extends SurveysBaseController {

    //Controller
    public $controller = 'telegram';

    // {"update_id":503766379,"message":{"message_id":15,"from":{"id":215795746,"first_name":"Edwin","last_name":"Mugendi"},"chat":{"id":215795746,"first_name":"Edwin","last_name":"Mugendi","type":"private"},"date":1474988534,"text":"\/start","entities":[{"type":"bot_command","offset":0,"length":6}]},"ip":"149.154.167.206","agent":null} [] []
    // {"update_id":503766380,"message":{"message_id":16,"from":{"id":215795746,"first_name":"Edwin","last_name":"Mugendi"},"chat":{"id":215795746,"first_name":"Edwin","last_name":"Mugendi","type":"private"},"date":1474988575,"text":"Hello"},"ip":"149.154.167.206","agent":null} [] []

    /**
     * S# webhookTelegram() function
     * 
     * Telegram webhook
     * 
     */
    public function webhookTelegram() {

        \Log::info('TG ' . json_encode($this->input));

        //Update array
        $update_array = array(
            'channel' => 'telegram',
            'type' => 'incoming',
            'update_id' => $this->input['update_id'],
            'message' => json_encode($this->input['message']),
            'status' => 1,
            'created_by' => 1,
            'updated_by' => 1
        );

        //Fields to select
        $fields = array('*');


        //Set where clause
        $where_clause = array(
            array(
                'where' => 'where',
                'column' => 'update_id',
                'operator' => '=',
                'operand' => $this->input['update_id']
            ),
            array(
                'where' => 'where',
                'column' => 'channel',
                'operator' => '=',
                'operand' => 'telegram'
            )
        );

        //Set scope
        $parameters['scope'] = array('statusOne');

        //Select update
        $update_model = $this->callController(\Util::buildNamespace('surveys', 'update', 1), 'select', array($fields, 1, $where_clause, $parameters));

        if (!$update_model) {

            //Create update
            $update_model = $this->callController(\Util::buildNamespace('surveys', 'update', 1), 'createIfValid', array($update_array, true));
        }//E# if statement

        return array('chat_id' => '215795746', 'text' => 'What is your name?');
    }

//E# webhookTelegram() function
}

//E# TelegramController() function