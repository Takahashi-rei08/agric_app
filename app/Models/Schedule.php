<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Calendar;
use App\Models\Action;
use App\Models\Plant;
use App\Models\User;


class Schedule extends Model
{
    use HasFactory;
    
    //calendarsテーブルに対するリレーション
    public function calendar(){
        return $this->hasOne(Calendar::class);
    }
    
    //actionsテーブルに対するリレーション
    public function action(){
        return $this->belongsTo(Action::class);
    }
    
    //plantsテーブルに対するリレーション
    public function plant(){
        return $this->belongsTo(Plant::class);
    }
    
    //usersテーブルに対するリレーション
    public function user(){
        return $this->belongsTo(User::class);
    }
}
