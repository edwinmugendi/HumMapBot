<?php

/**
 * S# BaseModel() Class
 * @author Edwin Mugendi
 * Base Model
 */
class BaseModel extends \Eloquent {

    /**
     * S# media() function
     * Set one to many relationship to Media Model
     */
    public function media() {
        return $this->morphMany(\Util::buildNamespace('media', 'media', 2), 'mediable');
    }

//E# media() function

    /**
     * S# setCreatedByAttribute() function
     * Set created_by attribute
     * @param string $value The value
     */
    public function setCreatedByAttribute($value) {
        $this->attributes['created_by'] = \Session::has('user') ? \Session::get('user')['id'] : 1;
    }

//E# setCreatedByAttribute() function

    /**
     * S# setUpdatedByAttribute() function
     * Set created_by attribute
     * @param string $value The value
     */
    public function setUpdatedByAttribute($value) {
        $this->attributes['updated_by'] = \Session::has('user') ? \Session::get('user')['id'] : 1;
    }

//E# setUpdatedByAttribute() function

    /**
     * S# getAddressAttribute() function
     * Get address attribute
     * @return array Address with lat and lng
     */
    public function getLatLngAttribute() {
        return array(
            'lat' => $this->attributes['lat'],
            'lng' => $this->attributes['lng']
        );
    }

//E# getAddressAttribute() function

    /**
     * S# scopeStatusOne() function
     * Select where status == 1
     * 
     * @param Object $query Query
     * 
     * @return Object The query
     */
    public function scopeStatusOne($query) {
        return $query->where('status', '=', 1);
    }

//E# scopeStatusOne() function

    /**
     * S# scopeStatusTwo() function
     * Select where status == 2 //Deleted
     * 
     * @param Object $query Query
     * 
     * @return Object The query
     */
    public function scopeStatusTwo($query) {
        return $query->where('status', '=', 2);
    }

//E# scopeStatusTwo() function

    /**
     * S# user() function
     * Set one to one relationship to User Model
     */
    public function user() {
        return $this->belongsTo(\Util::buildNamespace('accounts', 'user', 2), 'user_id');
    }

//E# user() function

    /**
     * S# getUserIdTextAttribute() function
     * Get user text
     */
    public function getUserIdTextAttribute() {
        //Get the logged in user card
        $user = $this->user()->first();

        $name = '';
        if ($user) {//User exists
            $name = $user->first_name;
            if ($user->middle_name) {
                //Append middle name
                $name .= ' ' . $user->middle_name;
            }//E# if statement
            //Append last name
            $name .= ' ' . $user->last_name;
        }//E# if statement
        //Return employee name
        return $name;
    }

//E# getUserTextAttribute() function

    /**
     * S# updater() function
     * Set one to one relationship to User Model
     */
    public function updater() {
        return $this->belongsTo(\Util::buildNamespace('accounts', 'user', 2), 'updated_by');
    }

//E# updater() function

    /**
     * S# getUpdaterIdTextAttribute() function
     * Get updater text
     */
    public function getUpdaterIdTextAttribute() {
        //Get updater
        $updater = $this->updater()->first();

        //Return employee name
        return $updater ? $updater->first_name . ' ' . $updater->last_name : '';
    }

//E# getUpdaterTextAttribute() function
}

//E# BaseModel() class
