<?php


namespace App\Containers\Example\Traits\Widget;


use App\Containers\Example\Models\Widget;

trait SetWidgetPriceTrait
{
    public function setWidgetPrice(Widget $widget, string $price) : Widget
    {
        return $this->widgetRepository->fill($widget, [ 'price' => $price ]);
    }
}