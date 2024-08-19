<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Calendar;
use App\Models\Comment;
use App\Models\User;
use App\Models\Plant;
use App\Models\Action;

class Post extends Model
{
    use HasFactory;
    
    //calendarsテーブルに対するリレーション
    public function calendar(){
        return $this->hasOne(Calendar::class);
    }
    
    //commentsテーブルに対するリレーション
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    
    //usersテーブルに対するリレーション
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    //plantsテーブルに対するリレーション
    public function plant(){
        return $this->belongsTo(Plant::class);
    }
    
    //actionsテーブルに対するリレーション
    public function action(){
        return $this->belongsTo(Action::class);
    }
    
    public function getPaginateByLimit(int $limit_count = 5)
    {
        // updated_atで降順に並べたあと、limitで件数制限をかける
        return $this->orderBy('updated_at', 'DESC')->paginate($limit_count);
    }
}
