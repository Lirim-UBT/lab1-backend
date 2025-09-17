<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'professor_id',
    ];
    protected $casts    = [
        'subject_id'   => 'integer',
        'professor_id' => 'integer',
    ];

    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function professor(){
        return $this->belongsTo(User::class, 'professor_id');
    }

    public function users(){
        return $this->belongsToMany(User::class, 'users_exams_pivot')
                    ->withPivot('grade', 'status', 'term')
                    ->withTimestamps();
    }
}
