<?php

namespace Lava\Locations;

class LocationsSeeder extends \Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\Eloquent::unguard();
		//Locations
		$this->call('Lava\Locations\CountriesTableSeeder');
		$this->call('Lava\Locations\TimezonesTableSeeder');
		$this->call('Lava\Locations\CurrenciesTableSeeder');
	}

}
