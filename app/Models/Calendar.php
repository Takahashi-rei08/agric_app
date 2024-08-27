<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Schedule;
use App\Models\Post;

class Calendar extends Model
{
    use HasFactory;
    
    //schedulesテーブルに対するリレーション
    public function schedule(){
        return $this->belongsTo(Schedule::class);
    }
    
    //postsテーブルに対するリレーション
    public function post(){
        return $this->belongsTo(Post::class);
    }
    
    public $timestamps = false;
}
