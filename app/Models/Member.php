<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{

    protected $fillable = [
        'user_id', 'coach_id', 'training_id', 'firstName', 'lastName'
     ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }


    public function coach()
    {
        return $this->belongsTo(Coach::class,'coach_id');
    }

    public function training()
    {
        return $this->belongsTo(Training::class,'training_id');
    }

    use HasFactory;
}
