<?php

namespace Lava\Products;

use Carbon\Carbon;

/**
 * S# SonicController() function
 * Sonic controller
 * @author Edwin Mugendi
 */
class SonicController extends ProductsBaseController {

    //Controller
    public $controller = 'sonic';

    /**
     * S# getCallback() function
     * Callback
     */
    public function getCallback() {
        //return $this->input;
        //IP check 
        if (!\App::environment('local')) {
            if (!in_array($this->input['ipAddress'], \Config::get('thirdParty.sonic.trustedIps'))) {
                return 'Untrusted IP';
            }//E# if statement
        }//E# if statement
        //Prepare Application user id
        if (array_key_exists('applicationUserId', $this->input)) {
            $this->input['user_id'] = urldecode($this->input['applicationUserId']);
        }//E# if statement
        //Prepare event id
        if (array_key_exists('eventId', $this->input)) {
            $this->input['event_id'] = $this->input['eventId'];
        }//E# if statement
        //Prepare rewards
        if (array_key_exists('rewards', $this->input)) {
            $this->input['points'] = $this->input['rewards'];
        }//E# if statement
        //Prepare item name
        if (array_key_exists('itemName', $this->input)) {
            $this->input['item_name'] = $this->input['itemName'];
        }//E# if statement
        //Prepare item name
        if (array_key_exists('itemName', $this->input)) {
            $this->input['item_name'] = $this->input['itemName'];
        }//E# if statement
        //Prepare publisher sub id
        if (array_key_exists('publisherSubId', $this->input)) {
            $this->input['publisher_sub_id'] = $this->input['publisherSubId'];
        }//E# if statement
        ///sonic/callback/positive?applicationUserId=userid&rewards=1&eventId=593f2456aaf930dd723b9beb8b26d26c&itemName=itemname&signature=ef085b0c6acbf75ffaf454c1b9f64220&timestamp=201407291026&publisherSubId=publish&country=
        ////sonic/callback/positive?
        //applicationUserId=userid&
        //rewards=1&
        //eventId=593f2456aaf930dd723b9beb8b26d26c
        //&itemName=itemname
        //&signature=ef085b0c6acbf75ffaf454c1b9f64220
        //&timestamp=201407291026
        //&publisherSubId=publish&
        //country=
        //Generate MD5
        $md5 = md5($this->input['timestamp'] . $this->input['event_id'] . $this->input['user_id'] . $this->input['points'] . \Config::get('thirdParty.sonic.secret'));

        //Validate the call using the signature
        if ($md5 != $this->input['signature']) {
            if (!\App::environment('local')) {
                return "MD5 error";
            }//E# if statement
        }//E# if statement
        //Fields to select
        $fields = array('*');

        //Set where clause
        $whereClause = array(
            array(
                'where' => 'where',
                'column' => 'event_id',
                'operator' => '=',
                'operand' => $this->input['event_id']
            ),
            array(
                'where' => 'where',
                'column' => 'status',
                'operator' => '=',
                'operand' => 0
            )
        );

        //Get sonic model
        $sonicModel = $this->select($fields, $whereClause, 1);

        if ($sonicModel) {//Negative
            
            if (((int) $sonicModel->negated == 0) && (\Request::segment(3) == 'negative')) {
                //Reduce points
                $sonicModel->points = ($sonicModel->points - $this->input['points']);

                //Mark as negated
                $sonicModel->negated = 1;

                $sonicModel->save();
            }//E# if statement
        } else {//Positive
            //Create sonic model
            $this->createIfValid($this->input, true);
        }//E# if statement

        return $this->input['event_id'] . ":OK";
    }

//E# getCallback() function

    /**
     * S# sonic() function
     * Cron job to award user promotion from sonic points
     * Status = 0 = Unprocessed
     * Status = 1 = Processed and user exists
     * Status = 2 = Processed and user does not exists
     */
    public function sonic() {
        //Current date
        $now = Carbon::now();

        $now->subHour();

        //Fields to select
        $fields = array('*');

        //Set where clause
        $whereClause = array(
            array(
                'where' => 'where',
                'column' => 'status',
                'operator' => '=',
                'operand' => 0
            ),
            array(
                'where' => 'where',
                'column' => 'created_at',
                'operator' => '<',
                'operand' => $now
            )
        );

        //Sonic Model
        $oneSonicModel = $this->select($fields, $whereClause, 1);

        if ($oneSonicModel) {//Found
            //Get user by id
            $userModel = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('id', $oneSonicModel->user_id));

            if ($userModel) {//User found
                //Fields to select
                $fields = array('*');

                //Set where clause
                $whereClause = array(
                    array(
                        'where' => 'where',
                        'column' => 'status',
                        'operator' => '=',
                        'operand' => 0
                    ),
                    array(
                        'where' => 'where',
                        'column' => 'created_at',
                        'operator' => '<',
                        'operand' => $now
                    ),
                    array(
                        'where' => 'where',
                        'column' => 'user_id',
                        'operator' => '=',
                        'operand' => $oneSonicModel->user_id
                    )
                );
                //Take only   
                $parameters['take'] = 10;

                //Sonic Model
                $sonicModel = $this->select($fields, $whereClause, 2);

                if ($sonicModel) {//Sonic Models found
                    //Promotion points
                    $promotionPoints = \Config::get('thirdParty.sonic.promotionPoints');

                    //Promotion value
                    $promotionValue = \Config::get('thirdParty.sonic.promotionValue');
                    foreach ($sonicModel as $singleModel) {
                        //Increment user points
                        $userModel->points += $singleModel->points;

                        //Mark as processed
                        $singleModel->status = 1;
                        //Save sonic model
                        $singleModel->save();

                        if ($userModel->points >= $promotionPoints) {

                            //Award promotion
                            $awarded = $this->awardPromotion($userModel, $promotionPoints, $promotionValue);

                            if ($awarded) {//Points awarded
                                $userModel->points -= $promotionPoints;
                            }//E# if statement
                        }//E# if statement
                    }//E# foreach statement
                    //Save user model
                    $userModel->save();
                }//E# if statement
            } else {//No such user
                $oneSonicModel->status = 2;
                $oneSonicModel->save();
            }//E# if statement
        }//E# if statement

        return "Cron job called";
    }

//E# sonic function

    /**
     * S# awardPromotion() function
     * Award a user promotion
     * 
     * @param Model $userModel User model
     * @param int $promotionPoints Promotion points
     * @param int $promotionValue Promotion value
     * 
     * @return boolean True if awarded, false otherwise
     */
    private function awardPromotion(&$userModel, $promotionPoints, $promotionValue) {
        //Issue single use randomly generate unique promo code to the user, 
        //Reset the users balance to 0.
        //The promo code should be a Lava promo code that is automatically added to the users account. We should also send the User a sms message with the code.
        //Get unique promotion code
        $promoCode = $this->callController(\Util::buildNamespace('products', 'promotion', 1), 'generateUniqueField', array('code', 6, 'upper'));

        //Define promo array
        $promoArray = array(
            'code' => $promoCode,
            'description' => 'SuperSonic Ads - Promotion code' . $promoCode . ', Points: ' . $promotionPoints . ', Value: ' . $promotionValue,
            'type' => 1,
            'value' => $promotionValue,
            'expiry_date' => Carbon::now(),
        );

        //Create a promo model
        $promoModel = $this->callController(\Util::buildNamespace('products', 'promotion', 1), 'createIfValid', array($promoArray, true));

        if ($promoModel) {//Code created
            //Claim
            $promoModel->users()->attach($userModel->id);

            //Message parameters
            $parameters = array(
                'promoCode' => $promoCode,
                'promoValue' => $promotionValue
            );
            //Send sms
            $sent = $this->callController(\Util::buildNamespace('messages', 'message', 1), 'converse', array('sms', null, null, $userModel->id, array($userModel->phone), 'sonicPromotion', \Config::get('app.locale'), $parameters));

            return true;
        } else {
            return false;
        }//E# if else statement
    }

//E# awardPromotion() function
}

//E# SonicController() function