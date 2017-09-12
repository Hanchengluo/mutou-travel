<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRedirectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redirects', function (Blueprint $table) {
            $table->increments('id')->comment('自增id');
            $table->string('url')->comment('原地址');
            $table->string('redirect')->comment('要重定向到的地址');
            $table->integer('code')->nullable()->default(301)->comment('http状态码');
            $table->mediumText('description')->nullable()->comment('描述');
            $table->timestamps();
            $table->index(['url','redirect','description']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('redirects',function(Blueprint $table){
            $table->dropIndex(['url','redirect','description']);
        });
        Schema::dropIfExists('redirects');
    }
}
