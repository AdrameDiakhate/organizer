<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'wording',
    ];
    public function users() {
        return $this->belongsToMany(User::class);
    }
    
    public function comments() {
        return $this->belongsToMany(Comment::class);
    }
    
}
