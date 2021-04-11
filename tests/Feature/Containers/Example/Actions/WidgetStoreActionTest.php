<?php


namespace Tests\Feature\Containers\Example\Actions;


use App\Containers\Example\Actions\WidgetStoreAction;
use App\Containers\Example\Events\WidgetCreatedEvent;
use App\Containers\Example\Models\Widget;
use Event;
use Tests\BaseTestCase;


class WidgetStoreActionTest extends BaseTestCase
{
    private function storeWidget() : Widget
    {
        $widgetStoreAction = app()->make(WidgetStoreAction::class);
        $widget = $widgetStoreAction->handle();

        return $widget;
    }

    public function testStoreReturnsWidget()
    {
        $widget = $this->storeWidget();

        $this->assertInstanceOf(Widget::class, $widget);
    }

    public function testStoreFiresWidgetCreatedEvent()
    {
        // we turned-off any event-listener except CreatedEvent::class
        Event::fake([
            WidgetCreatedEvent::class
        ]);

        $widget = $this->storeWidget();

        Event::assertDispatched(WidgetCreatedEvent::class);
    }
}