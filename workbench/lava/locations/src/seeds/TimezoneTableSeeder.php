<?php

namespace Lava\Locations;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimezonesTableSeeder extends Seeder {

	public function run() {
		//Seed timezones table
		DB::table('loc_timezones')->delete();

		$timezones = array(
		    array('id' => 1, 'name' => '(GMT) Casablanca', 'adjustment' => '+00:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 2, 'name' => '(GMT) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London', 'adjustment' => '+00:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 3, 'name' => '(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague', 'adjustment' => '+01:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 4, 'name' => '(GMT+01:00) Brussels, Copenhagen, Madrid, Paris', 'adjustment' => '+01:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 5, 'name' => '(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb', 'adjustment' => '+01:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 6, 'name' => '(GMT+01:00) West Central Africa', 'adjustment' => '+01:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 7, 'name' => '(GMT+02:00) Amman', 'adjustment' => '+02:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 8, 'name' => '(GMT+02:00) Athens, Bucharest, Istanbul', 'adjustment' => '+02:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 9, 'name' => '(GMT+02:00) Beirut', 'adjustment' => '+02:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 10, 'name' => '(GMT+02:00) Cairo', 'adjustment' => '+02:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 11, 'name' => '(GMT+02:00) Harare, Pretoria', 'adjustment' => '+02:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 12, 'name' => '(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius', 'adjustment' => '+02:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 13, 'name' => '(GMT+02:00) Jerusalem', 'adjustment' => '+02:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 14, 'name' => '(GMT+02:00) Minsk', 'adjustment' => '+02:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 15, 'name' => '(GMT+02:00) Windhoek', 'adjustment' => '+02:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 16, 'name' => '(GMT+03:00) Baghdad', 'adjustment' => '+03:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 17, 'name' => '(GMT+03:00) Kuwait, Riyadh', 'adjustment' => '+03:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 18, 'name' => '(GMT+03:00) Moscow, St. Petersburg, Volgograd', 'adjustment' => '+03:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 19, 'name' => '(GMT+03:00) Nairobi', 'adjustment' => '+03:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 20, 'name' => '(GMT+03:00) Tbilisi', 'adjustment' => '+03:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 21, 'name' => '(GMT+03:30) Tehran', 'adjustment' => '+03:30','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 22, 'name' => '(GMT+04:00) Abu Dhabi, Muscat', 'adjustment' => '+04:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 23, 'name' => '(GMT+04:00) Baku', 'adjustment' => '+04:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 24, 'name' => '(GMT+04:00) Caucasus Standard Time', 'adjustment' => '+04:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 25, 'name' => '(GMT+04:00) Yerevan', 'adjustment' => '+04:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 26, 'name' => '(GMT+04:30) Kabul', 'adjustment' => '+04:30','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 27, 'name' => '(GMT+05:00) Ekaterinburg', 'adjustment' => '+05:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 28, 'name' => '(GMT+05:00) Islamabad, Karachi', 'adjustment' => '+05:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 29, 'name' => '(GMT+05:00) Tashkent', 'adjustment' => '+05:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 30, 'name' => '(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi', 'adjustment' => '+05:30','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 31, 'name' => '(GMT+05:30) Sri Jayawardenepura', 'adjustment' => '+05:30','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 32, 'name' => '(GMT+05:45) Kathmandu', 'adjustment' => '+05:45','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 33, 'name' => '(GMT+06:00) Almaty, Novosibirsk', 'adjustment' => '+06:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 34, 'name' => '(GMT+06:00) Astana, Dhaka', 'adjustment' => '+06:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 35, 'name' => '(GMT+06:30) Yangon (Rangoon)', 'adjustment' => '+06:30','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 36, 'name' => '(GMT+07:00) Bangkok, Hanoi, Jakarta', 'adjustment' => '+07:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 37, 'name' => '(GMT+07:00) Krasnoyarsk', 'adjustment' => '+07:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 38, 'name' => '(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi', 'adjustment' => '+08:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 39, 'name' => '(GMT+08:00) Irkutsk, Ulaan Bataar', 'adjustment' => '+08:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 40, 'name' => '(GMT+08:00) Kuala Lumpur, Singapore', 'adjustment' => '+08:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 41, 'name' => '(GMT+08:00) Perth', 'adjustment' => '+08:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 42, 'name' => '(GMT+08:00) Taipei', 'adjustment' => '+08:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 43, 'name' => '(GMT+09:00) Osaka, Sapporo, Tokyo', 'adjustment' => '+09:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 44, 'name' => '(GMT+09:00) Seoul', 'adjustment' => '+09:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 45, 'name' => '(GMT+09:00) Yakutsk', 'adjustment' => '+09:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 46, 'name' => '(GMT+09:30) Adelaide', 'adjustment' => '+09:30','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 47, 'name' => '(GMT+09:30) Darwin', 'adjustment' => '+09:30','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 48, 'name' => '(GMT+10:00) Brisbane', 'adjustment' => '+10:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 49, 'name' => '(GMT+10:00) Canberra, Melbourne, Sydney', 'adjustment' => '+10:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 50, 'name' => '(GMT+10:00) Guam, Port Moresby', 'adjustment' => '+10:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 51, 'name' => '(GMT+10:00) Hobart', 'adjustment' => '+10:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 52, 'name' => '(GMT+10:00) Vladivostok', 'adjustment' => '+10:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 53, 'name' => '(GMT+11:00) Magadan, Solomon Is., New Caledonia', 'adjustment' => '+11:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 54, 'name' => '(GMT+12:00) Auckland, Wellington', 'adjustment' => '+12:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 55, 'name' => '(GMT+12:00) Fiji, Kamchatka, Marshall Is.', 'adjustment' => '+12:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 56, 'name' => '(GMT+13:00) Nuku alofa', 'adjustment' => '+13:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 57, 'name' => '(GMT-01:00) Azores', 'adjustment' => '-01:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 58, 'name' => '(GMT-01:00) Cape Verde Is.', 'adjustment' => '-01:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 59, 'name' => '(GMT-02:00) Mid-Atlantic', 'adjustment' => '-02:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 60, 'name' => '(GMT-03:00) Brasilia', 'adjustment' => '-03:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 61, 'name' => '(GMT-03:00) Buenos Aires', 'adjustment' => '-03:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 62, 'name' => '(GMT-03:00) Georgetown', 'adjustment' => '-03:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 63, 'name' => '(GMT-03:00) Greenland', 'adjustment' => '-03:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 64, 'name' => '(GMT-03:00) Montevideo', 'adjustment' => '-03:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 65, 'name' => '(GMT-03:30) Newfoundland', 'adjustment' => '-03:30','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 66, 'name' => '(GMT-04:00) Atlantic Time (Canada)', 'adjustment' => '-04:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 67, 'name' => '(GMT-04:00) La Paz', 'adjustment' => '-04:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 68, 'name' => '(GMT-04:00) Manaus', 'adjustment' => '-04:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 69, 'name' => '(GMT-04:00) Santiago', 'adjustment' => '-04:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 70, 'name' => '(GMT-04:30) Caracas', 'adjustment' => '-04:30','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 71, 'name' => '(GMT-05:00) Bogota, Lima, Quito, Rio Branco', 'adjustment' => '-05:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 72, 'name' => '(GMT-05:00) Eastern Time (US & Canada)', 'adjustment' => '-05:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 73, 'name' => '(GMT-05:00) Indiana (East)', 'adjustment' => '-05:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 74, 'name' => '(GMT-06:00) Central America', 'adjustment' => '-06:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 75, 'name' => '(GMT-06:00) Central Time (US & Canada)', 'adjustment' => '-06:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 76, 'name' => '(GMT-06:00) Guadalajara, Mexico City, Monterrey - New', 'adjustment' => '-06:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 77, 'name' => '(GMT-06:00) Guadalajara, Mexico City, Monterrey - Old', 'adjustment' => '-06:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 78, 'name' => '(GMT-06:00) Saskatchewan', 'adjustment' => '-06:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 79, 'name' => '(GMT-07:00) Arizona', 'adjustment' => '-07:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 80, 'name' => '(GMT-07:00) Chihuahua, La Paz, Mazatlan - New', 'adjustment' => '-07:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 81, 'name' => '(GMT-07:00) Chihuahua, La Paz, Mazatlan - Old', 'adjustment' => '-07:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 82, 'name' => '(GMT-07:00) Mountain Time (US & Canada)', 'adjustment' => '-07:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 83, 'name' => '(GMT-08:00) Pacific Time (US & Canada)', 'adjustment' => '-08:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 84, 'name' => '(GMT-08:00) Tijuana, Baja California', 'adjustment' => '-08:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 85, 'name' => '(GMT-09:00) Alaska', 'adjustment' => '-09:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 86, 'name' => '(GMT-10:00) Hawaii', 'adjustment' => '-10:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 87, 'name' => '(GMT-11:00) Midway Island, Samoa', 'adjustment' => '-11:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		    array('id' => 88, 'name' => '(GMT-12:00) International Date Line West', 'adjustment' => '-12:00','status'=>1,'created_by'=>1,'updated_by'=>1,'created_at'=> \Carbon\Carbon::now(),'updated_at'=> \Carbon\Carbon::now()),
		);

		//Unseed timezones table
		DB::table('loc_timezones')->insert($timezones);
	}

}
