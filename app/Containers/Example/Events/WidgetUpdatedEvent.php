<?php


namespace App\Containers\Example\Events;


use App\Containers\Example\Models\Widget;

class WidgetUpdatedEvent
{
    protected $widget;

    public function __construct(Widget $widget)
    {
        $this->widget = $widget;
    }
}