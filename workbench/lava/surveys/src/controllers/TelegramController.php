<?php

namespace Lava\Surveys;

use \Longman\TelegramBot\Telegram;
use \Longman\TelegramBot\Entities\InlineKeyboardMarkup;
use \Longman\TelegramBot\Entities\InlineKeyboardButton;
use \Longman\TelegramBot\Request;
use Longman\TelegramBot\Entities\ReplyKeyboardHide;
use Longman\TelegramBot\Entities\ReplyKeyboardMarkup;
use GuzzleHttp\Client as GuzzleClient;
use Intervention\Image\Facades\Image as InterventionImage;

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
    //Image ::[2016-10-16 16:38:58] prod.INFO: Chat id {"update_id":503766539,"message":{"message_id":496,"from":{"id":215795746,"first_name":"Edwin","last_name":"Mugendi"},"chat":{"id":215795746,"first_name":"Edwin","last_name":"Mugendi","type":"private"},"date":1476635938,"photo":[{"file_id":"AgADBAADqacxGyLI3Az9YNUPGyV2mvC0XxkABN37nA09u76ZkYICAAEC","file_size":1375,"file_path":"photo\/file_0.jpg","width":67,"height":90},{"file_id":"AgADBAADqacxGyLI3Az9YNUPGyV2mvC0XxkABJztvVmQ_ublkoICAAEC","file_size":17092,"width":240,"height":320},{"file_id":"AgADBAADqacxGyLI3Az9YNUPGyV2mvC0XxkABHouqgvCSPFVk4ICAAEC","file_size":67977,"width":600,"height":800},{"file_id":"AgADBAADqacxGyLI3Az9YNUPGyV2mvC0XxkABGSZ6CXVYx-lkIICAAEC","file_size":109523,"width":960,"height":1280}]},"ip":"149.154.167.206","agent":null} [] []

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

                //Data to update
                $data_to_update = array(
                    'workflow' => 'y',
                );

                //Update actual form
                $actual_form_model = $this->callController(\Util::buildNamespace('forms', \Str::lower(str_replace('_', ' ', $form_model->name)), 1), 'updateIfValid', array('id', $session_model->actual_form_id, $data_to_update, true));

                //Emoticons
                $emoticons = "\uD83D\uDC4D";

                $parameters = array(
                    'type' => 'text',
                    'chat_id' => $session_model->channel_chat_id,
                    'text' => 'Thanks for completing this survey ' . json_decode('"' . $emoticons . '"'),
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

                echo $question_model->name;
                $is_valid = $this->validateResponse($question_model);
                //dd($is_valid);
                if ($is_valid) {

                    $data_to_update = $this->setDataToUpdate($session_model, $form_model, $question_model);

                    if ($session_model->next_question < ($session_model->total_questions)) {
                        $session_model->next_question += 1;

                        if ($session_model->next_question == $session_model->total_questions) {
                            $data_to_update['workflow'] = 'complete';
                        }//E# if statement

                        $session_model->save();
                    }//E# if statement
                    //dd($data_to_update);
                    //Update actual form
                    $actual_form_model = $this->callController(\Util::buildNamespace('forms', $form_model->name, 1), 'updateIfValid', array('id', $session_model->actual_form_id, $data_to_update, true));

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
     * @param Model $session_model Session Model
     * @param Model $form_model Form Model
     * @param Model $question_model Question Model
     * 
     * @return array Data to update
     */
    private function setDataToUpdate($session_model, $form_model, $question_model) {
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
                    $photos = $this->input['message']['photo'];

                    $photos_count = count($photos);

                    $this->savePhoto($session_model, $form_model, $question_model, $photos[($photos_count - 1)]);

                    break;
                }//E# case
            case 'gps': {
                    $data_to_update['lat'] = $this->input['message']['location']['latitude'];
                    $data_to_update['lng'] = $this->input['message']['location']['longitude'];
                    break;
                }//E# case
            case 'radio': {
                    $data_to_update[\Str::lower(trim($this->input['message']['text']))] = $this->input['message']['text'];
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
     * S# savePhoto() function
     * 
     * Save photo
     * 
     * @param Model $session_model Session model
     * @param Model $form_model Form model
     * @param Model $form_model Form model
     * @param array $photo Photo
     */
    private function savePhoto($session_model, $form_model, $question_model, $photo) {
        //Telegram link
        $telegram_link = 'https://api.telegram.org/bot' . $this->tg_configs['api_key'] . '/getFile?file_id=' . $photo['file_id'];

        //Create guzzle client
        $guzzle_client = new GuzzleClient();

        //Call telegram
        $request = $guzzle_client->get($telegram_link);
        //Decode json
        $json_response = json_decode($request->getBody(), true);
        if ($json_response['ok'] == 'true') {

            //Telegram file link
            $telegram_file_link = 'https://api.telegram.org/file/bot' . $this->tg_configs['api_key'] . '/' . $json_response['result']['file_path'];

            //Build upload path
            $upload_path = public_path() . \Config::get('media::media.uploadPath');
            //Get image
            $image = $thumbnail = InterventionImage::make($telegram_file_link);

            //Get mime
            $mime = $image->mime();

            if ($mime == 'image/jpeg') {
                $extension = '.jpg';
            } elseif ($mime == 'image/png') {
                $extension = '.png';
            } elseif ($mime == 'image/gif') {
                $extension = '.gif';
            } else {
                $extension = '';
            }//E# if else statement
            //Resize images
            $image->resize(\Config::get('media::media.mainWidth'), \Config::get('media::media.mainHeight'));
            $thumbnail->resize(\Config::get('media::media.thumbnailWidth'), \Config::get('media::media.thumbnailHeight'));

            //Build media name
            $media_name = \Str::random(\Config::get('media::media.mediaNameLength')) . $extension;

            //Save images
            $image->save($upload_path . '/' . $media_name);
            $thumbnail->save($upload_path . '/thumbnails/' . $media_name);

            //Define media row 
            $mediaRow[] = array(
                /* 2 New fields */
                'is_image' => 1,
                'original_name' => $media_name,
                'controller_type' => str_replace(' ', '_', \Str::lower($form_model->name)),
                'type' => 'photo',
                'name' => $media_name,
                'extension' => $extension,
                'main_size' => $json_response['result']['file_size'],
                'thumbnail_size' => 1,
                'is_thumbnailed' => 1,
                'is_resized' => 1,
                'order' => 0,
                'refresh_key' => 1,
                'agent' => \Request::getClientIp(),
                /* 'ip' => \Request::server('HTTP_USER_AGENT'), */
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1
            );

            //Create a Media
            $media_model = $this->callController(\Util::buildNamespace('media', 'media', 1), 'createIfValid', $mediaRow);

            //Update actual form
            $actual_form_model = $this->callController(\Util::buildNamespace('forms', $form_model->name, 1), 'getModelByField', array('id', $session_model->actual_form_id));

            $actual_form_model->media()->save($media_model);
        }//E# if statement
    }

//E# savePhoto() function

    /**
     * S# validateResponse() function
     * 
     * Validate response
     * 
     * @param Model $question_model Question model
     * 
     */
    private function validateResponse($question_model) {

        switch ($question_model['type']) {
            case 'text': {
                    return true;
                    break;
                }//E# case
            case 'integer': {
                    return ctype_digit((string) $this->input['message']['text']);
                    break;
                }//E# case
            case 'decimal': {
                    return is_numeric($this->input['message']['text']);
                    break;
                }//E# case
            case 'photo': {
                    return (array_key_exists('photo', $this->input['message'])) && (count($this->input['message']['photo']) > 0);
                    break;
                }//E# case
            case 'gps': {
                    return (array_key_exists('location', $this->input['message']) && array_key_exists('latitude', $this->input['message']['location']) && array_key_exists('longitude', $this->input['message']['location']));
                    break;
                }//E# case
            case 'radio': {
                    $option_values = $question_model->options->lists('title');

                    return in_array($this->input['message']['text'], $option_values);
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
        //Fields to select
        $fields = array('*');

        //Set where clause
        $where_clause = array(
            array(
                'where' => 'where',
                'column' => 'name',
                'operator' => '=',
                'operand' => $form
            ),
            array(
                'where' => 'where',
                'column' => 'workflow',
                'operator' => '=',
                'operand' => 'published'
            )
        );

        $parameters = array();
        //Set scope
        $parameters['lazyLoad'] = array('questions');

        //Set scope
        $parameters['scope'] = array('statusOne');

        //Select form
        $form_model = $this->callController(\Util::buildNamespace('surveys', 'form', 1), 'select', array($fields, $where_clause, 1, $parameters));

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

                //Update session id
                $actual_form_model->session_id = $session_model->id;
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

            if ($session_model->next_question == 0 && count($form_model->media)) {

                $link = asset('media/lava/upload/' . $form_model->media[0]['name']);

                $parameters = array(
                    'type' => 'photo',
                    'chat_id' => $this->input['message']['chat']['id'],
                    'link' => $link,
                );

                $this->sendMessage($parameters);
            }

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

        //Emoticons
        $emoticons = "\uD83D\uDC4F";

        $parameters = array(
            'type' => 'text',
            'chat_id' => $this->input['message']['chat']['id'],
            'text' => json_decode('"' . $emoticons . '"') . ' Welcome to ' . \Config::get('product.name') . '. To respond to a survey, type "/fill {form name}" try /fill contact'
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

            //Emoticons
            $emoticons = "\uD83D\uDC4D";

            $parameters = array(
                'type' => 'text',
                'chat_id' => $session_model->channel_chat_id,
                'text' => 'Thanks for completing this survey ' . json_decode('"' . $emoticons . '"'),
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

        $text = ($session_model->next_question + 1) . '/' . $session_model->total_questions . '. ';


        $text .= $question_model->title;

        if (in_array($question_model['type'], array('text', 'integer', 'decimal', 'photo'))) {


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
            $parameters['text'] = $text;
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
            $parameters['text'] = $text;
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
            case 'photo': {
                    $this->tg_request->sendPhoto(['chat_id' => $parameters['chat_id']], $parameters['link']);
                    break;
                }//E# case
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