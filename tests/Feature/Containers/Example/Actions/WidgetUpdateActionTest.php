<?php


namespace Tests\Feature\Containers\Example\Actions;


use App\Containers\Example\Actions\WidgetUpdateAction;
use App\Containers\Example\Events\WidgetUpdatedEvent;
use App\Containers\Example\Models\Widget;
use Event;
use Tests\BaseTestCase;


class WidgetUpdateActionTest extends BaseTestCase
{
    private function updateWidget() : Widget
    {
        $widgetUpdateAction = app()->makeWith(WidgetUpdateAction::class);
        $widget = $widgetUpdateAction->handle(new Widget());

        return $widget;
    }

    public function testUpdateReturnsWidget()
    {
        $widget = $this->updateWidget();

        $this->assertInstanceOf(Widget::class, $widget);
    }

    public function testUpdateFiresWidgetCreatedEvent()
    {
        // we turned-off any event-listener except CreatedEvent::class
        Event::fake([
            WidgetUpdatedEvent::class
        ]);

        $widget = $this->updateWidget();

        Event::assertDispatched(WidgetUpdatedEvent::class);
    }
}