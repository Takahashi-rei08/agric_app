<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $params = [
            [
                'name' => '収穫'
            ],
            [
                'name' => '移植'
            ],
            [
                'name' => '耕耘'
            ],
            [
                'name' => '間引き'
            ],
            
        ];
        foreach($params as $param){
            DB::table('actions')->insert($param);
        }
    }
}
