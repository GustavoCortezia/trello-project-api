<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'sectionId',
        'environmentId'
    ];

    public function section(){
        return $this->belongsTo(Section::class, 'sectionId');
    }

    public function environment(){
        return $this->belongsTo(Environment::class, 'environmentId');
    }
}
