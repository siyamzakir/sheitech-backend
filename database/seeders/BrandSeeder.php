<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('brands')->insert([
            [
                'name'       => 'Honda',
                'image_url'  => 'https://via.placeholder.com/150',
                'type'       => 'bike',
                'category_id' => null,
                'is_popular' => 1,
            ],
            [
                'name'       => 'Yamaha',
                'image_url'  => 'https://via.placeholder.com/150',
                'type'       => 'bike',
                'category_id' => null,
                'is_popular' => 1,
            ],
            [
                'name'       => 'Suzuki',
                'image_url'  => 'https://via.placeholder.com/150',
                'type'       => 'bike',
                'category_id' => null,
                'is_popular' => 1,
            ],
            [
                'name'       => 'Kawasaki',
                'image_url'  => 'https://via.placeholder.com/150',
                'type'       => 'bike',
                'category_id' => null,
                'is_popular' => 1,
            ],
            [
                'name'       => 'BMW',
                'image_url'  => 'https://via.placeholder.com/150',
                'type'       => 'bike',
                'category_id' => null,
                'is_popular' => 1,
            ],
            [
                'name'       => 'Victory',
                'image_url'  => 'https://via.placeholder.com/150',
                'type'       => 'bike',
                'category_id' => null,
                'is_popular' => 1,
            ],
            [
                'name'       => 'Triumph',
                'image_url'  => 'https://via.placeholder.com/150',
                'type'       => 'bike',
                'category_id' => null,
                'is_popular' => 1,
            ],
            [
                'name'       => 'Harley Davidson',
                'image_url'  => 'https://via.placeholder.com/150',
                'type'       => 'bike',
                'category_id' => null,
                'is_popular' => 1,
            ],
            [
                'name'       => 'Ducati',
                'image_url'  => 'https://via.placeholder.com/150',
                'type'       => 'bike',
                'category_id' => null,
                'is_popular' => 1,
            ],
            [
                'name'       => 'KTM',
                'image_url'  => 'https://via.placeholder.com/150',
                'type'       => 'bike',
                'category_id' => null,
                'is_popular' => 1,
            ],
            [
                'name'       => 'Aprilia',
                'image_url'  => 'https://via.placeholder.com/150',
                'type'       => 'bike',
                'category_id' => null,
                'is_popular' => 1,
            ],
            [
                'name'       => 'Kymco',
                'image_url'  => 'https://via.placeholder.com/150',
                'type'       => 'bike',
                'category_id' => null,
                'is_popular' => 1,
            ],
            [
                'name'       => 'Royal Enfield',
                'image_url'  => 'https://via.placeholder.com/150',
                'type'       => 'bike',
                'category_id' => null,
                'is_popular' => 1,
            ],
            [
                'name'       => 'Royal Enfield',
                'image_url'  => 'https://via.placeholder.com/150',
                'type'       => 'accessory',
                'category_id' => null,
                'is_popular' => 1,
            ],
            [
                'name'       => 'KTM',
                'image_url'  => 'https://via.placeholder.com/150',
                'type'       => 'accessory',
                'category_id' => null,
                'is_popular' => 1,
            ],
            [
                'name'       => 'Aprilia',
                'image_url'  => 'https://via.placeholder.com/150',
                'type'       => 'accessory',
                'category_id' => null,
                'is_popular' => 1,
            ],
            [
                'name'       => 'Kymco',
                'image_url'  => 'https://via.placeholder.com/150',
                'type'       => 'accessory',
                'category_id' => null,
                'is_popular' => 1,
            ],
            [
                'name'       => 'Royal Enfield',
                'image_url'  => 'https://via.placeholder.com/150',
                'type'       => 'accessory',
                'category_id' => null,
                'is_popular' => 1,
            ],
            [
                'name'       => 'Royal Enfield',
                'image_url'  => 'https://via.placeholder.com/150',
                'type'       => 'accessory',
                'category_id' => null,
                'is_popular' => 1,
            ],
            [
                'name'       => 'KTM',
                'image_url'  => 'https://via.placeholder.com/150',
                'type'       => 'accessory',
                'category_id' => null,
                'is_popular' => 1,
            ],
            [
                'name'       => 'Aprilia',
                'image_url'  => 'https://via.placeholder.com/150',
                'type'       => 'accessory',
                'category_id' => null,
                'is_popular' => 1,
            ],
            [
                'name'       => 'Kymco',
                'image_url'  => 'https://via.placeholder.com/150',
                'type'       => 'accessory',
                'category_id' => null,
                'is_popular' => 1,
            ],
            [
                'name'       => 'Royal Enfield',
                'image_url'  => 'https://via.placeholder.com/150',
                'type'       => 'accessory',
                'category_id' => null,
                'is_popular' => 1,
            ],
            [
                'name'       => 'Royal Enfield',
                'image_url'  => 'https://via.placeholder.com/150',
                'type'       => 'accessory',
                'category_id' => 1,
                'is_popular' => 1,
            ],
            [
                'name'       => 'KTM',
                'image_url'  => 'https://via.placeholder.com/150',
                'type'       => 'accessory',
                'category_id' => 2,
                'is_popular' => 1,
            ],
            [
                'name'       => 'Aprilia',
                'image_url'  => 'https://via.placeholder.com/150',
                'type'       => 'accessory',
                'category_id' => 3,
                'is_popular' => 1,
            ],
            [
                'name'       => 'Kymco',
                'image_url'  => 'https://via.placeholder.com',
                'type'       => 'accessory',
                'category_id' => 4,
                'is_popular' => 1,
            ]
        ]);
    }
}
