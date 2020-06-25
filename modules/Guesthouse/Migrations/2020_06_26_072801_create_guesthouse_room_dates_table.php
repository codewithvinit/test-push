<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuesthouseRoomDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bravo_guesthouse_room_dates', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->bigInteger('target_id')->nullable();

            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->decimal('price',12,2)->nullable();
            $table->tinyInteger('max_guests')->nullable();
            $table->tinyInteger('active')->default(0)->nullable();
            $table->text('note_to_customer')->nullable();
            $table->text('note_to_admin')->nullable();
            $table->tinyInteger('is_instant')->default(0)->nullable();
            $table->smallInteger('number')->nullable();

            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
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
        Schema::dropIfExists('bravo_guesthouse_room_dates');
    }
}
