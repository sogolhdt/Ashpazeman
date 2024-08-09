<?php

namespace App\Models;

use App\Traits\ModelsTrait\GeneralCrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubCategory extends Model
{
    use HasFactory;
    use GeneralCrudTrait;
    protected $fillable = [
        'title',
        'category_id',
        'order',
        'image'
    ];
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function recipes():HasMany{
        return $this->hasMany(Recipe::class);
    }
    
}
