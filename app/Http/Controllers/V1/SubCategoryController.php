<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ModelController;
use App\Http\Resources\Category\SubCategoryCollection;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends ModelController
{
    public function __construct(Request $request, SubCategory $model)
    {
        parent::__construct($request, $model);
    }
    public function list()
    {
        $limit = $this->request->query('limit', 15);
        $order = $this->getOrder($this->request);

        $data = $this->model->_filter($this->requestFillable, $order, $limit);
        return new SubCategoryCollection($data);
    }
    public function store()
    {
        $this->validate([
            'title' => 'required|string',
            'category_id'=>'int|exists:categories,id',
            'image' => 'string',
            'order'=>'int'

        ]);
        $this->model->saveModel($this->fillable);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
