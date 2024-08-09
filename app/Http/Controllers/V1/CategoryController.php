<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\ModelController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Response;

class CategoryController extends ModelController
{

    public function __construct(Request $request, Category $model)
    {
        parent::__construct($request, $model);
    }
    public function store()
    {
        $this->validate([
            'title' => 'required|string',
            'image' => 'string',

        ]);
        $this->model->saveModel($this->fillable);
    }
}
