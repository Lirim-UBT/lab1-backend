<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model{
    use HasFactory;

    protected $fillable = [
        'name',
        'ects',
        'semester',
        'education_level',
        'status',
    ];
    protected $casts    = [
        'ects'     => 'integer',
        'semester' => 'integer',
        'status'   => 'integer',
    ];

    public function exams(){
        return $this->hasMany(Exam::class);
    }
}
