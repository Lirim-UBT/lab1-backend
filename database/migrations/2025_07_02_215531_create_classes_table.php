<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('classes', function(Blueprint $table){
            $table->id();
            $table->unsignedInteger("subject_id");
            $table->unsignedInteger("professor_id");

            $table->foreign("subject_id")->references("id")->on("subjects");
            $table->foreign("professor_id")->references("id")->on("subjects");
            $table->timestamps();
        });
    }

    public function down(): void{
        Schema::dropIfExists('classes');
    }
};
