<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Plant_Location;
use App\Models\Plant;

class Location extends Model
{
    use HasFactory;
    
    //usersテーブルに対するリレーション
    public function users(){
        return $this->hasMany(User::class);
    }
    
    //plantsテーブルに対するリレーション
    public function plants(){
        return $this->belongsToMany(Plant::class, 'plant_location');
    }
}
