<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'environmentId',
        'color'
    ];

    public function environment(){
        return $this->belongsTo(Environment::class, 'environmentId');
    }

    public function card(){
        return $this->hasMany(Card::class, 'sectionId');
    }
}
