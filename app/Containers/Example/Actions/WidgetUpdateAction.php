<?php

namespace App\Containers\Example\Actions;

use App\Containers\Example\Events\WidgetCreatedEvent;
use App\Containers\Example\Events\WidgetUpdatedEvent;
use App\Containers\Example\Interfaces\Repositories\WidgetRepositoryInterface;
use App\Containers\Example\Models\Widget;
use App\Containers\Example\Traits\Widget\SetWidgetNameTrait;
use App\Containers\Example\Traits\Widget\SetWidgetPriceTrait;
use App\Ship\Actions\BaseAbstractAction;
use App\Ship\Interfaces\Actions\BaseActionInterface;
use Illuminate\Support\Collection;

class WidgetUpdateAction extends BaseAbstractAction implements BaseActionInterface
{
    use SetWidgetNameTrait,
        SetWidgetPriceTrait;

    /**
     * @var Widget
     */
    protected $widget;

    /**
     * @var WidgetRepositoryInterface
     */
    protected $widgetRepository;

    /**
     * WidgetStoreAction constructor.
     * @param WidgetRepositoryInterface $widgetRepository
     */
    public function __construct(WidgetRepositoryInterface $widgetRepository)
    {
        $this->widgetRepository = $widgetRepository;
    }

    /**
     * @param Widget $widget
     * @return Widget
     */
    public function run(Widget $widget) : Widget
    {
        // Create the widget
        $this->widget = $widget;

        // Set the name
        $this->widget = $this->setWidgetName($this->widget, 'sdfdf');

        // Set the price
        $this->widget = $this->setWidgetPrice($this->widget, '10.23');

        // Return the widget (not persisted yet)
        return $this->widget;
    }

    /**
     * Return the class name used as the Action completed Event
     *
     * @return string
     */
    public function event()
    {
        return WidgetUpdatedEvent::class;
    }

    /**
     * Return the arguments passed to the Event constructor
     *
     * @return array
     */
    public function eventArguments() : array
    {
        return [ $this->widget ];
    }

    /**
     * Return a Collection of the models to be persisted
     *
     * @return Collection
     */
    public function models(): Collection
    {
        return collect()
            ->push($this->widget);
    }

    /**
     * Return a "map" of the Repositories used to persist (save) the models
     *
     * @return string[]
     */
    public function repositoryMap(): array
    {
        return [
            Widget::class => $this->widgetRepository,
        ];
    }
}