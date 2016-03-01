<?php

namespace Lava\Merchants;

use Lava\Payments\PaymentController;

/**
 * S# LocationModel() Class
 * @author Edwin Mugendi
 * Location Model
 */
class LocationModel extends \BaseModel {

    //Table
    protected $table = 'mct_locations';
    //View fields
    public $viewFields = array(
        'id' => array(1, 'text', '='),
        'workflow' => array(1, 'select', '=', 0),
        'merchant_id' => array(1, 'select', '=', 0),
        'name' => array(1, 'text', 'like', 1),
        'about' => array(1, 'text', 'like', 0),
        'phone' => array(1, 'text', 'like', 0),
        'email' => array(1, 'text', 'like', 0),
        'country_id' => array(1, 'select', '='),
        'province' => array(1, 'text', 'like'),
        'city' => array(1, 'text', 'like'),
        'street' => array(1, 'text', 'like'),
        'postal_code' => array(1, 'text', 'like', 0),
        'lat' => array(1, 'text', 'like', 0),
        'lng' => array(1, 'text', 'like', 0),
        'timezone_id' => array(0, 'select', '='),
        'currency_id' => array(1, 'select', '='),
        'date_format' => array(0, 'select', '='),
        'loyalty_stamps' => array(1, 'text', 'like', 0),
        'surcharge' => array(0, 'text', 'like', 0),
        'is_monday_open' => array(0, 'select', '=', 0),
        'monday_opens_at' => array(0, 'text', 'like', 0),
        'monday_closes_at' => array(0, 'text', 'like', 0),
        'is_tuesday_open' => array(0, 'select', '=', 0),
        'tuesday_opens_at' => array(0, 'text', 'like', 0),
        'tuesday_closes_at' => array(0, 'text', 'like', 0),
        'is_wednesday_open' => array(0, 'select', '=', 0),
        'wednesday_opens_at' => array(0, 'text', 'like', 0),
        'wednesday_closes_at' => array(0, 'text', 'like', 0),
        'is_thursday_open' => array(0, 'select', '=', 0),
        'thursday_opens_at' => array(0, 'text', 'like', 0),
        'thursday_closes_at' => array(0, 'text', 'like', 0),
        'is_friday_open' => array(0, 'select', '=', 0),
        'friday_opens_at' => array(0, 'text', 'like', 0),
        'friday_closes_at' => array(0, 'text', 'like', 0),
        'is_saturday_open' => array(0, 'select', '=', 0),
        'saturday_opens_at' => array(0, 'text', 'like', 0),
        'saturday_closes_at' => array(0, 'text', 'like', 0),
        'is_sunday_open' => array(0, 'select', '=', 0),
        'sunday_opens_at' => array(0, 'text', 'like', 0),
        'sunday_closes_at' => array(0, 'text', 'like', 0),
        'is_holiday_open' => array(0, 'select', '=', 0),
        'holiday_opens_at' => array(0, 'text', 'like', 0),
        'holiday_closes_at' => array(0, 'text', 'like', 0),
        'website' => array(0, 'text', 'like'),
        'facebook' => array(0, 'text', 'like'),
        'twitter' => array(0, 'text', 'like'),
    );
    //Fillable fields
    protected $fillable = array(
        'merchant_id',
        'name',
        'about',
        'phone',
        'email',
        'address',
        'country_id',
        'province',
        'city',
        'street',
        'postal_code',
        'lat',
        'lng',
        'currency_id',
        'timezone_id',
        'date_format',
        'loyalty_stamps',
        'surcharge',
        'is_monday_open',
        'monday_opens_at',
        'monday_closes_at',
        'is_tuesday_open',
        'tuesday_opens_at',
        'tuesday_closes_at',
        'is_wednesday_open',
        'wednesday_opens_at',
        'wednesday_closes_at',
        'is_thursday_open',
        'thursday_opens_at',
        'thursday_closes_at',
        'is_friday_open',
        'friday_opens_at',
        'friday_closes_at',
        'is_saturday_open',
        'saturday_opens_at',
        'saturday_closes_at',
        'is_sunday_open',
        'sunday_opens_at',
        'sunday_closes_at',
        'is_holiday_open',
        'holiday_opens_at',
        'holiday_closes_at',
        'website',
        'facebook',
        'twitter',
        'workflow',
        'agent',
        'ip',
        'status',
        'created_by',
        'updated_by',
    );
    //Appends fields
    protected $appends = array(
        'workflow_text',
        'merchant_id_text',
        'is_monday_open_text',
        'is_tuesday_open_text',
        'is_wednesday_open_text',
        'is_thursday_open_text',
        'is_friday_open_text',
        'is_saturday_open_text',
        'is_sunday_open_text',
        'is_holiday_open_text',
        'country_id_text',
        'workflow_text',
        'currency_id_text',
        'timezone_id_text',
        'star_rating',
        'favoured',
        'rated',
        'rating_count',
        'user_stamps'
    );
    //Hidden fields
    protected $hidden = array(
        'phone',
        'email',
        'website',
        'facebook',
        'twitter',
        'is_monday_open_text',
        'is_tuesday_open_text',
        'is_wednesday_open_text',
        'is_thursday_open_text',
        'is_friday_open_text',
        'is_saturday_open_text',
        'is_sunday_open_text',
        'is_holiday_open_text',
        'merchant_id_text',
        'merchant_id',
        'agent',
        'workflow_text',
        'country_id_text',
        'timezone_id_text',
        '',
        '',
    );
    //Create validation rules
    public $createRules = array(
        'name' => 'required',
    );
    //Update validation rules
    public $updateRules = array(
        'name' => 'required',
    );

    /**
     * S# getIsMondayOpenTextAttribute() function
     * Get IsMondayOpen Text
     */
    public function getIsMondayOpenTextAttribute() {
        //Set icon
        $icon = $this->attributes['is_monday_open'] ? 'glyphicon-ok commonColor' : 'glyphicon-remove commonColorRed';

        return '<i class="glyphicon ' . $icon . '"></i>';
    }

//E# getIsMondayOpenTextAttribute() function

    /**
     * S# getIsTuesdayOpenTextAttribute() function
     * Get IsTuesdayOpen Text
     */
    public function getIsTuesdayOpenTextAttribute() {
        //Set icon
        $icon = $this->attributes['is_tuesday_open'] ? 'glyphicon-ok commonColor' : 'glyphicon-remove commonColorRed';

        return '<i class="glyphicon ' . $icon . '"></i>';
    }

//E# getIsTuesdayOpenTextAttribute() function
    /**
     * S# getIsWednesdayOpenTextAttribute() function
     * Get IsWednesdayOpen Text
     */
    public function getIsWednesdayOpenTextAttribute() {
        //Set icon
        $icon = $this->attributes['is_wednesday_open'] ? 'glyphicon-ok commonColor' : 'glyphicon-remove commonColorRed';

        return '<i class="glyphicon ' . $icon . '"></i>';
    }

//E# getIsWednesdayOpenTextAttribute() function

    /**
     * S# getIsThursdayOpenTextAttribute() function
     * Get IsThursdayOpen Text
     */
    public function getIsThursdayOpenTextAttribute() {
        //Set icon
        $icon = $this->attributes['is_thursday_open'] ? 'glyphicon-ok commonColor' : 'glyphicon-remove commonColorRed';

        return '<i class="glyphicon ' . $icon . '"></i>';
    }

//E# getIsThursdayOpenTextAttribute() function
    /**
     * S# getIsFridayOpenTextAttribute() function
     * Get IsFridayOpen Text
     */
    public function getIsFridayOpenTextAttribute() {
        //Set icon
        $icon = $this->attributes['is_friday_open'] ? 'glyphicon-ok commonColor' : 'glyphicon-remove commonColorRed';

        return '<i class="glyphicon ' . $icon . '"></i>';
    }

//E# getIsFridayOpenTextAttribute() function
    /**
     * S# getIsSaturdayOpenTextAttribute() function
     * Get IsSaturdayOpen Text
     */
    public function getIsSaturdayOpenTextAttribute() {
        //Set icon
        $icon = $this->attributes['is_saturday_open'] ? 'glyphicon-ok commonColor' : 'glyphicon-remove commonColorRed';

        return '<i class="glyphicon ' . $icon . '"></i>';
    }

//E# getIsSaturdayOpenTextAttribute() function

    /**
     * S# getIsSundayOpenTextAttribute() function
     * Get IsSundayOpen Text
     */
    public function getIsSundayOpenTextAttribute() {
        //Set icon
        $icon = $this->attributes['is_sunday_open'] ? 'glyphicon-ok commonColor' : 'glyphicon-remove commonColorRed';

        return '<i class="glyphicon ' . $icon . '"></i>';
    }

//E# getIsSundayOpenTextAttribute() function

    /**
     * S# getIsHolidayOpenTextAttribute() function
     * Get IsHolidayOpen Text
     */
    public function getIsHolidayOpenTextAttribute() {
        //Set icon
        $icon = $this->attributes['is_holiday_open'] ? 'glyphicon-ok commonColor' : 'glyphicon-remove commonColorRed';

        return '<i class="glyphicon ' . $icon . '"></i>';
    }

//E# getIsHolidayOpenTextAttribute() function

    /**
     * S# getWorkflowTextAttribute() function
     * Get Workflow Text
     */
    public function getWorkflowTextAttribute() {
        $label = '';
        if ($this->attributes['workflow'] == 1) {
            $label = 'label label-success';
        } else if ($this->attributes['workflow'] == 2) {
            $label = 'label label-danger';
        } else if ($this->attributes['workflow'] == 3) {
            $label = 'label label-danger';
        }//E# if else statement

        return \Lang::has('merchants::location.data.workflow.' . $this->attributes['workflow']) ? '<span class="' . $label . '">' . \Lang::get('merchants::location.data.workflow.' . $this->attributes['workflow']) . '</span>' : '';
    }

//E# getWorkflowTextAttribute() function

    /**
     * S# currency() function
     * Set one to one relationship to Currency Model
     */
    public function currency() {
        return $this->belongsTo(\Util::buildNamespace('locations', 'currency', 2), 'currency_id');
    }

//E# currency() function

    /**
     * S# getCurrencyIdTextAttribute() function
     * Get Currency Text
     */
    public function getCurrencyIdTextAttribute() {
        //Get currency model
        $currency_model = $this->currency()->first();
        //Return name
        return $currency_model ? $currency_model->code : '';
    }

//E# getCurrencyIdTextAttribute() function

    /**
     * S# timezone() function
     * Set one to one relationship to Timezone Model
     */
    public function timezone() {
        return $this->belongsTo(\Util::buildNamespace('locations', 'timezone', 2), 'timezone_id');
    }

//E# timezone() function

    /**
     * S# getTimezoneIdTextAttribute() function
     * Get Timezone Text
     */
    public function getTimezoneIdTextAttribute() {
        //Get timezone model
        $timezone_model = $this->timezone()->first();
        //Return name
        return $timezone_model ? $timezone_model->name : '';
    }

//E# getTimezoneIdTextAttribute() function

    /**
     * S# merchant() function
     * Set one to one relationship to Merchant Model
     */
    public function merchant() {
        return $this->belongsTo(\Util::buildNamespace('merchants', 'merchant', 2), 'merchant_id');
    }

//E# merchant() function

    /**
     * S# getMerchantIdTextAttribute() function
     * 
     * Get Merchant Text
     */
    public function getMerchantIdTextAttribute() {

        //Get merchant model
        $merchant_model = $this->merchant()->first();

        //Return name
        return $merchant_model ? $merchant_model->name : '';
    }

//E# getMerchantIdTextAttribute() function

    /**
     * S# getDateFormatTextAttribute() function
     * Get DateFormat Text
     */
    public function getDateFormatTextAttribute() {
        return \Lang::has('merchants::merchant.data.date_format.' . $this->attributes['date_format']) ? \Lang::get('merchants::merchant.data.date_format.' . $this->attributes['date_format']) : '';
    }

//E# getDateFormatTextAttribute() function

    /**
     * S# country() function
     * Set one to one relationship to Country Model
     */
    public function country() {
        return $this->belongsTo(\Util::buildNamespace('locations', 'country', 2), 'country_id');
    }

//E# country() function

    /**
     * S# getCountryIdTextAttribute() function
     * Get Country Text
     */
    public function getCountryIdTextAttribute() {

        //Get country model
        $country_model = $this->country()->first();

        //Return name
        return $country_model ? $country_model->name : '';
    }

//E# getCountryIdTextAttribute() function

    /**
     * S# products() function
     * Set one to many relationship to Product Model
     */
    public function products() {
        return $this->hasMany(\Util::buildNamespace('products', 'product', 2), 'location_id');
    }

//E# products() function

    /**
     * S# ratings() function
     * Set one to many relationship to Rating Model
     */
    public function ratings() {
        return $this->hasMany(\Util::buildNamespace('merchants', 'feel', 2), 'location_id')->whereType(2);
    }

//E# ratings() function

    /**
     * S# getStarRatingAttribute() function
     * Calculate average of the ratings and return the star rating
     */
    public function getStarRatingAttribute() {
        return (float)$this->ratings()
                        ->avg('feeling');
    }

//E# getStarRatingAttribute() function

    /**
     * S# getRatingCountAttribute() function
     * Calculate average of the ratings and return the star rating
     */
    public function getRatingCountAttribute() {
        return (string) $this->ratings()
                        ->count();
    }

//E# getRatingCountAttribute() function

    /**
     * S# getFavouredAttribute() function
     * Has user favoured this location
     */
    public function getFavouredAttribute() {
        if (\Auth::check() && \Request::has('token')) {
            $favourite_model = $this->favourites()->count();

            return $favourite_model ? 1 : 0;
        } else {
            return -1;
        }//E# if else statement
    }

//E# getFavouredAttribute() function

    /**
     * S# getUserStampsAttribute() function
     * Get users stamps
     */
    public function getUserStampsAttribute() {
        if (\Auth::check() && \Request::has('token')) {
            //Create payment controller
            $payment_controller = new PaymentController();

            //Get loyalty stamps
            $stamp_model = $payment_controller->getLocationStamps($this->attributes['id'], \Auth::user()->id);

            if ($stamp_model) {//Stamp found
                return $stamp_model->feeling;
            }//E# if statement
        }//E# if statement
        return 0;
    }

//E# getUserStampsAttribute() function

    /**
     * S# getRatedAttribute() function
     * Has user rated this location
     */
    public function getRatedAttribute() {
        if (\Auth::check() && \Request::has('token')) {
            $feeling_model = $this->hasMany(\Util::buildNamespace('merchants', 'feel', 2), 'location_id')
                    ->whereType(2)
                    ->whereUserId(\Auth::user()->id)
                    ->first();

            return $feeling_model ? $feeling_model->feeling : 0;
        } else {
            return -1;
        }//E# if else statement
    }

//E# getIsRatedAttribute() function

    /**
     * S# getTotalReviewsAttribute() function
     * Return total number of reviews
     */
    public function getTotalReviewsAttribute() {
        return (string) $this->hasMany(\Util::buildNamespace('merchants', 'feel', 2), 'location_id')
                        ->whereType(3)
                        ->count();
    }

//E# getTotalReviewsAttribute() function

    /**
     * S# reviews() function
     * Set one to many relationship to Review Model
     */
    public function reviews() {
        return $this->hasMany(\Util::buildNamespace('merchants', 'feel', 2), 'location_id');
    }

//E# reviews() function

    /**
     * S# favourites() function
     * Set one to many relationship to Feel Model
     */
    public function favourites() {
        return $this->hasMany(\Util::buildNamespace('merchants', 'feel', 2), 'location_id')
                        ->whereType(1)
                        ->whereUserId(\Auth::user()->id);
    }

//E# favourites() function
}

//E# LocationModel() Class