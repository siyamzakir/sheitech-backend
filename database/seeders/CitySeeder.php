<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            [
                "id" => "65",
                "division_id" => "3",
                "name" => "Dhaka Metro",
            ],
            [
                "id" => "1",
                "division_id" => "3",
                "name" => "Dhamrai",
            ],
            [
                "id" => "66",
                "division_id" => "3",
                "name" => "Dohar",
            ],
            [
                "id" => "67",
                "division_id" => "3",
                "name" => "Keraniganj",
            ],
            [
                "id" => "68",
                "division_id" => "3",
                "name" => "Nawabganj",
            ],
            [
                "id" => "69",
                "division_id" => "3",
                "name" => "Savar",
            ],
            [
                "id" => "2",
                "division_id" => "3",
                "name" => "Faridpur",
            ],
            [
                "id" => "3",
                "division_id" => "3",
                "name" => "Gazipur",
            ],
            [
                "id" => "4",
                "division_id" => "3",
                "name" => "Gopalganj",
            ],
            [
                "id" => "5",
                "division_id" => "8",
                "name" => "Jamalpur",
            ],
            [
                "id" => "6",
                "division_id" => "3",
                "name" => "Kishoreganj",
            ],
            [
                "id" => "7",
                "division_id" => "3",
                "name" => "Madaripur",
            ],
            [
                "id" => "8",
                "division_id" => "3",
                "name" => "Manikganj",
            ],
            [
                "id" => "9",
                "division_id" => "3",
                "name" => "Munshiganj",
            ],
            [
                "id" => "10",
                "division_id" => "8",
                "name" => "Mymensingh",
            ],
            [
                "id" => "11",
                "division_id" => "3",
                "name" => "Narayanganj",
            ],
            [
                "id" => "12",
                "division_id" => "3",
                "name" => "Narsingdi",
            ],
            [
                "id" => "13",
                "division_id" => "8",
                "name" => "Netrokona",
            ],
            [
                "id" => "14",
                "division_id" => "3",
                "name" => "Rajbari",
            ],
            [
                "id" => "15",
                "division_id" => "3",
                "name" => "Shariatpur",
            ],
            [
                "id" => "16",
                "division_id" => "8",
                "name" => "Sherpur",
            ],
            [
                "id" => "17",
                "division_id" => "3",
                "name" => "Tangail",
            ],
            [
                "id" => "18",
                "division_id" => "5",
                "name" => "Bogura",
            ],
            [
                "id" => "19",
                "division_id" => "5",
                "name" => "Joypurhat",
            ],
            [
                "id" => "20",
                "division_id" => "5",
                "name" => "Naogaon",
            ],
            [
                "id" => "21",
                "division_id" => "5",
                "name" => "Natore",
            ],
            [
                "id" => "22",
                "division_id" => "5",
                "name" => "Nawabganj",
            ],
            [
                "id" => "23",
                "division_id" => "5",
                "name" => "Pabna",
            ],
            [
                "id" => "24",
                "division_id" => "5",
                "name" => "Rajshahi",
            ],
            [
                "id" => "25",
                "division_id" => "5",
                "name" => "Sirajgonj",
            ],
            [
                "id" => "26",
                "division_id" => "6",
                "name" => "Dinajpur",
            ],
            [
                "id" => "27",
                "division_id" => "6",
                "name" => "Gaibandha",
            ],
            [
                "id" => "28",
                "division_id" => "6",
                "name" => "Kurigram",
            ],
            [
                "id" => "29",
                "division_id" => "6",
                "name" => "Lalmonirhat",
            ],
            [
                "id" => "30",
                "division_id" => "6",
                "name" => "Nilphamari",
            ],
            [
                "id" => "31",
                "division_id" => "6",
                "name" => "Panchagarh",
            ],
            [
                "id" => "32",
                "division_id" => "6",
                "name" => "Rangpur",
            ],
            [
                "id" => "33",
                "division_id" => "6",
                "name" => "Thakurgaon",
            ],
            [
                "id" => "34",
                "division_id" => "1",
                "name" => "Barguna",
            ],
            [
                "id" => "35",
                "division_id" => "1",
                "name" => "Barishal",
            ],
            [
                "id" => "36",
                "division_id" => "1",
                "name" => "Bhola",
            ],
            [
                "id" => "37",
                "division_id" => "1",
                "name" => "Jhalokati",
            ],
            [
                "id" => "38",
                "division_id" => "1",
                "name" => "Patuakhali",
            ],
            [
                "id" => "39",
                "division_id" => "1",
                "name" => "Pirojpur",
            ],
            [
                "id" => "40",
                "division_id" => "2",
                "name" => "Bandarban",
            ],
            [
                "id" => "41",
                "division_id" => "2",
                "name" => "Brahmanbaria",
            ],
            [
                "id" => "42",
                "division_id" => "2",
                "name" => "Chandpur",
            ],
            [
                "id" => "43",
                "division_id" => "2",
                "name" => "Chattogram",
            ],
            [
                "id" => "44",
                "division_id" => "2",
                "name" => "Cumilla",
            ],
            [
                "id" => "45",
                "division_id" => "2",
                "name" => "Cox\'s Bazar",
            ],
            [
                "id" => "46",
                "division_id" => "2",
                "name" => "Feni",
            ],
            [
                "id" => "47",
                "division_id" => "2",
                "name" => "Khagrachari",
            ],
            [
                "id" => "48",
                "division_id" => "2",
                "name" => "Lakshmipur",
            ],
            [
                "id" => "49",
                "division_id" => "2",
                "name" => "Noakhali",
            ],
            [
                "id" => "50",
                "division_id" => "2",
                "name" => "Rangamati",
            ],
            [
                "id" => "51",
                "division_id" => "7",
                "name" => "Habiganj",
            ],
            [
                "id" => "52",
                "division_id" => "7",
                "name" => "Maulvibazar",
            ],
            [
                "id" => "53",
                "division_id" => "7",
                "name" => "Sunamganj",
            ],
            [
                "id" => "54",
                "division_id" => "7",
                "name" => "Sylhet",
            ],
            [
                "id" => "55",
                "division_id" => "4",
                "name" => "Bagerhat",
            ],
            [
                "id" => "56",
                "division_id" => "4",
                "name" => "Chuadanga",
            ],
            [
                "id" => "57",
                "division_id" => "4",
                "name" => "Jashore",
            ],
            [
                "id" => "58",
                "division_id" => "4",
                "name" => "Jhenaidah",
            ],
            [
                "id" => "59",
                "division_id" => "4",
                "name" => "Khulna",
            ],
            [
                "id" => "60",
                "division_id" => "4",
                "name" => "Kushtia",
            ],
            [
                "id" => "61",
                "division_id" => "4",
                "name" => "Magura",
            ],
            [
                "id" => "62",
                "division_id" => "4",
                "name" => "Meherpur",
            ],
            [
                "id" => "63",
                "division_id" => "4",
                "name" => "Narail",
            ],
            [
                "id" => "64",
                "division_id" => "4",
                "name" => "Satkhira",
            ],


        ];
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('cities')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::table('cities')->insert($cities);
    }
}
