<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetaTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meta_tags', function (Blueprint $table) {
            $table->id();
            $table->string('section');
            $table->string('title');
            $table->text('meta_keywords');
            $table->text('meta_description');
            $table->text('meta_og_title');
            $table->text('meta_og_description');
            $table->string('url_canonical');
            $table->string('url_image_og');
            $table->string('meta_type')->nullable();
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
        Schema::dropIfExists('meta_tags');
    }
}
