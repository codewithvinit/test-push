<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuesthouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bravo_guesthouses', function (Blueprint $table) {
            $table->bigIncrements('id');
            //Info
            $table->string('title', 255)->nullable();
            $table->string('slug', 255)->charset('utf8')->index();
            $table->text('content')->nullable();
            $table->integer('image_id')->nullable();
            $table->integer('banner_image_id')->nullable();
            $table->integer('location_id')->nullable();
            $table->string('address', 255)->nullable();
            $table->string('map_lat', 20)->nullable();
            $table->string('map_lng', 20)->nullable();
            $table->integer('map_zoom')->nullable();
            $table->tinyInteger('is_featured')->nullable();
            $table->string('gallery', 255)->nullable();
            $table->string('video', 255)->nullable();
            $table->text('policy')->nullable();
            $table->smallInteger('star_rate')->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->string('check_in_time', 255)->nullable();
            $table->string('check_out_time', 255)->nullable();
            $table->smallInteger('allow_full_day')->nullable();
            $table->decimal('sale_price', 12,2)->nullable();
            $table->string('status', 50)->nullable();
            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
            $table->decimal('review_score')->nullable();
            $table->string('ical_import_url')->nullable();
            $table->tinyInteger('enable_extra_price')->nullable();
            $table->text('extra_price')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('bravo_guesthouses');
    }
}
