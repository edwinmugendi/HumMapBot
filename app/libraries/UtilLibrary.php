<?php

/**
 * S# UtilLibrary() function
 * Business controller
 * @author Edwin Mugendi
 */
class UtilLibrary {

    /**
     * S# buildNamespace() function
     * Build name space
     * @param string $package The package
     * @param string $class The class
     * @param int $type The type of class to build ie Controller or Model
     * @return string The namespace
     */
    public static function buildNamespace($package, $class, $type) {
        $class = studly_case($class);
        $package = studly_case($package);
        if ($type == 1) {
            return '\Lava\\' . $package . '\\' . $class . 'Controller';
        } else if ($type == 2) {
            return '\Lava\\' . $package . '\\' . $class . 'Model';
        }//E# if else statement
    }

//E# buildNamespace() method

    /**
     * S# buildUrl() function
     * Build url
     */
    public static function buildUrl($route, $queryStrArray, $parameters = array()) {
        //Build the query string to add
        $queryString = http_build_query($queryStrArray);
        
        //Generate the route url and append the query string, then return
       return \URL::route($route, $parameters).'?'.$queryString;
    }

//E# buildUrl() method
}

//E# UtilLibrary() function