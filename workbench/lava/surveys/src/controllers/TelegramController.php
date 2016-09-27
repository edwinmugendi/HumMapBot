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

    /**
     * S# webhookTelegram() function
     * 
     * Telegram webhook
     * 
     */
    public function webhookTelegram() {

        \Log::info('TG ' . json_encode($this->input));

        return "true";
    }

//E# webhookTelegram() function
}

//E# TelegramController() function