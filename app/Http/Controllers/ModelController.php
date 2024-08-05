<?php

namespace App\Http\Controllers;

use App\Traits\ModelsTrait\GeneralCrudTrait;
use App\Traits\Responses\ResourceWithTrait;
use App\Traits\Responses\FailedResponseTrait;
use App\Traits\Responses\SuccessResponseTrait;

use Illuminate\Http\Request;


class ModelController extends Controller
{
    use ResourceWithTrait , FailedResponseTrait, SuccessResponseTrait;
    use GeneralCrudTrait;
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
    
}
