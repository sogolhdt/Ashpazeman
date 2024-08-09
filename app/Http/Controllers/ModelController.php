<?php

namespace App\Http\Controllers;

use App\Traits\Responses\ResourceWithTrait;
use App\Traits\Responses\FailedResponseTrait;
use App\Traits\Responses\SuccessResponseTrait;

use Illuminate\Http\Request;


class ModelController extends Controller
{
    use ResourceWithTrait , FailedResponseTrait, SuccessResponseTrait;
    protected $model;
    protected $request;
    protected $fillable;
    protected $requestFillable;


    public function __construct(Request $request,$model)
    {
        
        $this->model=$model;
        $this->fillable=$this->model->getFillable();
        $this->request=$request;
        $this->requestFillable=$this->request->only($this->fillable);
    }
    protected function validate(array $rules): void{
        $this->request->validate($rules);
    }
    protected function getOrder(Request $request)
    {

        $orderBy = $request->query('orderBy', 'id');
        $sort = $request->query('sort', 'desc');

        return [$orderBy => $sort];
    }
    
}
