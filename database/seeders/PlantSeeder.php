<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $params = [
            [
                'name' => 'トマト'
            ],
            [
                'name' => 'きゅうり'
            ],
            [
                'name' => '米'
            ],
            [
                'name' => 'リンゴ'
            ],
            
        ];
        foreach($params as $param){
            DB::table('plants')->insert($param);
        }
    }
}
