<?php

namespace App\Models;

use App\Traits\ModelsTrait\GeneralCrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recipe extends Model
{
    use HasFactory;
    use GeneralCrudTrait;
    protected $fillabl = [
        'title',
        'category_id',
        'sub_category_id',
        'user_id',
        'body',
        'order',
        'image1',
        'image2',
        'image3',
        'file_id',
        'rate',
        'views',
        'likes',
    ];
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
