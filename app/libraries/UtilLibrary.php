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
     * doesNamespaceExist() function
     * Check if a namespace exist
     * 
     * @param string $class The class
     * @param int $type The type of class to build ie Controller = 1 or Model = 2
     *
     * return boolean true if exist, false otherwise
     */
    public static function doesNamespaceExist($class, $type) {
        return class_exists(static::buildNamespace($class, $type));
    }

//E# doesNamespaceExist() function

    /**
     * S# calculateSpan() function
     * @author Edwin Mugendi
     * Calculate the span of an form cell
     * @param int $cells number of cells
     * @return int span of a form cell
     */
    public static function calculateSpan($cells) {
        return (int) (\Config::get('product.grid') / $cells);
    }

//E# calculateSpan() function

    /**
     * S# buildUrl() function
     * Build url
     */
    public static function buildUrl($route, $queryStrArray, $parameters = array()) {
        //Build the query string to add
        $queryString = http_build_query($queryStrArray);

        //Generate the route url and append the query string, then return
        return \URL::route($route, $parameters) . '?' . $queryString;
    }

//E# buildUrl() method

    /**
     * S# percentage() function
     * 
     * Calculate percentage
     * 
     * @param float $rate Percentage rate
     * @param float $value Value
     * 
     * @return float percentage
     */
    public static function percentage($rate, $value, $precision = 2) {

        return round((($rate * $value) / 100), $precision);
    }

//E# percentage() function

    /**
     * S# search2DArray() function
     * Search 2-Dimensional Array
     * 
     * @param array $array Array to search
     * @param str $field Field to search
     * @param str $value Value to search against
     * 
     * @return Mixed int if index is found, null otherwise
     */
    public static function search2DArray($array, $field, $value) {
        foreach ($array as $key => $val) {
            if ($val[$field] === $value) {
                return $key;
            }//E# if statement
        }//E# foreach statement
        return null;
    }

//E# search2DArray() function
}

//E# UtilLibrary() function