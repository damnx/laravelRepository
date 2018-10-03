<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhoneNumberAddressGenderIsActiveToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string("phone_number")->nullable($value = true);
            $table->longText("address")->nullable($value = true);
            $table->tinyInteger("gender")->default(0);
            $table->boolean("is_active")->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn("phone_number");
            $table->dropColumn("address");
            $table->dropColumn("gender");
            $table->dropColumn("is_active");
        });
    }
}
