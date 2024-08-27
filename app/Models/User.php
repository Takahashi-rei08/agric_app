<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Schedule;
use App\Models\City;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'city_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    //commentsテーブルに対するリレーション
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    
    //postsテーブルに対するリレーション
    public function posts(){
        return $this->hasMany(Post::class);
    }
    
    //schedulesテーブルに対するリレーション
    public function schedules(){
        return $this->hasMany(Schedule::class);
    }
    
    //Citiesテーブルに対するリレーション
    public function City(){
        return $this->belongsTo(City::class);
    }
}
