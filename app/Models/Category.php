<?php

namespace App\Models;

use App\Traits\ModelsTrait\GeneralCrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use GeneralCrudTrait;

    protected $fillable = [
        'title','image','orderّ'
    ];
}
