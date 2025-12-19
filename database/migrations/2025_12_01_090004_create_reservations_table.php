<?php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->integer('guests');
            $table->date('date');
            $table->string('time');
            $table->unsignedBigInteger('table_id');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('table_id')
                  ->references('id')
                  ->on('restaurant_tables')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};

