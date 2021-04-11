<?php


namespace App\Containers\Example\Traits\Widget;


use App\Containers\Example\Models\Widget;

trait SetWidgetNameTrait
{
    public function setWidgetName(Widget $widget, string $name) : Widget
    {
        return $this->widgetRepository->fill($widget, [ 'name' => $name ]);
    }
}