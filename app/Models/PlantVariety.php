<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use App\Models\Schedule;
use App\Models\Plant;
use App\Models\Plant_City;
use App\Models\City;

class PlantVariety extends Model
{
    use HasFactory;
    
    protected $table = 'plantVarieties';
    
    protected $fillable = [
        'name',
        'plant_id',
    ];
    
    //postsテーブルに対するリレーション
    public function posts(){
        return $this->hasMany(Post::class);
    }
    
    //postsテーブルに対するリレーション
    public function schedules(){
        return $this->hasMany(Schedule::class);
    }
    
    //plantsテーブルに対するリレーション
    public function plant(){
        return $this->belongsTo(Plant::class);
    }
    
    //citiesテーブルに対するリレーション
    public function cities(){
        return $this->belongsToMany(City::class, 'plantVariety_city');
    }
    
    public $timestamps = false;
}
