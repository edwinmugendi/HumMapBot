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
use Carbon\Carbon;

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

        $text_back = '';

        $parameters = array();

        //Set scope
        $parameters['scope'] = array('statusOne');

        //Order by
        $parameters['orderBy'][] = array('updated_at' => 'asc');

        //Select session
        $session_model = $this->callController(\Util::buildNamespace('surveys', 'session', 1), 'getModelByField', array('channel_chat_id', $this->input['message']['chat']['id'], $parameters));

        if ($session_model) {

            $session_model->updated_at = Carbon::now();

            $session_model->save();
        } else {
            $names = $this->input['message']['from']['first_name'];

            if (array_key_exists('last_name', $this->input['message']['from'])) {
                $names .= $this->input['message']['from']['last_name'];
            }//E# if statement

            $session_array = array(
                'organization_id' => 1,
                'channel_chat_id' => $this->input['message']['chat']['id'],
                'full_name' => $names,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            );

            //Create session
            $session_model = $this->callController(\Util::buildNamespace('surveys', 'session', 1), 'createIfValid', array($session_array, true));
        }//E# if else statement
        //Get text
        $text = $this->input['message']['text'];

        $message_array = array(
            'type' => 'in',
            'organization_id' => 1,
            'session_id' => $session_model->id,
            'text' => $text,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'status' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        );

        //Create message
        $message_model = $this->callController(\Util::buildNamespace('surveys', 'message', 1), 'createIfValid', array($message_array, true));

        $query_array = array(
            'query' => $text,
            'confidence' => 1,
            'sessionId' => $session_model->id,
        );
        //Call apiai
        $apiai_response = $this->callController(\Util::buildNamespace('surveys', 'apiai', 1), 'query', array($query_array));

        if ($apiai_response['status']) {
            // dd($apiai_response['message']['result']['parameters']);
            if ($apiai_response['message']['result']['parameters']) {
                //Call air table
                //$airtable_response = $this->callController(\Util::buildNamespace('surveys', 'apiai', 1), 'query', array($query_array));

                $text_back = 'Getting data from Air table';
            } else {
                $text_back = $apiai_response['message']['result']['fulfillment']['speech'];
            }//E# if else statement
        } else {
            $text_back = 'Ooops! Something went wrong. Kindly try after afew minutes';
        }//E# if else statement

        $message_array = array(
            'type' => 'out',
            'organization_id' => 1,
            'session_id' => $session_model->id,
            'text' => $text_back,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'status' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        );

        //Create message
        $message_model = $this->callController(\Util::buildNamespace('surveys', 'message', 1), 'createIfValid', array($message_array, true));

        $parameters = array(
            'type' => 'text',
            'chat_id' => $this->input['message']['chat']['id'],
            'text' => $text_back
        );

        $this->sendMessage($parameters);
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
            'text' => json_decode('"' . $emoticons . '"') . ' Welcome to ' . \Config::get('product.name') . '. How can I help today?'
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