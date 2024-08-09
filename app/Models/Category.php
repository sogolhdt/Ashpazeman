<?php

namespace App\Models;

use App\Traits\ModelsTrait\GeneralCrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
    use GeneralCrudTrait;

    protected $fillable = [
        'title',
        'image',
        'orderّ'
    ];
    public function subCategories(): HasMany
    {
        return $this->hasMany(SubCategory::class);
    } public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class);
    }
}
