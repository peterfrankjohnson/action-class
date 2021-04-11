<?php


namespace App\Containers\Example\Repositories;


use App\Containers\Example\Interfaces\Repositories\WidgetRepositoryInterface;
use App\Containers\Example\Models\Widget;

class WidgetRepositoryEloquent implements WidgetRepositoryInterface
{
    public function fill($model, array $modelData) : Widget
    {
        return $model->fill($modelData);
    }

    public function isDirty($model)
    {
        return $model->isDirty();
    }

    public function persist($model)
    {
        $model->save();
    }
}