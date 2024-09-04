<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlantVarietySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $params = [
            [
                'name' => '桃太郎ゴールド',
                'plant_id' => 1,//トマト
            ],
            [
                'name' => 'ホーム桃太郎',
                'plant_id' => 1,//トマト
            ],
            [
                'name' => 'あきたこまち',
                'plant_id' => 3,//米
            ],
            [
                'name' => 'ひとめぼれ',
                'plant_id' => 3,//米
            ],
            
        ];
        foreach($params as $param){
            DB::table('plantVarieties')->insert($param);
        }
    }
}
