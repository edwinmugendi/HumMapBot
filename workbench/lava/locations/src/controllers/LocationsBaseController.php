<?php

namespace Lava\Locations;

/**
 * S# LocationsBaseController() function
 * Locations Base Controller
 * @author Edwin Mugendi
 */
class LocationsBaseController extends \BaseController {

	//Package
	public $package = 'locations';

	/**
	 * S# getSelectOptions() function
	 * @author Edwin Mugendi
	 * Get countries select options
	 * @param string $language the code of the language
	 * @param string $listType the type of the list
	 * @return array countries select options
	 */
	public function getSelectOptions() {
		//Camelize cache name
		$cacheName = camel_case($this->controller.'_SectionOptions');

		\Cache::section($this->package)->flush($cacheName);

		if (!\Cache::section($this->package)->has($cacheName)) {//Country options not in cache
			//Fields to select
			$fields = array('id', 'name');

			//Build where clause
			$whereClause = array(
			    array(
				   'where' => 'where',
				   'column' => 'status',
				   'operator' => '=',
				   'operand' => 1
			    )
			);

			//Build extra parameters
			$parameters = array();
			$parameters['orderBy'][] = array('name' => 'asc');

			$parameters['convertTo'] = 'toArray';

			//Select all active country models
			$countryModel = $this->select($fields, $whereClause, 2, $parameters);

			//Array cache 
			$selectOptionsCache = array();

			//Prepend the array with the "Select Country"
			$selectOptionsCache[''] = \Lang::get('common.select');

			if ($countryModel) {//Country Model exist
				foreach ($countryModel as $singleCountryModel) {//Loop through country model
					$optionAttributes = array();
					$optionAttributes['text'] = $singleCountryModel['name'];
					$optionAttributes['id'] = $singleCountryModel['id'];

					//Append country option to the cache
					$selectOptionsCache[] = $optionAttributes;
				}//E# foreach statement
			}//E# if statement
			//Cache type select options
			\Cache::section($this->package)->forever($cacheName, $selectOptionsCache);
		}//E# if statement
		//Return cached type select option
		return \Cache::section($this->package)->get($cacheName);
	}

//E# getSelectOptions() function 
}

//E# LocationsBaseController() function