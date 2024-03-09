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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->double('discount', 8, 2)->default(0.00);
            $table->integer('points')->default(0);
            $table->foreignId('person_id');
            $table->foreign('person_id')
                ->references('id')
                ->on('people')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('type', 1)->comment('Individual or Business, [I, B, i, b]');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
