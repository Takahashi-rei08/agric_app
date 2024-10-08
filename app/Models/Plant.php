<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use App\Models\Schedule;
use App\Models\PlantVariety;
use App\Models\Plant_City;
use App\Models\City;

class Plant extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
    ];
    
    //postsテーブルに対するリレーション
    public function posts(){
        return $this->hasMany(Post::class);
    }
    
    //postsテーブルに対するリレーション
    public function schedules(){
        return $this->hasMany(Schedule::class);
    }
    
    //PlantVarietiesテーブルに対するリレーション
    public function plantVarieties(){
        return $this->hasMany(PlantVariety::class);
    }
    
    //citiesテーブルに対するリレーション
    public function cities(){
        return $this->belongsToMany(City::class, 'plant_city');
    }
    
    public $timestamps = false;
}
