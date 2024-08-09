<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\ModelController;
use App\Http\Resources\Category\CategoryCollection;
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
    public function list()
    {
        $limit = $this->request->query('limit', 15);
        $order = $this->getOrder($this->request);

        $data = $this->model->_filter($this->requestFillable, $order, $limit);
        return new CategoryCollection($data);
    }
    public function store()
    {
        $this->validate([
            'title' => 'required|string',
            'image' => 'string',
            'order'=>'int'

        ]);
        $this->model->saveModel($this->fillable);
    }
}
