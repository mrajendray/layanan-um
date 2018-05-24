<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertUsersData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = DB::table('users');

        $insert = array(
            array("fakultas"=>"Fakultas Teknik","username"=>"teknik","password"=>bcrypt("teknik")),
            array("fakultas"=>"Fakultas Sastra","username"=>"sastra","password"=>bcrypt("sastra"))
        );
        $table->insert($insert);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
