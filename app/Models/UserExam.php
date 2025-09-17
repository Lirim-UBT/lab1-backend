<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExam extends Model{
    use HasFactory;

    protected $table    = 'users_exams_pivot';
    protected $fillable = [
        'user_id',
        'exam_id',
        'grade',
        'status',
        'term',
    ];
    protected $casts    = [
        'user_id' => 'integer',
        'exam_id' => 'integer',
        'grade'   => 'integer',
        'status'  => 'integer',
        'term'    => 'integer',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function exam(){
        return $this->belongsTo(Exam::class);
    }
}
