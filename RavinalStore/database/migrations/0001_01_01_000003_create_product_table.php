<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('ProductName');
        $table->decimal('Price', 8, 2);
        $table->text('Description');
        $table->string('ProductCategory');
        $table->string('Image')->nullable();
        $table->timestamps(); // This will add created_at and updated_at columns
    });
}

};
