<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Post;

class Comment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'post_id',
        'comment',
    ];
    
     //usersテーブルに対するリレーション
    public function user(){
        return $this->belongsToMany(User::class);
    }
    
    //postsテーブルに対するリレーション
    public function post(){
        return $this->belongsToMany(Post::class);
    }
}
