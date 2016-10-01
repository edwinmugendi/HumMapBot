<?php

namespace Lava\Surveys;

use \Longman\TelegramBot\Telegram;

/**
 * S# TelegramController() function
 * Telegram controller
 * @author Edwin Mugendi
 */
class TelegramController extends SurveysBaseController {

    //Controller
    public $controller = 'telegram';
    private $tg_service;
    private $tg_configs;
    private $tg_request;

    // {"update_id":503766379,"message":{"message_id":15,"from":{"id":215795746,"first_name":"Edwin","last_name":"Mugendi"},"chat":{"id":215795746,"first_name":"Edwin","last_name":"Mugendi","type":"private"},"date":1474988534,"text":"\/start","entities":[{"type":"bot_command","offset":0,"length":6}]},"ip":"149.154.167.206","agent":null} [] []
    // {"update_id":503766380,"message":{"message_id":16,"from":{"id":215795746,"first_name":"Edwin","last_name":"Mugendi"},"chat":{"id":215795746,"first_name":"Edwin","last_name":"Mugendi","type":"private"},"date":1474988575,"text":"Hello"},"ip":"149.154.167.206","agent":null} [] []

    /**
     * S# __construct() function
     * 
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        //Get configs
        $this->tg_configs = \Config::get('thirdParty.telegram');

        // Create Telegram API object
        $this->tg_service = new Telegram($this->tg_configs['api_key'], $this->tg_configs['bot']);

        //Get request
        $this->tg_request = new \Longman\TelegramBot\Request($this->tg_service);
    }

//E# __contruct() function

    /**
     * S# webhookTelegram() function
     * 
     * Telegram webhook
     * 
     */
    public function webhookTelegram() {

        \Log::info('Chat id ' . json_encode($this->input));
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
        $update_model = $this->callController(\Util::buildNamespace('surveys', 'update', 1), 'select', array($fields, $where_clause, 1, $parameters));

        if (!$update_model) {
            //Create update
            $update_model = $this->callController(\Util::buildNamespace('surveys', 'update', 1), 'createIfValid', array($update_array, true));
        }//E# if statement

        if (array_key_exists('entities', $this->input['message']) && $this->input['message']['entities'][0]['type'] == 'bot_command') {
            $this->processCommands();
        } else {
            $this->processAnswer();
        }//E# if statement

        return array('chat_id' => $this->input['message']['chat']['id'], 'text' => 'What is your name?');
    }

//E# webhookTelegram() function

    /**
     * S# processAnswer() function
     * 
     * Process answer
     * 
     */
    private function processAnswer() {
        $parameters = array();

        //Set scope
        $parameters['scope'] = array('statusOne');

        //Select session
        $session_model = $this->callController(\Util::buildNamespace('surveys', 'session', 1), 'getModelByField', array('channel_chat_id', $this->input['message']['chat']['id'], $parameters));

        if ($session_model) {

            if ($session_model->next_question == ($session_model->total_questions - 1)) {
                $parameters = array(
                    'type' => 'text',
                    'chat_id' => $session_model->channel_chat_id,
                    'text' => 'Thank you for completing this form',
                );

                $this->sendMessage($parameters);
                return '';
            } else {
                $parameters = array();

                //Set scope
                $parameters['scope'] = array('statusOne');

                //Select form
                $form_model = $this->callController(\Util::buildNamespace('surveys', 'form', 1), 'getModelByField', array('id', $session_model->form_id, $parameters));

                $question_model = $form_model->questions[$session_model->next_question];

                $is_valid = $this->validateResponse($question_model);

                if ($is_valid) {
                    $data_to_update = array(
                        '' . $question_model->name . '' => $this->input['message']['text'],
                    );

                    //Update actual form
                    $actual_form_model = $this->callController(\Util::buildNamespace('forms', $form_model->name, 1), 'updateIfValid', array('id', $session_model->actual_form_id, $data_to_update));

                    if ($session_model->next_question <= ($session_model->total_questions - 1)) {
                        $session_model->next_question += 1;

                        $session_model->save();
                    }//E# if statement

                    $this->sendNextQuestion($form_model, $session_model);
                } else {
                    $parameters = array(
                        'type' => 'text',
                        'chat_id' => $this->input['message']['chat']['id'],
                        'text' => $question_model->error_message
                    );
                    $this->sendMessage($parameters);
                }//E# if else statement
            }//E# if else statement
        } else {

            $parameters = array(
                'type' => 'text',
                'chat_id' => $this->input['message']['chat']['id'],
                'text' => 'Oops! form not found. Type /start {form} eg /start contact'
            );

            $this->sendMessage($parameters);
        }//E# if else statement
    }

//E# processAnswer() function

    /**
     * S# validateResponse() function
     * 
     * Validate response
     * 
     * @param Model $question_model Question model
     * 
     */
    private function validateResponse($question_model) {
        $response = $this->input['message']['text'];

        switch ($question_model['type']) {
            case 'text': {
                    return true;
                    break;
                }//E# case
            case 'integer': {
                    return is_int((int) $response);
                    break;
                }//E# case
            case 'decimal': {
                    return is_numeric((float) $response);
                    break;
                }//E# case
            case 'photo': {
                    return true;
                    break;
                }//E# case
            case 'gps': {
                    return true;
                    break;
                }//E# case
            case 'radio': {
                    $option = $question_model->options->lists('value');
                    return in_array($response, $option_values);
                    break;
                }//E# case
            case 'checkbox': {
                    return true;
                    break;
                }//E# case

            default:
                return true;
                break;
        }//E# switch statement
    }

//E# validateResponse() function

    /**
     * S# processCommandStart() function
     * 
     * Process Command Start
     * 
     */
    private function processCommandStart() {
        $form = $this->getFormText();

        $parameters = array();
        //Set scope
        $parameters['lazyLoad'] = array('questions');

        //Set scope
        $parameters['scope'] = array('statusOne');

        //Select form
        $form_model = $this->callController(\Util::buildNamespace('surveys', 'form', 1), 'getModelByField', array('name', $form, $parameters));

        if ($form_model) {

            //Fields to select
            $fields = array('*');

            //Set where clause
            $where_clause = array(
                array(
                    'where' => 'where',
                    'column' => 'form_id',
                    'operator' => '=',
                    'operand' => $form_model->id
                ),
                array(
                    'where' => 'where',
                    'column' => 'channel_chat_id',
                    'operator' => '=',
                    'operand' => $this->input['message']['chat']['id']
                )
            );

            $parameters = array();

            //Set scope
            $parameters['scope'] = array('statusOne');

            //Select session
            $session_model = $this->callController(\Util::buildNamespace('surveys', 'session', 1), 'select', array($fields, $where_clause, 1, $parameters));

            if (!$session_model) {

                $names = $this->input['message']['from']['first_name'];
                if (array_key_exists('last_name', $this->input['message']['from'])) {
                    $names .= $this->input['message']['from']['last_name'];
                }//E# if statement

                $actual_form_array = array(
                    'organization_id' => $form_model->organization_id,
                    'form_id' => $form_model->id,
                    'channel' => 'telegram',
                    'channel_chat_id' => $this->input['message']['chat']['id'],
                    'names' => $names,
                    'status' => 1,
                    'created_by' => 1,
                    'updated_by' => 1,
                );

                //Create actual form 
                $actual_form_model = $this->callController(\Util::buildNamespace('forms', $form_model->name, 1), 'createIfValid', array($actual_form_array, true));

                $session_array = array(
                    'actual_form_id' => $actual_form_model->id,
                    'organization_id' => $form_model->organization_id,
                    'form_id' => $form_model->id,
                    'channel' => 'telegram',
                    'channel_chat_id' => $this->input['message']['chat']['id'],
                    'next_question' => 0,
                    'total_questions' => count($form_model['questions']),
                    'full_name' => $names,
                    'status' => 1,
                    'created_by' => 1,
                    'updated_by' => 1,
                );

                //Create session
                $session_model = $this->callController(\Util::buildNamespace('surveys', 'session', 1), 'createIfValid', array($session_array, true));
            }//E# if statement
            //Send next question
            $this->sendNextQuestion($form_model, $session_model);
        } else {
            $parameters = array(
                'type' => 'text',
                'chat_id' => $this->input['message']['chat']['id'],
                'text' => 'Oops! form not found. Type /start {form} eg /start contact'
            );

            $this->sendMessage($parameters);
        }//E# if else statement
    }

//E# processCommandStart() function

    /**
     * S# sendNextQuestion() function
     * 
     * Send next question
     * 
     * @param Model $form_model Form Model
     * @param Model $session_model Session model
     * 
     */
    private function sendNextQuestion($form_model, $session_model) {
        if ($session_model->next_question == $session_model->total_questions) {
            $parameters = array(
                'type' => 'text',
                'chat_id' => $session_model->channel_chat_id,
                'text' => 'Thank you for completing this form',
            );
        } else {
            $parameters = $this->buildNextQuestion($form_model, $session_model);
        }//E# if else statement

        $this->sendMessage($parameters);
    }

//E# sendNextQuestion() function

    /**
     * S# buildNextQuestion() function
     * 
     * Build next question
     * 
     * @param Model $form_model Form Model
     * @param Model $session_model Session model
     * 
     */
    private function buildNextQuestion($form_model, $session_model) {

        $next_question = $session_model->next_question;

        $question_model = $form_model['questions'][$next_question];

        if (in_array($question_model['type'], array('text', 'integer', 'decimal'))) {
            $text = $question_model->title;
        }//E# if else statement

        $parameters = array(
            'type' => 'text',
            'chat_id' => $session_model->channel_chat_id,
            'text' => $text
        );

        return $parameters;
    }

//E# buildNextQuestion() function

    /**
     * S# processCommands() function
     * 
     * Process commands
     * 
     */
    private function processCommands() {

        $command = $this->getCommand();

        switch ($command) {
            case '/start':
                $this->processCommandStart();
            default:
        }
    }

//E# processCommands() function

    /**
     * S# getCommand() function
     * 
     * Get command
     * 
     * @return str command
     */
    private function getCommand() {
        return substr($this->input['message']['text'], $this->input['message']['entities'][0]['offset'], $this->input['message']['entities'][0]['length']);
    }

//E# getCommand() function

    /**
     * S# getFormText() function
     * 
     * Get form text
     * 
     * @return str form text
     */
    private function getFormText() {
        return trim(substr($this->input['message']['text'], ($this->input['message']['entities'][0]['length'] + 1), (strlen($this->input['message']['text']) - 1)));
    }

//E# getFormText() function

    /**
     * S# sendMessage() function
     * 
     * Send message
     * 
     */
    private function sendMessage($parameters) {

        switch ($parameters['type']) {
            case 'text': {
                    $this->tg_request->sendMessage(['chat_id' => $parameters['chat_id'], 'text' => $parameters['text']]);
                    break;
                }//E# case
            case 'integer': {
                    $this->tg_request->sendMessage(['chat_id' => $parameters['chat_id'], 'text' => $parameters['text']]);
                    break;
                }//E# case
            case 'decimal': {
                    $this->tg_request->sendMessage(['chat_id' => $parameters['chat_id'], 'text' => $parameters['text']]);
                    break;
                }//E# case
            default:
                break;
        }//E# switch() statement
    }

//E# sendMessage() function
}

//E# TelegramController() function