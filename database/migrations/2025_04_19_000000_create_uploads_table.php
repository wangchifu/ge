<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploads', function (Blueprint $table) {
            $table->id();            
            $table->tinyInteger('order_by')->nullable();
            $table->string('power');
            $table->string('name');
            $table->string('sitename')->nullable();
            $table->string('url')->nullable();
            $table->unsignedInteger('type_id')->nullable();     
            $table->unsignedInteger('user_id');  
            $table->unsignedInteger('views');                   
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
        Schema::dropIfExists('uploads');
    }
}
