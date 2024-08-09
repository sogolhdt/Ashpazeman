<?php

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\User;
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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('title',100);
            $table->foreignIdFor(Category::class);
            $table->foreignIdFor(SubCategory::class);
            $table->foreignIdFor(User::class,'user_id');
            $table->longText('body')->charset('utf8')->collation('utf8_persian_ci');
            $table->unsignedTinyInteger('order')->default(0);
            
            $table->string('image1',100);
            $table->string('image2',100);
            $table->string('image3',100);
            $table->unsignedSmallInteger('file_id')->nullable();
            $table->unsignedTinyInteger('rate')->default(0);
            $table->unsignedSmallInteger('views')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
