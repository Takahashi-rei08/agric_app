<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Plant_City;
use App\Models\Plant;
use App\Models\User;

class City extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'code',
        'name',
        'prefecture_id',
    ];
    
    //usersテーブルに対するリレーション
    public function users(){
        return $this->hasMany(User::class);
    }
    
    //plantsテーブルに対するリレーション
    public function plants(){
        return $this->belongsToMany(Plant::class, 'plant_location');
    }
    
    public $timestamps = false;
}
