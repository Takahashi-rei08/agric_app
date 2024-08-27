<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\City;

class Prefecture extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'pref_code',
        'pref_name',
    ];
    
    //usersテーブルに対するリレーション
    public function cities(){
        return $this->hasMany(city::class);
    }
    
    //plantsテーブルに対するリレーション
    public function plants(){
        return $this->belongsToMany(Plant::class, 'plant_location');
    }
    
    public $timestamps = false;
}
