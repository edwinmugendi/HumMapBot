<?php

namespace Lava\Surveys;

use \Longman\TelegramBot\Telegram;
use \Longman\TelegramBot\Entities\InlineKeyboardMarkup;
use \Longman\TelegramBot\Entities\InlineKeyboardButton;
use \Longman\TelegramBot\Request;
use Longman\TelegramBot\Entities\ReplyKeyboardHide;
use Longman\TelegramBot\Entities\ReplyKeyboardMarkup;

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
        $this->tg_request = new Request($this->tg_service);
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
        /*
          $keyboard = $parameters = array();
          $keyboard[] = [['category1' => 2, 'category2' => 4]];
          $keyboards[] = $keyboard;
          $parameters['chat_id'] = '283329263';
          $parameters['text'] = 'Cal';

          $parameters['reply_markup'] = new ReplyKeyboardMarkup([
          'keyboard' => $keyboards[0],
          'resize_keyboard' => true,
          'one_time_keyboard' => true,
          'selective' => false
          ]);
          return Request::sendMessage($parameters);
         */
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

            if ($session_model->next_question == ($session_model->total_questions)) {
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
                //dd($is_valid);
                if ($is_valid) {

                    $data_to_update = $this->setDataToUpdate($question_model);

                    if ($session_model->next_question < ($session_model->total_questions)) {
                        $session_model->next_question += 1;

                        if ($session_model->next_question == $session_model->total_questions) {
                            $data_to_update['workflow'] = 'complete';
                        }//E# if statement

                        $session_model->save();
                    }//E# if statement
                    //dd($data_to_update);
                    //Update actual form
                    $actual_form_model = $this->callController(\Util::buildNamespace('forms', $form_model->name, 1), 'updateIfValid', array('id', $session_model->actual_form_id, $data_to_update));

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
                'text' => 'Oops! form not found. Type /start {form name} eg /start contact'
            );

            $this->sendMessage($parameters);
        }//E# if else statement
    }

//E# processAnswer() function

    /**
     * S# setDataToUpdate() function
     * 
     * Set data to update
     * 
     * @param Model $question_model Question Model
     * 
     * @return array Data to update
     */
    private function setDataToUpdate($question_model) {
        $data_to_update = array();

        switch ($question_model['type']) {
            case 'text': {
                    $data_to_update['' . $question_model->name . ''] = $this->input['message']['text'];
                    break;
                }//E# case
            case 'integer': {
                    $data_to_update['' . $question_model->name . ''] = $this->input['message']['text'];
                    break;
                }//E# case
            case 'decimal': {
                    $data_to_update['' . $question_model->name . ''] = $this->input['message']['text'];
                    break;
                }//E# case
            case 'photo': {
                    break;
                }//E# case
            case 'gps': {
                    $data_to_update['latitude'] = $this->input['message']['location']['latitude'];
                    $data_to_update['longitude'] = $this->input['message']['location']['longitude'];
                    break;
                }//E# case
            case 'radio': {
                    $data_to_update['' . $question_model->name . ''] = $this->input['message']['text'];
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

        return $data_to_update;
    }

//E# setDataToUpdate() function

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
                    return ctype_digit((string) $response);
                    break;
                }//E# case
            case 'decimal': {
                    return is_numeric($response);
                    break;
                }//E# case
            case 'photo': {
                    return true;
                    break;
                }//E# case
            case 'gps': {
                    return (array_key_exists('location', $this->input['message']) && array_key_exists('latitude', $this->input['message']['location']) && array_key_exists('longitude', $this->input['message']['location']));
                    break;
                }//E# case
            case 'radio': {
                    $option_values = $question_model->options->lists('title');
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
     * S# processCommandFill() function
     * 
     * Process Command Fill
     * 
     */
    private function processCommandFill() {

        $form = $this->getFormText();

        $names = $this->input['message']['from']['first_name'];
        if (array_key_exists('last_name', $this->input['message']['from'])) {
            $names .= $this->input['message']['from']['last_name'];
        }//E# if statement

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
            } else {
                //Session
                $session_array = array(
                    'next_question' => 0,
                    'full_name' => $names,
                    'total_questions' => count($form_model['questions']),
                );

                //Update session
                $session_model = $this->callController(\Util::buildNamespace('surveys', 'session', 1), 'updateIfValid', array('id', $session_model->id, $session_array, true));
            }//E# if else statement
            //Send next question
            $this->sendNextQuestion($form_model, $session_model);
        } else {
            $parameters = array(
                'type' => 'text',
                'chat_id' => $this->input['message']['chat']['id'],
                'text' => 'Sorry, form not found. to start filling a form, type "/fill {form name}" try /fill contact'
            );

            return $this->sendMessage($parameters);
        }//E# if else statement
    }

//E# processCommandFill() function

    /**
     * S# processCommandStart() function
     * 
     * Process Command Start
     * 
     */
    private function processCommandStart() {
        $parameters = array(
            'type' => 'text',
            'chat_id' => $this->input['message']['chat']['id'],
            'text' => 'Welcome to SurveyBot. To respond to a survey, type "/fill {form}" try /fill contact'
        );

        return $this->sendMessage($parameters);
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
            $parameters = array(
                'type' => 'text',
                'chat_id' => $session_model->channel_chat_id,
                'text' => $text
            );
        } else if ($question_model['type'] == 'gps') {
            $keyboard = $parameters = array();
            $keyboard[] = [
                [
                    'text' => 'request_location',
                    'request_location' => true
                ]
            ];
            $keyboards[] = $keyboard;
            $parameters['chat_id'] = $session_model->channel_chat_id;
            $parameters['text'] = $question_model->title;
            $parameters['type'] = 'gps';
            $parameters['reply_markup'] = new ReplyKeyboardMarkup([
                'keyboard' => $keyboards[0],
                'resize_keyboard' => true,
                'one_time_keyboard' => true,
                'selective' => false
            ]);
        } else if ($question_model['type'] == 'radio') {
            $keyboard = $parameters = array();
            foreach ($question_model->options as $single_option) {
                $keyboard[] = [$single_option['title']];
            }//E# foreach statement
            $keyboards[] = $keyboard;

            $parameters['chat_id'] = $session_model->channel_chat_id;
            $parameters['text'] = $question_model->title;
            $parameters['type'] = 'radio';
            $parameters['reply_markup'] = new ReplyKeyboardMarkup([
                'keyboard' => $keyboards[0],
                'resize_keyboard' => true,
                'one_time_keyboard' => true,
                'selective' => false
            ]);
        }//E# if else statement
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
            case '/start': {
                    $this->processCommandStart();
                    break;
                }//E# case statement
            case '/fill': {
                    $this->processCommandFill();
                    break;
                }//E# case statement
            default:
        }//E# switch statement

        return true;
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
            case 'gps': {
                    unset($parameters['type']);
                    $this->tg_request->sendMessage($parameters);
                    break;
                }//E# case
            case 'radio': {
                    unset($parameters['type']);
                    $this->tg_request->sendMessage($parameters);
                    break;
                }//E# case
            default:
                break;
        }//E# switch() statement

        return true;
    }

//E# sendMessage() function
}

//E# TelegramController() function