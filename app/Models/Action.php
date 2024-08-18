<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Schedule;
use App\Models\Post;

class Action extends Model
{
    use HasFactory;
    
    //schedulesテーブルに対するリレーション
    public function schedules(){
        return $this->hasMany(Schedule::class);
    }
    
    //postsテーブルに対するリレーション
    public function schedules(){
        return $this->hasMany(Schedule::class);
    }
}
