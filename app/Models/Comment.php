<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'content',
        'date'
    ];

    public function task() {
        return $this->belongsTo(Task::class);
    }
    
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function reactions() {
        return $this->belongsToMany(Reaction::class);
    }
    
}
