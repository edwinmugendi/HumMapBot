<?php

namespace Lava\Merchants;

/**
 * S# LocationModel() Class
 * @author Edwin Mugendi
 * Location Model
 */
class LocationModel extends \BaseModel {

    //Table
    protected $table = 'mct_locations';
    //Fillable fields
    protected $fillable = array(
        'total_reviews',
        'status',
        'created_by',
        'updated_by'
    );
    //Appends fields
    protected $appends = array(
        'star_rating',
        'image_url',
        'favoured',
        'rated',
        'rating_count',
        'user_stamps'
    );
    //Hidden fields
    protected $hidden = array(
        'phone_1',
        'phone_2',
        'phone_3',
        'email_1',
        'email_2',
        'email_3',
        'type_id',
        'plan_id',
        'registration_number',
        'tax_id',
        'vat',
        'vision',
        'mission',
        'slogan',
        'about',
        'email',
        'country_id',
        'town_id',
        'landline',
        'mobile',
        'website',
        'facebook',
        'twitter',
        'views',
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
    
    /**
     * S# merchant() function
     * Set one to one relationship to Merchant Model
     */
    public function merchant() {
        return $this->belongsTo(\Util::buildNamespace('merchants', 'merchant', 2), 'merchant_id');
    }

//E# merchant() function

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
        return (string) $this->ratings()
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
     * S# getImageUrlAttribute() function
     * Get image url
     */
    public function getImageUrlAttribute() {
        return asset('media/upload/merchant/thumbnails/' . $this->image);
    }

//E# getImageUrlAttribute() function

    /**
     * S# getFavouredAttribute() function
     * Has user favoured this location
     */
    public function getFavouredAttribute() {
        if ($this->loggedInUser) {
            $favouriteModel = $this->favourites()
                    ->count();
            return (string) ($favouriteModel ? 1 : 0);
        } else {
            return '-1';
        }
    }

//E# getFavouredAttribute() function
    
    /**
     * S# getUserStampsAttribute() function
     * Get users stamps
     */
    public function getUserStampsAttribute() {
       
        if ($this->loggedInUser) {
            //Create user controller
            $userController = new UserController();

            //Get loyalty stamps
            $stampModel = $userController->callController(\Util::buildNamespace('payments', 'payment', 1), 'getLocationStamps', array($this->attributes['id'], $this->loggedInUser->id));

            if ($stampModel) {//Stamp found
                return $stampModel->feeling;
            }//E# if statement
        }//E# if statement
        return '-1';
    }

//E# getUserStampsAttribute() function

    /**
     * S# getRatedAttribute() function
     * Has user rated this location
     */
    public function getRatedAttribute() {
        if ($this->loggedInUser) {
            $feelingModel = $this->hasMany(\Util::buildNamespace('merchants', 'feel', 2), 'location_id')
                    ->whereType(2)
                    ->whereUserId($this->loggedInUser->id)
                    ->first();
            return (string) ($feelingModel ? $feelingModel->feeling : 0);
        } else {
            return '-1';
        }//E# if else statement
    }

//E# getIsRatedAttribute() function

    /**
     * S# getTotalReviewsAttribute() function
     * Return total number of reviews
     */
    public function getTotalReviewsAttribute() {
        return (string)$this->hasMany(\Util::buildNamespace('merchants', 'feel', 2), 'location_id')
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
                    ->whereUserId($this->loggedInUser->id);
    }

//E# favourites() function
}

//E# LocationModel() Class