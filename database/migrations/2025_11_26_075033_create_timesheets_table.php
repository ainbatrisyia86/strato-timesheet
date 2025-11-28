<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('timesheets', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');

        $table->integer('week');       
        $table->integer('month');      
        $table->integer('year');      

        $table->string('position');  
        $table->date('date');          

        $table->string('project');   
        $table->string('task');        

        $table->time('start_time');    
        $table->time('end_time');      

        $table->decimal('total_hours', 5, 2); 
        
        $table->string('status')->default('draft'); // draft/submitted
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timesheets');
    }
};
