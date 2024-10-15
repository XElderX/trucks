<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTruckSubunitsTable extends Migration
{
    public function up()
    {
        Schema::create('truck_subunits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('main_truck')->constrained('trucks')->onDelete('cascade'); // Main truck foreign key
            $table->foreignId('subunit')->constrained('trucks')->onDelete('cascade'); // Subunit truck foreign key
            $table->date('start_date'); // Start date
            $table->date('end_date'); // End date
            $table->timestamps(); // Timestamps for created_at and updated_at

            // Add a unique constraint to prevent overlapping subunit dates
            $table->unique(['main_truck', 'start_date', 'end_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('truck_subunits');
    }
}
