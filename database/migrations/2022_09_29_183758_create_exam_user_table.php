<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users' , 'id');
            $table->foreignId('exam_id')->constrained('exams' , 'id');
            $table->float('score', 5 , 2)->nullable(); // 100.00
            $table->smallInteger('time_mins')->nullable();
            $table->enum('status' , ['opened', 'closed'])->default('closed'); // ????
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_user');
    }
};
