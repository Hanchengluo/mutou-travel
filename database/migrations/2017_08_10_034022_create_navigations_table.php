<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavigationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navigations', function (Blueprint $table) {
            $table->increments('id')->comment('自增id');
            $table->integer('parent_id')->comment('父id');
            $table->integer('position_id')->comment('位置id');
            $table->integer('sort')->default(0)->comment('排序、越小越靠前');
            $table->string('name')->comment('名称 用于权限控制、生成URL或多语言');
            $table->string('display_name')->comment('显示的名称');
            $table->string('target')->default('_self')->comment('链接打开方式:_self、_blank');
            $table->text('url')->nullable()->comment('链接地址');
            $table->string('icon')->default('ios-grid-view-outline')->comment('图标');
            $table->tinyInteger('icon_type')->default(0)->comment('图标类型-0：字体图标,1:图片');
            $table->tinyInteger('display')->default(1)->comment('是否显示-0:不显示、1:显示');
            $table->timestamps();
        });

        Schema::create('navigation_positions', function (Blueprint $table) {
            $table->increments('id')->commit('自增id');
            $table->string('name')->comment('导航标识');
            $table->string('display_name')->comment('显示的名称');
            $table->integer('sort')->default(0)->comment('排序');
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
        Schema::dropIfExists('navigations');
        Schema::dropIfExists('navigation_positions');
    }
}
