<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('users_exams_pivot', function(Blueprint $table){
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('exam_id')->constrained('exams');
            $table->unsignedBigInteger('term');
            $table->integer('grade')->default(0);
            $table->integer('status');
            $table->timestamps();
        });
    }

    public function down(): void{
        Schema::dropIfExists('users_exams_pivot');
    }
};
