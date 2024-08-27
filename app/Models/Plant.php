<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use App\Models\Schedule;
use App\Models\Plant_Location;
use App\Models\City;

class Plant extends Model
{
    use HasFactory;
    
    //postsテーブルに対するリレーション
    public function posts(){
        return $this->hasMany(Post::class);
    }
    
    //postsテーブルに対するリレーション
    public function schedules(){
        return $this->hasMany(Schedule::class);
    }
    
    //locationsテーブルに対するリレーション
    public function cities(){
        return $this->belongsToMany(City::class, 'plant_city');
    }
    
    public $timestamps = false;
}
