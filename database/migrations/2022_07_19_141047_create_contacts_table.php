<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->comment('Полное ФИО');
            $table->string('company')->comment('Название компании')->nullable();
            $table->string('phone')->comment('Без 8');
            $table->string('email')->comment('Электронная почта');
            $table->date('date_birthday')->comment('Дата рождения')->nullable();
            $table->string('photo')->comment('Название фото файла')->nullable();
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
        Schema::dropIfExists('contacts');
    }
}
