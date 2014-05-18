<?php

namespace Lava\Messages;

/**
 * S# MessageController() function
 * Message controller
 * @author Edwin Mugendi
 */
class MessageController extends MessagesBaseController {

    //Controller  
    public $controller = 'message';

    public function send() {
        $this->converse('email', 'edwin@sapamatech.com', 'dc@4thmind.com', 'translate', 'en');
    }

    public function converse($type, $sender, $recipient, $comCode, $lang, $parameters = array()) {
        switch ($type) {
            case 'email': {
                    return $this->email($sender, $recipient, $comCode, $lang, $parameters);
                    break;
                }//E# case
            case 'sms': {
                    break;
                }//E# case
            default:
                break;
        }//E# switch statement
    }

//E# converse() function

    /**
     * S# getMessageBody() function
     * @author Edwin Mugendi
     * Get message body as as string
     * @param string $type Is is Email, SMS or Push
     * @param string $comCode The communication code
     * @param array $parameters The parameters 
     * @return string The message
     */
    private function getMessageBody($type, $comCode, $parameters) {
        //Return the actual conversation
        return \View::make($this->package . '::' . $this->controller . '.' . \Config::get('app.locale') . '.' . $comCode)
                        ->with('viewData', $parameters)
                        ->render();
    }

//E# getMessageBody() function

    /**
     * S# email() function
     * @author Edwin Mugendi
     * Send email
     * @param string $sender The sender's email
     * @param string $recipient The recipient's email
     * @param string $comCode The communication code
     * @param array $parameters The parameters 
     * @return boolean 1 if email is sent 0 otherwise
     */
    public function email($sender, $recipient, $comCode, $lang, $parameters = array()) {
        //Define view data
        $viewData = array();
        
        //Get content to inject to the template
        $parameters['contentToInject'] = $this->getMessageBody('email', $comCode, $parameters);
        
        //Set parameters as view data
        $viewData['viewData'] = $parameters;

        //Set the subject
        $subject = \Lang::get($this->package . '::' . $this->controller . '.heading.email.' . $comCode . '.subject', $parameters);
        
        //Build the template
        $template = array(
            'html' => $this->package . '::' . $this->controller . '.' . \Config::get('app.locale') . '.emailTemplateView'
        );

        //Send email
        $sent = \Mail::send($template, $viewData, function($message) use(&$recipient, &$senderName, &$subject) {
                    $message->to($recipient, $senderName)->subject($subject);
                });

        //Return sent response
        return $sent;
    }

//E# email() function
}

//E# MessageController() function