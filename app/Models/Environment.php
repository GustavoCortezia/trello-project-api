<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Environment extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'userId'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'userId');
    }

    public function card(){
        return $this->hasMany(Card::class, 'environmentId');
    }

    public function section(){
        return $this->hasMany(Section::class, 'environmentId');
    }
}
